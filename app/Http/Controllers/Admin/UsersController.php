<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at','desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function promote(Request $request, User $user)
    {
        $this->authorizeAction($request->user());
        $role = $request->input('to', 'tipster');
        $old = $user->role;
        $user->update(['role' => $role]);

        // record audit
        \App\Models\RoleChange::create([
            'user_id' => $user->id,
            'actor_id' => $request->user()->id,
            'old_role' => $old,
            'new_role' => $role,
            'reason' => $request->input('reason'),
        ]);

        return redirect()->route('admin.users.index')->with('success',"User role changed to {$role}");
    }

    public function demote(Request $request, User $user)
    {
        $this->authorizeAction($request->user());
        $old = $user->role;
        $user->update(['role' => 'user']);

        \App\Models\RoleChange::create([
            'user_id' => $user->id,
            'actor_id' => $request->user()->id,
            'old_role' => $old,
            'new_role' => 'user',
            'reason' => $request->input('reason'),
        ]);

        return redirect()->route('admin.users.index')->with('success','User demoted to user');
    }

    protected function authorizeAction(User $actor)
    {
        if(!$actor || $actor->role !== 'admin') abort(403);
    }
}