@extends('layouts.app')

@section('title', 'Coming Soon')

@section('content')
<div class="flex h-screen overflow-hidden">
    <!-- Main Dashboard -->
    <main class="flex-1 overflow-y-auto p-8 flex items-center justify-center">
        <div class="text-center">
            <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Module Coming Soon</h1>
            <p class="text-slate-600">This section is currently under development.</p>
            <a href="{{ url()->previous() }}" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Go Back</a>
        </div>
    </main>
</div>
@endsection
