<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
  // Animate donut circles on load
  document.addEventListener('DOMContentLoaded', () => {
    const circles = document.querySelectorAll('.circle-fg');
    circles.forEach(c => {
      const val = parseFloat(c.dataset.val) || 0;
      const max = parseFloat(c.dataset.max) || 100;
      const circumference = 2 * Math.PI * 42; // r=42
      const ratio = max > 0 ? val / max : 0;
      const dash = ratio * circumference;
      // Animate
      c.style.strokeDasharray = `0 ${circumference}`;
      setTimeout(() => {
        c.style.transition = 'stroke-dasharray 1s ease';
        c.style.strokeDasharray = `${dash} ${circumference}`;
      }, 200);
    });

    // Sidebar active link
    document.querySelectorAll('.sidebar-menu li a').forEach(link => {
      link.addEventListener('click', function(e) {
        if(this.getAttribute('href') === '#') e.preventDefault();
        document.querySelectorAll('.sidebar-menu li').forEach(l => l.classList.remove('active'));
        this.parentElement.classList.add('active');
      });
    });
  });
</script>
</body>
</html>
