<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script>
function toggleSidebar() {
    if (window.innerWidth < 992) {
        document.body.classList.toggle('sb-open');
    } else {
        document.body.classList.toggle('sb-collapsed');
    }
}

function closeSidebar() {
    document.body.classList.remove('sb-open');
}

function toggleMenu(el) {
    const submenu = el.nextElementSibling;
    const isOpen  = submenu && submenu.classList.contains('open');

    // Close all open submenus
    document.querySelectorAll('.sidebar-submenu.open').forEach(s => {
        s.classList.remove('open');
        if (s.previousElementSibling) {
            s.previousElementSibling.classList.remove('open');
        }
    });

    if (!isOpen && submenu) {
        submenu.classList.add('open');
        el.classList.add('open');
    }
}

// Auto-open active submenu
document.querySelectorAll('.sidebar-submenu').forEach(sub => {
    if (sub.querySelector('a.active')) {
        sub.classList.add('open');
        if (sub.previousElementSibling) sub.previousElementSibling.classList.add('open');
    }
});
</script>
@stack('scripts')
</body>
</html>
