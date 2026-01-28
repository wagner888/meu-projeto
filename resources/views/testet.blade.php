<?php
session_start();
if (!isset($_SESSION['tester_nome'])) {
    $_SESSION['tester_nome'] = 'Tester Exemplo';
}

// Detectar página atual
$paginaAtual = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Pratika - Sistema de Testes</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #ff8c42;
            --light: #ffd9b3;
            --dark: #e65c00;
            --green: #00e68a;
            --bg: #fffaf0;
            --text: #2c1810;
            --shadow: rgba(255, 140, 66, 0.2);
            --menu-bg: #1a1a2e;
            --menu-hover: #16213e;
            --red: #ff4d4d;
            --border: #ffe0c2;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body{
            font-family:'Poppins',sans-serif;
            background:linear-gradient(135deg,#ffd9b3 0%,#ff8c42 50%,#e65c00 100%);
            min-height:100vh;
            color:var(--text);
            padding:0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        /* MENU SUPERIOR */
        .top-menu {
            background: var(--menu-bg);
            color: white;
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            width: 100%;
        }
        .menu-container {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        .menu-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
        }
        .menu-logo i {
            font-size: 1.8rem;
            color: var(--primary);
        }
        .menu-logo span {
            font-weight: 700;
            font-size: 1.1rem;
        }
        .menu-nav {
            display: flex;
            justify-content: center;
            flex: 1;
        }
        .menu-nav ul {
            display: flex;
            list-style: none;
            gap: 0;
        }
        .menu-nav li {
            margin: 0;
        }
        .menu-nav a {
            color: white;
            text-decoration: none;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s;
            border-radius: 0;
            position: relative;
        }
        .menu-nav a i {
            font-size: 1.1rem;
        }
        .menu-nav a:hover {
            background: var(--menu-hover);
            color: var(--primary);
        }
        .menu-nav a.active {
            background: var(--primary);
            color: white;
            font-weight: 600;
        }
        
        /* USER INFO E LOGOUT */
        .menu-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .user-info i {
            font-size: 1.3rem;
            color: var(--primary);
        }
        .user-name {
            font-weight: 500;
            font-size: 0.95rem;
        }
        .btn-logout {
            background: rgba(255, 77, 77, 0.2);
            color: white;
            border: 1px solid rgba(255, 77, 77, 0.4);
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            text-decoration: none;
        }
        .btn-logout:hover {
            background: var(--red);
            border-color: var(--red);
            transform: translateY(-2px);
        }
        
        /* CONTAINER PRINCIPAL - CENTRALIZADO */
        .container{
            max-width:1100px;
            width: 100%;
            margin:30px auto;
            background:white;
            border-radius:24px;
            overflow:hidden;
            box-shadow:0 20px 50px var(--shadow);
        }
        .header{
            background:linear-gradient(135deg,#ff8c42 0%,#e65c00 100%);
            color:white;
            padding:20px 20px;
            text-align:center;
        }
        .section-title{
            font-size:1.6rem;color:#e65c00;margin-bottom:25px;font-weight:600;
            border-bottom:2px solid #ffe0c2;padding-bottom:10px;
        }
        .form-group{margin-bottom:22px;}
        label{
            display:block;margin-bottom:8px;font-weight:600;color:#b34a00;
            display:flex;align-items:center;gap:8px;
        }
        label i{font-size:1.1rem;}
        select,textarea,input[disabled]{
            width:100%;padding:14px;border:2px solid #ffe0c2;border-radius:12px;
            font-size:1rem;transition:all .3s;background:#fffaf0;
        }
        select:focus,textarea:focus{
            outline:none;border-color:#ff8c42;box-shadow:0 0 0 4px rgba(255,140,66,.15);
        }
        input[disabled]{background:#fff5eb;font-weight:600;color:#e65c00;}
        textarea{resize:vertical;min-height:100px;}
        .resultados-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        .campo-texto {
            position: relative;
        }
        .campo-texto label {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        .edit-menu {
            position: absolute;
            top: 5px;
            right: 5px;
            display: flex;
            gap: 5px;
            z-index: 10;
        }
        .edit-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 5px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.75rem;
            transition: all 0.3s;
        }
        .edit-btn:hover {
            background: var(--dark);
            transform: scale(1.05);
        }
        .edit-btn.active {
            background: var(--green);
        }
        .row{
            display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
            gap:22px;
        }
        .btn{
            padding:14px 28px;border:none;border-radius:12px;font-size:1.1rem;
            font-weight:600;cursor:pointer;transition:all .3s;display:inline-flex;
            align-items:center;justify-content:center;gap:10px;
        }
        .btn-primary{
            background:linear-gradient(135deg,#ff8c42 0%,#e65c00 100%);
            color:white;width:100%;box-shadow:0 6px 15px rgba(255,140,66,.3);
        }
        .btn-primary:hover{
            transform:translateY(-3px);box-shadow:0 12px 25px rgba(255,140,66,.4);
        }
        .btn-primary i{font-size:1.3rem;}

        .btn-success{
            background:linear-gradient(135deg,#00e68a 0%,#00cc7a 100%);
            color:white;width:100%;box-shadow:0 6px 15px rgba(0,230,138,.3);
        }
        .btn-success:hover{
            transform:translateY(-3px);box-shadow:0 12px 25px rgba(0,230,138,.4);
        }
        .btn-success i{font-size:1.3rem;}

        /* BOTÃO GRAVAR */
        .btn-gravar{
            background:linear-gradient(135deg, var(--green) 0%, #00cc7a 100%);
            color:#fff;
            margin-top:15px;
            width:100%;
            box-shadow:0 4px 12px rgba(0,230,138,.3);
            font-weight:600;
        }
        .btn-gravar:hover{
            background:linear-gradient(135deg, #00cc7a 0%, #00b36b 100%);
            transform:translateY(-2px);
            box-shadow:0 8px 18px rgba(0,230,138,.4);
        }
        .btn-gravar i{font-size:1.3rem;}

        .section{
            margin:28px 0;border:1px solid #ffe0c2;border-radius:16px;overflow:hidden;
            box-shadow:0 4px 12px rgba(255,140,66,.1);
        }
        .section-header{
            background:linear-gradient(135deg,#ff8c42 0%,#e65c00 100%);
            color:white;padding:16px 20px;font-weight:600;cursor:pointer;
            display:flex;justify-content:space-between;align-items:center;
            transition:background .3s;
        }
        .section-header:hover{background:linear-gradient(135deg,#e65c00 0%,#cc5200 100%);}
        .plus{font-size:26px;transition:transform .3s;}
        .open .plus{transform:rotate(45deg);}
        .section-content{display:none;padding:20px;background:#fffaf0;}
        .section-content ul{
            margin:0 0 18px 0;padding-left:22px;color:#5c2e00;list-style-type:none;
        }
        .section-content li{
            margin:8px 0;padding-left:10px;position:relative;
        }
        .section-content li:before{
            content:"•";color:#ff8c42;font-weight:bold;position:absolute;left:0;
        }
        .alert{
            padding:16px;border-radius:12px;margin-bottom:20px;font-weight:500;
        }
        .alert-success{
            background:#d4edda;color:#155724;border-left:5px solid #28a745;
        }
        .alert-error{
            background:#f8d7da;color:#721c24;border-left:5px solid #dc3545;
        }
        
        @media (max-width: 1200px) {
            .menu-container {
                max-width: 90%;
            }
        }
        
        @media (max-width: 992px) {
            .menu-nav a {
                padding: 18px 15px;
                font-size: 0.85rem;
                gap: 6px;
            }
            .menu-nav a i {
                font-size: 1rem;
            }
        }
        
        @media (max-width: 768px) {
            .menu-container {
                flex-direction: column;
                gap: 15px;
                padding: 10px;
            }
            .menu-nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }
            .menu-nav a {
                padding: 12px 15px;
                border-radius: 8px;
                font-size: 0.9rem;
            }
            .menu-right {
                flex-direction: column;
                width: 100%;
            }
            .user-info {
                width: 100%;
                justify-content: center;
            }
            .btn-logout {
                width: 100%;
                justify-content: center;
            }
            .container {
                margin: 15px;
                border-radius: 16px;
            }
            .header {
                padding: 15px;
            }
        }
        
        @media (max-width: 576px) {
            .row {
                grid-template-columns: 1fr;
            }
            .resultados-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- MENU SUPERIOR -->
    <nav class="top-menu">
        <div class="menu-container">
            <div class="menu-logo">
                <i class="fas fa-vial"></i>
                <span>E-Pratika</span>
            </div>
            
            <nav class="menu-nav">
                <ul>
                    <li><a href="index.php" class="<?= $paginaAtual == 'index' ? 'active' : '' ?>">
                        <i class="fas fa-plus-circle"></i> Novo Teste
                    </a></li>
                    <li><a href="consulta.php" class="<?= $paginaAtual == 'consulta' ? 'active' : '' ?>">
                        <i class="fas fa-search"></i> Consultar
                    </a></li>
                    <li><a href="relatorios.php" class="<?= $paginaAtual == 'relatorios' ? 'active' : '' ?>">
                        <i class="fas fa-chart-bar"></i> Relatórios
                    </a></li>
                    <li><a href="dashboard.php" class="<?= $paginaAtual == 'dashboard' ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a></li>
                    <li><a href="configuracoes.php" class="<?= $paginaAtual == 'configuracoes' ? 'active' : '' ?>">
                        <i class="fas fa-cog"></i> Configurações
                    </a></li>
                    <li><a href="usuarios.php" class="<?= $paginaAtual == 'usuarios' ? 'active' : '' ?>">
                        <i class="fas fa-users"></i> Usuários
                    </a></li>
                </ul>
            </nav>
            
            <div class="menu-right">
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span class="user-name"><?= htmlspecialchars($_SESSION['tester_nome']) ?></span>
                </div>
                <a href="logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <!-- Header mantido apenas para o background color, mas sem conteúdo -->
        </div>

        <!-- REMOVIDO: Todas as abas (nav-tabs) -->
        <!-- Conteúdo principal direto -->
        <div style="padding:35px;">
            <h2 class="section-title">Novo Teste</h2>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'cadastrar') {
                try {
                    $pdo = new PDO("mysql:host=localhost;dbname=epratika_tests;charset=utf8mb4", 'root', '');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "INSERT INTO testes 
                            (tester_nome, versao_epratika, versao_ebiometrica, versao_launcher, versao_magisk, estado, umed_tipo,
                             resultados_atualizacao, corrigidos_atualizacao, resultados_aulas, corrigidos_aulas,
                             resultados_interface, corrigidos_interface, resultados_desempenho, corrigidos_desempenho,
                             resultados_sincronizacao, corrigidos_sincronizacao, resultados_regras, corrigidos_regras)
                             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        $_SESSION['tester_nome'],
                        $_POST['versao_epratika'],
                        $_POST['versao_ebiometrica'],
                        $_POST['versao_launcher'],
                        $_POST['versao_magisk'],
                        $_POST['estado'],
                        $_POST['umed_tipo'],
                        $_POST['resultados_atualizacao'] ?? '',
                        $_POST['corrigidos_atualizacao'] ?? '',
                        $_POST['resultados_aulas'] ?? '',
                        $_POST['corrigidos_aulas'] ?? '',
                        $_POST['resultados_interface'] ?? '',
                        $_POST['corrigidos_interface'] ?? '',
                        $_POST['resultados_desempenho'] ?? '',
                        $_POST['corrigidos_desempenho'] ?? '',
                        $_POST['resultados_sincronizacao'] ?? '',
                        $_POST['corrigidos_sincronizacao'] ?? '',
                        $_POST['resultados_regras'] ?? '',
                        $_POST['corrigidos_regras'] ?? ''
                    ]);
                    echo '<div class="alert alert-success">Teste cadastrado com sucesso!</div>';
                } catch(Exception $e) {
                    echo '<div class="alert alert-error">Erro: '.htmlspecialchars($e->getMessage()).'</div>';
                }
            }
            ?>
            <form method="POST">
                <input type="hidden" name="action" value="cadastrar">
                <div class="form-group">
                    <label>Tester</label>
                    <input type="text" value="<?= $_SESSION['tester_nome'] ?>" disabled>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label><i class="fas fa-mobile-alt"></i> Versão E-Pratika *</label>
                        <select name="versao_epratika" required>
                            <option value="">Selecione...</option>
                            <option>3.2.1</option><option>3.2.0</option><option>3.1.9</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-fingerprint"></i> Versão E-Biométrica *</label>
                        <select name="versao_ebiometrica" required>
                            <option value="">Selecione...</option>
                            <option>2.1.5</option><option>2.1.4</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label><i class="fas fa-rocket"></i> Versão Launcher *</label>
                        <select name="versao_launcher" required>
                            <option value="">Selecione...</option>
                            <option>1.4.2</option><option>1.4.1</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-magic"></i> Versão MAGISK *</label>
                        <select name="versao_magisk" required>
                            <option value="">Selecione...</option>
                            <option>25.2</option><option>25.1</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Estado *</label>
                        <select name="estado" required>
                            <option value="">Selecione o estado...</option>
                            <option value="AC">AC</option><option value="AL">AL</option><option value="AP">AP</option>
                            <option value="AM">AM</option><option value="BA">BA</option><option value="CE">CE</option>
                            <option value="DF">DF</option><option value="ES">ES</option><option value="GO">GO</option>
                            <option value="MA">MA</option><option value="MT">MT</option><option value="MS">MS</option>
                            <option value="MG">MG</option><option value="PA">PA</option><option value="PB">PB</option>
                            <option value="PR">PR</option><option value="PE">PE</option><option value="PI">PI</option>
                            <option value="RJ">RJ</option><option value="RN">RN</option><option value="RS">RS</option>
                            <option value="RO">RO</option><option value="RR">RR</option><option value="SC">SC</option>
                            <option value="SP">SP</option><option value="SE">SE</option><option value="TO">TO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-microchip"></i> Tipo de Umed *</label>
                        <select name="umed_tipo" required>
                            <option value="">Selecione...</option>
                            <option value="Full">Umed Full</option>
                            <option value="Lite">Umed Lite</option>
                            <option value="Minimal 20.1.3">Minimal Versão 20.1.3</option>
                            <option value="Minimal 3.0.3">Minimal Versão 3.0.3</option>
                            <option value="Minimal 3.2.0">Minimal Versão 3.2.0</option>
                            <option value="Minimal 3.7.0">Minimal Versão 3.7.0</option>
                            <option value="OBD2">OBD2</option>
                            <option value="MOBILE TRACKER - Cat:A">Mobile Tracker Cat:A</option>
                        </select>
                    </div>
                </div>

                <!-- SEÇÃO 1 -->
                <div class="section">
                    <div class="section-header" onclick="toggle(this)">Atualização e Inicialização <span class="plus">+</span></div>
                    <div class="section-content">
                        <div class="resultados-container">
                            <div class="campo-texto">
                                <div class="edit-menu">
                                    <button class="edit-btn" onclick="toggleEdit('resultados-atualizacao')" title="Editar resultados">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="edit-btn" onclick="clearText('resultados-atualizacao')" title="Limpar">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                                <label><i class="fas fa-clipboard-list"></i> Resultados Observados</label>
                                <textarea id="resultados-atualizacao" name="resultados_atualizacao" placeholder="Descreva os resultados observados durante o teste..." readonly></textarea>
                            </div>
                            <div class="campo-texto">
                                <div class="edit-menu">
                                    <button class="edit-btn" onclick="toggleEdit('corrigidos-atualizacao')" title="Editar corrigidos">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="edit-btn" onclick="clearText('corrigidos-atualizacao')" title="Limpar">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                                <label><i class="fas fa-check-circle"></i> O que foi Corrigido</label>
                                <textarea id="corrigidos-atualizacao" name="corrigidos_atualizacao" placeholder="Descreva o que foi corrigido durante o teste..." readonly></textarea>
                            </div>
                        </div>
                        <div style="margin-top: 15px;">
                            <h4 style="color: var(--dark); margin-bottom: 10px; font-size: 0.95rem;">
                                <i class="fas fa-list-check"></i> Itens de Verificação:
                            </h4>
                            <ul>
                                <li>Corrigido o problema que exigia reinicialização do Tablet para concluir a atualização.</li>
                                <li>Corrigido o problema em que o aplicativo fechava após o download sem concluir a atualização.</li>
                                <li>Corrigido o processo de atualização manual, garantindo execução completa.</li>
                                <li>Correção aplicada no acompanhamento da instalação, garantindo funcionamento normal.</li>
                                <li>Corrigido o problema em que o Tablet não recebia atualizações pontuais liberadas.</li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-gravar" onclick="saveSection('atualizacao')">
                            <i class="fas fa-save"></i> Gravar Seção
                        </button>
                    </div>
                </div>

                <!-- SEÇÃO 2 -->
                <div class="section">
                    <div class="section-header" onclick="toggle(this)">Aulas e Coletas <span class="plus">+</span></div>
                    <div class="section-content">
                        <div class="resultados-container">
                            <div class="campo-texto">
                                <div class="edit-menu">
                                    <button class="edit-btn" onclick="toggleEdit('resultados-aulas')" title="Editar resultados">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="edit-btn" onclick="clearText('resultados-aulas')" title="Limpar">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                                <label><i class="fas fa-clipboard-list"></i> Resultados Observados</label>
                                <textarea id="resultados-aulas" name="resultados_aulas" placeholder="Descreva os resultados observados durante o teste..." readonly></textarea>
                            </div>
                            <div class="campo-texto">
                                <div class="edit-menu">
                                    <button class="edit-btn" onclick="toggleEdit('corrigidos-aulas')" title="Editar corrigidos">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="edit-btn" onclick="clearText('corrigidos-aulas')" title="Limpar">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                                <label><i class="fas fa-check-circle"></i> O que foi Corrigido</label>
                                <textarea id="corrigidos-aulas" name="corrigidos_aulas" placeholder="Descreva o que foi corrigido durante o teste..." readonly></textarea>
                            </div>
                        </div>
                        <div style="margin-top: 15px;">
                            <h4 style="color: var(--dark); margin-bottom: 10px; font-size: 0.95rem;">
                                <i class="fas fa-list-check"></i> Itens de Verificação:
                            </h4>
                            <ul>
                                <li>Corrigido o comportamento que impedia a mudança automática para a segunda aula.</li>
                                <li>Corrigida a falha que iniciava uma nova aula (fantasma) ao tentar finalizar a atual.</li>
                                <li>Corrigido o bloqueio de coleta causado pelo modo descanso da tela.</li>
                                <li>Corrigido o erro de permissão negada na coleta da digital.</li>
                                <li>Corrigido o erro de "permissão não aceita" durante a coleta.</li>
                                <li>Corrigido o erro na categoria B que solicitava foto durante a aula de forma indevida.</li>
                                <li>Corrigido o erro na categoria A que emitia alerta sonoro sem solicitar foto.</li>
                                <li>Corrigido o erro na categoria A que impedia a solicitação de coleta de percurso no início da aula.</li>
                                <li>Corrigido o erro na categoria A que impedia a solicitação de fotos de percurso.</li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-gravar" onclick="saveSection('aulas')">
                            <i class="fas fa-save"></i> Gravar Seção
                        </button>
                    </div>
                </div>

                <!-- SEÇÃO 3 -->
                <div class="section">
                    <div class="section-header" onclick="toggle(this)">Interface e Mensagens <span class="plus">+</span></div>
                    <div class="section-content">
                        <div class="resultados-container">
                            <div class="campo-texto">
                                <div class="edit-menu">
                                    <button class="edit-btn" onclick="toggleEdit('resultados-interface')" title="Editar resultados">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="edit-btn" onclick="clearText('resultados-interface')" title="Limpar">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                                <label><i class="fas fa-clipboard-list"></i> Resultados Observados</label>
                                <textarea id="resultados-interface" name="resultados_interface" placeholder="Descreva os resultados observados durante o teste..." readonly></textarea>
                            </div>
                            <div class="campo-texto">
                                <div class="edit-menu">
                                    <button class="edit-btn" onclick="toggleEdit('corrigidos-interface')" title="Editar corrigidos">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="edit-btn" onclick="clearText('corrigidos-interface')" title="Limpar">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                                <label><i class="fas fa-check-circle"></i> O que foi Corrigido</label>
                                <textarea id="corrigidos-interface" name="corrigidos_interface" placeholder="Descreva o que foi corrigido durante o teste..." readonly></textarea>
                            </div>
                        </div>
                        <div style="margin-top: 15px;">
                            <h4 style="color: var(--dark); margin-bottom: 10px; font-size: 0.95rem;">
                                <i class="fas fa-list-check"></i> Itens de Verificação:
                            </h4>
                            <ul>
                                <li>Corrigido o alerta exibido ao finalizar retorno informando "Nenhum usuário para validação."</li>
                                <li>Corrigida a mensagem constante "Aguarde, conectado ao serviço de atividade."</li>
                                <li>Corrigido o erro que abria a câmera do Tablet em vez do módulo e-Biometrika.</li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-gravar" onclick="saveSection('interface')">
                            <i class="fas fa-save"></i> Gravar Seção
                        </button>
                    </div>
                </div>

                <!-- SEÇÃO 4 -->
                <div class="section">
                    <div class="section-header" onclick="toggle(this)">Desempenho e Estabilidade <span class="plus">+</span></div>
                    <div class="section-content">
                        <div class="resultados-container">
                            <div class="campo-texto">
                                <div class="edit-menu">
                                    <button class="edit-btn" onclick="toggleEdit('resultados-desempenho')" title="Editar resultados">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="edit-btn" onclick="clearText('resultados-desempenho')" title="Limpar">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                                <label><i class="fas fa-clipboard-list"></i> Resultados Observados</label>
                                <textarea id="resultados-desempenho" name="resultados_desempenho" placeholder="Descreva os resultados observados durante o teste..." readonly></textarea>
                            </div>
                            <div class="campo-texto">
                                <div class="edit-menu">
                                    <button class="edit-btn" onclick="toggleEdit('corrigidos-desempenho')" title="Editar corrigidos">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="edit-btn" onclick="clearText('corrigidos-desempenho')" title="Limpar">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                                <label><i class="fas fa-check-circle"></i> O que foi Corrigido</label>
                                <textarea id="corrigidos-desempenho" name="corrigidos_desempenho" placeholder="Descreva o que foi corrigido durante o teste..." readonly></textarea>
                            </div>
                        </div>
                        <div style="margin-top: 15px;">
                            <h4 style="color: var(--dark); margin-bottom: 10px; font-size: 0.95rem;">
                                <i class="fas fa-list-check"></i> Itens de Verificação:
                            </h4>
                            <ul>
                                <li>Corrigido o travamento causado pelas mensagens "MAGISK parou" e "Launcher não respondendo."</li>
                                <li>Corrigido o travamento do Tablet na solicitação de permissão de superusuário.</li>
                                <li>Corrigido o travamento da tela branca ao iniciar a segunda aula.</li>
                                <li>Corrigido o looping na captura da foto final de percurso.</li>
                                <li>Corrigido o looping na captura da foto final da aula.</li>
                                <li>Corrigida a falha que ocasionava a interrupção inesperada do aplicativo e-PRÁTIKA.</li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-gravar" onclick="saveSection('desempenho')">
                            <i class="fas fa-save"></i> Gravar Seção
                        </button>
                    </div>
                </div>

                <!-- SEÇÃO 5 -->
                <div class="section">
                    <div class="section-header" onclick="toggle(this)">Sincronização e Agendamento <span class="plus">+</span></div>
                    <div class="section-content">
                        <div class="resultados-container">
                            <div class="campo-texto">
                                <div class="edit-menu">
                                    <button class="edit-btn" onclick="toggleEdit('resultados-sincronizacao')" title="Editar resultados">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="edit-btn" onclick="clearText('resultados-sincronizacao')" title="Limpar">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                                <label><i class="fas fa-clipboard-list"></i> Resultados Observados</label>
                                <textarea id="resultados-sincronizacao" name="resultados_sincronizacao" placeholder="Descreva os resultados observados durante o teste..." readonly></textarea>
                            </div>
                            <div class="campo-texto">
                                <div class="edit-menu">
                                    <button class="edit-btn" onclick="toggleEdit('corrigidos-sincronizacao')" title="Editar corrigidos">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="edit-btn" onclick="clearText('corrigidos-sincronizacao')" title="Limpar">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                                <label><i class="fas fa-check-circle"></i> O que foi Corrigido</label>
                                <textarea id="corrigidos-sincronizacao" name="corrigidos_sincronizacao" placeholder="Descreva o que foi corrigido durante o teste..." readonly></textarea>
                            </div>
                        </div>
                        <div style="margin-top: 15px;">
                            <h4 style="color: var(--dark); margin-bottom: 10px; font-size: 0.95rem;">
                                <i class="fas fa-list-check"></i> Itens de Verificação:
                            </h4>
                            <ul>
                                <li>Corrigido o problema de sincronização que impedia a abertura da aula.</li>
                                <li>Corrigido o problema que impedia a exibição do horário de agendamento no Tablet.</li>
                                <li>Corrigido o problema de exibição incorreta do horário durante aula em andamento.</li>
                                <li>Corrigido o erro que registrava aulas finalizadas como canceladas.</li>
                                <li>Corrigido o bloqueio que impedia a finalização após atingir o tempo total da aula.</li>
                                <li>Corrigido o erro em que a aula em andamento desaparecia do Tablet.</li>
                                <li>Corrigido o cronômetro que exibia tempo negativo durante a aula.</li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-gravar" onclick="saveSection('sincronizacao')">
                            <i class="fas fa-save"></i> Gravar Seção
                        </button>
                    </div>
                </div>

                <!-- SEÇÃO 6 -->
                <div class="section">
                    <div class="section-header" onclick="toggle(this)">Regras Específicas <span class="plus">+</span></div>
                    <div class="section-content">
                        <div class="resultados-container">
                            <div class="campo-texto">
                                <div class="edit-menu">
                                    <button class="edit-btn" onclick="toggleEdit('resultados-regras')" title="Editar resultados">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="edit-btn" onclick="clearText('resultados-regras')" title="Limpar">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                                <label><i class="fas fa-clipboard-list"></i> Resultados Observados</label>
                                <textarea id="resultados-regras" name="resultados_regras" placeholder="Descreva os resultados observados durante o teste..." readonly></textarea>
                            </div>
                            <div class="campo-texto">
                                <div class="edit-menu">
                                    <button class="edit-btn" onclick="toggleEdit('corrigidos-regras')" title="Editar corrigidos">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="edit-btn" onclick="clearText('corrigidos-regras')" title="Limpar">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                                <label><i class="fas fa-check-circle"></i> O que foi Corrigido</label>
                                <textarea id="corrigidos-regras" name="corrigidos_regras" placeholder="Descreva o que foi corrigido durante o teste..." readonly></textarea>
                            </div>
                        </div>
                        <div style="margin-top: 15px;">
                            <h4 style="color: var(--dark); margin-bottom: 10px; font-size: 0.95rem;">
                                <i class="fas fa-list-check"></i> Itens de Verificação:
                            </h4>
                            <ul>
                                <li>Corrigida a regra de agendamento da Bahia, garantindo que aulas após 17h possuam duração mínima de 45 minutos.</li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-gravar" onclick="saveSection('regras')">
                            <i class="fas fa-save"></i> Gravar Seção
                        </button>
                    </div>
                </div>

                <!-- BOTÃO DE ENVIO -->
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-paper-plane"></i> Enviar Teste
                </button>
            </form>
        </div>
    </div>

<script>
function toggle(el){
    const content = el.nextElementSibling;
    content.style.display = content.style.display === 'block' ? 'none' : 'block';
    el.classList.toggle('open');
}

function toggleEdit(fieldId) {
    const textarea = document.getElementById(fieldId);
    const isReadonly = textarea.hasAttribute('readonly');
    
    if (isReadonly) {
        textarea.removeAttribute('readonly');
        textarea.style.backgroundColor = '#fff';
        textarea.style.borderColor = 'var(--primary)';
        textarea.focus();
        
        // Atualizar botão
        event.target.closest('.edit-btn').classList.add('active');
        event.target.closest('.edit-btn').innerHTML = '<i class="fas fa-save"></i>';
    } else {
        textarea.setAttribute('readonly', true);
        textarea.style.backgroundColor = '#fffaf0';
        textarea.style.borderColor = '#ffe0c2';
        
        // Atualizar botão
        event.target.closest('.edit-btn').classList.remove('active');
        event.target.closest('.edit-btn').innerHTML = '<i class="fas fa-edit"></i>';
        
        // Salvar no localStorage
        localStorage.setItem(fieldId, textarea.value);
    }
}

function clearText(fieldId) {
    if (confirm('Tem certeza que deseja limpar este campo?')) {
        const textarea = document.getElementById(fieldId);
        textarea.value = '';
        localStorage.removeItem(fieldId);
    }
}

function saveSection(section) {
    const campos = ['resultados', 'corrigidos'];
    let salvos = 0;
    
    campos.forEach(campo => {
        const fieldId = `${campo}-${section}`;
        const textarea = document.getElementById(fieldId);
        if (textarea.value.trim()) {
            localStorage.setItem(fieldId, textarea.value);
            salvos++;
        }
    });
    
    if (salvos > 0) {
        // Mostrar mensagem de sucesso
        const btn = event.target.closest('.btn-gravar');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Salvo!';
        btn.style.background = 'var(--green)';
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.background = '';
        }, 2000);
    } else {
        alert('Preencha pelo menos um campo antes de salvar.');
    }
}

// Carregar dados salvos ao iniciar
document.addEventListener('DOMContentLoaded', function() {
    const secoes = ['atualizacao', 'aulas', 'interface', 'desempenho', 'sincronizacao', 'regras'];
    const campos = ['resultados', 'corrigidos'];
    
    secoes.forEach(secao => {
        campos.forEach(campo => {
            const fieldId = `${campo}-${secao}`;
            const savedValue = localStorage.getItem(fieldId);
            if (savedValue) {
                const textarea = document.getElementById(fieldId);
                if (textarea) {
                    textarea.value = savedValue;
                }
            }
        });
    });
});
</script>
</body>
</html>