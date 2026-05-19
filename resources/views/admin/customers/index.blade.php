@extends('layouts.dashboard')

@section('title', 'Manage Customers')

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
    <div>
        <h1 class="heading-editorial text-4xl mb-1">{{ __('messages.customers') }}</h1>
        <p class="text-muted-veltrix text-sm">{{ __('messages.staff_overview') }}</p>
    </div>
    <div class="flex flex-wrap items-center gap-4 w-full md:w-auto">
        <form action="{{ route('admin.customers') }}" method="GET" class="flex flex-1 md:flex-none items-center gap-3">
            <div class="relative flex-1 md:w-72">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_client_records') }}" class="w-full bg-white border border-[var(--color-border-soft)] rounded-2xl px-5 py-3 text-xs font-bold uppercase tracking-widest placeholder-muted-veltrix focus:border-[var(--color-primary)] outline-none shadow-sm transition-all">
                <button type="submit" class="absolute right-5 top-3.5 text-muted-veltrix hover:text-[var(--color-primary)] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
            <select name="staff_id" onchange="this.form.submit()" class="bg-white border border-[var(--color-border-soft)] rounded-2xl px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-[var(--color-charcoal)] focus:border-[var(--color-primary)] outline-none shadow-sm transition-all appearance-none pr-10 cursor-pointer">
                <option value="">{{ __('messages.all_personnel') }}</option>
                @foreach($staff as $s)
                    <option value="{{ $s->id }}" {{ request('staff_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
            @if(request('search') || request('staff_id'))
                <a href="{{ route('admin.customers') }}" class="text-muted-veltrix hover:text-[var(--color-accent)] p-2 transition-colors" title="Clear Filters">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            @endif
        </form>
        <button onclick="document.getElementById('add-customer-modal').classList.remove('hidden')" class="btn-primary-veltrix space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span class="text-xs uppercase tracking-widest">{{ __('messages.add_customer') }}</span>
        </button>
    </div>
</div>

<div class="card-veltrix !p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[var(--color-bg-card)] border-b border-[var(--color-border-soft)]">
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.customer_name') }}</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.email_address') }}</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.phone_number') }}</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.status') }}</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.assigned_to') }}</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest text-center">{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody id="customer-table-body">
                @forelse($customers as $customer)
                <tr class="group hover:bg-[var(--color-bg-base)] transition-colors border-b border-[var(--color-border-soft)] last:border-0" id="customer-row-{{ $customer->id }}">
                    <td class="px-8 py-5">
                        <div class="flex items-center">
                            <div class="w-9 h-9 rounded-xl bg-[var(--color-primary)] text-white flex items-center justify-center font-bold text-xs mr-4 shadow-sm">
                                {{ substr($customer->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-bold text-[var(--color-charcoal)]">{{ $customer->name }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <a href="mailto:{{ $customer->email }}" class="text-xs font-medium text-muted-veltrix hover:text-[var(--color-primary)] transition-colors flex items-center gap-2">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $customer->email }}
                        </a>
                    </td>
                    <td class="px-8 py-5">
                        @if($customer->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone) }}" target="_blank" class="inline-flex items-center space-x-2 text-muted-veltrix hover:text-emerald-600 transition-colors duration-200 group" title="Message on WhatsApp">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.115.548 4.183 1.594 6.012L.15 23.85l5.961-1.564A11.968 11.968 0 0012.03 24c6.646 0 12.031-5.385 12.031-12.031S18.677 0 12.031 0zm0 21.969c-1.844 0-3.655-.496-5.244-1.439l-.376-.223-3.89 1.02 1.04-3.79-.245-.39A9.927 9.927 0 012.03 12.03C2.03 6.516 6.516 2.03 12.031 2.03c5.515 0 10 4.486 10 10s-4.485 10-10 10zm5.495-7.514c-.301-.151-1.782-.88-2.057-.98-.276-.101-.477-.151-.678.15-.201.302-.779.98-.954 1.18-.176.202-.352.227-.653.076-1.554-.775-2.658-1.405-3.69-3.21-.101-.176.106-.164.402-.756.1-.202.05-.378-.025-.529-.075-.151-.678-1.636-.928-2.241-.244-.59-.493-.51-.678-.519-.176-.01-.378-.01-.578-.01-.201 0-.527.075-.803.377-.276.302-1.054 1.031-1.054 2.514 0 1.483 1.079 2.916 1.23 3.118.151.201 2.127 3.245 5.152 4.548 2.046.88 2.68.705 3.181.579.624-.158 1.782-.729 2.032-1.433.251-.704.251-1.308.176-1.433-.075-.126-.276-.201-.577-.352z"/></svg>
                            <span class="text-xs font-medium">{{ $customer->phone }}</span>
                        </a>
                        @else
                        <span class="text-[10px] font-bold text-muted-veltrix opacity-30">N/A</span>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider
                            @if($customer->status == 'lead') bg-orange-50 text-orange-800 @elseif($customer->status == 'active') bg-emerald-50 text-emerald-800 @else bg-slate-100 text-slate-600 @endif">
                            {{ $customer->status }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="text-xs font-bold text-[var(--color-charcoal)] flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full {{ $customer->assignedTo ? 'bg-emerald-500' : 'bg-[var(--color-border-soft)]' }}"></div>
                            {{ $customer->assignedTo->name ?? 'Unassigned' }}
                        </div>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <div class="flex justify-center gap-2">
                            <button onclick="viewCustomerDetails({{ $customer->id }})" class="p-2 text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] rounded-xl transition-all" title="{{ __('messages.inspect') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            <button onclick="openEditCustomerModal({{ $customer->id }})" class="p-2 text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] rounded-xl transition-all" title="{{ __('messages.edit_customer') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button onclick="deleteCustomer({{ $customer->id }})" class="p-2 text-muted-veltrix hover:text-[var(--color-accent)] hover:bg-[var(--color-accent)]/5 rounded-xl transition-all" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-20 text-center">
                        <div class="w-16 h-16 bg-[var(--color-bg-card)] text-muted-veltrix rounded-2xl flex items-center justify-center mx-auto mb-4 opacity-50">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <p class="text-muted-veltrix text-sm font-bold uppercase tracking-widest opacity-40">No records matching criteria</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Customer Modal -->
<div id="add-customer-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-[var(--color-primary)]/10 backdrop-blur-md">
    <div class="bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 border border-[var(--color-border-soft)]" id="modal-content">
        <div class="px-10 py-8 border-b border-[var(--color-border-soft)] flex justify-between items-center bg-[var(--color-bg-card)]">
            <div>
                <h3 class="heading-editorial text-2xl">{{ __('messages.add_customer') }}</h3>
                <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mt-1">Initiate New Relationship</p>
            </div>
            <button id="close-modal-btn" class="text-muted-veltrix hover:text-[var(--color-accent)] transition p-2 bg-white rounded-xl shadow-sm border border-[var(--color-border-soft)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-10">
            <form id="add-customer-form" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.full_name') }}</label>
                        <input type="text" name="name" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold" placeholder="E.g. Alexander Pierce">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.email_address') }}</label>
                        <input type="email" name="email" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold" placeholder="alex@domain.com">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.phone_number') }}</label>
                        <input type="text" name="phone" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold" placeholder="+1 234 567 890">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.status') }}</label>
                        <select name="status" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold uppercase tracking-widest appearance-none cursor-pointer">
                            <option value="lead">{{ __('messages.lead') }}</option>
                            <option value="active">{{ __('messages.active') }}</option>
                            <option value="inactive">{{ __('messages.inactive') }}</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.assigned_to') }}</label>
                    <select name="assigned_to" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold uppercase tracking-widest appearance-none cursor-pointer">
                        @foreach(\App\Models\User::where('role', 'staff')->get() as $staffMember)
                            <option value="{{ $staffMember->id }}">{{ $staffMember->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeModal()" class="flex-1 btn-secondary-veltrix">
                        {{ __('messages.close_details') }}
                    </button>
                    <button type="submit" class="flex-1 btn-primary-veltrix">
                        <span class="text-xs uppercase tracking-widest font-bold">{{ __('messages.save_customer') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div id="edit-customer-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-[var(--color-primary)]/10 backdrop-blur-md">
    <div class="bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 border border-[var(--color-border-soft)]" id="edit-modal-content">
        <div class="px-10 py-8 border-b border-[var(--color-border-soft)] flex justify-between items-center bg-[var(--color-bg-card)]">
            <div>
                <h3 class="heading-editorial text-2xl">{{ __('messages.edit_customer') }}</h3>
                <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mt-1">Modify Customer Profile Parameters</p>
            </div>
            <button onclick="closeEditModal()" class="text-muted-veltrix hover:text-[var(--color-accent)] transition p-2 bg-white rounded-xl shadow-sm border border-[var(--color-border-soft)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-10">
            <form id="edit-customer-form" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-customer-id">
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.full_name') }}</label>
                    <input type="text" name="name" id="edit-customer-name" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.email_address') }}</label>
                    <input type="email" name="email" id="edit-customer-email" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-medium">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.phone_number') }}</label>
                    <input type="text" name="phone" id="edit-customer-phone" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-medium">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.status') }}</label>
                        <select name="status" id="edit-customer-status" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold uppercase tracking-widest appearance-none cursor-pointer">
                            <option value="lead">{{ __('messages.lead') }}</option>
                            <option value="active">{{ __('messages.active') }}</option>
                            <option value="inactive">{{ __('messages.inactive') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.assigned_to') }}</label>
                        <select name="assigned_to" id="edit-customer-assigned" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold uppercase tracking-widest appearance-none cursor-pointer">
                            <option value="">{{ __('messages.unassigned') }}</option>
                            @foreach($staff as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeEditModal()" class="flex-1 btn-secondary-veltrix">
                        {{ __('messages.close_details') }}
                    </button>
                    <button type="submit" class="flex-1 btn-primary-veltrix">
                        <span class="text-xs uppercase tracking-widest font-bold">{{ __('messages.save_changes') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const modal = document.getElementById('add-customer-modal');
    const modalContent = document.getElementById('modal-content');
    const openBtn = document.querySelector('button[onclick*="add-customer-modal"]');
    const closeBtn = document.getElementById('close-modal-btn');
    const addForm = document.getElementById('add-customer-form');

    const editModal = document.getElementById('edit-customer-modal');
    const editModalContent = document.getElementById('edit-modal-content');
    const editCustomerForm = document.getElementById('edit-customer-form');

    function openModal() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    addForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(addForm);
        try {
            const response = await fetch("{{ route('customers.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: formData
            });
            const data = await response.json();
            if (data.success) {
                closeModal();
                showSuccessMessage('Customer onboarding successful');
                setTimeout(() => location.reload(), 1500);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    async function openEditCustomerModal(id) {
        try {
            const response = await fetch(`/api/customers/${id}`);
            const customer = await response.json();
            
            document.getElementById('edit-customer-id').value = customer.id;
            document.getElementById('edit-customer-name').value = customer.name;
            document.getElementById('edit-customer-email').value = customer.email || '';
            document.getElementById('edit-customer-phone').value = customer.phone || '';
            document.getElementById('edit-customer-status').value = customer.status;
            document.getElementById('edit-customer-assigned').value = customer.assigned_to || '';

            editModal.classList.remove('hidden');
            setTimeout(() => {
                editModalContent.classList.remove('scale-95', 'opacity-0');
                editModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        } catch (error) {
            console.error('Error fetching customer details:', error);
        }
    }

    function closeEditModal() {
        editModalContent.classList.remove('scale-100', 'opacity-100');
        editModalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            editModal.classList.add('hidden');
        }, 300);
    }

    editModal?.addEventListener('click', (e) => {
        if (e.target === editModal) closeEditModal();
    });

    editCustomerForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('edit-customer-id').value;
        const formData = new FormData(editCustomerForm);
        try {
            const response = await fetch(`/customers/${id}`, {
                method: 'POST', // Spooled PUT via _method in FormData
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: formData
            });
            const data = await response.json();
            if (data.success) {
                closeEditModal();
                showSuccessMessage('Customer details updated');
                setTimeout(() => location.reload(), 1500);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    async function deleteCustomer(id) {
        if (!confirm('Permanently remove this customer record?')) return;
        try {
            const response = await fetch(`/customers/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (data.success) {
                gsap.to(`#customer-row-${id}`, {
                    x: 20,
                    opacity: 0,
                    duration: 0.5,
                    onComplete: () => document.getElementById(`customer-row-${id}`).remove()
                });
                showSuccessMessage('Record purged successfully');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
</script>
@endpush
@endsection
