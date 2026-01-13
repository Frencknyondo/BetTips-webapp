<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tip;
use Illuminate\Support\Facades\Storage;

class TipsController extends Controller
{
    public function index()
    {
        $tips = Tip::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.tips.index', compact('tips'));
    }

    public function create()
    {
        return view('admin.tips.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'nullable|string',
            'bet_code' => 'nullable|string',
            'odds' => 'nullable|numeric|min:1|max:100',
            'start_time' => 'nullable|date',
            'stake' => 'nullable|integer|min:1|max:10',
            'tip_type' => 'required|in:free,locked,premium',
            'price' => 'nullable|numeric|min:0',
            'body' => 'nullable|string',
            'link' => 'nullable|url',
            // accept image or video files (jpg,png,webp,gif,mp4,webm)
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm|max:40960', // 40 MB limit (matches php.ini)
            'slip_image' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:5120', // 5 MB limit for slip images
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        // Map form fields to database columns
        if($request->has('start_time')) {
            $data['starts_at'] = $request->start_time;
        }
        if($request->has('description')) {
            $data['body'] = $request->description;
        }

        if($request->hasFile('media')){
            $path = $request->file('media')->store('tips', 'public');
            $data['image_path'] = $path;
        }

        if($request->hasFile('slip_image')){
            $path = $request->file('slip_image')->store('tips', 'public');
            $data['image_path'] = $path; // Use slip_image if media not provided
        }

        $data['created_by'] = $request->user()->id;
        $data['is_active'] = $request->has('is_active');

        Tip::create($data);

        return redirect()->route('admin.tips.index')->with('success','Posted alright');
    }

    public function edit(Tip $tip)
    {
        return view('admin.tips.edit', compact('tip'));
    }

    public function update(Request $request, Tip $tip)
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
            if($tip->image_path) Storage::disk('public')->delete($tip->image_path);
            $path = $request->file('media')->store('tips', 'public');
            $data['image_path'] = $path;
        }

        $data['is_active'] = $request->has('is_active');
        $tip->update($data);

        return redirect()->route('admin.tips.index')->with('success','Tip updated');
    }

    public function destroy(Tip $tip)
    {
        if($tip->image_path) Storage::disk('public')->delete($tip->image_path);
        $tip->delete();
        return redirect()->route('admin.tips.index')->with('success','Tip removed');
    }

    public function toggle(Tip $tip)
    {
        $tip->update(['is_active' => !$tip->is_active]);
        return redirect()->route('admin.tips.index')->with('success','Tip status updated');
    }
}
