@extends('layouts.dashboard')

@section('title', __('messages.manage_staff'))

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
    <div>
        <h1 class="heading-editorial text-4xl mb-1">{{ __('messages.personnel') }}</h1>
        <p class="text-muted-veltrix text-sm">{{ __('messages.orchestrate_team_desc') }}</p>
    </div>
    <div class="flex flex-wrap items-center gap-4 w-full md:w-auto">
        <form action="{{ route('admin.staff') }}" method="GET" class="flex flex-1 md:flex-none items-center gap-3">
            <div class="relative flex-1 md:w-72">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_personnel') }}" class="w-full bg-white border border-[var(--color-border-soft)] rounded-2xl px-5 py-3 text-xs font-bold uppercase tracking-widest focus:border-[var(--color-primary)] outline-none shadow-sm transition-all">
                <button type="submit" class="absolute right-5 top-3.5 text-muted-veltrix hover:text-[var(--color-primary)] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
            @if(request('search'))
                <a href="{{ route('admin.staff') }}" class="text-muted-veltrix hover:text-[var(--color-accent)] p-2 transition-colors" title="Clear Filters">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            @endif
        </form>
        <button id="open-modal-btn" class="btn-primary-veltrix space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span class="text-xs uppercase tracking-widest font-bold">{{ __('messages.add_member') }}</span>
        </button>
    </div>
</div>

