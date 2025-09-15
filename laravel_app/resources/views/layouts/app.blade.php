<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Vibing Oreo — app showcase">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vibing Oreo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600,700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* reset browser default margin and use border-box sizing for predictable layout */
        html { box-sizing: border-box; }
        *, *::before, *::after { box-sizing: inherit; }
        body{ margin:0; font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Apple Color Emoji', 'Segoe UI Emoji'; background-color:#0b1020; color:#e6eef8; }
    </style>
    <style>
        /* sparkle styles */
        .sparkle {
            position: fixed;
            pointer-events: none;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0.2) rotate(0deg);
            opacity: 1;
            mix-blend-mode: screen;
            transition: transform 600ms cubic-bezier(.2,.9,.2,1), opacity 600ms linear;
            will-change: transform, opacity;
            z-index: 45;
        }
        .sparkle.small { width:6px; height:6px; }
        .sparkle.large { width:10px; height:10px; }
    </style>
    <style>
        /* responsive Oreo positioning: anchored to the left of the centered footer container
           We'll compute a final left offset at runtime so the Oreo visually sits above the VO box.
        */
          /* Oreo will be positioned fixed in the viewport so it remains aligned across refreshes.
              JS will compute its left so its center aligns with the VO element, and set bottom to sit on top of the footer.
          */
          .oreo-img{ position:fixed; left:0; bottom:0; transform: none; opacity:0.98; filter: drop-shadow(0 10px 30px rgba(2,6,23,0.7)); z-index:60; pointer-events:none; }
    /* sizes: show on small screens (centered over VO), larger sizes on sm/md/lg */
    .oreo-img{ display:block; width:64px; }
    @media (min-width: 640px){ .oreo-img{ width:96px; } }
    @media (min-width: 768px){ .oreo-img{ width:200px; } }
    @media (min-width: 1024px){ .oreo-img{ width:420px; max-width:30vw; } }
    </style>
    <style>
  /* Make auth / sign-in cards and wrappers readable on the dark site theme */
  .auth-card, .signin-card, .login-card, .auth-wrapper, .signin-form, .card {
    background: rgba(255,255,255,0.04); /* subtle card against dark bg */
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.6), 0 1px 0 rgba(255,255,255,0.02) inset;
    color: #eaeaea;
    z-index: 1200;
    position: relative;
  }

  /* Inputs must be white with dark text so they are readable */
  input[type="text"], input[type="email"], input[type="password"], textarea, .form-control, input[type="checkbox"], input[type="radio"] {
    background: #ffffff !important;
    color: #111827 !important;
    border: 1px solid rgba(0,0,0,0.15) !important;
    padding: 0.35rem 0.5rem !important;
    border-radius: 4px !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.25) !important;
  }

  /* Make form buttons clearly visible */
  button, .btn {
    color: #fff !important;
  }
  .btn-primary {
    background: linear-gradient(180deg,#2563eb,#1e40af) !important;
    border: none !important;
  }

  /* Center and constrain width of auth forms */
  .auth-wrapper, .signin-form {
    max-width: 520px;
    margin: 48px auto !important;
  }

  /* Ensure labels and helper text are readable */
  label, .form-label, .help-text, .field-label {
    color: #e6e6e6 !important;
  }

  /* If any overlay or modal inadvertently covers the form, raise its stacking context */
  .auth-card, .signin-card, .login-card { z-index: 1400; }
</style>
    <style>
  /* Strong overrides for auth/login forms to ensure correct vertical layout */
  /* Scope narrowly to avoid affecting other forms */
  .auth-wrapper, .signin-form, .login-card, .auth-card, form.login-form, form#login_form, .login-wrapper {
    box-sizing: border-box;
    max-width: 520px;
    width: 100%;
    margin: 64px auto !important;
    padding: 18px !important;
    background: rgba(255,255,255,0.03) !important;
  }

  .auth-wrapper label, .signin-form label, .auth-card label, form.login-form label {
    display: block !important;
    width: 100% !important;
    margin-bottom: 6px !important;
    color: #e6e6e6 !important;
    font-weight: 500;
  }

  .auth-wrapper input[type="text"], .auth-wrapper input[type="email"],
  .auth-wrapper input[type="password"], .auth-wrapper textarea,
  form.login-form input, form.login-form textarea, .auth-card .form-control {
    display: block !important;
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    padding: 0.5rem 0.6rem !important;
    margin: 0 0 10px 0 !important;
    background: #ffffff !important;
    color: #0b1220 !important;
    border: 1px solid rgba(0,0,0,0.12) !important;
    border-radius: 6px !important;
  }

  /* Make primary action clearly visible and placed below fields */
  .auth-wrapper .btn, .auth-card .btn, form.login-form button, form.login-form input[type="submit"] {
    display: inline-block !important;
    margin-top: 8px !important;
    padding: 0.45rem 0.8rem !important;
  }

  /* Remove any float or inline layout rules that could push fields sideways */
  .auth-wrapper .field, .auth-wrapper .form-row, .signin-form .field { display: block !important; float: none !important; }

  /* If any parent layout applied large left padding, center the auth box visually */
  .auth-wrapper { margin-left: auto !important; margin-right: auto !important; }

  /* Increase contrast of helper text and errors */
  .auth-wrapper .help-text, .auth-wrapper .error, .auth-wrapper .invalid-feedback { color: #ffdcdc !important; }
</style>
    <style>
  /* Persistent login form improvements injected into layout so /login displays correctly */
  main[role="main"], main {
    display: block;
  }
  /* Target the immediate container inside main used by the login form */
  main > div, .auth-wrapper, .login-wrapper, .signin-form {
    max-width: 640px;
    margin: 56px auto !important;
    padding: 22px !important;
    border-radius: 12px !important;
    background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.04));
    box-shadow: 0 8px 30px rgba(0,0,0,0.6);
    z-index: 1600;
  }

  main h2, .auth-wrapper h2 { color: #eaeaea !important; margin-bottom: 12px !important; }

  /* Labels stack above inputs and inputs are full width */
  .auth-wrapper label, main label { display:block !important; color:#ddd !important; margin-bottom:6px !important; font-weight:600 !important; }
  .auth-wrapper input[type="email"], .auth-wrapper input[type="password"],
  main input[type="email"], main input[type="password"],
  .login-wrapper input, .signin-form input, .auth-wrapper textarea {
    display:block !important;
    width:100% !important;
    box-sizing:border-box !important;
    padding:12px !important;
    border-radius:8px !important;
    border:1px solid rgba(0,0,0,0.12) !important;
    background:#ffffff !important;
    color:#0b1220 !important;
    margin-bottom:12px !important;
  }

  /* Buttons placed below fields and clearly visible */
  .auth-wrapper .btn, .signin-form .btn, main button, form button {
    display:inline-block !important;
    background: linear-gradient(180deg,#2563eb,#1e40af) !important;
    color: #fff !important;
    padding: 0.5rem 0.9rem !important;
    border-radius: 8px !important;
    border: none !important;
    margin-top: 8px !important;
  }

  /* Remove floats and ensure vertical stacking */
  .auth-wrapper .field, .auth-wrapper .form-row, .signin-form .field { display:block !important; float:none !important; }
</style>
        <style>
        /* Water ripple effect (click/touch) */
        .ripple {
            position: fixed;
            pointer-events: none;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            opacity: 0.9;
            mix-blend-mode: screen;
            background: radial-gradient(circle at 30% 30%, rgba(96,165,250,0.35), rgba(59,130,246,0.18));
            box-shadow: 0 8px 30px rgba(59,130,246,0.12);
            transition: transform 650ms cubic-bezier(.2,.9,.2,1), opacity 650ms linear;
            z-index: 1600;
        }
        </style>
</head>
<body class="bg-zinc-950 text-zinc-100 antialiased">
    <div id="app">
        <!-- full-width fixed header -->
        <header class="fixed top-0 left-0 right-0 z-50 backdrop-blur supports-[backdrop-filter]:bg-zinc-950/50 bg-[rgba(6,8,15,0.55)]/90 border-b border-white/10">
            <div class="mx-auto max-w-7xl px-0">
                <div class="flex h-16 items-center justify-between">
                    <a href="/" class="flex items-center gap-3 group">
                        <div class="h-8 w-8 rounded-md bg-white/5 ring-1 ring-inset ring-white/10 flex items-center justify-center text-indigo-400">
                            <span class="text-sm font-semibold tracking-tight">VO</span>
                        </div>
                        <span class="text-sm sm:text-base font-medium tracking-tight text-zinc-100 group-hover:text-white transition-colors">Vibing Oreo</span>
                    </a>
                    <div class="flex items-center gap-2">
                        <a href="/admin" class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/[0.03] px-3.5 py-2 text-sm text-zinc-200 hover:text-white hover:bg-white/[0.06] hover:border-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60 transition-all">Admin</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- page content: add top and bottom padding so fixed header/footer don't overlap -->
        <main class="pt-16 pb-28">
            @yield('content')
        </main>

        <!-- full-width fixed footer -->
        <!-- full-width fixed footer (height matched to header) -->
        <footer id="contact" class="fixed bottom-0 left-0 right-0 z-40 h-16 border-t border-white/10 backdrop-blur supports-[backdrop-filter]:bg-zinc-950/50 bg-[rgba(6,8,15,0.6)]/90">
            <div class="mx-auto max-w-7xl px-0 h-16 flex items-center justify-between relative">
                <div class="flex items-center gap-3 relative">
                    <div class="h-8 w-8 rounded-md bg-white/5 ring-1 ring-inset ring-white/10 flex items-center justify-center text-indigo-400">
                        <span class="text-sm font-semibold tracking-tight">VO</span>
                    </div>
                    <!-- Oreo positioned relative to the centered container so it aligns with VO -->
                        <img src="/assets/images/Oreo.png" alt="Oreo" class="pointer-events-none oreo-img" />
                </div>
                <div class="flex items-center text-xs text-zinc-500">
                    <!-- absolute-right copyright -->
                    <div style="position:absolute; right:1rem; top:50%; transform:translateY(-50%); z-index:41;">© <span id="year">{{ date('Y') }}</span> Vibing Oreo. All rights reserved.</div>
                </div>
            </div>
        </footer>
    </div>
    <script>
        // initialize lucide icons (if script loaded)
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
        }
        // ensure year element updated (fallback)
        (function(){ var y = document.getElementById('year'); if (y) y.textContent = new Date().getFullYear(); })();
    </script>
    <!-- Markdown parser + sanitizer for safe client-side rendering of descriptions -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dompurify@3.1.7/dist/purify.min.js"></script>
    <script>
        // Ensure the login form exists and the Sign in button will submit it — only on /login.
        (function(){
            if (!window.location || window.location.pathname !== '/login') return;
            function ensureLoginForm(){
                try{
                    var main = document.querySelector('main');
                    if(!main) return;
                    var existingForm = main.querySelector('form');
                    var tokenMeta = document.querySelector('meta[name="csrf-token"]');
                    var token = tokenMeta ? tokenMeta.getAttribute('content') : null;

                    if(!existingForm){
                        // locate likely inputs and button
                        var email = main.querySelector('input[type=email], input[name=email]');
                        var password = main.querySelector('input[type=password], input[name=password]');
                        var btn = main.querySelector('button, input[type=submit]');
                        if(email || password || btn){
                            var form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '/login';
                            // add CSRF hidden input if available
                            if(token){
                                var hidden = document.createElement('input'); hidden.type='hidden'; hidden.name='_token'; hidden.value=token; form.appendChild(hidden);
                            }
                            // move located elements into the form
                            [email, password, btn].forEach(function(el){ if(el) form.appendChild(el); });
                            // clear main and insert the form wrapper
                            main.innerHTML = '';
                            main.appendChild(form);
                        }
                    }

                    // fallback submit: if a button is clicked but has no form ancestor, submit the main form
                    document.body.addEventListener('click', function(e){
                        var t = e.target;
                        if(!t) return;
                        if(t.matches('button') || (t.matches('input') && t.type === 'submit')){
                            var f = t.closest('form');
                            if(!f){
                                var f2 = document.querySelector('main form');
                                if(f2){ e.preventDefault(); f2.submit(); }
                            }
                        }
                    }, true);
                }catch(err){ console.warn('ensureLoginForm error', err); }
            }
            if(document.readyState === 'loading') document.addEventListener('DOMContentLoaded', ensureLoginForm); else ensureLoginForm();
        })();
    </script>
    <script>
        // Ensure the Oreo image sits directly above the VO box and at the extreme left of the centered footer container.
        (function(){
            function alignOreoFixed(){
                const footer = document.querySelector('footer');
                const vo = footer && footer.querySelector('.h-8.w-8');
                const oreo = document.querySelector('img.oreo-img');
                if (!footer || !vo || !oreo) return;

                const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
                const voRect = vo.getBoundingClientRect();
                // measure oreo natural width (after CSS applied)
                const oreoRect = oreo.getBoundingClientRect();

                // compute desired left in viewport coords so oreo center == vo center
                const desiredLeftViewport = (voRect.left + voRect.width/2) - (oreoRect.width/2);

                // clamp so it stays fully on-screen
                const clampedLeft = Math.max(0, Math.min(Math.round(desiredLeftViewport), Math.max(0, vw - Math.round(oreoRect.width))));

                // set fixed position (viewport coords)
                oreo.style.position = 'fixed';
                oreo.style.left = clampedLeft + 'px';

                // place Oreo above the footer: compute footer height and set bottom accordingly
                const footerRect = footer.getBoundingClientRect();
                // ensure we place it right above the footer; add a small offset so it sits slightly overlapping
                const bottomPx = Math.max(0, Math.round(window.innerHeight - footerRect.top)); // 6px gap
                oreo.style.bottom = bottomPx + 'px';
                oreo.style.transform = 'translateY(0)';
                oreo.style.display = '';
            }

            // Run on load and resize; debounce resize
            window.addEventListener('load', alignOreoFixed);
            let t;
            window.addEventListener('resize', function(){ clearTimeout(t); t = setTimeout(alignOreoFixed, 120); });
        })();
    </script>
    <script>
        // sparkle trail on mousemove
        (function(){
            const colors = ['#7c3aed', '#06b6d4', '#f472b6', '#fde68a', '#60a5fa'];
            let last = {x:0,y:0, t:0};
            const THROTTLE = 8; // px
            const container = document.body;

            function makeSparkle(x,y){
                const el = document.createElement('div');
                el.className = 'sparkle';
                // random size and color
                const sizeClass = Math.random() > 0.7 ? 'large' : (Math.random() > 0.7 ? 'small' : '');
                if(sizeClass) el.classList.add(sizeClass);
                const color = colors[Math.floor(Math.random()*colors.length)];
                el.style.background = color;
                el.style.left = x + 'px';
                el.style.top = y + 'px';
                // slight rotation
                el.style.transform = 'translate(-50%, -50%) scale(0.2) rotate(' + (Math.random()*360) + 'deg)';
                container.appendChild(el);

                // force layout then animate
                requestAnimationFrame(()=>{
                    el.style.transform = 'translate(-50%, -50%) scale(1.1) rotate(' + (Math.random()*360) + 'deg)';
                    el.style.opacity = '0';
                });

                // cleanup after animation
                setTimeout(()=>{ try{ el.remove(); }catch(e){} }, 700);
            }

            function onMove(e){
                const x = e.clientX || (e.touches && e.touches[0] && e.touches[0].clientX) || 0;
                const y = e.clientY || (e.touches && e.touches[0] && e.touches[0].clientY) || 0;
                const dx = x - last.x;
                const dy = y - last.y;
                const dist = Math.sqrt(dx*dx + dy*dy);
                const now = Date.now();
                // throttle by distance/time
                if (dist > THROTTLE || (now - last.t) > 30) {
                    last = {x,y,t:now};
                    // create a couple sparkles for richer trail
                    makeSparkle(x + (Math.random()*10-5), y + (Math.random()*10-5));
                    if (Math.random() > 0.6) makeSparkle(x + (Math.random()*20-10), y + (Math.random()*20-10));
                }
            }

            // enable on mouse and touch move
            window.addEventListener('mousemove', onMove, {passive:true});
            window.addEventListener('touchmove', function(e){ if(e.touches && e.touches[0]) onMove(e.touches[0]); }, {passive:true});
        })();
    </script>
    <script>
        /* Ripple effect: create a single-use circle at click/touch position */
        (function(){
            function createRipple(x,y){
                const el = document.createElement('div');
                el.className = 'ripple';
                // choose a size based on viewport so ripple is visible but not huge
                const base = Math.max(window.innerWidth, window.innerHeight);
                const size = Math.max(64, Math.round(base * 0.12));
                el.style.width = size + 'px';
                el.style.height = size + 'px';
                el.style.left = x + 'px';
                el.style.top = y + 'px';
                document.body.appendChild(el);
                // debug log so we can see creation in Playwright console
                try{ console.debug('ripple:created', {x,y, size: size}); }catch(e){}
                // Force layout then animate
                requestAnimationFrame(function(){
                    el.style.transform = 'translate(-50%, -50%) scale(1)';
                    el.style.opacity = '0';
                });
                // Cleanup after animation (keep longer during debug)
                setTimeout(function(){ try{ el.remove(); } catch(e){} }, 2000);
            }

            // Handle clicks and touch starts; skip inside modals to avoid interfering with inputs (e.g., file picker)
            window.addEventListener('click', function(e){
                try{ if (e && e.target && (e.target.closest && e.target.closest('.modal'))) return; }catch(_){}
                createRipple(e.clientX, e.clientY);
            }, {passive:true});
            window.addEventListener('touchstart', function(e){
                try{
                    const t = e.touches && e.touches[0];
                    if(!t) return;
                    const el = document.elementFromPoint(t.clientX, t.clientY);
                    if (el && (el.closest && el.closest('.modal'))) return;
                    createRipple(t.clientX, t.clientY);
                }catch(_){ }
            }, {passive:true});
        })();
    </script>
    @stack('scripts')
</body>
</html>
