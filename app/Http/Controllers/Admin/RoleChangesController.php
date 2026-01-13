<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleChange;

class RoleChangesController extends Controller
{
    public function index()
    {
        $changes = RoleChange::with(['user','actor'])->orderBy('created_at','desc')->paginate(30);
        return view('admin.role_changes.index', compact('changes'));
    }
}