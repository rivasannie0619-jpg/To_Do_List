<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('To-Do List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4">
                    <a href="{{ route('todos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Add New Todo
                    </a>
                </div>

                <table class="min-w-full border">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Title</th>
                            <th class="p-3 border">Description</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($todos as $todo)
                            <tr class="border-b">
                                <td class="p-3 border">{{ $todo->title }}</td>
                                <td class="p-3 border">{{ $todo->description ?? '-' }}</td>
                                <td class="p-3 border">
                                    @if ($todo->is_completed)
                                        <span class="text-green-600 font-semibold">Completed</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Pending</span>
                                    @endif
                                </td>
                                <td class="p-3 border space-x-2">
                                    <a href="{{ route('todos.edit', $todo->id) }}" class="text-blue-600 hover:underline">Edit</a>

                                    <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="inline" onsubmit="return confirm('Sigurado ka bang gusto mong burahin ito?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-500">Wala pang todo. Mag-add ka!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>