// Minimal JS for subtle animations and interactivity
document.addEventListener('DOMContentLoaded', ()=>{
    // Fade-in for cards
    document.querySelectorAll('.card').forEach((el,i)=>{
        el.style.opacity = 0;
        el.style.transform = 'translateY(8px)';
        setTimeout(()=>{
            el.style.transition = 'opacity .5s ease, transform .5s ease';
            el.style.opacity = 1;
            el.style.transform = 'translateY(0)';
        }, 80 * i);
    });
});

// Modal accessibility helpers (if modal exists)
document.addEventListener('DOMContentLoaded', ()=>{
    const modal = document.getElementById('modal');
    if(!modal) return;
    // prevent page scroll when modal open
    new MutationObserver(()=>{
        if(modal.classList.contains('open')) document.body.style.overflow = 'hidden';
        else document.body.style.overflow = '';
    }).observe(modal,{attributes:true,attributeFilter:['class']});
});
