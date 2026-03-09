/* ============================================================
   DriveNow — Premium JS
   • Navbar scroll state
   • Scroll-reveal (IntersectionObserver)
   • Date validation for rental form
   • Smooth number counters (stats)
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  // ── 1. Navbar scroll behaviour ──────────────────────────
  const navbar = document.querySelector('.navbar');
  if (navbar) {
    const onScroll = () => {
      navbar.classList.toggle('scrolled', window.scrollY > 40);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // ── 2. Scroll reveal ────────────────────────────────────
  const reveals = document.querySelectorAll('.reveal');
  if (reveals.length && 'IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('visible');
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    reveals.forEach(el => io.observe(el));
  } else {
    reveals.forEach(el => el.classList.add('visible'));
  }

  // ── 3. Animated counters ────────────────────────────────
  const counters = document.querySelectorAll('.stat-number[data-target]');
  if (counters.length && 'IntersectionObserver' in window) {
    const countIO = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (!e.isIntersecting) return;
        const el     = e.target;
        const target = parseInt(el.dataset.target, 10);
        const suffix = el.dataset.suffix || '';
        const dur    = 1400;
        const step   = 16;
        const steps  = Math.round(dur / step);
        let   cur    = 0;
        const inc    = target / steps;
        const timer  = setInterval(() => {
          cur += inc;
          if (cur >= target) { cur = target; clearInterval(timer); }
          el.textContent = Math.round(cur) + suffix;
        }, step);
        countIO.unobserve(el);
      });
    }, { threshold: 0.5 });
    counters.forEach(el => countIO.observe(el));
  }

  // ── 4. Rental form date validation ─────────────────────
  document.querySelectorAll('.rent-form').forEach(function (form) {
    const debut = form.querySelector('[name="date_debut"]');
    const fin   = form.querySelector('[name="date_fin"]');
    if (!debut || !fin) return;

    debut.addEventListener('change', function () {
      if (!this.value) return;
      const next = new Date(this.value);
      next.setDate(next.getDate() + 1);
      const minStr = next.toISOString().split('T')[0];
      fin.min = minStr;
      if (fin.value && fin.value <= this.value) fin.value = minStr;
    });
  });

  // ── 5. Confirm before delete ────────────────────────────
  document.querySelectorAll('a[data-confirm]').forEach(function (link) {
    link.addEventListener('click', function (e) {
      if (!confirm(this.dataset.confirm)) e.preventDefault();
    });
  });

  // ── 6. Auto-dismiss alerts ──────────────────────────────
  document.querySelectorAll('.alert').forEach(function (alert) {
    setTimeout(() => {
      alert.style.transition = 'opacity .6s, max-height .6s, padding .6s, margin .6s';
      alert.style.opacity    = '0';
      alert.style.maxHeight  = '0';
      alert.style.padding    = '0';
      alert.style.margin     = '0';
    }, 5000);
  });

});
