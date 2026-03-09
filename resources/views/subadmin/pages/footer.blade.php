<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

  // Count-up animation
  document.querySelectorAll('[data-count]').forEach(el => {
    const target = parseInt(el.dataset.count);
    const prefix = el.dataset.prefix || '';
    let cur = 0;
    const step = Math.ceil(target / 60);
    const t = setInterval(() => {
      cur = Math.min(cur + step, target);
      el.textContent = prefix + cur.toLocaleString();
      if (cur >= target) clearInterval(t);
    }, 18);
  });

  // Progress bars
  setTimeout(() => {
    document.querySelectorAll('.mini-fill[data-w]').forEach(b => {
      b.style.width = b.dataset.w;
    });
  }, 350);

  // Donut chart
  const circ = 2 * Math.PI * 40; // r=40 → ~251
  setTimeout(() => {
    let offset = 0;
    document.querySelectorAll('.donut-fg').forEach(arc => {
      const val    = parseFloat(arc.dataset.val);
      const max    = parseFloat(arc.dataset.max);
      const dash   = (val / max) * circ;
      const gap    = circ - dash;
      const rotate = (offset / max) * circ;

      arc.style.strokeDasharray  = `${dash} ${gap}`;
      arc.style.strokeDashoffset = -rotate;
      offset += val;
    });
  }, 300);

  // Sidebar active
  document.querySelectorAll('.sb-menu li a').forEach(a => {
    a.addEventListener('click', function(e) {
      if (this.getAttribute('href') === '#') e.preventDefault();
      document.querySelectorAll('.sb-menu li').forEach(l => l.classList.remove('active'));
      this.parentElement.classList.add('active');
    });
  });

});
</script>
</body>
</html>
