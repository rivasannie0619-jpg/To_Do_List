<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('To-Do List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
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

                <div class="overflow-x-auto">
                    <table class="min-w-full border text-sm">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="p-3 border">ID</th>
                                <th class="p-3 border">Title</th>
                                <th class="p-3 border">Description</th>
                                <th class="p-3 border">Status</th>
                                <th class="p-3 border">Priority</th>
                                <th class="p-3 border">Due Date</th>
                                <th class="p-3 border">Category</th>
                                <th class="p-3 border">Created At</th>
                                <th class="p-3 border">Updated At</th>
                                <th class="p-3 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($todos as $todo)
                                <tr class="border-b">
                                    <td class="p-3 border">{{ $todo->id }}</td>
                                    <td class="p-3 border">{{ $todo->title }}</td>
                                    <td class="p-3 border">{{ $todo->description ?? '-' }}</td>
                                    <td class="p-3 border">
                                        @php
                                            $statusColors = [
                                                'Not Started' => 'text-gray-600',
                                                'In Progress' => 'text-blue-600',
                                                'Completed' => 'text-green-600',
                                                'Cancelled' => 'text-red-600',
                                            ];
                                        @endphp
                                        <span class="font-semibold {{ $statusColors[$todo->status] ?? '' }}">
                                            {{ $todo->status }}
                                        </span>
                                    </td>
                                    <td class="p-3 border">
                                        @php
                                            $priorityColors = [
                                                'Low' => 'text-gray-600',
                                                'Medium' => 'text-yellow-600',
                                                'High' => 'text-orange-600',
                                                'Urgent' => 'text-red-600',
                                            ];
                                        @endphp
                                        <span class="font-semibold {{ $priorityColors[$todo->priority] ?? '' }}">
                                            {{ $todo->priority }}
                                        </span>
                                    </td>
                                    <td class="p-3 border">
                                        {{ $todo->due_date ? $todo->due_date->format('M d, Y h:i A') : '-' }}
                                    </td>
                                    <td class="p-3 border">{{ $todo->category ?? '-' }}</td>
                                    <td class="p-3 border">{{ $todo->created_at->format('M d, Y h:i A') }}</td>
                                    <td class="p-3 border">{{ $todo->updated_at->format('M d, Y h:i A') }}</td>
                                    <td class="p-3 border space-x-2 whitespace-nowrap">
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
                                    <td colspan="10" class="p-3 text-center text-gray-500">Wala pang todo. Mag-add ka!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>