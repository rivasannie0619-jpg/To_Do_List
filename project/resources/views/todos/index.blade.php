<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('To-Do List') }}
        </h2>
    </x-slot>
 
    <div class="py-12" x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }}, showDetails: false, selectedTodo: null }">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
 
            {{-- STATS / DASHBOARD CARDS --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm p-4 border">
                    <p class="text-gray-500 text-xs uppercase font-medium">Total Tasks</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalCount }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4 border">
                    <p class="text-gray-500 text-xs uppercase font-medium">Not Started</p>
                    <p class="text-2xl font-bold text-gray-600">{{ $notStartedCount }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4 border">
                    <p class="text-gray-500 text-xs uppercase font-medium">In Progress</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $inProgressCount }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4 border">
                    <p class="text-gray-500 text-xs uppercase font-medium">Completed</p>
                    <p class="text-2xl font-bold text-green-600">{{ $completedCount }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4 border">
                    <p class="text-gray-500 text-xs uppercase font-medium">Cancelled</p>
                    <p class="text-2xl font-bold text-red-600">{{ $cancelledCount }}</p>
                </div>
            </div>
 
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
 
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif
 
                {{-- SEARCH BAR + DROPDOWN FILTER + ADD BUTTON --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
                    <form method="GET" action="{{ route('todos.index') }}" class="flex flex-col sm:flex-row gap-2 flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search title or description..."
                            class="border-gray-300 rounded shadow-sm p-2 border text-sm w-full sm:w-64">
 
                        <select name="status" class="border-gray-300 rounded shadow-sm p-2 border text-sm">
                            <option value="All">All Status</option>
                            @foreach (['Not Started', 'In Progress', 'Completed', 'Cancelled'] as $option)
                                <option value="{{ $option }}" {{ request('status') == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
 
                        <button type="submit"
                            class="bg-gray-900 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-gray-800">
                            SEARCH
                        </button>
 
                        @if (request('search') || (request('status') && request('status') !== 'All'))
                            <a href="{{ route('todos.index') }}"
                                class="border border-gray-300 text-gray-700 px-4 py-2 rounded text-sm font-semibold hover:bg-gray-50 text-center">
                                RESET
                            </a>
                        @endif
                    </form>
 
                    <button @click="showModal = true" type="button"
                        class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-800 font-semibold text-sm whitespace-nowrap">
                        + ADD TODO
                    </button>
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
                                <tr class="border-b hover:bg-gray-50 cursor-pointer"
                                    @click="showDetails = true; selectedTodo = {
                                        id: {{ $todo->id }},
                                        title: @js($todo->title),
                                        description: @js($todo->description),
                                        status: @js($todo->status),
                                        priority: @js($todo->priority),
                                        due_date: @js($todo->due_date ? $todo->due_date->format('M d, Y h:i A') : null),
                                        category: @js($todo->category),
                                        created_at: @js($todo->created_at->format('M d, Y h:i A')),
                                        updated_at: @js($todo->updated_at->format('M d, Y h:i A')),
                                        edit_url: @js(route('todos.edit', $todo->id))
                                    }">
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
                                    <td class="p-3 border space-x-2 whitespace-nowrap" @click.stop>
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
                                    <td colspan="10" class="p-3 text-center text-gray-500">
                                        @if (request('search') || request('status'))
                                            Walang nahanap na todo na tumugma sa search/filter mo.
                                        @else
                                            Wala pang todo. Mag-add ka!
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
 
                <div class="mt-4">
                    {{ $todos->links() }}
                </div>
 
            </div>
        </div>
 
        {{-- MODAL: Add New Todo --}}
        <div x-show="showModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
             style="display: none;">
            <div @click.outside="showModal = false"
                 class="bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
 
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Add New Todo</h3>
                </div>
 
                <form action="{{ route('todos.store') }}" method="POST" class="p-6">
                    @csrf
 
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1 text-sm">Task Title</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full border-gray-300 rounded shadow-sm p-2 border">
                        @error('title')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
 
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1 text-sm">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full border-gray-300 rounded shadow-sm p-2 border">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
 
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1 text-sm">Status</label>
                            <select name="status" class="w-full border-gray-300 rounded shadow-sm p-2 border">
                                @foreach (['Not Started', 'In Progress', 'Completed', 'Cancelled'] as $option)
                                    <option value="{{ $option }}" {{ old('status') == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <div>
                            <label class="block text-gray-700 font-medium mb-1 text-sm">Priority</label>
                            <select name="priority" class="w-full border-gray-300 rounded shadow-sm p-2 border">
                                @foreach (['Low', 'Medium', 'High', 'Urgent'] as $option)
                                    <option value="{{ $option }}" {{ old('priority') == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            @error('priority')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
 
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1 text-sm">Due Date</label>
                            <input type="datetime-local" name="due_date" value="{{ old('due_date') }}"
                                class="w-full border-gray-300 rounded shadow-sm p-2 border">
                            @error('due_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <div>
                            <label class="block text-gray-700 font-medium mb-1 text-sm">Category</label>
                            <input type="text" name="category" value="{{ old('category') }}"
                                placeholder="Work, Personal, Study..."
                                class="w-full border-gray-300 rounded shadow-sm p-2 border">
                            @error('category')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
 
                    <p class="text-xs text-gray-400 mb-4">Created At at Updated At ay awtomatikong ita-tala.</p>
 
                    <div class="flex justify-end gap-2 pt-2 border-t">
                        <button type="button" @click="showModal = false"
                            class="border border-gray-300 text-gray-700 px-4 py-2 rounded text-sm font-semibold hover:bg-gray-50">
                            CANCEL
                        </button>
                        <button type="submit"
                            class="bg-gray-900 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-gray-800">
                            SAVE
                        </button>
                    </div>
                </form>
            </div>
        </div>
 
        {{-- MODAL: View Todo Details --}}
        <div x-show="showDetails" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
             style="display: none;">
            <div @click.outside="showDetails = false"
                 x-show="showDetails"
                 class="bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto"
                 template x-if="selectedTodo">
                <div>
                    <div class="px-6 py-4 border-b flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900" x-text="selectedTodo?.title"></h3>
                        <button @click="showDetails = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                    </div>
 
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-xs uppercase text-gray-500 font-medium mb-1">Description</p>
                            <p class="text-gray-800 text-sm" x-text="selectedTodo?.description || '-'"></p>
                        </div>
 
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs uppercase text-gray-500 font-medium mb-1">Status</p>
                                <p class="text-sm font-semibold" x-text="selectedTodo?.status"></p>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-gray-500 font-medium mb-1">Priority</p>
                                <p class="text-sm font-semibold" x-text="selectedTodo?.priority"></p>
                            </div>
                        </div>
 
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs uppercase text-gray-500 font-medium mb-1">Due Date</p>
                                <p class="text-sm text-gray-800" x-text="selectedTodo?.due_date || '-'"></p>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-gray-500 font-medium mb-1">Category</p>
                                <p class="text-sm text-gray-800" x-text="selectedTodo?.category || '-'"></p>
                            </div>
                        </div>
 
                        <div class="grid grid-cols-2 gap-4 pt-2 border-t">
                            <div>
                                <p class="text-xs uppercase text-gray-500 font-medium mb-1">Created At</p>
                                <p class="text-xs text-gray-500" x-text="selectedTodo?.created_at"></p>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-gray-500 font-medium mb-1">Updated At</p>
                                <p class="text-xs text-gray-500" x-text="selectedTodo?.updated_at"></p>
                            </div>
                        </div>
                    </div>
 
                    <div class="px-6 py-4 border-t flex justify-end gap-2">
                        <button @click="showDetails = false"
                            class="border border-gray-300 text-gray-700 px-4 py-2 rounded text-sm font-semibold hover:bg-gray-50">
                            CLOSE
                        </button>
                        <a :href="selectedTodo?.edit_url"
                            class="bg-gray-900 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-gray-800">
                            EDIT
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
 