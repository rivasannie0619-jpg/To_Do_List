<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Title</label>
                        <input type="text" name="title" value="{{ old('title', $todo->title) }}"
                            class="w-full border-gray-300 rounded shadow-sm p-2 border">
                        @error('title')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full border-gray-300 rounded shadow-sm p-2 border">{{ old('description', $todo->description) }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Status</label>
                            <select name="status" class="w-full border-gray-300 rounded shadow-sm p-2 border">
                                @foreach (['Not Started', 'In Progress', 'Completed', 'Cancelled'] as $option)
                                    <option value="{{ $option }}" {{ old('status', $todo->status) == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Priority</label>
                            <select name="priority" class="w-full border-gray-300 rounded shadow-sm p-2 border">
                                @foreach (['Low', 'Medium', 'High', 'Urgent'] as $option)
                                    <option value="{{ $option }}" {{ old('priority', $todo->priority) == $option ? 'selected' : '' }}>
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
                            <label class="block text-gray-700 font-medium mb-1">Due Date</label>
                            <input type="datetime-local" name="due_date"
                                value="{{ old('due_date', $todo->due_date ? $todo->due_date->format('Y-m-d\TH:i') : '') }}"
                                class="w-full border-gray-300 rounded shadow-sm p-2 border">
                            @error('due_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Category</label>
                            <input type="text" name="category" value="{{ old('category', $todo->category) }}"
                                placeholder="Work, Personal, Study, Errands..."
                                class="w-full border-gray-300 rounded shadow-sm p-2 border">
                            @error('category')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Update Todo
                        </button>
                        <a href="{{ route('todos.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>