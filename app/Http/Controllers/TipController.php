<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tip;
use App\Models\AccessCode;
use Illuminate\Support\Str;

class TipController extends Controller
{
    public function index()
    {
        $tips = Tip::with('creator')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tips', compact('tips'));
    }

    public function show(Tip $tip)
    {
        // Check if tip is active
        if (!$tip->is_active) {
            abort(404);
        }

        // Load creator
        $tip->load('creator');

        return view('tip', compact('tip'));
    }

    public function store(Request $request)
    {
        // Validate the request data from the tipster form
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string',
            'bet_code' => 'required|string',
            'odds' => 'required|numeric|min:1|max:100',
            'start_time' => 'required|date|after:now',
            'validity_time' => 'required|integer|min:1',
            'stake' => 'nullable|integer|min:1|max:10',
            'tip_type' => 'required|in:free,locked,premium',
            'price' => 'nullable|numeric|min:0|required_if:tip_type,locked,premium',
            'number_of_codes' => 'nullable|integer|min:1|max:100|required_if:tip_type,premium',
            'description' => 'nullable|string|max:1000',
            'slip_image' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:5120', // 5 MB limit
        ]);

        // Map form fields to database columns
        $data['starts_at'] = $data['start_time'];
        unset($data['start_time']);

        if(isset($data['description'])) {
            $data['body'] = $data['description'];
            unset($data['description']);
        }

        // Handle file upload
        if($request->hasFile('slip_image')){
            $path = $request->file('slip_image')->store('tips', 'public');
            $data['image_path'] = $path;
        }

        // Set additional fields
        $data['created_by'] = $request->user()->id;
        $data['is_active'] = true; // Tips are active by default

        // Calculate validity_time as expiration timestamp
        $data['validity_time'] = now()->timestamp + $data['validity_time'];

        // Create the tip
        $tip = Tip::create($data);

        // Generate access codes for premium tips
        if ($data['tip_type'] === 'premium' && isset($data['number_of_codes'])) {
            $codes = [];
            for ($i = 0; $i < $data['number_of_codes']; $i++) {
                do {
                    $code = Str::random(12);
                } while (AccessCode::where('code', $code)->exists());

                $codes[] = [
                    'code' => $code,
                    'tip_id' => $tip->id,
                    'created_by' => $request->user()->id,
                    'is_used' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            AccessCode::insert($codes);
        }

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Tip imeingezwa kwa mafanikio!',
            'tip' => $tip
        ]);
    }

    public function unlock(Request $request, Tip $tip)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to unlock tips.'
            ], 401);
        }

        // Validate the code
        $request->validate([
            'code' => 'required|string'
        ]);

        // Find the access code
        $accessCode = AccessCode::where('code', $request->code)
            ->where('tip_id', $tip->id)
            ->where('is_used', false)
            ->first();

        if (!$accessCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or already used access code.'
            ], 400);
        }

        // Mark the code as used
        $accessCode->update([
            'is_used' => true,
            'used_by' => auth()->id(),
            'used_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tip unlocked successfully!'
        ]);
    }
}
