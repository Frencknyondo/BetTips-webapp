<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipsterApplication;
use App\Models\User;

class TipsterApplicationsController extends Controller
{
    public function index()
    {
        $applications = TipsterApplication::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.tipster_applications.index', compact('applications'));
    }

    public function approve($id)
    {
        $app = TipsterApplication::findOrFail($id);

        if ($app->status !== 'pending') {
            return back()->with('error', 'Application has already been processed.');
        }

        $app->update(['status' => 'approved']);
        $app->user->update(['role' => 'tipster']);

        return back()->with('success', 'User is now a Tipster');
    }

    public function reject($id)
    {
        $app = TipsterApplication::findOrFail($id);

        if ($app->status !== 'pending') {
            return back()->with('error', 'Application has already been processed.');
        }

        $app->update(['status' => 'rejected']);

        return back()->with('success', 'Application rejected');
    }
}
