// app_ui.js - small UI helpers: navbar scroll, smooth internal scroll, and simple reveal
document.addEventListener('DOMContentLoaded', function(){
  // NAVBAR style on scroll
  const nav = document.getElementById('mainNav');
  function onScroll(){
    if(window.scrollY > 20) nav.classList.add('scrolled'); else nav.classList.remove('scrolled');
  }
  document.addEventListener('scroll', onScroll, {passive:true});
  onScroll();

  // smooth scroll for internal links
  document.querySelectorAll('a[href^="#"]').forEach(a=>{
    a.addEventListener('click', function(e){
      const href = this.getAttribute('href');
      if(href.length>1){
        e.preventDefault();
        const el = document.querySelector(href);
        if(el) el.scrollIntoView({behavior:'smooth', block:'start'});
        // collapse mobile menu if open
        const collapse = document.querySelector('.navbar-collapse.show');
        if(collapse) new bootstrap.Collapse(collapse).hide();
      }
    });
  });

  // simple reveal on scroll using IntersectionObserver
  const io = new IntersectionObserver((entries)=> {
    entries.forEach(entry => {
      if(entry.isIntersecting) {
        entry.target.classList.add('reveal-in');
        io.unobserve(entry.target);
      }
    });
  }, {threshold:0.12});
  document.querySelectorAll('.card-clean, [data-reveal]').forEach(el => io.observe(el));
});
