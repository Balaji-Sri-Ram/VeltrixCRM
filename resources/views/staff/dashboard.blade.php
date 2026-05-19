@extends('layouts.dashboard')

@section('title', __('messages.staff_dashboard'))

@section('content')
<div class="mb-10">
    <h1 class="heading-editorial text-4xl mb-1">{{ __('messages.dashboard') }}</h1>
    <p class="text-muted-veltrix text-sm">{{ __('messages.hello') }}, {{ Auth::user()->name }}! {{ __('messages.assignments_msg') }}</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
    <div class="card-veltrix !p-6 flex justify-between items-start">
        <div>
            <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-[0.2em] mb-4">{{ __('messages.my_customers') }}</p>
            <h3 id="stat-myCustomers" class="heading-editorial text-3xl">{{ $assignedCustomers ?? 0 }}</h3>
            <p class="text-[9px] font-bold text-muted-veltrix mt-4 uppercase tracking-widest">{{ __('messages.active_relationships') }}</p>
        </div>
        <div class="p-3 bg-[var(--color-bg-base)] text-[var(--color-primary)] rounded-2xl border border-[var(--color-border-soft)]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
    </div>

    <div class="card-veltrix !p-6 flex justify-between items-start">
        <div>
            <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-[0.2em] mb-4">{{ __('messages.pending_tasks') }}</p>
            <h3 id="stat-pendingTasks" class="heading-editorial text-3xl">{{ $pendingTasks ?? 0 }}</h3>
            <p class="text-[9px] font-bold text-[var(--color-accent)] mt-4 uppercase tracking-widest">{{ __('messages.immediate_attention') }}</p>
        </div>
        <div class="p-3 bg-[var(--color-bg-base)] text-[var(--color-accent)] rounded-2xl border border-[var(--color-border-soft)]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="card-veltrix !p-6 flex justify-between items-start">
        <div>
            <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-[0.2em] mb-4">{{ __('messages.completed_tasks') }}</p>
            <h3 id="stat-completedTasks" class="heading-editorial text-3xl">{{ $completedTasks ?? 0 }}</h3>
            <p class="text-[9px] font-bold text-emerald-600 mt-4 uppercase tracking-widest">{{ __('messages.successful_resolutions') }}</p>
        </div>
        <div class="p-3 bg-[var(--color-bg-base)] text-emerald-600 rounded-2xl border border-[var(--color-border-soft)]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>
</div>

<!-- Recent Customers -->
<div class="mt-8">
    <div class="card-veltrix !p-0 overflow-hidden">
        <div class="flex justify-between items-center p-8 border-b border-[var(--color-border-soft)] bg-[var(--color-bg-card)]">
            <div>
                <h3 class="heading-editorial text-xl">{{ __('messages.recent_customers') }}</h3>
                <p class="text-muted-veltrix text-[10px] font-bold uppercase tracking-widest mt-1">{{ __('messages.direct_assignments') }}</p>
            </div>
            <a href="{{ route('staff.customers') }}" class="btn-secondary-veltrix !px-6 !py-2 !text-[10px] font-bold uppercase tracking-widest">{{ __('messages.view_all') }}</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[var(--color-border-soft)]">
                        <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.customer_name') }}</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.email_address') }}</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.status') }}</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest text-right">{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody id="recent-customers-list">
                    @forelse($recentCustomers as $customer)
                    <tr class="group hover:bg-[var(--color-bg-base)] transition-colors border-b border-[var(--color-border-soft)] last:border-0">
                        <td class="px-8 py-4">
                            <div class="flex items-center">
                                <div class="w-9 h-9 rounded-xl bg-[var(--color-primary)] text-white flex items-center justify-center font-bold text-xs mr-4 shadow-sm">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-[var(--color-charcoal)]">{{ $customer->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <span class="text-xs font-medium text-muted-veltrix">{{ $customer->email }}</span>
                        </td>
                        <td class="px-8 py-4">
                            <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider
                                @if($customer->status == 'lead') bg-orange-50 text-orange-800 @elseif($customer->status == 'active') bg-emerald-50 text-emerald-800 @else bg-slate-100 text-slate-600 @endif">
                                {{ $customer->status }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <button onclick="viewCustomerDetails({{ $customer->id }})" class="text-[var(--color-primary)] text-[10px] font-bold uppercase tracking-widest hover:underline">{{ __('messages.inspect') }}</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-12 text-center text-muted-veltrix text-sm">{{ __('messages.no_recent_assignments') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Real-time Stats Logic
        window.refreshStaffStats = async function() {
            try {
                const response = await fetch("{{ route('staff.stats') }}");
                const data = await response.json();
                
                const customersCount = document.getElementById('stat-myCustomers');
                const pendingTasksCount = document.getElementById('stat-pendingTasks');
                const completedTasksCount = document.getElementById('stat-completedTasks');
 
                if (customersCount) customersCount.textContent = data.assignedCustomers;
                if (pendingTasksCount) pendingTasksCount.textContent = data.pendingTasks;
                if (completedTasksCount) completedTasksCount.textContent = data.completedTasks;
                
                const list = document.getElementById('recent-customers-list');
                if (list) {
                    if (data.recentCustomers.length > 0) {
                        list.innerHTML = data.recentCustomers.map(c => `
                            <tr class="group hover:bg-[var(--color-bg-base)] transition-colors border-b border-[var(--color-border-soft)] last:border-0">
                                <td class="px-8 py-4">
                                    <div class="flex items-center">
                                        <div class="w-9 h-9 rounded-xl bg-[var(--color-primary)] text-white flex items-center justify-center font-bold text-xs mr-4 shadow-sm">
                                            ${c.name.charAt(0)}
                                        </div>
                                        <span class="text-sm font-bold text-[var(--color-charcoal)]">${c.name}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="text-xs font-medium text-muted-veltrix">${c.email || 'N/A'}</span>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider ${c.status === 'active' ? 'bg-emerald-50 text-emerald-800' : (c.status === 'lead' ? 'bg-orange-50 text-orange-800' : 'bg-slate-100 text-slate-600')}">
                                        ${c.status}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <button onclick="viewCustomerDetails(${c.id})" class="text-[var(--color-primary)] text-[10px] font-bold uppercase tracking-widest hover:underline">{{ __('messages.inspect') }}</button>
                                </td>
                            </tr>
                        `).join('');
                    } else {
                        list.innerHTML = '<tr><td colspan="4" class="px-8 py-12 text-center text-muted-veltrix text-sm">{{ __('messages.no_recent_assignments') }}</td></tr>';
                    }
                }
            } catch (error) {
                console.error('Failed to refresh stats:', error);
            }
        };

        setInterval(refreshStaffStats, 30000); // Poll every 30 seconds
    });
</script>
@endpush
@endsection
