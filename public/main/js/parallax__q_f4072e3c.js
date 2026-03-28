let bg = document.querySelector('.krp__OccCB1651G');
window.addEventListener('mousemove', function(e) {
    let x = e.clientX / window.innerWidth;
    let y = e.clientY / window.innerHeight;  
    bg.style.transform = 'translate(-' + x * 20 + 'px, -' + y * 20 + 'px)';
});