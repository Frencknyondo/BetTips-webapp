@extends('admin.layout')

@section('title','Users')

@section('content')
    <h2 class="text-xl font-bold mb-4">Users</h2>

    <div class="space-y-3">
        @foreach($users as $user)
            <div class="bg-gray-800 p-3 rounded flex items-center justify-between">
                <div>
                    <div class="font-bold">{{ $user->name }} <span class="text-sm text-gray-400">({{ $user->role }})</span></div>
                    <div class="text-sm text-gray-400">{{ $user->email }} • {{ $user->phone }}</div>
                </div>
                <div class="flex items-center gap-2">
                    @if($user->role !== 'tipster')
                        <form method="POST" action="{{ route('admin.users.promote', $user) }}">@csrf
                            <input type="hidden" name="to" value="tipster" />
                            <button class="px-3 py-1 bg-green-600 rounded">Promote to Tipster</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.users.demote', $user) }}">@csrf
                            <button class="px-3 py-1 bg-yellow-600 rounded">Demote to User</button>
                        </form>
                    @endif
                    @if($user->role !== 'admin')
                        <form method="POST" action="{{ route('admin.users.promote', $user) }}">@csrf
                            <input type="hidden" name="to" value="admin" />
                            <button class="px-3 py-1 bg-blue-600 rounded">Make Admin</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection