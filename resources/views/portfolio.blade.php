<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Portfolio</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Mono:wght@300;400&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --bg: #0d0d0d;
      --surface: #141414;
      --accent: #c8a96e;
      --accent2: #e8d5b0;
      --text: #e8e4dc;
      --muted: #7a7570;
      --border: rgba(200,169,110,0.2);
    }

    html { scroll-behavior: smooth; }

    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'DM Mono', monospace;
      font-weight: 300;
      overflow-x: hidden;
      cursor: none;
    }

    /* Custom cursor */
    .cursor {
      width: 8px; height: 8px;
      background: var(--accent);
      border-radius: 50%;
      position: fixed;
      pointer-events: none;
      z-index: 9999;
      transform: translate(-50%, -50%);
      transition: transform 0.1s ease;
    }
    .cursor-ring {
      width: 36px; height: 36px;
      border: 1px solid var(--accent);
      border-radius: 50%;
      position: fixed;
      pointer-events: none;
      z-index: 9998;
      transform: translate(-50%, -50%);
      transition: all 0.15s ease;
      opacity: 0.5;
    }

    /* Noise overlay */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 1000;
      opacity: 0.4;
    }

    /* NAV */
    nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 100;
      padding: 24px 48px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid transparent;
      transition: border-color 0.4s, background 0.4s;
    }
    nav.scrolled {
      background: rgba(13,13,13,0.9);
      backdrop-filter: blur(12px);
      border-color: var(--border);
    }
    .nav-logo {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.4rem;
      font-weight: 600;
      color: var(--accent);
      letter-spacing: 0.1em;
    }
    .nav-links {
      display: flex;
      gap: 36px;
      list-style: none;
    }
    .nav-links a {
      color: var(--muted);
      text-decoration: none;
      font-size: 0.7rem;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      transition: color 0.3s;
    }
    .nav-links a:hover { color: var(--accent); }

    /* HERO */
    #hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 120px 48px 60px;
      position: relative;
      overflow: hidden;
    }
    .hero-bg-line {
      position: absolute;
      top: 0; bottom: 0;
      width: 1px;
      background: var(--border);
    }
    .hero-bg-line:nth-child(1) { left: 25%; }
    .hero-bg-line:nth-child(2) { left: 50%; }
    .hero-bg-line:nth-child(3) { left: 75%; }

    .hero-content { position: relative; z-index: 2; max-width: 800px; }

    .hero-tag {
      font-size: 0.65rem;
      letter-spacing: 0.25em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 24px;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeUp 0.8s 0.3s forwards;
    }

    .hero-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(3.5rem, 8vw, 7rem);
      font-weight: 300;
      line-height: 1.05;
      letter-spacing: -0.01em;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeUp 1s 0.5s forwards;
    }
    .hero-name span { color: var(--accent); font-style: italic; }

    .hero-desc {
      margin-top: 28px;
      font-size: 0.8rem;
      line-height: 1.9;
      color: var(--muted);
      max-width: 440px;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeUp 0.8s 0.8s forwards;
    }

    .hero-cta {
      margin-top: 48px;
      display: flex;
      gap: 20px;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeUp 0.8s 1s forwards;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 14px 32px;
      font-family: 'DM Mono', monospace;
      font-size: 0.7rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      text-decoration: none;
      border: 1px solid var(--accent);
      color: var(--accent);
      background: transparent;
      transition: all 0.3s;
      cursor: none;
    }
    .btn:hover { background: var(--accent); color: var(--bg); }
    .btn-ghost { border-color: var(--border); color: var(--muted); }
    .btn-ghost:hover { border-color: var(--muted); color: var(--text); background: transparent; }

    .hero-scroll {
      position: absolute;
      bottom: 40px;
      right: 48px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      color: var(--muted);
      font-size: 0.6rem;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      opacity: 0;
      animation: fadeUp 1s 1.4s forwards;
    }
    .scroll-line {
      width: 1px;
      height: 60px;
      background: linear-gradient(to bottom, var(--accent), transparent);
      animation: scrollPulse 2s ease-in-out infinite;
    }

    /* SECTIONS */
    section {
      padding: 120px 48px;
      position: relative;
    }

    .section-header {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 72px;
    }
    .section-num {
      font-size: 0.6rem;
      color: var(--accent);
      letter-spacing: 0.2em;
    }
    .section-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2rem, 4vw, 3.2rem);
      font-weight: 300;
    }
    .section-line {
      flex: 1;
      height: 1px;
      background: var(--border);
    }

    /* ABOUT */
    #about { background: var(--surface); }
    .about-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: start;
    }
    .about-text p {
      font-size: 0.85rem;
      line-height: 2;
      color: var(--muted);
      margin-bottom: 20px;
    }
    .about-text p strong { color: var(--text); font-weight: 400; }
    .about-stats {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2px;
    }
    .stat-card {
      background: var(--bg);
      padding: 32px 28px;
      border-left: 2px solid var(--accent);
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.6s;
    }
    .stat-card.visible { opacity: 1; transform: none; }
    .stat-num {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2.8rem;
      color: var(--accent);
      font-weight: 300;
      line-height: 1;
    }
    .stat-label {
      font-size: 0.65rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--muted);
      margin-top: 8px;
    }

    /* SKILLS */
    .skills-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1px;
      background: var(--border);
    }
    .skill-item {
      background: var(--bg);
      padding: 32px 28px;
      position: relative;
      overflow: hidden;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.5s;
    }
    .skill-item.visible { opacity: 1; transform: none; }
    .skill-item::before {
      content: '';
      position: absolute;
      bottom: 0; left: 0;
      width: 0; height: 2px;
      background: var(--accent);
      transition: width 0.4s;
    }
    .skill-item:hover::before { width: 100%; }
    .skill-icon { font-size: 1.4rem; margin-bottom: 12px; }
    .skill-name {
      font-size: 0.75rem;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      margin-bottom: 8px;
    }
    .skill-bar-bg {
      height: 2px;
      background: var(--border);
      margin-top: 12px;
    }
    .skill-bar {
      height: 2px;
      background: var(--accent);
      width: 0;
      transition: width 1.2s ease;
    }
    .skill-item.visible .skill-bar { width: var(--pct); }

    /* PROJECTS */
    #projects { background: var(--surface); }
    .projects-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2px;
    }
    .project-card {
      background: var(--bg);
      padding: 40px 36px;
      position: relative;
      overflow: hidden;
      cursor: none;
      opacity: 0;
      transform: translateY(24px);
      transition: all 0.6s;
    }
    .project-card.visible { opacity: 1; transform: none; }
    .project-card::after {
      content: '';
      position: absolute;
      inset: 0;
      background: var(--accent);
      opacity: 0;
      transition: opacity 0.4s;
    }
    .project-card:hover::after { opacity: 0.04; }
    .project-num {
      font-size: 0.6rem;
      color: var(--accent);
      letter-spacing: 0.2em;
      margin-bottom: 24px;
    }
    .project-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.6rem;
      font-weight: 300;
      margin-bottom: 16px;
      transition: color 0.3s;
    }
    .project-card:hover .project-title { color: var(--accent); }
    .project-desc {
      font-size: 0.75rem;
      line-height: 1.9;
      color: var(--muted);
      margin-bottom: 28px;
    }
    .project-tags { display: flex; flex-wrap: wrap; gap: 8px; }
    .tag {
      font-size: 0.6rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      padding: 6px 12px;
      border: 1px solid var(--border);
      color: var(--muted);
    }
    .project-link {
      margin-top: 28px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 0.65rem;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--accent);
      text-decoration: none;
      border-bottom: 1px solid var(--border);
      padding-bottom: 4px;
      transition: border-color 0.3s;
    }
    .project-link:hover { border-color: var(--accent); }

    /* CONTACT */
    .contact-inner {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
    }
    .contact-text {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(1.8rem, 3vw, 2.6rem);
      font-weight: 300;
      line-height: 1.3;
    }
    .contact-text em { color: var(--accent); font-style: italic; }
    .contact-info { display: flex; flex-direction: column; gap: 20px; }
    .contact-item {
      display: flex;
      flex-direction: column;
      gap: 4px;
      padding: 20px 0;
      border-bottom: 1px solid var(--border);
    }
    .contact-label {
      font-size: 0.6rem;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--muted);
    }
    .contact-value {
      font-size: 0.85rem;
      color: var(--accent2);
    }

    /* FOOTER */
    footer {
      padding: 32px 48px;
      border-top: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    footer span { font-size: 0.65rem; color: var(--muted); letter-spacing: 0.1em; }

    /* ANIMATIONS */
    @keyframes fadeUp {
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes scrollPulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      nav { padding: 20px 24px; }
      .nav-links { display: none; }
      section { padding: 80px 24px; }
      #hero { padding: 120px 24px 60px; }
      .about-grid, .contact-inner { grid-template-columns: 1fr; gap: 40px; }
      .hero-scroll { display: none; }
    }
  </style>
</head>
<body>

  <div class="cursor" id="cursor"></div>
  <div class="cursor-ring" id="cursorRing"></div>

  <!-- NAV -->
  <nav id="navbar">
    <div class="nav-logo">Jeeva Rs.</div>
    <ul class="nav-links">
      <li><a href="#about">About</a></li>
      <li><a href="#skills">Skills</a></li>
      <li><a href="#projects">Projects</a></li>
      <li><a href="#contact">Contact</a></li>
    </ul>
  </nav>

  <!-- HERO -->
  <section id="hero">
    <div class="hero-bg-line"></div>
    <div class="hero-bg-line"></div>
    <div class="hero-bg-line"></div>
    <div class="hero-content">
      <p class="hero-tag">— Python & PHP Full Stack Developer.</p>
      <h1 class="hero-name">
        Clean Code. <span>Smart</span><br/>Solutions.
      </h1>
      <p class="hero-desc">
        I build thoughtful, elegant interfaces and reliable systems that solve real problems — where design meets functionality.
      </p>
      <div class="hero-cta">
        <a href="#projects" class="btn">View Work</a>
        <a href="#contact" class="btn btn-ghost">Get in Touch</a>
      </div>
    </div>
    <div class="hero-scroll">
      <div class="scroll-line"></div>
      Scroll
    </div>
  </section>

  <!-- ABOUT -->
  <section id="about">
    <div class="section-header">
      <span class="section-num">01</span>
      <h2 class="section-title">About Me</h2>
      <div class="section-line"></div>
    </div>
    <div class="about-grid">
      <div class="about-text">
        <p>I'm a <strong>passionate developer</strong> with a deep appreciation for clean code and intentional design. I believe that the best digital products are built at the intersection of technical excellence and thoughtful user experience.</p>
        <p>With a background in both <strong>front-end and back-end development</strong>, I bring a holistic perspective to every project. I care deeply about the details — from pixel-perfect layouts to performant, scalable architecture.</p>
        <p>When I'm not coding, you'll find me exploring design systems, contributing to open source, or enjoying a quiet cup of coffee while sketching UI ideas.</p>
      </div>
      <div class="about-stats">
        <div class="stat-card"><div class="stat-num">Fresher</div><div class="stat-label">Projects Experience</div></div>
        <div class="stat-card"><div class="stat-num">4+</div><div class="stat-label">Projects Delivered</div></div>
        <div class="stat-card"><div class="stat-num">Join Me</div><div class="stat-label">Happy Clients</div></div>
        <div class="stat-card"><div class="stat-num">100%</div><div class="stat-label">Dedication</div></div>
      </div>
    </div>
  </section>

  <!-- SKILLS -->
  <section id="skills">
    <div class="section-header">
      <span class="section-num">02</span>
      <h2 class="section-title">Skills</h2>
      <div class="section-line"></div>
    </div>
    <div class="skills-grid">
      <div class="skill-item" style="--pct:92%"><div class="skill-icon">◈</div><div class="skill-name">PYTHON</div><div class="skill-bar-bg"><div class="skill-bar"></div></div></div>
      <div class="skill-item" style="--pct:88%"><div class="skill-icon">◆</div><div class="skill-name">PHP</div><div class="skill-bar-bg"><div class="skill-bar"></div></div></div>
      <div class="skill-item" style="--pct:85%"><div class="skill-icon">◇</div><div class="skill-name">DJNGO</div><div class="skill-bar-bg"><div class="skill-bar"></div></div></div>
      <div class="skill-item" style="--pct:80%"><div class="skill-icon">▣</div><div class="skill-name">LARAVEL</div><div class="skill-bar-bg"><div class="skill-bar"></div></div></div>
      <div class="skill-item" style="--pct:75%"><div class="skill-icon">◑</div><div class="skill-name">JAVASCRIPT</div><div class="skill-bar-bg"><div class="skill-bar"></div></div></div>
      <div class="skill-item" style="--pct:70%"><div class="skill-icon">▦</div><div class="skill-name">MYSQL</div><div class="skill-bar-bg"><div class="skill-bar"></div></div></div>
      <div class="skill-item" style="--pct:80%"><div class="skill-icon">▣</div><div class="skill-name">HTML</div><div class="skill-bar-bg"><div class="skill-bar"></div></div></div>
      <div class="skill-item" style="--pct:80%"><div class="skill-icon">▣</div><div class="skill-name">CSS</div><div class="skill-bar-bg"><div class="skill-bar"></div></div></div>
      <div class="skill-item" style="--pct:75%"><div class="skill-icon">◑</div><div class="skill-name">BOOTSTRAP</div><div class="skill-bar-bg"><div class="skill-bar"></div></div></div>
       <div class="skill-item" style="--pct:88%"><div class="skill-icon">◆</div><div class="skill-name">TYPING</div><div class="skill-bar-bg"><div class="skill-bar"></div></div></div>
    </div>
  </section>

  <!-- PROJECTS -->
  <section id="projects">
    <div class="section-header">
      <span class="section-num">03</span>
      <h2 class="section-title">Projects</h2>
      <div class="section-line"></div>
    </div>
    <div class="projects-grid">
      <div class="project-card">
        <div class="project-num">001</div>
        <h3 class="project-title">E-Commerce Platform</h3>
        <p class="project-desc">A modern eCommerce platform built with a clean and responsive design.
            Customers can browse products, add items to cart, and complete purchases through a smooth and intuitive interface.</p>
        <div class="project-tags"><span class="tag">PYTHON</span><span class="tag">DJNAGO</span><span class="tag">MYSQL</span></div>
        <a href="#" class="project-link">View Project →</a>
      </div>
      <div class="project-card">
        <div class="project-num">002</div>
        <h3 class="project-title">ChatApp-Ai</h3>
        <p class="project-desc">Developed an AI chat application powered by Claude AI that enables dynamic, real-time conversations.Implemented message handling, API integration, and a user-friendly interface for smooth interaction.</p>
        <div class="project-tags"><span class="tag">CLAUDE AI</span></div>
        <a href="https://chatweb-tau-three.vercel.app/" class="project-link">View Project →</a>
      </div>
      <div class="project-card">
        <div class="project-num">003</div>
        <h3 class="project-title">MyPortFolio</h3>
        <p class="project-desc">A personal portfolio website showcasing my web development projects, technical skills, and practical experience. Designed with a clean, responsive layout to highlight my work and capabilities.</p>
        <div class="project-tags"><span class="tag">LARAVEL</span><span class="tag">HTML</span><span class="tag">CSS</span></div>
        <a href="https://laravelportfolio-7807.onrender.com/" class="project-link">View Project →</a>
      </div>
    </div>
  </section>

  <!-- CONTACT -->
  <section id="contact">
    <div class="section-header">
      <span class="section-num">04</span>
      <h2 class="section-title">Let's Talk</h2>
      <div class="section-line"></div>
    </div>
    <div class="contact-inner">
      <div class="contact-text">
        Have a project in mind? Let's build something <em>remarkable</em> together.
      </div>
      <div class="contact-info">
        <div class="contact-item">
          <span class="contact-label">Email</span>
          <span class="contact-value">jeevars047@gmail.com</span>
        </div>
        <div class="contact-item">
          <span class="contact-label">Location</span>
          <span class="contact-value">Chennai, Tamil Nadu</span>
        </div>
        <div class="contact-item">
          <span class="contact-label">Availability</span>
          <span class="contact-value">Open to Freelance & Full-time</span>
        </div>
        <div style="margin-top: 8px;">
          <a href="mailto:jeevars047@gmail.com" class="btn">Send a Message</a>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <span>© 2026 — Jeeva R</span>
    <span>Designed & Developed with intention.</span>
  </footer>

  <script>
    // Custom cursor
    const cursor = document.getElementById('cursor');
    const ring = document.getElementById('cursorRing');
    let mx = 0, my = 0, rx = 0, ry = 0;

    document.addEventListener('mousemove', e => {
      mx = e.clientX; my = e.clientY;
      cursor.style.left = mx + 'px';
      cursor.style.top = my + 'px';
    });

    function animateRing() {
      rx += (mx - rx) * 0.12;
      ry += (my - ry) * 0.12;
      ring.style.left = rx + 'px';
      ring.style.top = ry + 'px';
      requestAnimationFrame(animateRing);
    }
    animateRing();

    document.querySelectorAll('a, button').forEach(el => {
      el.addEventListener('mouseenter', () => { ring.style.transform = 'translate(-50%,-50%) scale(1.6)'; ring.style.opacity = '1'; });
      el.addEventListener('mouseleave', () => { ring.style.transform = 'translate(-50%,-50%) scale(1)'; ring.style.opacity = '0.5'; });
    });

    // Navbar scroll
    window.addEventListener('scroll', () => {
      document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 60);
    });

    // Intersection observer for animations
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
          setTimeout(() => entry.target.classList.add('visible'), 100 * (entry.target.dataset.delay || 0));
        }
      });
    }, { threshold: 0.15 });

    document.querySelectorAll('.stat-card, .skill-item, .project-card').forEach((el, i) => {
      el.dataset.delay = i % 4;
      observer.observe(el);
    });
  </script>
</body>
</html>