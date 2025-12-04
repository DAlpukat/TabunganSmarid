<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Pengguna (Admin)') }}
        </h2>
    </x-slot>

    <div class="gradient-bg py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-6">
                @if(session('success'))
                    <div class="bg-green-900 bg-opacity-50 border border-green-500 text-green-300 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="text-left border-b border-gray-700">
                                <th class="py-3 px-4">Nama</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-3 px-4">Role</th>
                                <th class="py-3 px-4">Bergabung</th>
                                <th class="py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="border-b border-gray-800 hover:bg-gray-800 hover:bg-opacity-30">
                                    <td class="py-4 px-4">{{ $user->name }}</td>
                                    <td class="py-4 px-4">{{ $user->email }}</td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 rounded-full text-xs {{ $user->is_admin ? 'bg-purple-900 text-purple-300' : 'bg-gray-700 text-gray-300' }}">
                                            {{ $user->is_admin ? 'Admin' : 'User' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-4">
                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 text-sm"
                                                        onclick="return confirm('Yakin hapus user {{ $user->name }}? Semua datanya akan hilang permanen!')">
                                                    Hapus Permanen
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-gray-400">Belum ada user</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>