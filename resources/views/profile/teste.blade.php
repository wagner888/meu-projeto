<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Pratika - Página Simples</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        :root{
            --p:#ff8c42;
            --d:#e65c00;
            --l:#ffd9b3;
            --s:rgba(255,140,66,.45);
        }
        *{margin:0;padding:0;box-sizing:border-box}
        body{
            font-family:'Poppins',sans-serif;
            background:linear-gradient(135deg,#ffd9b3 0%,#ff8c42 45%,#e65c00 100%);
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
        }
        .card{
            background:white;
            width:100%;
            max-width:600px;
            border-radius:34px;
            overflow:hidden;
            box-shadow:0 40px 100px var(--s);
            animation:float 8s ease-in-out infinite;
        }
        @keyframes float{
            0%,100%{transform:translateY(0)}
            50%{transform:translateY(-25px)}
        }
        .header{
            background:linear-gradient(135deg,var(--p),var(--d));
            color:white;
            text-align:center;
            padding:70px 40px;
        }
        .header i{
            font-size:5rem;
            margin-bottom:20px;
            text-shadow:0 8px 20px rgba(0,0,0,.4);
        }
        .header h1{
            font-size:4rem;
            font-weight:900;
            letter-spacing:-2px;
            text-shadow:0 6px 20px rgba(0,0,0,.5);
        }
        .header p{
            font-size:1.5rem;
            margin-top:15px;
            opacity:.95;
            font-weight:500;
        }
        .content{
            padding:60px 50px;
            background:#fffaf0;
            text-align:center;
        }
        .content h2{
            color:var(--d);
            font-size:2.2rem;
            margin-bottom:20px;
            font-weight:700;
        }
        .content p{
            color:#8a4500;
            font-size:1.3rem;
            line-height:1.8;
            margin-bottom:30px;
        }
        .btn{
            display:inline-block;
            padding:20px 50px;
            background:linear-gradient(135deg,var(--p),var(--d));
            color:white;
            text-decoration:none;
            border-radius:50px;
            font-size:1.5rem;
            font-weight:800;
            box-shadow:0 15px 40px var(--s);
            transition:all .5s;
        }
        .btn i{
            margin-right:12px;
            font-size:1.6rem;
        }
        .btn:hover{
            transform:translateY(-10px);
            box-shadow:0 30px 60px var(--s);
        }
        .footer{
            padding:30px;
            text-align:center;
            color:#e65c00;
            font-size:1.1rem;
            font-weight:600;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="header">
        <i class="fas fa-clipboard-check"></i>
        <h1>E-Pratika</h1>
        <p>Gerenciamento de Testes em Campo</p>
    </div>

    <div class="content">
        <h2>Bem-vindo ao Sistema!</h2>
        <p>
            Esta é uma página simples, limpa e profissional<br>
            no mesmo estilo laranja do seu projeto E-Pratika.
        </p>
        <p>
            Perfeita para dashboard inicial, mensagem de boas-vindas,<br>
            página de sucesso, manutenção ou qualquer coisa que precisar!
        </p>

        <a href="/login" class="btn">
            <i class="fas fa-sign-in-alt"></i>
            Ir para Login
        </a>
        <br><br>
        <a href="/consultar" class="btn" style="background:linear-gradient(135deg,#00e68a,#00b36b);">
            <i class="fas fa-search"></i>
            Consultar Testes
        </a>
    </div>

    <div class="footer">
        © 2025 E-Pratika • Todos os direitos reservados
    </div>
</div>

</body>
</html>