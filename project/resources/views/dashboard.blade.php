<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto">

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
            <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}! Here's a quick overview of your tasks. Go to <a href="{{ route('todos.index') }}" class="text-gray-900 font-semibold underline">To-Do List</a> to manage them.</p>
        </div>
    </div>
</x-app-layout>