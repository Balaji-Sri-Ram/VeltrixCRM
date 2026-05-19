@extends('layouts.dashboard')

@section('title', __('messages.tasks'))

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
    <div>
        <h1 class="heading-editorial text-4xl mb-1">{{ __('messages.tasks') }}</h1>
        <p class="text-muted-veltrix text-sm">{{ __('messages.staff_overview') }}</p>
    </div>
    <div class="flex flex-wrap items-center gap-4 w-full md:w-auto">
        <form action="{{ route('admin.tasks') }}" method="GET" class="flex flex-1 md:flex-none items-center gap-3">
            <div class="relative flex-1 md:w-72">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_objectives') }}" class="w-full bg-white border border-[var(--color-border-soft)] rounded-2xl px-5 py-3 text-xs font-bold uppercase tracking-widest focus:border-[var(--color-primary)] outline-none shadow-sm transition-all">
                <button type="submit" class="absolute right-5 top-3.5 text-muted-veltrix hover:text-[var(--color-primary)] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
            <select name="status" onchange="this.form.submit()" class="bg-white border border-[var(--color-border-soft)] rounded-2xl px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-[var(--color-charcoal)] focus:border-[var(--color-primary)] outline-none shadow-sm transition-all appearance-none pr-10 cursor-pointer">
                <option value="">{{ __('messages.status_filter') }}</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('messages.pending') }}</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ __('messages.in_progress') }}</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
            </select>
            <select name="staff_id" onchange="this.form.submit()" class="bg-white border border-[var(--color-border-soft)] rounded-2xl px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-[var(--color-charcoal)] focus:border-[var(--color-primary)] outline-none shadow-sm transition-all appearance-none pr-10 cursor-pointer">
                <option value="">{{ __('messages.personnel') }}</option>
                @foreach($staff as $s)
                    <option value="{{ $s->id }}" {{ request('staff_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
            @if(request('search') || request('status') || request('staff_id'))
                <a href="{{ route('admin.tasks') }}" class="text-muted-veltrix hover:text-[var(--color-accent)] p-2 transition-colors" title="Clear Filters">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            @endif
        </form>
        <button id="open-modal-btn" class="btn-primary-veltrix space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span class="text-xs uppercase tracking-widest font-bold">{{ __('messages.add_task') }}</span>
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="tasks-grid">
    @forelse($tasks as $task)
    <div class="card-veltrix group flex flex-col h-full transition-all duration-300 hover:shadow-lg" id="task-row-{{ $task->id }}">
        <div class="flex justify-between items-center mb-6">
            <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider 
                @if($task->status == 'completed') bg-emerald-50 text-emerald-800 @elseif($task->status == 'in_progress') bg-[var(--color-bg-base)] text-[var(--color-primary)] @else bg-orange-50 text-orange-800 @endif">
                {{ __('messages.' . $task->status) }}
            </span>
            <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                @if($task->status != 'completed')
                <button onclick="updateTaskStatus({{ $task->id }}, 'completed')" class="p-1.5 text-muted-veltrix hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Mark Complete">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
                @endif
                <button onclick="openEditTaskModal({{ $task->id }})" class="p-1.5 text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-primary)]/5 rounded-lg transition-all" title="{{ __('messages.edit_task') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <button onclick="deleteTask({{ $task->id }})" class="p-1.5 text-muted-veltrix hover:text-[var(--color-accent)] hover:bg-[var(--color-accent)]/5 rounded-lg transition-all" title="Delete">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </div>
        <h3 class="heading-editorial text-xl mb-3">{{ $task->title }}</h3>
        <p class="text-xs text-muted-veltrix line-clamp-3 mb-6 leading-relaxed flex-grow">{{ $task->description }}</p>
        
        <div class="mb-5 flex flex-wrap gap-2 text-[9px] font-bold uppercase tracking-widest text-muted-veltrix opacity-60">
            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            {{ $task->due_date ? __('messages.due') . ': ' . date('M d, Y', strtotime($task->due_date)) : __('messages.no_due_date') }}
        </div>
        
        <div class="pt-6 border-t border-[var(--color-border-soft)] flex justify-between items-center">
            <div class="flex items-center text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">
                <svg class="w-3.5 h-3.5 mr-2 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                {{ $task->customer->name ?? __('messages.internal_project') }}
            </div>
            <div class="flex items-center text-[10px] font-bold text-muted-veltrix uppercase tracking-widest opacity-60">
                <div class="w-4 h-4 rounded-full bg-[var(--color-primary)] text-white text-[8px] font-bold flex items-center justify-center mr-1.5 shadow-sm">
                    {{ substr($task->assignedTo->name ?? '?', 0, 1) }}
                </div>
                {{ $task->assignedTo->name ?? __('messages.unassigned') }}
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-24 text-center">
        <div class="w-20 h-20 bg-[var(--color-bg-card)] text-muted-veltrix rounded-[24px] flex items-center justify-center mx-auto mb-6 opacity-50">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
        </div>
        <h3 class="heading-editorial text-2xl mb-2">{{ __('messages.no_tasks_found') }}</h3>
    </div>
    @endforelse
</div>

<!-- Create Task Modal -->
<div id="add-task-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-[var(--color-primary)]/10 backdrop-blur-md">
    <div class="bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 border border-[var(--color-border-soft)]" id="modal-content">
        <div class="px-10 py-8 border-b border-[var(--color-border-soft)] flex justify-between items-center bg-[var(--color-bg-card)]">
            <div>
                <h3 class="heading-editorial text-2xl">{{ __('messages.add_task') }}</h3>
                <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mt-1">Assign Operational Objective</p>
            </div>
            <button id="close-modal-btn" class="text-muted-veltrix hover:text-[var(--color-accent)] transition p-2 bg-white rounded-xl shadow-sm border border-[var(--color-border-soft)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-10">
            <form id="add-task-form" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.task_title') }}</label>
                    <input type="text" name="title" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold" placeholder="E.g. Quarterly Audit Preparation">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.description') }}</label>
                    <textarea name="description" rows="3" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-medium leading-relaxed" placeholder="Detailed objective parameters..."></textarea>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.assigned_to') }}</label>
                        <select name="assigned_to" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold uppercase tracking-widest appearance-none cursor-pointer">
                            @foreach($staff as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.customer') }}</label>
                        <select name="customer_id" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold uppercase tracking-widest appearance-none cursor-pointer">
                            <option value="">{{ __('messages.none') }}</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.status') }}</label>
                        <select name="status" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold uppercase tracking-widest appearance-none cursor-pointer">
                            <option value="pending">{{ __('messages.pending') }}</option>
                            <option value="in_progress">{{ __('messages.in_progress') }}</option>
                            <option value="completed">{{ __('messages.completed') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.due_date') }}</label>
                        <input type="date" name="due_date" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold">
                    </div>
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeModal()" class="flex-1 btn-secondary-veltrix">
                        {{ __('messages.close_details') }}
                    </button>
                    <button type="submit" class="flex-1 btn-primary-veltrix">
                        <span class="text-xs uppercase tracking-widest font-bold">{{ __('messages.save_task') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div id="edit-task-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-[var(--color-primary)]/10 backdrop-blur-md">
    <div class="bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 border border-[var(--color-border-soft)]" id="edit-modal-content">
        <div class="px-10 py-8 border-b border-[var(--color-border-soft)] flex justify-between items-center bg-[var(--color-bg-card)]">
            <div>
                <h3 class="heading-editorial text-2xl">{{ __('messages.edit_task') }}</h3>
                <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mt-1">Modify Operational Objective Parameters</p>
            </div>
            <button onclick="closeEditModal()" class="text-muted-veltrix hover:text-[var(--color-accent)] transition p-2 bg-white rounded-xl shadow-sm border border-[var(--color-border-soft)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-10">
            <form id="edit-task-form" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-task-id">
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.task_title') }}</label>
                    <input type="text" name="title" id="edit-task-title" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.description') }}</label>
                    <textarea name="description" id="edit-task-description" rows="3" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-medium leading-relaxed"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.assigned_to') }}</label>
                        <select name="assigned_to" id="edit-task-assigned" required class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold uppercase tracking-widest appearance-none cursor-pointer">
                            @foreach($staff as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.customer') }}</label>
                        <select name="customer_id" id="edit-task-customer" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold uppercase tracking-widest appearance-none cursor-pointer">
                            <option value="">{{ __('messages.none') }}</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.status') }}</label>
                        <select name="status" id="edit-task-status" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold uppercase tracking-widest appearance-none cursor-pointer">
                            <option value="pending">{{ __('messages.pending') }}</option>
                            <option value="in_progress">{{ __('messages.in_progress') }}</option>
                            <option value="completed">{{ __('messages.completed') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.due_date') }}</label>
                        <input type="date" name="due_date" id="edit-task-due" class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-3.5 outline-none focus:border-[var(--color-primary)] transition-all text-xs font-bold">
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
    const modal = document.getElementById('add-task-modal');
    const modalContent = document.getElementById('modal-content');
    const openBtn = document.getElementById('open-modal-btn');
    const closeBtn = document.getElementById('close-modal-btn');
    const addTaskForm = document.getElementById('add-task-form');

    const editModal = document.getElementById('edit-task-modal');
    const editModalContent = document.getElementById('edit-modal-content');
    const editTaskForm = document.getElementById('edit-task-form');

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

    addTaskForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(addTaskForm);
        try {
            const response = await fetch("{{ route('tasks.store') }}", {
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
                showSuccessMessage('Task assigned successfully');
                setTimeout(() => location.reload(), 1500);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    async function openEditTaskModal(id) {
        try {
            const response = await fetch(`/api/tasks/${id}`);
            const task = await response.json();
            
            document.getElementById('edit-task-id').value = task.id;
            document.getElementById('edit-task-title').value = task.title;
            document.getElementById('edit-task-description').value = task.description || '';
            document.getElementById('edit-task-assigned').value = task.assigned_to;
            document.getElementById('edit-task-customer').value = task.customer_id || '';
            document.getElementById('edit-task-status').value = task.status;
            document.getElementById('edit-task-due').value = task.due_date || '';

            editModal.classList.remove('hidden');
            setTimeout(() => {
                editModalContent.classList.remove('scale-95', 'opacity-0');
                editModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        } catch (error) {
            console.error('Error fetching task details:', error);
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

    editTaskForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('edit-task-id').value;
        const formData = new FormData(editTaskForm);
        try {
            const response = await fetch(`/tasks/${id}`, {
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
                showSuccessMessage('Objective details updated');
                setTimeout(() => location.reload(), 1500);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    async function updateTaskStatus(id, status) {
        try {
            const response = await fetch(`/tasks/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status })
            });
            const data = await response.json();
            if (data.success) {
                showSuccessMessage('Objective status updated');
                setTimeout(() => location.reload(), 1000);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function deleteTask(id) {
        if (!confirm('Permanently remove this objective?')) return;
        try {
            const response = await fetch(`/tasks/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (data.success) {
                gsap.to(`#task-row-${id}`, {
                    x: 20,
                    opacity: 0,
                    duration: 0.5,
                    onComplete: () => document.getElementById(`task-row-${id}`).remove()
                });
                showSuccessMessage('Objective removed successfully');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
</script>
@endpush
@endsection
