@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="container mx-auto px-6 py-12 z-10 relative">
    <div class="max-w-4xl mx-auto">
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-blue-600 hover:text-blue-500 mb-6 transition font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Dashboard
        </a>

        <div class="clean-card p-8 relative overflow-hidden">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 relative z-10">
                <div>
                    <h1 class="text-4xl font-bold text-slate-900 mb-2">{{ $customer->name }}</h1>
                    <div class="flex items-center space-x-4 text-slate-600">
                        <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> {{ $customer->email ?? 'No email provided' }}</span>
                        <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> {{ $customer->phone ?? 'No phone provided' }}</span>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="px-4 py-1.5 rounded-full text-sm font-medium border
                        {{ $customer->status == 'active' ? 'bg-green-100 text-green-700 border-green-200' : 
                          ($customer->status == 'lead' ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : 'bg-red-100 text-red-700 border-red-200') }}">
                        {{ ucfirst($customer->status) }}
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8 relative z-10">
                <!-- WhatsApp Integration Button (wa.me) -->
                @php
                    $phone = preg_replace('/[^0-9]/', '', $customer->phone ?? '');
                    $message = urlencode("Hello " . $customer->name . ", this is a message from VeltrixCRM.");
                    $waLink = "https://wa.me/" . $phone . "?text=" . $message;
                @endphp
                <a href="{{ $phone ? $waLink : '#' }}" target="_blank" class="{{ !$phone ? 'opacity-50 cursor-not-allowed' : '' }} flex items-center justify-center space-x-2 bg-[#25D366] hover:bg-[#1ebd5c] text-white font-medium py-3 px-6 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.115.548 4.183 1.594 6.012L.15 23.85l5.961-1.564A11.968 11.968 0 0012.03 24c6.646 0 12.031-5.385 12.031-12.031S18.677 0 12.031 0zm0 21.969c-1.844 0-3.655-.496-5.244-1.439l-.376-.223-3.89 1.02 1.04-3.79-.245-.39A9.927 9.927 0 012.03 12.03C2.03 6.516 6.516 2.03 12.031 2.03c5.515 0 10 4.486 10 10s-4.485 10-10 10zm5.495-7.514c-.301-.151-1.782-.88-2.057-.98-.276-.101-.477-.151-.678.15-.201.302-.779.98-.954 1.18-.176.202-.352.227-.653.076-1.554-.775-2.658-1.405-3.69-3.21-.101-.176.106-.164.402-.756.1-.202.05-.378-.025-.529-.075-.151-.678-1.636-.928-2.241-.244-.59-.493-.51-.678-.519-.176-.01-.378-.01-.578-.01-.201 0-.527.075-.803.377-.276.302-1.054 1.031-1.054 2.514 0 1.483 1.079 2.916 1.23 3.118.151.201 2.127 3.245 5.152 4.548 2.046.88 2.68.705 3.181.579.624-.158 1.782-.729 2.032-1.433.251-.704.251-1.308.176-1.433-.075-.126-.276-.201-.577-.352z"/></svg>
                    <span>Message on WhatsApp</span>
                </a>

                <a href="mailto:{{ $customer->email }}" class="flex items-center justify-center space-x-2 border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium py-3 px-6 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>Send Email</span>
                </a>
            </div>

            <!-- Task Statistics -->
            <div class="mt-8 relative z-10">
                <h3 class="text-xl font-bold text-slate-900 mb-4">Task Statistics</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4 text-center">
                        <span class="block text-2xl font-bold text-indigo-600">{{ $customer->tasks->count() }}</span>
                        <span class="text-xs text-indigo-400 font-medium uppercase">Total Tasks</span>
                    </div>
                    <div class="bg-green-50 border border-green-100 rounded-2xl p-4 text-center">
                        <span class="block text-2xl font-bold text-green-600">{{ $customer->tasks->where('status', 'completed')->count() }}</span>
                        <span class="text-xs text-green-400 font-medium uppercase">Completed</span>
                    </div>
                    <div class="bg-orange-50 border border-orange-100 rounded-2xl p-4 text-center">
                        <span class="block text-2xl font-bold text-orange-600">{{ $customer->tasks->where('status', '!=', 'completed')->count() }}</span>
                        <span class="text-xs text-orange-400 font-medium uppercase">Pending</span>
                    </div>
                </div>
            </div>

            <!-- AI Suggested Notes/Replies -->
            <div class="mt-10 border-t border-slate-200 pt-8 relative z-10">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">AI Assistant Suggestions</h3>
                </div>
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-6">
                    <p class="text-slate-700 mb-4">Based on {{ $customer->name }}'s status as a <strong class="text-blue-700">{{ $customer->status }}</strong>, here is a suggested message:</p>
                    <div class="relative">
                        <textarea class="w-full bg-white border border-slate-300 rounded-lg p-4 text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none" rows="4" readonly>Hi {{ $customer->name }},&#10;&#10;I noticed you are currently a {{ $customer->status }} in our system. I wanted to reach out and see how we can assist you further today. Let me know if you need anything!&#10;&#10;Best,&#10;VeltrixCRM Team</textarea>
                        <button class="absolute bottom-4 right-4 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 px-3 py-1.5 rounded-md text-sm font-medium transition shadow-sm">
                            Copy text
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
