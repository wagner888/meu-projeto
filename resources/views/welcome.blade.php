<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Pratika - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        :root{--p:#ff8c42;--d:#e65c00;--l:#ffd9b3;--s:rgba(255,140,66,.4)}
        *{margin:0;padding:0;box-sizing:border-box}
        body{
            font-family:'Poppins',sans-serif;
            background:linear-gradient(135deg, #ff6b35 0%, #ff8c42 25%, #e65c00 50%, #ff8c42 75%, #ff6b35 100%);
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
            overflow:hidden;
            position:relative;
        }
        
        /* Canvas para as linhas */
        #linesCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }
        
        .card{
            background:white;
            width:100%;
            max-width:480px;
            border-radius:32px;
            overflow:hidden;
            box-shadow:0 35px 90px rgba(0,0,0,.3);
            animation:float 7s ease-in-out infinite;
            position:relative;
            z-index:2;
        }
        
        .stop-float { animation: none !important; }

        @keyframes float{
            0%,100%{transform:translateY(0)}
            50%{transform:translateY(-20px)}
        }
        .header{
            background:linear-gradient(135deg,var(--p),var(--d));
            color:white;
            text-align:center;
            padding:60px 40px;
        }
        .header h1{
            font-size:4.2rem;
            font-weight:900;
            letter-spacing:-2px;
            text-shadow:0 6px 20px rgba(0,0,0,.5);
        }
        .header p{
            font-size:1.4rem;
            margin-top:12px;
            opacity:.95;
            font-weight:500;
        }
        .body{
            padding:55px 50px;
            background:#fffaf0;
        }
        .input-box{
            position:relative;
            margin-bottom:32px;
        }
        .input-box i{
            position:absolute;
            left:22px;
            top:50%;
            transform:translateY(-50%);
            font-size:1.5rem;
            color:var(--d);
        }
        input{
            width:100%;
            padding:22px 22px 22px 70px;
            border:3px solid #ffe0c2;
            border-radius:20px;
            background:white;
            font-size:1.2rem;
            transition:all .4s;
            box-shadow:0 6px 20px rgba(0,0,0,.05);
        }
        input:focus{
            outline:none;
            border-color:var(--p);
            box-shadow:0 0 0 10px rgba(255,140,66,.3);
            transform:scale(1.03);
        }
        .btn{
            width:100%;
            padding:22px;
            background:linear-gradient(135deg,var(--p),var(--d));
            color:white;
            border:none;
            border-radius:20px;
            font-size:1.7rem;
            font-weight:800;
            cursor:pointer;
            box-shadow:0 15px 40px var(--s);
            transition:all .4s;
            margin-top:10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
        }
        .btn i {
            font-size: 1.9rem;
        }
        .btn:hover{
            transform:translateY(-8px);
            box-shadow:0 30px 60px var(--s);
        }
        .links{
            margin-top:30px;
            text-align:center;
            font-size:1.1rem;
        }
        .links a{
            color:var(--d);
            font-weight:700;
            text-decoration:none;
        }
        .links a:hover{
            text-decoration:underline;
        }
        .erro{
            background:#fee2e2;
            color:#991b1b;
            padding:18px;
            border-radius:16px;
            margin-bottom:25px;
            border-left:8px solid #ef4444;
            font-weight:600;
        }
    </style>
</head>
<body>

<canvas id="linesCanvas"></canvas>

<div class="card" id="loginCard">
    <div class="header">
        <h1>E-Pratika</h1>
        <p>Gerenciamento de Testes em Campo</p>
    </div>

    <div class="body">
        <div id="errorContainer"></div>

        <form id="loginForm">
            <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" required autofocus placeholder="Informe seu Login">
            </div>

            <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" required placeholder="Informe sua Senha">
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-door-open"></i>
                Entrar como Tester
            </button>
        </form>

        <div class="links">
            <a href="#" onclick="alert('Funcionalidade de recuperação de senha'); return false;">Esqueceu sua senha?</a>
        </div>
    </div>
</div>

<script>
    class AnimatedCanvas {
        constructor() {
            this.canvas = document.getElementById('linesCanvas');
            this.ctx = this.canvas.getContext('2d');
            this.lines = [];
            this.init();
        }
        
        init() {
            this.resizeCanvas();
            window.addEventListener('resize', () => this.resizeCanvas());
            this.createLines();
            this.animate();
        }
        
        resizeCanvas() {
            this.canvas.width = window.innerWidth;
            this.canvas.height = window.innerHeight;
            this.centerX = this.canvas.width / 2;
            this.centerY = this.canvas.height / 2;
        }
        
        createLines() {
            const lineCount = 12;
            for (let i = 0; i < lineCount; i++) {
                const side = i % 2 === 0 ? 'left' : 'right';
                this.lines.push(new CurvedLine(this, side, i));
            }
        }
        
        animate() {
            this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
            
            this.lines.forEach(line => {
                line.update();
                line.draw();
            });
            
            requestAnimationFrame(() => this.animate());
        }
    }
    
    class CurvedLine {
        constructor(canvasManager, side, index) {
            this.canvas = canvasManager;
            this.ctx = canvasManager.ctx;
            this.side = side;
            this.index = index;
            this.gradients = [
                { start: 'rgba(255, 140, 66, 0)', mid: 'rgba(255, 140, 66, 1)', end: 'rgba(255, 200, 100, 1)' },
                { start: 'rgba(230, 92, 0, 0)', mid: 'rgba(230, 92, 0, 1)', end: 'rgba(255, 140, 66, 1)' },
                { start: 'rgba(255, 180, 100, 0)', mid: 'rgba(255, 180, 100, 1)', end: 'rgba(255, 220, 150, 1)' },
                { start: 'rgba(255, 107, 53, 0)', mid: 'rgba(255, 107, 53, 1)', end: 'rgba(255, 160, 80, 1)' }
            ];
            this.reset();
        }
        
        reset() {
            const centerX = this.canvas.centerX;
            const centerY = this.canvas.centerY;
            
            // Offset vertical aleatório
            this.yOffset = (Math.random() - 0.5) * this.canvas.canvas.height * 0.6;
            
            // Define pontos de início e fim
            if (this.side === 'left') {
                this.startX = -150;
                this.startY = centerY + this.yOffset;
                this.endX = centerX - 50;
                this.endY = centerY + (Math.random() - 0.5) * 150;
            } else {
                this.startX = this.canvas.canvas.width + 150;
                this.startY = centerY + this.yOffset;
                this.endX = centerX + 50;
                this.endY = centerY + (Math.random() - 0.5) * 150;
            }
            
            // Ponto de controle para curva Bézier mais suave
            this.cpX = (this.startX + this.endX) / 2;
            this.cpY = this.startY + (Math.random() - 0.5) * 100;
            
            this.progress = -this.index * 0.12; // Espaçamento inicial
            this.speed = 0.0015; // Velocidade mais tranquila
            this.gradient = this.gradients[Math.floor(Math.random() * this.gradients.length)];
            this.opacity = 0;
            this.phase = 'growing'; // growing, visible, fading
        }
        
        update() {
            if (this.phase === 'growing') {
                this.opacity += 0.015;
                if (this.opacity >= 0.8) {
                    this.opacity = 0.8;
                    this.phase = 'visible';
                }
            }
            
            this.progress += this.speed;
            
            if (this.progress >= 1) {
                this.phase = 'fading';
            }
            
            if (this.phase === 'fading') {
                this.opacity -= 0.02;
                if (this.opacity <= 0) {
                    this.reset();
                    this.phase = 'growing';
                }
            }
        }
        
        getPointOnCurve(t) {
            // Curva Bézier quadrática
            const x = Math.pow(1 - t, 2) * this.startX + 
                      2 * (1 - t) * t * this.cpX + 
                      Math.pow(t, 2) * this.endX;
            const y = Math.pow(1 - t, 2) * this.startY + 
                      2 * (1 - t) * t * this.cpY + 
                      Math.pow(t, 2) * this.endY;
            return { x, y };
        }
        
        draw() {
            if (this.opacity <= 0 || this.progress < 0) return;
            
            this.ctx.save();
            this.ctx.globalAlpha = this.opacity;
            
            // Desenha a linha em segmentos
            const segments = 80;
            const currentProgress = Math.min(this.progress, 1);
            
            for (let i = 0; i < segments * currentProgress; i++) {
                const t1 = i / segments;
                const t2 = (i + 1) / segments;
                
                const p1 = this.getPointOnCurve(t1);
                const p2 = this.getPointOnCurve(t2);
                
                // Gradiente suave ao longo da linha
                const gradient = this.ctx.createLinearGradient(p1.x, p1.y, p2.x, p2.y);
                const segmentProgress = t1;
                
                if (segmentProgress < 0.2) {
                    gradient.addColorStop(0, this.gradient.start);
                    gradient.addColorStop(1, this.gradient.mid);
                } else if (segmentProgress < 0.8) {
                    gradient.addColorStop(0, this.gradient.mid);
                    gradient.addColorStop(1, this.gradient.mid);
                } else {
                    gradient.addColorStop(0, this.gradient.mid);
                    gradient.addColorStop(1, this.gradient.end);
                }
                
                this.ctx.strokeStyle = gradient;
                this.ctx.lineWidth = 2.5;
                this.ctx.lineCap = 'round';
                this.ctx.lineJoin = 'round';
                
                this.ctx.beginPath();
                this.ctx.moveTo(p1.x, p1.y);
                this.ctx.lineTo(p2.x, p2.y);
                this.ctx.stroke();
            }
            
            // Ponto luminoso no final
            if (this.progress > 0.15 && this.progress < 0.95) {
                const endPoint = this.getPointOnCurve(currentProgress);
                this.drawGlowingDot(endPoint.x, endPoint.y);
            }
            
            this.ctx.restore();
        }
        
        drawGlowingDot(x, y) {
            // Brilho externo amarelado
            const outerGradient = this.ctx.createRadialGradient(x, y, 0, x, y, 25);
            outerGradient.addColorStop(0, 'rgba(255, 200, 100, 0.3)');
            outerGradient.addColorStop(1, 'rgba(255, 200, 100, 0)');
            
            this.ctx.fillStyle = outerGradient;
            this.ctx.beginPath();
            this.ctx.arc(x, y, 25, 0, Math.PI * 2);
            this.ctx.fill();
            
            // Brilho interno laranja
            const innerGradient = this.ctx.createRadialGradient(x, y, 0, x, y, 12);
            innerGradient.addColorStop(0, 'rgba(255, 140, 66, 0.9)');
            innerGradient.addColorStop(1, 'rgba(255, 140, 66, 0)');
            
            this.ctx.fillStyle = innerGradient;
            this.ctx.beginPath();
            this.ctx.arc(x, y, 12, 0, Math.PI * 2);
            this.ctx.fill();
            
            // Ponto central branco
            this.ctx.fillStyle = 'rgba(255, 255, 255, 0.95)';
            this.ctx.beginPath();
            this.ctx.arc(x, y, 2, 0, Math.PI * 2);
            this.ctx.fill();
        }
    }
    
    // Inicializa a animação
    const animatedCanvas = new AnimatedCanvas();
    
    // Gerenciamento do formulário
    const form = document.getElementById('loginForm');
    const card = document.getElementById('loginCard');
    const errorContainer = document.getElementById('errorContainer');
    
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        card.classList.add('stop-float');
        errorContainer.innerHTML = '<div class="erro">Credenciais inválidas. Tente novamente.</div>';
        
        console.log('Login attempt:', {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        });
    });
</script>

</body>
</html>