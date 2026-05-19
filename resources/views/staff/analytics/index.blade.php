@extends('layouts.dashboard')

@section('title', __('messages.intelligence') . ' | VeltrixCRM')

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
    <div>
        <h1 class="heading-editorial text-4xl mb-1">{{ __('messages.intelligence') }}</h1>
        <p class="text-muted-veltrix text-sm">{{ __('messages.intelligence_subtitle') }}</p>
    </div>
    <div class="flex gap-3 w-full md:w-auto">
        <select class="bg-white border border-[var(--color-border-soft)] text-[10px] font-bold uppercase tracking-widest text-muted-veltrix rounded-2xl px-5 py-3 outline-none shadow-sm appearance-none pr-10 cursor-pointer">
            <option>{{ __('messages.last_30_days') }}</option>
            <option>{{ __('messages.last_quarter') }}</option>
            <option>{{ __('messages.this_year') }}</option>
        </select>
        <div class="relative group inline-block" id="export-dropdown-wrapper">
            <button class="btn-primary-veltrix !px-8 !rounded-xl inline-flex items-center gap-2 cursor-pointer transition-all duration-300">
                <span class="text-xs uppercase tracking-widest font-bold">Export Report</span>
                <svg class="w-3.5 h-3.5 text-white opacity-85 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-2xl border border-[var(--color-border-soft)] opacity-0 translate-y-2 pointer-events-none transition-all duration-300 z-[99] overflow-hidden group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto">
                <button onclick="downloadFormat('csv')" class="w-full flex items-center px-5 py-3.5 text-[10px] font-bold uppercase tracking-widest text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition-colors border-b border-[var(--color-border-soft)] text-left">
                    📁 .csv
                </button>
                <button onclick="downloadFormat('pdf')" class="w-full flex items-center px-5 py-3.5 text-[10px] font-bold uppercase tracking-widest text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition-colors border-b border-[var(--color-border-soft)] text-left">
                    📄 .pdf
                </button>
                <button onclick="downloadFormat('docx')" class="w-full flex items-center px-5 py-3.5 text-[10px] font-bold uppercase tracking-widest text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition-colors text-left">
                    📝 .docx
                </button>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
    <div class="card-veltrix !p-8">
        <div class="flex justify-between items-center mb-8">
            <h3 class="heading-editorial text-xl">{{ __('messages.entity_distribution') }}</h3>
            <span class="text-[9px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.market_segmentation') }}</span>
        </div>
        <div class="h-64 relative">
            <canvas id="customerChart"></canvas>
        </div>
    </div>
    <div class="card-veltrix !p-8">
        <div class="flex justify-between items-center mb-8">
            <h3 class="heading-editorial text-xl">{{ __('messages.operational_velocity') }}</h3>
            <span class="text-[9px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.objective_throughput') }}</span>
        </div>
        <div class="h-64 relative">
            <canvas id="taskChart"></canvas>
        </div>
    </div>
</div>

