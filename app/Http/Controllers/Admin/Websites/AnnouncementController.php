<?php

namespace App\Http\Controllers\Admin\Websites;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\ApiHelper;

class AnnouncementController extends Controller
{
    /**
     * Determine the correct route name based on user role
     */
    protected function getRouteName(string $action): string
    {
        /** @var User|null $user */
        $user = Auth::user();
        
        if ($user && $user->hasRole('Super Admin')) {
            return 'admin.websites.pengumuman.' . $action;
        }
        
        return 'admin.panel.websites.pengumuman.' . $action;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $response = ApiHelper::get('/announcement');
            $announcements = $response->announcements ?? [];
            
            // Convert to collection and paginate
            $asdasd = collect($announcements);
            $currentPage = request()->get('page', 1);
            $perPage = 5;
            
            $asdasd = new \Illuminate\Pagination\LengthAwarePaginator(
                $asdasd->forPage($currentPage, $perPage),
                $asdasd->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            
            return view('admin.websites.pengumuman.index', compact('asdasd'));
            
        } catch (\Exception $e) {
            return view('admin.websites.pengumuman.index', [
                'asdasd' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 5)
            ])->with('error', 'Gagal mendapatkan data pengumuman: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.websites.pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'tajuk' => 'required|string|max:255',
            'kandungan' => 'required|string',
            'tarikh_mula' => 'required|date',
            'tarikh_akhir' => 'required|date|after_or_equal:tarikh_mula',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'tajuk.required' => 'Tajuk pengumuman diperlukan.',
            'kandungan.required' => 'Kandungan pengumuman diperlukan.',
            'tarikh_mula.required' => 'Tarikh mula diperlukan.',
            'tarikh_akhir.required' => 'Tarikh akhir diperlukan.',
            'tarikh_akhir.after_or_equal' => 'Tarikh akhir mesti sama atau selepas tarikh mula.',
            'gambar.image' => 'Fail yang dimuat naik mestilah gambar.',
            'gambar.mimes' => 'Gambar mestilah format: jpeg, jpg, atau png.',
            'gambar.max' => 'Saiz gambar tidak boleh melebihi 2MB.',
        ]);

        try {
            $image = $request->file('gambar');

            $data = [
                'title' => $request->input('tajuk'),
                'content' => $request->input('kandungan'),
                'start_date' => $request->input('tarikh_mula'),
                'end_date' => $request->input('tarikh_akhir'),
                'image_base64' => $image ? base64_encode(file_get_contents($image->getRealPath())) : null,
                'adminID' => Auth::id() ?? Auth::user()->id
            ];
            
            $response = ApiHelper::post('/announcement', $data);
            
            // Check for API errors
            if ($response && property_exists($response, 'error')) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menambah pengumuman: ' . ($response->error ?? 'Unknown error'));
            }
            
            return redirect()->route($this->getRouteName('index'))
                ->with('success', 'Pengumuman berjaya ditambah.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $response = ApiHelper::get('/announcement/' . $id);
            
            if (!$response || property_exists($response, 'error')) {
                return redirect()->route($this->getRouteName('index'))
                    ->with('error', 'Gagal mendapatkan data pengumuman: ' . ($response->error ?? 'Unknown error'));
            }
            
            $item = $response->announcement ?? null;
            
            if (!$item) {
                return redirect()->route($this->getRouteName('index'))
                    ->with('error', 'Pengumuman tidak dijumpai.');
            }
            
            return view('admin.websites.pengumuman.edit', compact('item'));
            
        } catch (\Exception $e) {
            return redirect()->route($this->getRouteName('index'))
                ->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate input
        $request->validate([
            'tajuk' => 'required|string|max:255',
            'kandungan' => 'required|string',
            'tarikh_mula' => 'required|date',
            'tarikh_akhir' => 'required|date|after_or_equal:tarikh_mula',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'tajuk.required' => 'Tajuk pengumuman diperlukan.',
            'kandungan.required' => 'Kandungan pengumuman diperlukan.',
            'tarikh_mula.required' => 'Tarikh mula diperlukan.',
            'tarikh_akhir.required' => 'Tarikh akhir diperlukan.',
            'tarikh_akhir.after_or_equal' => 'Tarikh akhir mesti sama atau selepas tarikh mula.',
            'gambar.image' => 'Fail yang dimuat naik mestilah gambar.',
            'gambar.mimes' => 'Gambar mestilah format: jpeg, jpg, atau png.',
            'gambar.max' => 'Saiz gambar tidak boleh melebihi 2MB.',
        ]);

        try {
            $image = $request->file('gambar');

            $data = [
                'title' => $request->input('tajuk'),
                'content' => $request->input('kandungan'),
                'start_date' => $request->input('tarikh_mula'),
                'end_date' => $request->input('tarikh_akhir'),
                'image_base64' => $image ? base64_encode(file_get_contents($image->getRealPath())) : null,
                'adminID' => Auth::id() ?? 2
            ];
            
            $response = ApiHelper::patch('/announcement/' . $id, $data);
            
            // Check for API errors
            if ($response && property_exists($response, 'error')) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengemaskini pengumuman: ' . ($response->error ?? 'Unknown error'));
            }
            
            return redirect()->route($this->getRouteName('index'))
                ->with('success', 'Pengumuman berjaya dikemaskini.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $response = ApiHelper::delete('/announcement/' . $id);
            
            // Check for API errors
            if ($response && property_exists($response, 'error')) {
                return redirect()->back()
                    ->with('error', 'Gagal memadam pengumuman: ' . ($response->error ?? 'Unknown error'));
            }
            
            return redirect()->route($this->getRouteName('index'))
                ->with('success', 'Pengumuman berjaya dipadam.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ralat: ' . $e->getMessage());
        }
    }
}
