<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use Illuminate\Support\Facades\Storage;

class AdsController extends Controller
{
    public function index()
    {
        $ads = Ad::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        return view('admin.ads.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'link' => 'nullable|url',
            // accept image or video files (jpg,png,webp,gif,mp4,webm)
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm|max:40960', // 40 MB limit (matches php.ini)
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        if($request->hasFile('media')){
            $path = $request->file('media')->store('ads', 'public');
            $data['image_path'] = $path;
        }

        $data['created_by'] = $request->user()->id;
        $data['is_active'] = $request->has('is_active');

        Ad::create($data);

        return redirect()->route('admin.ads.index')->with('success','Posted alright');
    }

    public function edit(Ad $ad)
    {
        return view('admin.ads.edit', compact('ad'));
    }

    public function update(Request $request, Ad $ad)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'link' => 'nullable|url',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm|max:40960', // 40 MB limit (matches php.ini)
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        if($request->hasFile('media')){
            // delete old if exists
            if($ad->image_path) Storage::disk('public')->delete($ad->image_path);
            $path = $request->file('media')->store('ads', 'public');
            $data['image_path'] = $path;
        }

        $data['is_active'] = $request->has('is_active');
        $ad->update($data);

        return redirect()->route('admin.ads.index')->with('success','Ad updated');
    }

    public function destroy(Ad $ad)
    {
        if($ad->image_path) Storage::disk('public')->delete($ad->image_path);
        $ad->delete();
        return redirect()->route('admin.ads.index')->with('success','Ad removed');
    }

    public function toggle(Ad $ad)
    {
        $ad->update(['is_active' => !$ad->is_active]);
        return redirect()->route('admin.ads.index')->with('success','Ad status updated');
    }
}