<div class="card-veltrix !p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[var(--color-bg-card)] border-b border-[var(--color-border-soft)]">
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.name') }}</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.email') }}</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.role') }}</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">{{ __('messages.joined') }}</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-muted-veltrix uppercase tracking-widest text-center">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody id="staff-table-body">
                @forelse($staff as $member)
                <tr class="group hover:bg-[var(--color-bg-base)] transition-colors border-b border-[var(--color-border-soft)] last:border-0" id="staff-row-{{ $member->id }}">
                    <td class="px-8 py-4">
                        <div class="flex items-center">
                            <div class="w-9 h-9 rounded-xl bg-[var(--color-primary)] text-white flex items-center justify-center font-bold text-xs mr-4 shadow-sm">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-bold text-[var(--color-charcoal)]">{{ $member->name }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-4 text-muted-veltrix text-xs font-medium">{{ $member->email }}</td>
                    <td class="px-8 py-4">
                        <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider bg-[var(--color-bg-base)] text-[var(--color-primary)]">
                            {{ $member->role }}
                        </span>
                    </td>
                    <td class="px-8 py-4 text-muted-veltrix text-xs">{{ $member->created_at->format('M d, Y') }}</td>
                    <td class="px-8 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <button onclick="viewStaffDetails({{ $member->id }})" class="p-2 text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] rounded-xl transition-all" title="{{ __('messages.inspect') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            <button onclick="openEditStaffModal({{ $member->id }})" class="p-2 text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] rounded-xl transition-all" title="{{ __('messages.edit_member') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button onclick="deleteStaff({{ $member->id }})" class="p-2 text-muted-veltrix hover:text-[var(--color-accent)] hover:bg-[var(--color-accent)]/5 rounded-xl transition-all" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="no-staff-row">
                    <td colspan="5" class="px-8 py-20 text-center">
                        <div class="w-16 h-16 bg-[var(--color-bg-card)] text-muted-veltrix rounded-2xl flex items-center justify-center mx-auto mb-4 opacity-50">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <p class="text-muted-veltrix text-sm font-bold uppercase tracking-widest opacity-40">{{ __('messages.no_personnel_registered') }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Staff Modal -->
<div id="add-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-[var(--color-primary)]/10 backdrop-blur-md">
    <div class="bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 border border-[var(--color-border-soft)]" id="modal-content">
        <div class="px-10 py-8 border-b border-[var(--color-border-soft)] flex justify-between items-center bg-[var(--color-bg-card)]">
            <div>
                <h3 class="heading-editorial text-2xl">{{ __('messages.new_member') }}</h3>
                <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mt-1">{{ __('messages.operational_authority_onboarding') }}</p>
            </div>
            <button id="close-modal-btn" class="text-muted-veltrix hover:text-[var(--color-accent)] transition p-2 bg-white rounded-xl shadow-sm border border-[var(--color-border-soft)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-10">
            <form id="add-staff-form" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.full_name') }}</label>
                    <input type="text" name="name" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold" placeholder="E.g. Alexander Veltrix">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.email_address') }}</label>
                    <input type="email" name="email" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold" placeholder="email@veltrix.com">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.security_credential') }}</label>
                    <input type="password" name="password" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold" placeholder="{{ __('messages.initialize_password') }}">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.operational_role') }}</label>
                    <select name="role" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold uppercase tracking-widest appearance-none cursor-pointer">
                        <option value="staff">{{ __('messages.operational_staff') }}</option>
                        <option value="admin">{{ __('messages.system_administrator') }}</option>
                    </select>
                </div>
                <button type="submit" class="w-full btn-primary-veltrix !py-4 mt-4">
                    <span class="text-xs uppercase tracking-widest font-bold">{{ __('messages.authorize_member') }}</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Edit Staff Modal -->
<div id="edit-staff-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-[var(--color-primary)]/10 backdrop-blur-md">
    <div class="bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 border border-[var(--color-border-soft)]" id="edit-modal-content">
        <div class="px-10 py-8 border-b border-[var(--color-border-soft)] flex justify-between items-center bg-[var(--color-bg-card)]">
            <div>
                <h3 class="heading-editorial text-2xl">{{ __('messages.edit_member') }}</h3>
                <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mt-1">Modify Operational Authority Credentials</p>
            </div>
            <button onclick="closeEditModal()" class="text-muted-veltrix hover:text-[var(--color-accent)] transition p-2 bg-white rounded-xl shadow-sm border border-[var(--color-border-soft)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-10">
            <form id="edit-staff-form" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-staff-id">
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.full_name') }}</label>
                    <input type="text" name="name" id="edit-staff-name" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.email_address') }}</label>
                    <input type="email" name="email" id="edit-staff-email" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.security_credential') }} (Optional)</label>
                    <input type="password" name="password" id="edit-staff-password" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold" placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.operational_role') }}</label>
                    <select name="role" id="edit-staff-role" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold uppercase tracking-widest appearance-none cursor-pointer">
                        <option value="staff">{{ __('messages.operational_staff') }}</option>
                        <option value="admin">{{ __('messages.system_administrator') }}</option>
                    </select>
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
    const modal = document.getElementById('add-modal');
    const modalContent = document.getElementById('modal-content');
    const openBtn = document.getElementById('open-modal-btn');
    const closeBtn = document.getElementById('close-modal-btn');
    const addForm = document.getElementById('add-staff-form');

    const editModal = document.getElementById('edit-staff-modal');
    const editModalContent = document.getElementById('edit-modal-content');
    const editStaffForm = document.getElementById('edit-staff-form');

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
            const response = await fetch("{{ route('admin.staff.store') }}", {
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
                showSuccessMessage("{{ __('messages.member_authorized_success') }}");
                setTimeout(() => location.reload(), 1500);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    async function openEditStaffModal(id) {
        try {
            const response = await fetch(`/api/staff/${id}`);
            const staff = await response.json();
            
            document.getElementById('edit-staff-id').value = staff.id;
            document.getElementById('edit-staff-name').value = staff.name;
            document.getElementById('edit-staff-email').value = staff.email;
            document.getElementById('edit-staff-role').value = staff.role;
            document.getElementById('edit-staff-password').value = ''; // clear password input

            editModal.classList.remove('hidden');
            setTimeout(() => {
                editModalContent.classList.remove('scale-95', 'opacity-0');
                editModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        } catch (error) {
            console.error('Error fetching staff details:', error);
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

    editStaffForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('edit-staff-id').value;
        const formData = new FormData(editStaffForm);
        try {
            const response = await fetch(`/admin/staff/${id}`, {
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
                showSuccessMessage('Staff credentials updated');
                setTimeout(() => location.reload(), 1500);
            }
        } catch (error) {
            console.error('Error updating staff details:', error);
        }
    });

    async function deleteStaff(id) {
        if (!confirm("{{ __('messages.confirm_deauthorize_member') }}")) return;
        try {
            const response = await fetch(`/admin/staff/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (data.success) {
                gsap.to(`#staff-row-${id}`, {
                    x: 20,
                    opacity: 0,
                    duration: 0.5,
                    onComplete: () => document.getElementById(`staff-row-${id}`).remove()
                });
                showSuccessMessage("{{ __('messages.member_deauthorized_success') }}");
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
</script>
@endpush
@endsection
