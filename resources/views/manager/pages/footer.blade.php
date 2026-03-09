<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

  // ── Count-up animation ──
  document.querySelectorAll('[data-count]').forEach(el => {
    const target = parseInt(el.dataset.count);
    const prefix = el.dataset.prefix || '';
    let current = 0;
    const step = Math.ceil(target / 60);
    const timer = setInterval(() => {
      current = Math.min(current + step, target);
      el.textContent = prefix + current.toLocaleString();
      if (current >= target) clearInterval(timer);
    }, 20);
  });

  // ── Bar Chart ──
  const data7  = [42000, 58000, 51000, 73000, 66000, 84250, 79000];
  const data12 = [28000, 35000, 42000, 38000, 55000, 48000, 61000, 58000, 51000, 73000, 66000, 84250];
  const labels7  = ['Sep','Oct','Nov','Dec','Jan','Feb','Mar'];
  const labels12 = ['Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar'];

  function renderChart(vals, lbls) {
    const chart  = document.getElementById('barChart');
    const labDiv = document.getElementById('barLabels');
    chart.innerHTML = ''; labDiv.innerHTML = '';
    const maxVal = Math.max(...vals);
    vals.forEach((v, i) => {
      const wrap = document.createElement('div');
      wrap.className = 'bar-wrap';
      const pct = Math.round((v / maxVal) * 130);
      wrap.innerHTML = `
        <div class="bar" style="height:4px" data-h="${pct}px">
          <div class="bar-tip">$${v.toLocaleString()}</div>
        </div>`;
      chart.appendChild(wrap);

      const lbl = document.createElement('div');
      lbl.style.cssText = 'flex:1;text-align:center;font-size:10px;color:#94a3b8;';
      lbl.textContent = lbls[i];
      labDiv.appendChild(lbl);
    });
    // Animate bars
    setTimeout(() => {
      document.querySelectorAll('.bar').forEach(b => {
        b.style.transition = 'height 0.9s cubic-bezier(.4,0,.2,1)';
        b.style.height = b.dataset.h;
      });
    }, 100);
  }

  renderChart(data7, labels7);

  document.getElementById('chartFilter').addEventListener('change', function() {
    if (this.selectedIndex === 0) renderChart(data7, labels7);
    else renderChart(data12, labels12);
  });

  // ── Progress Bars ──
  setTimeout(() => {
    document.querySelectorAll('.progress-bar[data-width]').forEach(bar => {
      bar.style.width = bar.dataset.width;
    });
  }, 400);

});
</script>
</body>
</html>