<div class="card-veltrix !p-0 overflow-hidden">
    <div class="px-8 py-6 border-b border-[var(--color-border-soft)] flex justify-between items-center bg-[var(--color-bg-card)]">
        <div>
            <h3 class="heading-editorial text-xl">{{ __('messages.system_pulse') }}</h3>
            <p class="text-muted-veltrix text-[10px] font-bold uppercase tracking-widest mt-1">{{ __('messages.activity_sequence') }}</p>
        </div>
        <div class="flex items-center space-x-4">
            <button onclick="clearLogs()" class="text-[9px] font-bold text-[var(--color-accent)] hover:text-white uppercase tracking-widest px-4 py-1.5 border border-[var(--color-accent)]/20 rounded-xl hover:bg-[var(--color-accent)] transition-all">
                {{ __('messages.purge_sequence') }}
            </button>
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[9px] font-bold text-muted-veltrix tracking-[0.2em] uppercase">{{ __('messages.live_sync') }}</span>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-[var(--color-border-soft)]">
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.authority') }}</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.operation') }}</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.parameter') }}</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.timestamp') }}</th>
                </tr>
            </thead>
            <tbody id="logs-body">
                <!-- Logs will be injected here -->
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    let customerChart, taskChart;

    // Export function supporting CSV, PDF, and DOCX generation for staff
    function downloadFormat(format) {
        if (format === 'csv') {
            const link = document.createElement('a');
            link.href = "{{ route('staff.analytics.export') }}";
            link.download = 'veltrix_staff_report.csv';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            showSuccessMessage("Workspace intelligence report exported as CSV successfully!");
        } else if (format === 'docx') {
            // Generate a beautifully styled DOCX report (using formatted HTML structure) for staff
            const htmlContent = `
                <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
                <head>
                    <title>Veltrix CRM Staff Report</title>
                    <style>
                        body { font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.6; color: #1a1a1a; }
                        h1 { color: #2D3A2D; font-size: 24pt; border-bottom: 2px solid #2D3A2D; padding-bottom: 10px; font-family: sans-serif; }
                        h3 { color: #2D3A2D; font-size: 14pt; border-bottom: 1px solid #E5E2DC; padding-bottom: 5px; margin-top: 25px; }
                        p { font-size: 11pt; }
                        table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 25px; }
                        th { border-bottom: 2.5px solid #2D3A2D; text-align: left; padding: 8px; font-weight: bold; font-size: 11pt; }
                        td { border-bottom: 1px solid #E5E2DC; padding: 8px; font-size: 10.5pt; }
                    </style>
                </head>
                <body>
                    <h1>VELTRIX CRM STAFF REPORT</h1>
                    <p><strong>Generated At:</strong> ${new Date().toLocaleString()}</p>
                    <p><strong>Author:</strong> ${document.querySelector('#topbar .font-bold')?.textContent || 'Staff Member'}</p>
                    
                    <h3>1. Assigned Customer Distribution</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Customer Segment</th>
                                <th style="text-align: right;">Total Records</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="color: #d97706; font-weight: bold;">Leads / Prospects</td>
                                <td style="text-align: right; font-weight: bold;">${customerChart.data.datasets[0].data[0]}</td>
                            </tr>
                            <tr>
                                <td style="color: #065f46; font-weight: bold;">Active Customers</td>
                                <td style="text-align: right; font-weight: bold;">${customerChart.data.datasets[0].data[1]}</td>
                            </tr>
                            <tr>
                                <td style="color: #71717a; font-weight: bold;">Inactive Accounts</td>
                                <td style="text-align: right; font-weight: bold;">${customerChart.data.datasets[0].data[2]}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h3>2. Assigned Task Velocity</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Task Status</th>
                                <th style="text-align: right;">Total Tasks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="color: #10b981; font-weight: bold;">Pending Deliverables</td>
                                <td style="text-align: right; font-weight: bold;">${taskChart.data.datasets[0].data[0]}</td>
                            </tr>
                            <tr>
                                <td style="color: #059669; font-weight: bold;">In Progress Activities</td>
                                <td style="text-align: right; font-weight: bold;">${taskChart.data.datasets[0].data[1]}</td>
                            </tr>
                            <tr>
                                <td style="color: #064e3b; font-weight: bold;">Completed Milestones</td>
                                <td style="text-align: right; font-weight: bold;">${taskChart.data.datasets[0].data[2]}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h3>3. Recent Team Operational Logs</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${Array.from(document.querySelectorAll('#logs-body tr')).slice(0, 8).map(tr => `
                                <tr>
                                    <td style="font-weight: bold;">${tr.querySelector('td:nth-child(1) span').textContent}</td>
                                    <td>${tr.querySelector('td:nth-child(2) span').textContent.trim()}</td>
                                    <td>${tr.querySelector('td:nth-child(3)').textContent}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </body>
                </html>
            `;
            
            const blob = new Blob(['\ufeff' + htmlContent], {
                type: 'application/msword'
            });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'veltrix_staff_report_' + new Date().toISOString().slice(0,10) + '.docx';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
            showSuccessMessage("Workspace intelligence report exported as DOCX successfully!");
        } else if (format === 'pdf') {
            // Generate a beautifully styled PDF report directly from the client data
            const element = document.createElement('div');
            element.className = 'p-10 bg-white text-black font-sans';
            element.style.width = '750px';
            element.style.color = '#1a1a1a';
            
            // Build the PDF content
            element.innerHTML = `
                <div style="border-bottom: 2px solid #2D3A2D; padding-bottom: 16px; margin-bottom: 24px;">
                    <h1 style="color: #2D3A2D; margin: 0; font-size: 26px; font-family: sans-serif;">VELTRIX CRM</h1>
                    <p style="color: #706F6C; margin: 4px 0 0 0; font-size: 13px;">Staff Performance & Intelligence Report</p>
                </div>
                
                <table style="width: 100%; margin-bottom: 20px; font-size: 12px; color: #555;">
                    <tr>
                        <td><strong>Generated At:</strong> ${new Date().toLocaleString()}</td>
                        <td style="text-align: right;"><strong>Author:</strong> ${document.querySelector('#topbar .font-bold')?.textContent || 'Staff Member'}</td>
                    </tr>
                </table>

                <div style="margin-top: 20px; margin-bottom: 24px;">
                    <h3 style="color: #2D3A2D; border-bottom: 1px solid #E5E2DC; padding-bottom: 6px; font-size: 16px;">1. Assigned Customer Distribution</h3>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 13px;">
                        <thead>
                            <tr style="border-bottom: 1.5px solid #2D3A2D; text-align: left; font-weight: bold; color: #2D3A2D;">
                                <th style="padding: 8px 0;">Customer Segment</th>
                                <th style="padding: 8px 0; text-align: right;">Total Records</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: 1px solid #E5E2DC;">
                                <td style="padding: 8px 0; color: #d97706; font-weight: bold;">Leads / Prospects</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: bold;">${customerChart.data.datasets[0].data[0]}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #E5E2DC;">
                                <td style="padding: 8px 0; color: #065f46; font-weight: bold;">Active Customers</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: bold;">${customerChart.data.datasets[0].data[1]}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #E5E2DC;">
                                <td style="padding: 8px 0; color: #71717a; font-weight: bold;">Inactive Accounts</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: bold;">${customerChart.data.datasets[0].data[2]}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 20px; margin-bottom: 24px;">
                    <h3 style="color: #2D3A2D; border-bottom: 1px solid #E5E2DC; padding-bottom: 6px; font-size: 16px;">2. Assigned Task Velocity</h3>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 13px;">
                        <thead>
                            <tr style="border-bottom: 1.5px solid #2D3A2D; text-align: left; font-weight: bold; color: #2D3A2D;">
                                <th style="padding: 8px 0;">Task Status</th>
                                <th style="padding: 8px 0; text-align: right;">Total Tasks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: 1px solid #E5E2DC;">
                                <td style="padding: 8px 0; color: #10b981; font-weight: bold;">Pending Deliverables</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: bold;">${taskChart.data.datasets[0].data[0]}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #E5E2DC;">
                                <td style="padding: 8px 0; color: #059669; font-weight: bold;">In Progress Activities</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: bold;">${taskChart.data.datasets[0].data[1]}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #E5E2DC;">
                                <td style="padding: 8px 0; color: #064e3b; font-weight: bold;">Completed Milestones</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: bold;">${taskChart.data.datasets[0].data[2]}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 20px; margin-bottom: 10px; page-break-inside: avoid;">
                    <h3 style="color: #2D3A2D; border-bottom: 1px solid #E5E2DC; padding-bottom: 6px; font-size: 16px;">3. Recent Team Operational Logs</h3>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11px;">
                        <thead>
                            <tr style="border-bottom: 1.5px solid #2D3A2D; text-align: left; font-weight: bold; color: #2D3A2D;">
                                <th style="padding: 6px 0;">User</th>
                                <th style="padding: 6px 0;">Action</th>
                                <th style="padding: 6px 0;">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${Array.from(document.querySelectorAll('#logs-body tr')).slice(0, 8).map(tr => `
                                <tr style="border-bottom: 1px solid #E5E2DC;">
                                    <td style="padding: 6px 0; font-weight: bold;">${tr.querySelector('td:nth-child(1) span').textContent}</td>
                                    <td style="padding: 6px 0;"><span style="background: #F5F3EF; border: 1px solid #E5E2DC; padding: 2px 6px; border-radius: 4px; font-size: 10px;">${tr.querySelector('td:nth-child(2) span').textContent.trim()}</span></td>
                                    <td style="padding: 6px 0; color: #555;">${tr.querySelector('td:nth-child(3)').textContent}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 40px; border-top: 1px solid #E5E2DC; padding-top: 10px; font-size: 10px; color: #706F6C; text-align: center;">
                    © ${new Date().getFullYear()} VeltrixCRM Technologies. All rights reserved. Confidential intelligence report.
                </div>
            `;
            
            const opt = {
                margin: 0.5,
                filename: 'veltrix_staff_report_' + new Date().toISOString().slice(0,10) + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            
            html2pdf().from(element).set(opt).save();
            showSuccessMessage("Workspace intelligence report exported as PDF successfully!");
        }
    }

    const translationMap = {
        'LOGIN': "{{ __('messages.login') }}",
        'LOGOUT': "{{ __('messages.logout') }}",
        'GOOGLE LOGIN': "{{ __('messages.google_login') }}",
        'REGISTRATION': "{{ __('messages.registration') }}",
        'User logged into the system.': "{{ __('messages.user_logged_into_the_system') }}",
        'User logged out.': "{{ __('messages.user_logged_out') }}",
        'User successfully logged in via Google OAuth.': "{{ __('messages.user_successfully_logged_in_via_google_oauth') }}",
        'User registered via Google OAuth as a staff.': "{{ __('messages.user_registered_via_google_oauth_as_a_staff') }}",
        'Sequence empty.': "{{ __('messages.sequence_empty') }}"
    };

    function getTranslation(str) {
        if (!str) return '';
        const clean = str.trim();
        return translationMap[clean] || clean;
    }

    async function initCharts() {
        const response = await fetch("{{ route('staff.analytics.data') }}");
        const data = await response.json();

        const chartFont = {
            family: "'Plus Jakarta Sans', sans-serif",
            size: 10,
            weight: '700'
        };

        // Customer Chart (Doughnut matched 100% with Veltrix Admin)
        const ctxC = document.getElementById('customerChart').getContext('2d');
        if (customerChart) customerChart.destroy();
        customerChart = new Chart(ctxC, {
            type: 'doughnut',
            data: {
                labels: ['{{ __('messages.lead') }}', '{{ __('messages.active') }}', '{{ __('messages.inactive') }}'],
                datasets: [{
                    data: [data.customerStats.lead, data.customerStats.active, data.customerStats.inactive],
                    backgroundColor: ['#d97706', '#065f46', '#71717a'], // Exact Admin Colors
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { 
                        position: 'bottom', 
                        labels: { 
                            usePointStyle: true, 
                            padding: 30,
                            font: chartFont,
                            color: '#71717a',
                            useBorderRadius: true,
                            borderRadius: 4
                        } 
                    }
                }
            }
        });

        // Task Chart (Bar matched 100% with Veltrix Admin)
        const ctxT = document.getElementById('taskChart').getContext('2d');
        if (taskChart) taskChart.destroy();
        taskChart = new Chart(ctxT, {
            type: 'bar',
            data: {
                labels: ['{{ __('messages.pending') }}', '{{ __('messages.in_progress') }}', '{{ __('messages.completed') }}'],
                datasets: [{
                    label: '{{ __('messages.tasks') }}',
                    data: [data.taskStats.pending, data.taskStats.in_progress, data.taskStats.completed],
                    backgroundColor: ['#10b981', '#059669', '#064e3b'], // Exact Admin Colors
                    borderRadius: 12,
                    maxBarThickness: 45
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { display: true, color: 'rgba(0,0,0,0.03)' },
                        ticks: { font: chartFont, color: '#a1a1aa' }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: { font: chartFont, color: '#a1a1aa' }
                    }
                },
                plugins: { 
                    legend: { display: false }
                }
            }
        });

        updateLogs(data.recentLogs);
    }

    function updateLogs(logs) {
        const body = document.getElementById('logs-body');
        if (!body) return;
        if (logs.length === 0) {
            body.innerHTML = `<tr><td colspan="4" class="px-8 py-12 text-center text-muted-veltrix text-sm">${getTranslation('Sequence empty.')}</td></tr>`;
            return;
        }
        body.innerHTML = logs.map(log => `
            <tr class="group hover:bg-[var(--color-bg-base)] transition-colors border-b border-[var(--color-border-soft)] last:border-0">
                <td class="px-8 py-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-xl bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] text-[var(--color-primary)] flex items-center justify-center text-[10px] font-bold mr-4 shadow-sm group-hover:bg-white transition-colors">
                            ${log.user.name.charAt(0)}
                        </div>
                        <span class="text-xs font-bold text-[var(--color-charcoal)]">${log.user.name}</span>
                    </div>
                </td>
                <td class="px-8 py-4">
                    <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider bg-[var(--color-bg-card)] text-muted-veltrix border border-[var(--color-border-soft)] group-hover:bg-white transition-colors">
                        ${getTranslation(log.action)}
                    </span>
                </td>
                <td class="px-8 py-4 text-xs font-medium text-muted-veltrix">${getTranslation(log.description)}</td>
                <td class="px-8 py-4 text-[10px] text-muted-veltrix font-bold uppercase tracking-widest opacity-60">${new Date(log.created_at).toLocaleTimeString()}</td>
            </tr>
        `).join('');
    }

    async function clearLogs() {
        if (!confirm("{{ __('messages.confirm_purge_sequence') }}")) return;
        try {
            const response = await fetch("{{ route('staff.analytics.logs.clear') }}", {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (data.success) {
                gsap.to('#logs-body tr', {
                    x: 20,
                    opacity: 0,
                    stagger: 0.05,
                    duration: 0.4,
                    onComplete: () => updateLogs([])
                });
                showSuccessMessage("{{ __('messages.sequence_purged_success') }}");
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    initCharts();

    // Refresh every 30 seconds
    setInterval(async () => {
        try {
            const response = await fetch("{{ route('staff.analytics.data') }}");
            const data = await response.json();
            
            if (customerChart) {
                customerChart.data.datasets[0].data = [data.customerStats.lead, data.customerStats.active, data.customerStats.inactive];
                customerChart.update();
            }

            if (taskChart) {
                taskChart.data.datasets[0].data = [data.taskStats.pending, data.taskStats.in_progress, data.taskStats.completed];
                taskChart.update();
            }

            updateLogs(data.recentLogs);
        } catch (e) {
            console.error('Refresh failed', e);
        }
    }, 30000);
</script>
@endpush
@endsection
