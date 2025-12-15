<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caixa Eletrônico</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 8px;
            color: #00d4ff;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .saldo {
            background: rgba(0, 212, 255, 0.2);
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 25px;
            font-size: 1.3rem;
            font-weight: bold;
            border: 1px solid rgba(0, 212, 255, 0.4);
        }

        .menu {
            display: grid;
            gap: 12px;
        }

        .btn {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            padding: 14px;
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
            padding-left: 20px;
            font-weight: 500;
        }

        .btn:hover {
            background: rgba(0, 212, 255, 0.3);
            transform: translateY(-2px);
        }

        .btn.sair {
            background: rgba(255, 99, 132, 0.3);
        }

        .btn.sair:hover {
            background: rgba(255, 99, 132, 0.5);
        }

        .form-group {
            margin-top: 20px;
            display: none;
        }

        .form-group.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }

        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 1rem;
            margin-top: 10px;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .submit-btn {
            margin-top: 15px;
            width: 100%;
            padding: 12px;
            background: #00d4ff;
            color: #1e3c72;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background: #00b0d4;
        }

        .voltar {
            margin-top: 15px;
            text-align: center;
        }

        .voltar button {
            background: none;
            border: none;
            color: #00d4ff;
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .mensagem {
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }

        .sucesso { background: rgba(0, 255, 0, 0.2); color: #b3ffba; }
        .erro { background: rgba(255, 0, 0, 0.2); color: #ffb3b3; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9rem;
            opacity: 0.7;
        }
    </style>
</head>
<body>

<?php
// Inicialização das variáveis
$saldo = 1000.00;
$titular = "Wagner";
$mensagem = "";
$tipoMensagem = "";

session_start();

// Se não houver sessão, inicializa
if (!isset($_SESSION['saldo'])) {
    $_SESSION['saldo'] = $saldo;
    $_SESSION['titular'] = $titular;
}

$saldo = $_SESSION['saldo'];
$titular = $_SESSION['titular'];

// Processa ações
if ($_POST) {
    if (isset($_POST['acao'])) {
        $acao = $_POST['acao'];

        if ($acao == 'sacar') {
            $valor = (float)str_replace(',', '.', $_POST['valor']);
            if ($valor <= 0) {
                $mensagem = "Valor inválido!";
                $tipoMensagem = "erro";
            } elseif ($valor > $saldo) {
                $mensagem = "Saldo insuficiente!";
                $tipoMensagem = "erro";
            } else {
                $saldo -= $valor;
                $mensagem = "Saque de R$ " . number_format($valor, 2) . " realizado com sucesso!";
                $tipoMensagem = "sucesso";
            }
        }

        if ($acao == 'depositar') {
            $valor = (float)str_replace(',', '.', $_POST['valor']);
            if ($valor <= 0) {
                $mensagem = "Valor inválido!";
                $tipoMensagem = "erro";
            } else {
                $saldo += $valor;
                $mensagem = "Depósito de R$ " . number_format($valor, 2) . " realizado com sucesso!";
                $tipoMensagem = "sucesso";
            }
        }

        $_SESSION['saldo'] = $saldo;
    }
}
?>

<div class="container">
    <div class="header">
        <h1>Caixa Eletrônico</h1>
        <p>Bem-vindo, <strong><?= htmlspecialchars($titular) ?></strong></p>
    </div>

    <div class="saldo">
        Saldo atual: <strong>R$ <?= number_format($saldo, 2, ',', '.') ?></strong>
    </div>

    <?php if ($mensagem): ?>
        <div class="mensagem <?= $tipoMensagem ?>">
            <?= $mensagem ?>
        </div>
    <?php endif; ?>

    <!-- Menu Principal -->
    <div id="menu" class="menu">
        <button class="btn" onclick="mostrarConsulta()">1. Consultar saldo</button>
        <button class="btn" onclick="mostrarSaque()">2. Sacar valor</button>
        <button class="btn" onclick="mostrarDeposito()">3. Depositar valor</button>
        <button class="btn sair" onclick="sair()">4. Sair</button>
    </div>

    <!-- Formulário de Saque -->
    <div id="form-saque" class="form-group">
        <h3>Sacar Valor</h3>
        <form method="POST">
            <input type="hidden" name="acao" value="sacar">
            <input type="number" step="0.01" name="valor" placeholder="Digite o valor (ex: 50.00)" required>
            <button type="submit" class="submit-btn">Confirmar Saque</button>
        </form>
        <div class="voltar">
            <button onclick="voltarMenu()">Voltar ao menu</button>
        </div>
    </div>

    <!-- Formulário de Depósito -->
    <div id="form-deposito" class="form-group">
        <h3>Depositar Valor</h3>
        <form method="POST">
            <input type="hidden" name="acao" value="depositar">
            <input type="number" step="0.01" name="valor" placeholder="Digite o valor (ex: 100.00)" required>
            <button type="submit" class="submit-btn">Confirmar Depósito</button>
        </form>
        <div class="voltar">
            <button onclick="voltarMenu()">Voltar ao menu</button>
        </div>
    </div>

    <!-- Consulta de Saldo -->
    <div id="consulta-saldo" class="form-group">
        <h3>Seu saldo atual é:</h3>
        <div class="saldo" style="font-size: 1.5rem; margin: 15px 0;">
            R$ <?= number_format($saldo, 2, ',', '.') ?>
        </div>
        <div class="voltar">
            <button onclick="voltarMenu()">Voltar ao menu</button>
        </div>
    </div>
</div>

<footer>
    Caixa Eletrônico Digital &copy; 2025
</footer>

<script>
function mostrarSaque() {
    hideAll();
    document.getElementById('form-saque').classList.add('active');
}

function mostrarDeposito() {
    hideAll();
    document.getElementById('form-deposito').classList.add('active');
}

function mostrarConsulta() {
    hideAll();
    document.getElementById('consulta-saldo').classList.add('active');
}

function sair() {
    if (confirm('Tem certeza que deseja sair?')) {
        window.location.href = '?sair=1';
    }
}

function voltarMenu() {
    hideAll();
    document.getElementById('menu').style.display = 'grid';
}

function hideAll() {
    document.querySelectorAll('.form-group').forEach(el => {
        el.classList.remove('active');
    });
    document.getElementById('menu').style.display = 'none';
}

// Mostrar menu ao carregar
window.onload = function() {
    voltarMenu();
};
</script>

</body>
</html>