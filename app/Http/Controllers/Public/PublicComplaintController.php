<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\ComplaintReceivedNotification;
use App\Mail\ComplaintSubmittedNotification;
use App\Models\Complaint;
use App\Models\ComplaintType;
use App\Models\ComplaintStatusLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PublicComplaintController extends Controller
{
    /**
     * Show the form for creating a new complaint.
     */
    public function create(): View
    {
        $complaintTypes = ComplaintType::orderBy('type_name')->get();
        return view('public.tambahaduan', compact('complaintTypes'));
    }

    /**
     * Store a newly created complaint.
     */
    public function store(Request $request): RedirectResponse
    {
        // ============================================================
        // SESSION LOCK PREVENTION
        // ============================================================
        // Check if a submission is already in progress for this session
        $submissionLockKey = 'complaint_submission_lock';
        $lastSubmissionTime = session($submissionLockKey);
        
        if ($lastSubmissionTime && now()->timestamp - $lastSubmissionTime < 10) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sila tunggu sebentar sebelum menghantar aduan. Sistem sedang memproses aduan anda.');
        }
        
        // Set lock for 10 seconds
        session([$submissionLockKey => now()->timestamp]);
        
        // ============================================================
        // DUPLICATE SUBMISSION PREVENTION
        // ============================================================
        // Check for duplicate submissions within the last 2 minutes
        // This prevents users from submitting the same complaint multiple times
        $recentDuplicate = Complaint::where('phone_number', $request->telefon)
            ->where('email', $request->email)
            ->where('description', $request->huraian)
            ->where('created_at', '>', now()->subMinutes(2))
            ->first();

        if ($recentDuplicate) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Aduan yang serupa telah dihantar baru-baru ini. Sila tunggu beberapa minit sebelum menghantar aduan baharu. ID Aduan anda: ' . ($recentDuplicate->public_id ?? '#' . $recentDuplicate->id));
        }

        // Check rate limiting: Maximum 3 complaints per hour from same phone number
        $hourlyCount = Complaint::where('phone_number', $request->telefon)
            ->where('created_at', '>', now()->subHour())
            ->count();

        if ($hourlyCount >= 3) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Anda telah menghantar terlalu banyak aduan dalam masa yang singkat. Sila cuba lagi selepas 1 jam.');
        }

        // Map form field names to database column names
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'telefon' => ['required', 'string', 'min:10', 'max:12', 'regex:/^[0-9]+$/'],
            'email' => ['required', 'email', 'max:255'],
            'alamat' => ['required', 'string', 'max:200', 'regex:/^[a-zA-Z0-9\s.,-]+$/'],
            'kategori' => ['required'],
            'huraian' => ['required', 'string', 'max:1000'],
            'gambar' => ['nullable', 'array', 'max:10'],
            'gambar.*' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'nama.required' => 'Nama diperlukan.',
            'nama.regex' => 'Nama hanya boleh mengandungi huruf dan ruang.',
            'nama.max' => 'Nama tidak boleh melebihi 100 aksara.',
            'telefon.required' => 'Nombor telefon diperlukan.',
            'telefon.min' => 'Nombor telefon mestilah sekurang-kurangnya 10 digit.',
            'telefon.max' => 'Nombor telefon tidak boleh melebihi 12 digit.',
            'telefon.regex' => 'Nombor telefon hanya boleh mengandungi nombor.',
            'email.required' => 'Emel diperlukan.',
            'email.email' => 'Sila masukkan alamat emel yang sah.',
            'email.max' => 'Emel tidak boleh melebihi 255 aksara.',
            'alamat.required' => 'Alamat diperlukan.',
            'alamat.regex' => 'Alamat hanya boleh mengandungi huruf, nombor, dan aksara khas (., -).',
            'alamat.max' => 'Alamat tidak boleh melebihi 200 aksara.',
            'kategori.required' => 'Jenis aduan diperlukan.',
            'huraian.required' => 'Penerangan diperlukan.',
            'huraian.max' => 'Penerangan tidak boleh melebihi 1000 aksara.',
            'gambar.array' => 'Gambar mestilah dalam format yang betul.',
            'gambar.max' => 'Maksimum 10 gambar dibenarkan.',
            'gambar.*.image' => 'Semua fail yang dimuat naik mestilah imej.',
            'gambar.*.mimes' => 'Format gambar hanya dibenarkan: JPG, JPEG, dan PNG.',
            'gambar.*.max' => 'Saiz setiap imej tidak boleh melebihi 2MB.',
        ]);

        // Map kategori value to complaint_type_id
        // The form uses text values, we need to find matching complaint type
        $kategoriValue = $validated['kategori'];
        $complaintType = null;
        
        // Try to find by ID first (if it's numeric)
        if (is_numeric($kategoriValue)) {
            $complaintType = ComplaintType::find($kategoriValue);
        }
        
        // If not found, try to find by type_name (case-insensitive partial match)
        if (!$complaintType) {
            $kategoriMap = [
                'prasarana' => 'Prasarana',
                'kebersihan' => 'Kebersihan',
                'keselamatan' => 'Keselamatan',
                'lain' => 'Lain-lain',
            ];
            
            $searchName = $kategoriMap[$kategoriValue] ?? $kategoriValue;
            $complaintType = ComplaintType::where('type_name', 'like', "%{$searchName}%")->first();
        }
        
        if (!$complaintType) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jenis aduan yang dipilih tidak sah.');
        }

        // Map form fields to database columns
        $complaintData = [
            'name' => $validated['nama'],
            'phone_number' => $validated['telefon'],
            'email' => $validated['email'],
            'address' => $validated['alamat'],
            'complaint_type_id' => $complaintType->id,
            'description' => $validated['huraian'],
            'status' => 'menunggu', // Default status for public complaints
        ];

        // Handle multiple image uploads
        if ($request->hasFile('gambar')) {
            $imagePaths = [];
            foreach ($request->file('gambar') as $image) {
                $imagePaths[] = $image->store('complaints', 'public');
            }
            $complaintData['image_path'] = $imagePaths;
        }

        $complaint = Complaint::create($complaintData);
        
        // Reload complaint with relationships for email
        $complaint->load(['complaintType']);

        // Create status log (for public, use first admin user as system user)
        try {
            // Get first admin user (Super Admin or Admin)
            $adminUser = User::whereHas('roles', function($query) {
                $query->whereIn('name', ['Super Admin', 'Admin']);
            })->first();
            
            if ($adminUser) {
                ComplaintStatusLog::create([
                    'complaint_id' => $complaint->id,
                    'status' => $complaint->status,
                    'updated_by' => $adminUser->id,
                    'comment' => 'Aduan diterima dari sistem awam.',
                    'created_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            // If status log creation fails, continue without it
            // The complaint is still created successfully
        }

        // Send email notifications
        $emailSent = false;
        $emailError = null;
        
        try {
            // Send email to the resident (penduduk)
            if ($complaint->email) {
                Mail::to($complaint->email)->send(new ComplaintSubmittedNotification($complaint));
                $emailSent = true;
            }
            
            // Send email to admin
            $adminEmail = config('mail.admin_email', env('ADMIN_EMAIL'));
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new ComplaintReceivedNotification($complaint));
            }
        } catch (\Exception $e) {
            // Log the error but don't fail the complaint creation
            $emailError = $e->getMessage();
            Log::error('Failed to send complaint notification emails: ' . $emailError);
        }

        // Prepare success message
        $successMessage = 'Aduan anda berjaya dihantar! ID Aduan: ' . ($complaint->public_id ?? '#' . $complaint->id);
        
        if ($emailSent) {
            $successMessage .= ' Emel pengesahan telah dihantar ke ' . $complaint->email . '.';
        } elseif ($emailError) {
            // If email failed, still show success but with a note
            $successMessage .= ' (Nota: Emel pengesahan tidak dapat dihantar, tetapi aduan anda telah direkodkan.)';
        }

        // Clear the submission lock after successful creation
        session()->forget('complaint_submission_lock');

        return redirect()->route('public.complaint.create')
            ->with('success', $successMessage)
            ->with('email_sent', $emailSent)
            ->with('redirect_to', 'semakstatus');
    }

    /**
     * Show the check status form.
     */
    public function checkStatus(): View
    {
        return view('public.semakstatus');
    }

    /**
     * List complaints by phone number.
     */
    public function list(Request $request): View|RedirectResponse
    {
        $phoneNumber = $request->input('no_telefon') ?? $request->session()->get('public_phone_number');
        
        if (!$phoneNumber) {
            return redirect()->route('public.status.check')
                ->with('error', 'Sila masukkan nombor telefon untuk melihat senarai aduan.');
        }

        $complaints = Complaint::where('phone_number', $phoneNumber)
            ->with('complaintType')
            ->orderBy('created_at', 'desc')
            ->get();

        // Store phone number in session for next requests
        $request->session()->put('public_phone_number', $phoneNumber);

        return view('public.listaduan', compact('complaints', 'phoneNumber'));
    }

    /**
     * Show complaint details.
     */
    public function show(Complaint $complaint): View|RedirectResponse
    {
        // Verify that the complaint belongs to the phone number in session
        $phoneNumber = request()->session()->get('public_phone_number');
        
        if ($complaint->phone_number !== $phoneNumber) {
            return redirect()->route('public.status.check')
                ->with('error', 'Anda tidak mempunyai kebenaran untuk melihat aduan ini.');
        }

        $complaint->load(['complaintType', 'statusLogs']);
        
        return view('public.statusaduan', compact('complaint'));
    }
}
