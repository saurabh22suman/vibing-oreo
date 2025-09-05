@extends('layouts.app')

@section('content')
<style>
.admin-container{max-width:980px;margin:56px auto;padding:18px;display:flex;flex-direction:column;align-items:center;gap:18px}
.admin-actions{display:flex;gap:12px;justify-content:center;align-items:center;background:linear-gradient(180deg,rgba(255,255,255,0.01),rgba(255,255,255,0.02));padding:12px 18px;border-radius:12px;box-shadow:0 8px 30px rgba(0,0,0,0.45)}
.admin-table{width:100%;border-collapse:collapse;margin-top:6px}
.admin-table thead th{padding:12px 10px;text-align:left;color:#e6e6e6}
.admin-table td{padding:10px 10px;vertical-align:middle}
.admin-table tbody tr{border-bottom:1px solid rgba(255,255,255,0.03)}
.admin-table .btn{margin-right:6px}
.btn.small{padding:6px 10px;border-radius:8px}
.modal-dialog{max-width:720px}
</style>

<div class="admin-container">
<div class="admin-actions">
    <button id="open-create" class="btn">Add New App</button>
    <button id="open-change-password" class="btn" style="margin-left:12px">Change password</button>
    <a class="btn" href="/logout" style="margin-left:12px" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
    <form id="logout-form" action="/logout" method="POST" style="display:none">@csrf</form>
</div>

<!-- Change Password Modal -->
<div id="modal-password" class="modal" aria-hidden="true" style="display:none">
    <div class="modal-overlay" id="modalpw-overlay"></div>
    <div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modalpw-title">
        <button class="modal-close" id="modalpw-close">×</button>
        <h3 id="modalpw-title">Change Password</h3>

        @if ($errors->any())
            <div class="alert" style="margin-bottom:8px">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert success" style="margin-bottom:8px">{{ session('success') }}</div>
        @endif

        <form id="modalpw-form" method="POST" action="{{ route('admin.changePassword') }}">
            @csrf
            <label>Current Password<input type="password" name="current_password" required></label>
            <label>New Password<input type="password" name="password" required></label>
            <label>Confirm New Password<input type="password" name="password_confirmation" required></label>
            <div style="margin-top:12px">
                <button class="btn" type="submit">Update Password</button>
                <button type="button" class="btn" id="modalpw-cancel" style="margin-left:8px">Cancel</button>
            </div>
        </form>
    </div>
</div>
<table class="admin-table">
    <thead><tr><th>Title</th><th>Category</th><th>Actions</th></tr></thead>
    <tbody>
        @foreach($apps as $app)
            <tr>
                <td>{{ $app->title }}</td>
                <td>{{ $app->category }}</td>
                <td>
                    <button
                        class="btn small edit-btn"
                        data-id="{{ $app->id }}"
                        data-title="{{ e($app->title) }}"
                        data-description="{{ e($app->description) }}"
                        data-link="{{ $app->link }}"
                        data-category="{{ $app->category }}"
                        data-image="{{ $app->image }}"
                    >Edit</button>
                    <form method="POST" action="{{ route('admin.destroy', $app->id) }}" style="display:inline">@csrf
                        <button class="btn small danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal (create / edit) -->
<div id="modal" class="modal" aria-hidden="true" style="display:none">
    <div class="modal-overlay" id="modal-overlay"></div>
    <div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <button class="modal-close" id="modal-close">×</button>
        <h3 id="modal-title">Create App</h3>
        <form id="modal-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.store') }}">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="id" id="form-id" value="">
            <label>Title<input type="text" name="title" id="form-title" required></label>
            <label>Description<textarea name="description" id="form-description"></textarea></label>
            <label>Image<input type="file" name="image" id="form-image"></label>
            <label>Link<input type="url" name="link" id="form-link"></label>
            <label>Category<input type="text" name="category" id="form-category"></label>
            <div style="margin-top:12px">
                <button class="btn" type="submit" id="form-submit">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const modal = document.getElementById('modal');
    const overlay = document.getElementById('modal-overlay');
    const closeBtn = document.getElementById('modal-close');
    const openCreate = document.getElementById('open-create');
    const form = document.getElementById('modal-form');
    const titleEl = document.getElementById('modal-title');

    function openModal(){ modal.style.display='block'; setTimeout(()=> modal.classList.add('open'),10); }
    function closeModal(){ modal.classList.remove('open'); setTimeout(()=> modal.style.display='none',200); }

    openCreate.addEventListener('click', ()=>{
        titleEl.textContent = 'Create App';
        form.action = "{{ route('admin.store') }}";
        document.getElementById('form-method').value = 'POST';
        document.getElementById('form-id').value = '';
        form.reset();
        openModal();
    });

    document.querySelectorAll('.edit-btn').forEach(btn=>{
        btn.addEventListener('click', ()=>{
            const id = btn.dataset.id;
            titleEl.textContent = 'Edit App';
            form.action = `/admin/${id}/update`;
            document.getElementById('form-method').value = 'POST';
            document.getElementById('form-id').value = id;
            document.getElementById('form-title').value = btn.dataset.title || '';
            document.getElementById('form-description').value = btn.dataset.description || '';
            document.getElementById('form-link').value = btn.dataset.link || '';
            document.getElementById('form-category').value = btn.dataset.category || '';
            openModal();
        });
    });

    overlay.addEventListener('click', closeModal);
    closeBtn.addEventListener('click', closeModal);
    // Password modal handlers
    const modalpw = document.getElementById('modal-password');
    if (modalpw) {
        const modalpwOverlay = document.getElementById('modalpw-overlay');
        const modalpwClose = document.getElementById('modalpw-close');
        const modalpwCancel = document.getElementById('modalpw-cancel');
        const openChangePw = document.getElementById('open-change-password');

        function openPwModal(){ modalpw.style.display='block'; setTimeout(()=> modalpw.classList.add('open'),10); }
        function closePwModal(){ modalpw.classList.remove('open'); setTimeout(()=> modalpw.style.display='none',200); }

        if (openChangePw) openChangePw.addEventListener('click', ()=>{ openPwModal(); });
        modalpwOverlay.addEventListener('click', closePwModal);
        modalpwClose.addEventListener('click', closePwModal);
        modalpwCancel.addEventListener('click', closePwModal);
    }
});
</script>

</div>

@endsection
