<?php

namespace App\Http\Controllers\Admin\Websites;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ApiHelper;
use Illuminate\Container\Attributes\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asdasd = ApiHelper::get('/announcement')->announcements;
        return view('admin.websites.pengumuman.index', compact('asdasd'));
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
        $image = $request->file('gambar');

        $data = [
            'title' => $request->input('tajuk'),
            'content' => $request->input('kandungan'),
            'start_date' => $request->input('tarikh_mula'),
            'end_date' => $request->input('tarikh_akhir'),
            'image_base64' => $image ? base64_encode(file_get_contents($image->getRealPath())) : null,
            'adminID' => 2
        ];
        $response = ApiHelper::post('/announcement', $data);
        return redirect()->back()->with('success', 'Pengumuman berjaya ditambah.');
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
        $item = ApiHelper::get('/announcement/' . $id)->announcement;
        return view('admin.websites.pengumuman.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $image = $request->file('gambar');

        $data = [
            'title' => $request->input('tajuk'),
            'content' => $request->input('kandungan'),
            'start_date' => $request->input('tarikh_mula'),
            'end_date' => $request->input('tarikh_akhir'),
            'image_base64' => $image ? base64_encode(file_get_contents($image->getRealPath())) : null,
            'adminID' => 2
        ];
        $response = ApiHelper::patch('/announcement/' . $id, $data);
        return redirect()->back()->with('success', 'Pengumuman berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = ApiHelper::delete('/announcement/' . $id);
        return redirect()->back()->with('success', 'Pengumuman berjaya dipadam.');
    }
}
