@extends('layouts.dashboard')

@section('title', __('messages.admin_dashboard'))

@section('content')
<div class="mb-10 flex justify-between items-end">
    <div>
        <h1 class="heading-editorial text-4xl mb-1">{{ __('messages.dashboard') }}</h1>
        <p class="text-muted-veltrix text-sm">{{ __('messages.hello') }}, {{ Auth::user()->name }}. {{ __('messages.assignments_msg') }}</p>
    </div>
    <button onclick="refreshStats()" class="btn-primary-veltrix group">
        <svg id="refresh-icon" class="w-4 h-4 mr-2 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
        <span class="text-xs uppercase tracking-widest font-bold">{{ __('messages.refresh_data') }}</span>
    </button>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
    <div class="card-veltrix !p-6 flex justify-between items-start">
        <div>
            <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-[0.2em] mb-4">{{ __('messages.total_customers') }}</p>
            <h3 id="stat-totalCustomers" class="heading-editorial text-3xl">{{ $totalCustomers ?? 0 }}</h3>
            <p class="text-[10px] text-emerald-600 font-bold mt-4 flex items-center bg-emerald-50 px-2 py-1 rounded-lg inline-flex">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +12.5%
            </p>
        </div>
        <div class="p-3 bg-[var(--color-bg-base)] text-[var(--color-primary)] rounded-2xl border border-[var(--color-border-soft)]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
    </div>
    
    <div class="card-veltrix !p-6 flex justify-between items-start">
        <div>
            <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-[0.2em] mb-4">{{ __('messages.active_staff') }}</p>
            <h3 id="stat-totalStaff" class="heading-editorial text-3xl">{{ $totalStaff ?? 0 }}</h3>
            <p class="text-[10px] text-muted-veltrix font-bold mt-4 px-2 py-1 bg-[var(--color-bg-base)] rounded-lg inline-flex">{{ __('messages.online') }}: 12</p>
        </div>
        <div class="p-3 bg-[var(--color-bg-base)] text-[var(--color-accent)] rounded-2xl border border-[var(--color-border-soft)]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>
    </div>

    <div class="card-veltrix !p-6 flex justify-between items-start">
        <div>
            <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-[0.2em] mb-4">{{ __('messages.total_tasks') }}</p>
            <h3 id="stat-totalTasks" class="heading-editorial text-3xl">{{ $totalTasks ?? 0 }}</h3>
            <p class="text-[10px] text-[var(--color-accent)] font-bold mt-4 flex items-center bg-[var(--color-accent)]/5 px-2 py-1 rounded-lg inline-flex">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                -2.4%
            </p>
        </div>
        <div class="p-3 bg-[var(--color-bg-base)] text-[var(--color-graphite)] rounded-2xl border border-[var(--color-border-soft)]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
        </div>
    </div>

    <div class="card-veltrix !p-6 flex justify-between items-start">
        <div>
            <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-[0.2em] mb-4">{{ __('messages.completed') }}</p>
            <h3 id="stat-completedTasks" class="heading-editorial text-3xl">{{ $completedTasks ?? 0 }}</h3>
            <div class="w-24 bg-[var(--color-border-soft)] rounded-full h-1 mt-4 relative overflow-hidden">
                <div class="bg-emerald-600 h-1 rounded-full" style="width: 70%"></div>
            </div>
            <p class="text-[9px] font-bold text-muted-veltrix mt-2 uppercase tracking-widest">70% Efficiency</p>
        </div>
        <div class="p-3 bg-[var(--color-bg-base)] text-emerald-600 rounded-2xl border border-[var(--color-border-soft)]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Analytics Chart -->
    <div class="lg:col-span-2 card-veltrix">
        <div class="flex justify-between items-center w-full mb-8">
            <div>
                <h3 class="heading-editorial text-xl">{{ __('messages.staff_performance_flow') }}</h3>
                <p class="text-muted-veltrix text-[10px] font-bold uppercase tracking-widest mt-1">{{ __('messages.staff_analytics') }}</p>
            </div>
            <select id="metric-selector" class="bg-white border border-[var(--color-border-soft)] rounded-2xl px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-[var(--color-charcoal)] focus:border-[var(--color-primary)] outline-none shadow-sm transition-all appearance-none pr-10 cursor-pointer">
                <option value="all">{{ __('messages.all_metrics') }}</option>
                <option value="customers">{{ __('messages.customers_only') }}</option>
                <option value="tasks">{{ __('messages.tasks_only') }}</option>
            </select>
        </div>
        <div class="h-80 w-full relative">
            <canvas id="growthChart"></canvas>
        </div>
    </div>

    <!-- Recent Activity Timeline -->
    <div class="card-veltrix overflow-hidden flex flex-col">
        <div class="mb-8">
            <h3 class="heading-editorial text-xl">{{ __('messages.system_pulse') }}</h3>
            <p class="text-muted-veltrix text-[10px] font-bold uppercase tracking-widest mt-1">{{ __('messages.real_time_events') }}</p>
        </div>
        <div class="space-y-8 flex-1 overflow-y-auto pr-2 custom-scrollbar" id="activity-timeline">
            @if(isset($recentActivities) && count($recentActivities) > 0)
                @foreach($recentActivities as $activity)
                    @php
                        $actionKey = 'messages.' . strtolower(str_replace(' ', '_', $activity->action));
                        $descKey = 'messages.' . strtolower(str_replace([' ', '.'], ['_', ''], $activity->description));
                    @endphp
                    <div class="relative pl-8 border-l border-[var(--color-border-soft)] pb-4 group">
                        <div class="absolute -left-[4.5px] top-1 w-2 h-2 rounded-full bg-[var(--color-primary)] ring-4 ring-white group-last:bg-[var(--color-accent)]"></div>
                        <p class="text-xs font-bold text-[var(--color-charcoal)] uppercase tracking-wider">{{ Lang::has($actionKey) ? __($actionKey) : $activity->action }}</p>
                        <p class="text-xs text-muted-veltrix mt-1 leading-relaxed">{{ Lang::has($descKey) ? __($descKey) : $activity->description }}</p>
                        <p class="text-[9px] font-bold text-muted-veltrix mt-2 opacity-50 uppercase tracking-widest">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            @else
                <!-- Mock Activity for UI Display -->
                <div class="relative pl-8 border-l border-[var(--color-border-soft)] pb-6 group">
                    <div class="absolute -left-[4.5px] top-1 w-2 h-2 rounded-full bg-[var(--color-primary)] ring-4 ring-white"></div>
                    <p class="text-xs font-bold text-[var(--color-charcoal)] uppercase tracking-wider">{{ __('messages.new_subscription') }}</p>
                    <p class="text-xs text-muted-veltrix mt-1">{{ __('messages.acme_global_upgraded_to_enterprise') }}</p>
                    <p class="text-[9px] font-bold text-muted-veltrix mt-2 opacity-50 uppercase">{{ __('messages.just_now') }}</p>
                </div>
                <div class="relative pl-8 border-l border-[var(--color-border-soft)] pb-6 group">
                    <div class="absolute -left-[4.5px] top-1 w-2 h-2 rounded-full bg-[var(--color-accent)] ring-4 ring-white"></div>
                    <p class="text-xs font-bold text-[var(--color-charcoal)] uppercase tracking-wider">{{ __('messages.task_resolved') }}</p>
                    <p class="text-xs text-muted-veltrix mt-1">{{ __('messages.annual_report_validation_complete') }}</p>
                    <p class="text-[9px] font-bold text-muted-veltrix mt-2 opacity-50 uppercase">{{ __('messages.14_mins_ago') }}</p>
                </div>
                <div class="relative pl-8 border-l border-[var(--color-border-soft)] pb-6 group">
                    <div class="absolute -left-[4.5px] top-1 w-2 h-2 rounded-full bg-[var(--color-primary)] ring-4 ring-white"></div>
                    <p class="text-xs font-bold text-[var(--color-charcoal)] uppercase tracking-wider">{{ __('messages.staff_online') }}</p>
                    <p class="text-xs text-muted-veltrix mt-1">{{ __('messages.marcus_entered_the_workspace') }}</p>
                    <p class="text-[9px] font-bold text-muted-veltrix mt-2 opacity-50 uppercase">{{ __('messages.1_hour_ago') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Recent Customers -->
<div class="mt-8">
    <div class="card-veltrix !p-0 overflow-hidden">
        <div class="flex justify-between items-center p-8 border-b border-[var(--color-border-soft)] bg-[var(--color-bg-card)]">
            <div>
                <h3 class="heading-editorial text-xl">{{ __('messages.recent_customers') }}</h3>
                <p class="text-muted-veltrix text-[10px] font-bold uppercase tracking-widest mt-1">{{ __('messages.newly_onboarded_entities') }}</p>
            </div>
            <a href="{{ route('admin.customers') }}" class="btn-secondary-veltrix !px-6 !py-2 !text-[10px] font-bold uppercase tracking-widest">{{ __('messages.view_all') }}</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[var(--color-border-soft)]">
                        <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.customer_name') }}</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.status') }}</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.joined') }}</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest text-right">{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody id="recent-customers-list">
                    @if(isset($recentCustomers) && count($recentCustomers) > 0)
                        @foreach($recentCustomers as $customer)
                        <tr class="group hover:bg-[var(--color-bg-base)] transition-colors">
                            <td class="px-8 py-4">
                                <div class="flex items-center">
                                    <div class="w-9 h-9 rounded-xl bg-[var(--color-primary)] text-white flex items-center justify-center font-bold text-xs mr-4">
                                        {{ substr($customer->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-[var(--color-charcoal)]">{{ $customer->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider
                                    @if($customer->status == 'lead') bg-orange-50 text-orange-800 @elseif($customer->status == 'active') bg-emerald-50 text-emerald-800 @else bg-slate-100 text-slate-600 @endif">
                                    {{ $customer->status }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-xs font-medium text-muted-veltrix">{{ $customer->created_at->diffForHumans() }}</td>
                            <td class="px-8 py-4 text-right">
                                <button onclick="viewCustomerDetails({{ $customer->id }})" class="text-[var(--color-primary)] text-[10px] font-bold uppercase tracking-widest hover:underline">{{ __('messages.inspect') }}</button>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr><td colspan="4" class="px-8 py-12 text-center text-muted-veltrix text-sm">{{ __('messages.no_recent_transactions') }}</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Timeline Animation
        gsap.from("#activity-timeline > div", {
            x: -10,
            opacity: 0,
            duration: 1,
            stagger: 0.15,
            ease: "power4.out",
            delay: 0.8
        });

        const ctx = document.getElementById('growthChart').getContext('2d');
        
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(45, 58, 45, 0.20)'); // Forest Green, increased opacity fill
        gradient.addColorStop(1, 'rgba(45, 58, 45, 0.0)');  

        let gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
        gradient2.addColorStop(0, 'rgba(155, 90, 70, 0.15)'); // Terracotta, increased opacity fill
        gradient2.addColorStop(1, 'rgba(155, 90, 70, 0.0)');  

        let staffData = @json($staffPerformance);
        if (!staffData || staffData.length === 0) {
            staffData = [
                { name: 'Ramu Parasa', customers_count: 5, tasks_count: 8 },
                { name: 'Test Staff', customers_count: 3, tasks_count: 4 },
                { name: 'Kiran', customers_count: 6, tasks_count: 5 },
                { name: 'Balu Parasa', customers_count: 2, tasks_count: 3 }
            ];
        }

        // Sort ascending by total workload (lowest on the left, highest on the right)
        staffData.sort((a, b) => (a.customers_count + a.tasks_count) - (b.customers_count + b.tasks_count));

        const labels = staffData.map(s => s.name);
        const customersData = staffData.map(s => s.customers_count);
        const tasksData = staffData.map(s => s.tasks_count);

        let growthChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: '{{ __('messages.assigned_customers') }}',
                        data: customersData,
                        borderColor: '#2D3A2D',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#2D3A2D',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: '{{ __('messages.assigned_tasks') }}',
                        data: tasksData,
                        borderColor: '#9B5A46',
                        backgroundColor: gradient2,
                        borderWidth: 2,
                        borderDash: [8, 8],
                        pointRadius: 0,
                        pointHoverRadius: 0,
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: { 
                    legend: { 
                        display: true, 
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 6,
                            padding: 20,
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 10, weight: '700' },
                            color: '#706F6C'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#2D3A2D',
                        titleFont: { family: "'Plus Jakarta Sans', sans-serif", size: 11, weight: '800' },
                        bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
                        padding: 15,
                        cornerRadius: 12,
                        displayColors: true
                    }
                },
                scales: {
                    x: { 
                        grid: { display: false },
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif", size: 10, weight: '600' }, color: '#706F6C' }
                    },
                    y: { 
                        grid: { color: 'rgba(229, 226, 220, 0.4)', drawBorder: false }, 
                        ticks: { 
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 10, weight: '600' }, 
                            color: '#706F6C', 
                            stepSize: 1, 
                            precision: 0,
                            callback: function(value) { 
                                if (Math.floor(value) === value) {
                                    return value; 
                                }
                            }
                        }
                    }
                }
            }
        });

        // Dropdown Metric Selector Logic
        const metricSelector = document.getElementById('metric-selector');
        if (metricSelector) {
            metricSelector.addEventListener('change', (e) => {
                const val = e.target.value;
                if (val === 'all') {
                    growthChart.setDatasetVisibility(0, true);
                    growthChart.setDatasetVisibility(1, true);
                } else if (val === 'customers') {
                    growthChart.setDatasetVisibility(0, true);
                    growthChart.setDatasetVisibility(1, false);
                } else if (val === 'tasks') {
                    growthChart.setDatasetVisibility(0, false);
                    growthChart.setDatasetVisibility(1, true);
                }
                growthChart.update();
            });
        }

        // Real-time Stats Logic
        window.refreshStats = async function() {
            const btn = document.getElementById('refresh-icon');
            btn.classList.add('animate-spin');
            
            try {
                const response = await fetch("{{ route('admin.stats') }}");
                const data = await response.json();
                
                document.getElementById('stat-totalCustomers').textContent = data.totalCustomers;
                document.getElementById('stat-totalStaff').textContent = data.totalStaff;
                document.getElementById('stat-totalTasks').textContent = data.totalTasks;
                document.getElementById('stat-completedTasks').textContent = data.completedTasks;
                
                // Update chart dynamically
                if (growthChart && data.staffPerformance) {
                    let freshStaffData = data.staffPerformance;
                    if (!freshStaffData || freshStaffData.length === 0) {
                        freshStaffData = [
                            { name: 'Ramu Parasa', customers_count: 5, tasks_count: 8 },
                            { name: 'Test Staff', customers_count: 3, tasks_count: 4 },
                            { name: 'Kiran', customers_count: 6, tasks_count: 5 },
                            { name: 'Balu Parasa', customers_count: 2, tasks_count: 3 }
                        ];
                    }
                    // Sort ascending by total workload
                    freshStaffData.sort((a, b) => (a.customers_count + a.tasks_count) - (b.customers_count + b.tasks_count));

                    growthChart.data.labels = freshStaffData.map(s => s.name);
                    growthChart.data.datasets[0].data = freshStaffData.map(s => s.customers_count);
                    growthChart.data.datasets[1].data = freshStaffData.map(s => s.tasks_count);
                    growthChart.update();
                }

                const list = document.getElementById('recent-customers-list');
                if (data.recentCustomers.length > 0) {
                    list.innerHTML = data.recentCustomers.map(c => `
                        <tr class="group hover:bg-[var(--color-bg-base)] transition-colors">
                            <td class="px-8 py-4">
                                <div class="flex items-center">
                                    <div class="w-9 h-9 rounded-xl bg-[var(--color-primary)] text-white flex items-center justify-center font-bold text-xs mr-4">
                                        ${c.name.charAt(0)}
                                    </div>
                                    <span class="text-sm font-bold text-[var(--color-charcoal)]">${c.name}</span>
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider ${c.status === 'active' ? 'bg-emerald-50 text-emerald-800' : (c.status === 'lead' ? 'bg-orange-50 text-orange-800' : 'bg-slate-100 text-slate-600')}">
                                    ${c.status}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-xs font-medium text-muted-veltrix">{{ __('messages.just_now') }}</td>
                            <td class="px-8 py-4 text-right">
                                <button onclick="viewCustomerDetails(${c.id})" class="text-[var(--color-primary)] text-[10px] font-bold uppercase tracking-widest hover:underline">{{ __('messages.inspect') }}</button>
                            </td>
                        </tr>
                    `).join('');
                }
            } catch (error) {
                console.error('Failed to refresh stats:', error);
            } finally {
                setTimeout(() => btn.classList.remove('animate-spin'), 500);
            }
        };

        setInterval(refreshStats, 30000); // Poll every 30 seconds
    });
</script>
@endpush
@endsection
