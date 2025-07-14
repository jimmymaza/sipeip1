<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login SIPeIP1</title>

  <!-- Fuente moderna -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body, html {
      height: 100%;
      background: #0b0f1a;
      overflow: hidden;
      color: #fff;
    }

    #bg-canvas {
      position: fixed;
      top: 0; left: 0;
      width: 100vw;
      height: 100vh;
      z-index: 0;
      background: linear-gradient(135deg, #001f3f, #000814);
    }

    .login-container {
      position: relative;
      z-index: 10;
      width: 350px;
      margin: auto;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0, 20, 40, 0.9);
      border-radius: 15px;
      padding: 35px 30px;
      box-shadow: 0 0 20px #00ffff66, inset 0 0 30px #00ffff33;
    }

    .logo {
      width: 90px;
      height: 90px;
      margin: 0 auto 20px;
      border-radius: 50%;
      overflow: hidden;
      border: 2px solid #00ffff;
      box-shadow: 0 0 10px #00ffff;
    }

    .logo img {
      width: 100%;
      display: block;
    }

    h1 {
      text-align: center;
      color: #00ffff;
      margin-bottom: 5px;
      font-size: 1.3rem;
    }

    .subtitle {
      text-align: center;
      font-size: 0.85rem;
      color: #00ffffcc;
      margin-bottom: 25px;
    }

    label {
      font-size: 0.85rem;
      color: #ffc107;
      margin-bottom: 5px;
      display: block;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-bottom: 2px solid #00ffffaa;
      background: transparent;
      color: #fff;
      margin-bottom: 15px;
      transition: border-color 0.3s ease;
    }

    input:focus {
      outline: none;
      border-bottom-color: #ff5722;
      box-shadow: 0 2px 10px #00ffff88;
    }

    ::placeholder {
      color: #ccc;
    }

    button {
      width: 100%;
      background: #00ffff;
      color: #002a3a;
      font-weight: 600;
      font-size: 1rem;
      border: none;
      padding: 10px;
      border-radius: 25px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #00cccc;
    }

    .error-message {
      background: #ff003366;
      padding: 10px;
      border-radius: 8px;
      color: #ff4444;
      text-align: center;
      font-size: 0.85rem;
      margin-bottom: 15px;
    }

    small {
      color: #ffaaaa;
      font-size: 0.8rem;
    }

    .forgot {
      margin-top: 15px;
      text-align: center;
    }

    .forgot a {
      color: #00e5ff;
      font-size: 0.85rem;
      text-decoration: none;
    }

    .forgot a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<canvas id="bg-canvas"></canvas>

<div class="login-container" role="main" aria-label="Formulario de inicio de sesión">
  <div class="logo">
    <img src="{{ asset('snp.png') }}" alt="Logo SNP">
  </div>

  <h1>Sistema Integral de Planificación</h1>
  <p class="subtitle">SIPeIP1</p>

  @if(session('error'))
    <div class="error-message">
      {{ session('error') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="error-message">
      <ul style="list-style: none; padding: 0; margin: 0;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <label for="cedula">Cédula o Correo</label>
    <input id="cedula" name="cedula" type="text" required placeholder="Ingrese su cédula o correo" value="{{ old('cedula') }}">
    @error('cedula')
      <small>{{ $message }}</small>
    @enderror

    <label for="password">Contraseña</label>
    <input id="password" name="password" type="password" required placeholder="Ingrese su contraseña">
    @error('password')
      <small>{{ $message }}</small>
    @enderror

    <button type="submit">Iniciar sesión</button>

    <div class="forgot">
      <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
    </div>
  </form>
</div>

<script>
  const canvas = document.getElementById('bg-canvas');
  const ctx = canvas.getContext('2d');
  let width, height;
  let particles = [];
  const PARTICLE_COUNT = 70;
  const MAX_DISTANCE = 130;
  let mousePos = { x: null, y: null };

  function random(min, max) {
    return Math.random() * (max - min) + min;
  }

  class Particle {
    constructor() {
      this.x = random(0, width);
      this.y = random(0, height);
      this.vx = random(-0.5, 0.5);
      this.vy = random(-0.5, 0.5);
      this.radius = 2 + Math.random() * 2;
    }

    move() {
      this.x += this.vx;
      this.y += this.vy;
      if (this.x < 0 || this.x > width) this.vx *= -1;
      if (this.y < 0 || this.y > height) this.vy *= -1;
    }

    draw() {
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.radius, 0, 2 * Math.PI);
      ctx.fillStyle = 'rgba(0, 255, 255, 0.8)';
      ctx.fill();
    }
  }

  function connectParticles() {
    for (let a = 0; a < particles.length; a++) {
      for (let b = a + 1; b < particles.length; b++) {
        let dx = particles[a].x - particles[b].x;
        let dy = particles[a].y - particles[b].y;
        let dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < MAX_DISTANCE) {
          ctx.beginPath();
          ctx.strokeStyle = 'rgba(0,255,255,' + (1 - dist / MAX_DISTANCE) + ')';
          ctx.lineWidth = 1;
          ctx.moveTo(particles[a].x, particles[a].y);
          ctx.lineTo(particles[b].x, particles[b].y);
          ctx.stroke();
        }

        if (mousePos.x !== null && mousePos.y !== null) {
          let mdx = particles[a].x - mousePos.x;
          let mdy = particles[a].y - mousePos.y;
          let mdist = Math.sqrt(mdx * mdx + mdy * mdy);
          if (mdist < MAX_DISTANCE) {
            ctx.beginPath();
            ctx.strokeStyle = 'rgba(0,255,255,' + (1 - mdist / MAX_DISTANCE) + ')';
            ctx.lineWidth = 1;
            ctx.moveTo(particles[a].x, particles[a].y);
            ctx.lineTo(mousePos.x, mousePos.y);
            ctx.stroke();
          }
        }
      }
    }
  }

  function setup() {
    width = window.innerWidth;
    height = window.innerHeight;
    canvas.width = width;
    canvas.height = height;
    particles = [];
    for (let i = 0; i < PARTICLE_COUNT; i++) {
      particles.push(new Particle());
    }
  }

  function animate() {
    ctx.clearRect(0, 0, width, height);
    particles.forEach(p => {
      p.move();
      p.draw();
    });
    connectParticles();
    requestAnimationFrame(animate);
  }

  window.addEventListener('resize', setup);
  window.addEventListener('mousemove', e => {
    mousePos.x = e.clientX;
    mousePos.y = e.clientY;
  });
  window.addEventListener('mouseout', () => {
    mousePos.x = null;
    mousePos.y = null;
  });

  setup();
  animate();
</script>

</body>
</html>
