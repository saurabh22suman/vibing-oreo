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
/* generic modal styles */
.modal{position:fixed;inset:0;display:none;z-index:2000;pointer-events:auto}
.modal.open{display:block}
.modal-overlay{position:absolute;inset:0;background:rgba(0,0,0,0.6);backdrop-filter:blur(2px);z-index:0;pointer-events:auto}
.modal-dialog{position:relative;margin:8vh auto;background:rgba(24,24,27,0.96);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:18px;width:min(92vw,720px);box-shadow:0 20px 60px rgba(0,0,0,0.6);z-index:1;pointer-events:auto}
.modal-close{position:absolute;top:12px;right:12px;height:36px;width:36px;border-radius:9999px;background:#27272a;border:1px solid rgba(255,255,255,0.12);color:#e5e7eb;pointer-events:auto}
/* lock background scroll while any modal is open */
body.modal-open{overflow:hidden}
/* form alignment & inputs */
.modal-dialog label{display:block;margin:10px 0 6px;color:#e5e7eb}
.modal-dialog label input,
.modal-dialog label textarea{
    width:100%;
    max-width:100%;
    display:block;
    box-sizing:border-box;
}
.modal-dialog input[type=file]{
    pointer-events:auto;
    position:relative;
    z-index:10;
}
/* custom file picker row */
.file-row{display:flex;align-items:center;gap:10px}
.file-name{color:#9aa3af;font-size:0.9rem}
/* sticky save bar */
.form-actions{position:sticky;bottom:0;display:flex;justify-content:flex-end;background:linear-gradient(180deg,rgba(24,24,27,0),rgba(24,24,27,0.96) 30%);padding-top:8px;margin-top:16px}
/* fullscreen variant for add-new */
.modal.fullscreen .modal-dialog{margin:0;inset:0;position:absolute;width:100vw;max-width:none;height:100vh;border-radius:0;padding:56px 20px 20px 20px;display:flex;flex-direction:column}
.modal.fullscreen .modal-overlay{background:rgba(0,0,0,0.75)}
.modal.fullscreen h3{width:min(96vw,840px);margin:6px auto 16px}
.modal.fullscreen form{height:calc(100vh - 140px);overflow:auto;width:min(96vw,840px);margin:0 auto;padding-bottom:16px}
/* ensure close button is always clickable in fullscreen */
.modal.fullscreen .modal-close{position:fixed;top:16px;right:16px;z-index:3000}
</style>

<div class="admin-container">
@if(session('success'))
    <div class="alert success" style="padding:8px 12px;border-radius:8px;background:rgba(34,197,94,0.12);color:#bbf7d0;border:1px solid rgba(34,197,94,0.35);width:100%;max-width:980px;">{{ session('success') }}</div>
@endif
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
            <label>Description
                <textarea name="description" id="form-description" placeholder="Write description in Markdown (supports **bold**, _italics_, lists, links)"></textarea>
                <small style="display:block;color:#9aa3af;margin-top:4px">Tip: You can use Markdown. Example: **bold**, _italic_, [link](https://example.com), lists with - or 1.</small>
            </label>
            <div class="file-field">
                <label for="form-image">Image</label>
                <div class="file-row">
                    <input type="file" name="image" id="form-image" accept="image/*" style="position:absolute;left:-9999px;">
                    <button type="button" class="btn" id="file-trigger">Choose Image</button>
                    <span id="file-name" class="file-name">No file chosen</span>
                </div>
            </div>
            <label>Link
                <input type="url" name="link" id="form-link" placeholder="https://your-app.com">
                <small style="display:block;color:#9aa3af;margin-top:4px">Tip: Include https:// — we'll add it automatically if you omit it.</small>
            </label>
            <label>Category<input type="text" name="category" id="form-category"></label>
            <div class="form-actions">
                <button class="btn" type="submit" id="form-submit" style="min-width:96px">Save</button>
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
    const linkInput = document.getElementById('form-link');
    const submitBtn = document.getElementById('form-submit');

    function openModal(){ modal.style.display='block'; document.body.classList.add('modal-open'); setTimeout(()=> modal.classList.add('open'),10); }
    function closeModal(){ modal.classList.remove('open'); document.body.classList.remove('modal-open'); setTimeout(()=> modal.style.display='none',200); }

    openCreate.addEventListener('click', ()=>{
        titleEl.textContent = 'Create App';
        form.action = "{{ route('admin.store') }}";
        document.getElementById('form-method').value = 'POST';
        document.getElementById('form-id').value = '';
        form.reset();
    // reset file name label
    const fn = document.getElementById('file-name'); if(fn) fn.textContent = 'No file chosen';
    // open the create form as a full-screen popup
    modal.classList.add('fullscreen');
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
            // keep edit as standard-sized modal
            modal.classList.remove('fullscreen');
            // reset file name label (since existing item may have image)
            const fn = document.getElementById('file-name'); if(fn) fn.textContent = 'No file chosen';
            openModal();
        });
    });

    overlay.addEventListener('click', closeModal);
    closeBtn.addEventListener('click', closeModal);
    // Close on Escape
    document.addEventListener('keydown', (e)=>{
        if(e.key === 'Escape' && modal.classList.contains('open')){ closeModal(); }
    });
    // Auto-prefix scheme for URL field before the browser validates
    function normalizeLink(){
        if(!linkInput) return;
        let v = (linkInput.value || '').trim();
        if(!v) return;
        if(!/^https?:\/\//i.test(v)){
            linkInput.value = 'https://' + v;
        }
    }
    if (linkInput){
        linkInput.addEventListener('blur', normalizeLink);
        linkInput.addEventListener('change', normalizeLink);
    }
    if (submitBtn){
        submitBtn.addEventListener('click', function(){
            normalizeLink();
            // allow native validation to proceed after normalization
        });
    }
    // Custom file picker wiring
    (function(){
        const trigger = document.getElementById('file-trigger');
        const input = document.getElementById('form-image');
        const nameEl = document.getElementById('file-name');
        if (trigger && input && nameEl){
            trigger.addEventListener('click', function(){ input.click(); });
            input.addEventListener('change', function(){ nameEl.textContent = (input.files && input.files[0]) ? input.files[0].name : 'No file chosen'; });
        }
    })();
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
        document.addEventListener('keydown', (e)=>{
            if(e.key === 'Escape' && modalpw.classList.contains('open')){ closePwModal(); }
        });
    }
});
</script>

</div>

@endsection
