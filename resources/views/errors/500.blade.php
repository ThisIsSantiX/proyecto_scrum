{{-- resources/views/errors/500.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error Interno del Servidor - 500</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', sans-serif;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
      background: #1a1a1a;
    }
    .error-container {
      position: relative;
      text-align: center;
      z-index: 20;
      max-width: 600px;
      padding: 20px;
    }
    .error-container img {
      max-width: 160px;
      margin-bottom: 20px;
    }
    h1 {
      font-size: 6rem;
      font-weight: bold;
      color: #f87171;
      text-shadow: 0 0 10px #f87171, 0 0 20px #dc2626;
    }
    h2 {
      font-size: 2rem;
      margin-bottom: 15px;
      text-shadow: 0 0 5px #f87171;
    }
    p {
      font-size: 1.2rem;
      margin-bottom: 25px;
      color: #d1d5db;
    }
    .btn-back {
      background-color: #f87171;
      color: #fff;
      font-weight: bold;
      padding: 10px 25px;
      border-radius: 50px;
      text-decoration: none;
      border: none;
      box-shadow: 0 0 10px #f87171, 0 0 20px #dc2626;
    }
    .btn-back:hover {
      background-color: #dc2626;
      box-shadow: 0 0 20px #dc2626, 0 0 40px #f87171;
    }
    canvas {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: block;
      z-index: 1;
    }
  </style>
</head>
<body>

  <canvas id="aurora"></canvas>
  <canvas id="particles"></canvas>

  <div class="error-container">
    <img src="{{ asset('assets/images/error/500.png') }}" alt="500 Error">
    <h1>500</h1>
    <h2>Error Interno del Servidor</h2>
    <p>Algo salió mal en el servidor. Inténtalo de nuevo más tarde.</p>
    <a href="{{ route('dashboard') }}" class="btn-back">Volver al inicio</a>
  </div>

  <script>
    const auroraCanvas = document.getElementById('aurora');
    const auroraCtx = auroraCanvas.getContext('2d');
    const particleCanvas = document.getElementById('particles');
    const ctx = particleCanvas.getContext('2d');

    let W = auroraCanvas.width = particleCanvas.width = window.innerWidth;
    let H = auroraCanvas.height = particleCanvas.height = window.innerHeight;

    // Aurora
    let auroraTime = 0;
    function drawAurora() {
      auroraTime += 0.01;
      const gradient = auroraCtx.createRadialGradient(W/2, H/2, 0, W/2, H/2, W);
      const alpha = 0.05 + (Math.sin(auroraTime) + 1)/2 * 0.15;
      gradient.addColorStop(0, 'rgba(40,10,10,' + alpha + ')');
      gradient.addColorStop(0.5, 'rgba(20,5,5,' + (alpha*0.7) + ')');
      gradient.addColorStop(1, 'rgba(5,0,0,' + (alpha * 0.4) + ')');
      auroraCtx.fillStyle = gradient;
      auroraCtx.fillRect(0, 0, W, H);
    }

    // Partículas
    const particles = [];
    const colors = ['#f87171', '#dc2626', '#ef4444', '#fecaca'];
    for (let i = 0; i < 80; i++) {
      particles.push({
        x: Math.random() * W,
        y: Math.random() * H,
        radius: Math.random() * 3 + 1,
        color: colors[Math.floor(Math.random() * colors.length)],
        vx: (Math.random() - 0.5) * 0.5,
        vy: (Math.random() - 0.5) * 0.5
      });
    }

    let mouse = { x: W/2, y: H/2 };
    window.addEventListener('mousemove', e => {
      mouse.x = e.clientX;
      mouse.y = e.clientY;
    });

    function drawParticles() {
      ctx.clearRect(0, 0, W, H);
      particles.forEach(p => {
        p.x += p.vx;
        p.y += p.vy;
        const dx = mouse.x - p.x;
        const dy = mouse.y - p.y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < 120) {
          p.vx += dx * 0.001;
          p.vy += dy * 0.001;
        }
        if (p.x < 0) { p.x = 0; p.vx *= -1; }
        if (p.x > W) { p.x = W; p.vx *= -1; }
        if (p.y < 0) { p.y = 0; p.vy *= -1; }
        if (p.y > H) { p.y = H; p.vy *= -1; }
        p.vx *= 0.98;
        p.vy *= 0.98;
        const grad = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.radius);
        grad.addColorStop(0, p.color);
        grad.addColorStop(1, 'transparent');
        ctx.fillStyle = grad;
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
        ctx.fill();
      });
    }

    function animate() {
      drawAurora();
      drawParticles();
      requestAnimationFrame(animate);
    }
    animate();

    window.addEventListener('resize', () => {
      W = auroraCanvas.width = particleCanvas.width = window.innerWidth;
      H = auroraCanvas.height = particleCanvas.height = window.innerHeight;
    });
  </script>

</body>
</html>
