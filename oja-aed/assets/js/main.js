/* Oja Aed — main.js */
(function () {
  'use strict';

  // ── Sticky header ──────────────────────────────────────────────────────────
  const header = document.querySelector('.site-header');
  if (header) {
    let lastY = 0;
    window.addEventListener('scroll', () => {
      const y = window.scrollY;
      header.classList.toggle('scrolled', y > 60);
      header.classList.toggle('hidden', y > lastY && y > 200);
      lastY = y;
    }, { passive: true });
  }

  // ── Mobile menu ────────────────────────────────────────────────────────────
  const toggle = document.querySelector('.menu-toggle');
  const nav    = document.querySelector('.primary-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!open));
      nav.classList.toggle('is-open', !open);
      document.body.classList.toggle('menu-open', !open);
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) {
        toggle.setAttribute('aria-expanded', 'false');
        nav.classList.remove('is-open');
        document.body.classList.remove('menu-open');
      }
    });
  }

  // ── Smooth scroll for anchor links ─────────────────────────────────────────
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', (e) => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // ── Reveal on scroll ───────────────────────────────────────────────────────
  const revealEls = document.querySelectorAll('.reveal');
  if (revealEls.length && 'IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('revealed');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    revealEls.forEach(el => io.observe(el));
  }

  // ── Recipe print ───────────────────────────────────────────────────────────
  const printBtn = document.querySelector('.recipe-print-btn');
  if (printBtn) {
    printBtn.addEventListener('click', () => window.print());
  }

  // ── Hero scroll indicator ──────────────────────────────────────────────────
  const scrollDown = document.querySelector('.hero-scroll');
  if (scrollDown) {
    scrollDown.addEventListener('click', () => {
      const next = document.querySelector('.hero + *');
      if (next) next.scrollIntoView({ behavior: 'smooth' });
    });
  }
})();
