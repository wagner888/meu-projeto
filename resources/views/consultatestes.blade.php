<?php
session_start();
if (!isset($_SESSION['tester_nome'])) {
    $_SESSION['tester_nome'] = 'Tester Exemplo';
}

// Detectar página atual
$paginaAtual = basename($_SERVER['PHP_SELF'], '.php');

// Configuração do banco
try {
    $pdo = new PDO("mysql:host=localhost;dbname=wagner;charset=utf8mb4", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// === PARÂMETROS DE ORDENAÇÃO ===
$colunasPermitidas = [
    'data_teste', 'tester_nome', 'estado', 'versao_epratika',
    'versao_ebiometrica', 'versao_launcher', 'versao_magisk', 'umed_tipo'
];

$ordemColuna = $_GET['ordem'] ?? 'data_teste';
$ordemDirecao = $_GET['dir'] ?? 'DESC';

if (!in_array($ordemColuna, $colunasPermitidas)) {
    $ordemColuna = 'data_teste';
}
$ordemDirecao = strtoupper($ordemDirecao) === 'ASC' ? 'ASC' : 'DESC';
$proximaDirecao = $ordemDirecao === 'ASC' ? 'DESC' : 'ASC';

// === FILTROS E PAGINAÇÃO ===
$itensPorPagina = isset($_GET['itens']) ? max(5, min(100, (int)$_GET['itens'])) : 10;
$paginaAtual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($paginaAtual - 1) * $itensPorPagina;

$filtros = [];
$params = [];

if (!empty($_GET['tester'])) {
    $filtros[] = "tester_nome LIKE :tester";
    $params[':tester'] = '%' . $_GET['tester'] . '%';
}
if (!empty($_GET['estado'])) {
    $filtros[] = "estado = :estado";
    $params[':estado'] = $_GET['estado'];
}
if (!empty($_GET['versao_epratika'])) {
    $filtros[] = "versao_epratika = :versao_epratika";
    $params[':versao_epratika'] = $_GET['versao_epratika'];
}
if (!empty($_GET['versao_ebiometrica'])) {
    $filtros[] = "versao_ebiometrica = :versao_ebiometrica";
    $params[':versao_ebiometrica'] = $_GET['versao_ebiometrica'];
}
if (!empty($_GET['versao_launcher'])) {
    $filtros[] = "versao_launcher = :versao_launcher";
    $params[':versao_launcher'] = $_GET['versao_launcher'];
}
if (!empty($_GET['versao_magisk'])) {
    $filtros[] = "versao_magisk = :versao_magisk";
    $params[':versao_magisk'] = $_GET['versao_magisk'];
}
if (!empty($_GET['umed_tipo'])) {
    $filtros[] = "umed_tipo = :umed_tipo";
    $params[':umed_tipo'] = $_GET['umed_tipo'];
}
if (!empty($_GET['data_inicio'])) {
    $filtros[] = "DATE(data_teste) >= :data_inicio";
    $params[':data_inicio'] = $_GET['data_inicio'];
}
if (!empty($_GET['data_fim'])) {
    $filtros[] = "DATE(data_teste) <= :data_fim";
    $params[':data_fim'] = $_GET['data_fim'];
}

$where = !empty($filtros) ? 'WHERE ' . implode(' AND ', $filtros) : '';

// Total de registros
$countSql = "SELECT COUNT(*) as total FROM testes $where";
$stmtCount = $pdo->prepare($countSql);
$stmtCount->execute($params);
$totalRegistros = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
$totalPaginas = max(1, ceil($totalRegistros / $itensPorPagina));

// Consulta paginada com ordenação
$sql = "SELECT * FROM testes $where ORDER BY $ordemColuna $ordemDirecao LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);

foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', $itensPorPagina, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$testes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Função para manter parâmetros na URL
function manterParams(array $novos = []): string {
    $params = $_GET;
    foreach ($novos as $k => $v) {
        $params[$k] = $v;
    }
    return http_build_query($params);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Testes - E-Pratika</title>
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
            --blue: #4d88ff;
            --dark-blue: #1a66ff;
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

        .filters { background: #fff5eb; padding: 25px; border-bottom: 1px solid var(--border); }
        .filter-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 18px; }
        .filter-group { display: flex; flex-direction: column; }
        .filter-group label { display: flex; align-items: center; gap: 8px; font-weight: 600; color: #b34a00; margin-bottom: 8px; font-size: 0.95rem; }
        .filter-group i { font-size: 1.1rem; color: var(--primary); }
        .filter-group select, .filter-group input {
            width: 100%; padding: 12px 14px; border: 2px solid var(--border); border-radius: 12px; background: white; font-size: 1rem; transition: all 0.3s;
        }
        .filter-group select:focus, .filter-group input:focus {
            outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(255, 140, 66, 0.15);
        }
        .filter-actions { display: flex; gap: 12px; align-items: center; margin-top: 26px; }
        .btn-filter, .btn-clear {
            padding: 12px 24px; border: none; border-radius: 12px; font-weight: 600; cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 48px; transition: all 0.3s;
        }
        .btn-filter { background: linear-gradient(135deg, var(--blue), var(--dark-blue)); color: white; box-shadow: 0 6px 15px rgba(77, 136, 255, 0.3); flex: 1; }
        .btn-clear { background: linear-gradient(135deg, #dc3545, #c82333); color: white; box-shadow: 0 6px 15px rgba(220, 53, 69, 0.3); flex: 1; border: 2px solid #dc3545; }
        .btn-filter:hover, .btn-clear:hover { transform: translateY(-2px); }

        .results { padding: 25px; }
        .stats-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 20px;
            flex-wrap: wrap;
        }
        .stats {
            display: flex;
            gap: 20px;
            align-items: center;
            font-weight: 600;
            color: #b34a00;
        }
        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .pagination-controls label {
            font-weight: 600;
            color: #b34a00;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .pagination-controls select {
            padding: 8px 12px;
            border: 2px solid var(--border);
            border-radius: 8px;
            background: white;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text);
            cursor: pointer;
            transition: all 0.3s;
        }
        .pagination-controls select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.15);
        }
        .pagination-controls select:hover {
            border-color: var(--primary);
        }

        table { width: 100%; border-collapse: collapse; background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        th {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white; padding: 16px 12px; text-align: left; font-weight: 600; font-size: 0.95rem; cursor: pointer; user-select: none;
        }
        th:hover { background: var(--dark); }
        th i.fa-sort { opacity: 0.6; }
        th i.fa-sort-up, th i.fa-sort-down { opacity: 1; color: #fff; }
        td { padding: 14px 12px; border-bottom: 1px solid #f0f0f0; font-size: 0.95rem; }
        tr:hover { background: #fff8f0; }
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; text-align: center; white-space: nowrap; }
        .badge-full { background: #d4edda; color: #155724; }
        .badge-lite { background: #fff3cd; color: #856404; }
        .btn-view {
            background: linear-gradient(135deg, var(--blue), var(--dark-blue));
            color: white; border: none; padding: 8px 16px; border-radius: 8px;
            font-size: 0.9rem; cursor: pointer; transition: all 0.3s; display: inline-block;
            text-align: center; white-space: nowrap; text-decoration: none;
        }
        .btn-view:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(77,136,255,0.4); }

        .pagination-wrapper {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 25px;
            align-items: center;
        }
        .pagination { 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            gap: 8px; 
            flex-wrap: wrap; 
        }
        .page-btn { 
            min-width: 40px; 
            height: 40px; 
            border: 2px solid var(--border); 
            background: white; 
            color: #b34a00; 
            font-weight: 600; 
            border-radius: 10px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            cursor: pointer; 
            transition: all 0.3s; 
            text-decoration: none; 
        }
        .page-btn:hover:not(.disabled):not(.active) { 
            background: var(--primary); 
            color: white; 
            border-color: var(--primary); 
        }
        .page-btn.active { 
            background: linear-gradient(135deg, var(--primary), var(--dark)); 
            color: white; 
            border-color: transparent; 
        }
        .page-btn.disabled { 
            opacity: 0.5; 
            cursor: not-allowed; 
            pointer-events: none; 
        }
        .pagination-info {
            font-weight: 600;
            color: #b34a00;
            text-align: center;
            padding: 10px;
            background: #fff5eb;
            border-radius: 10px;
        }

        .no-results { text-align: center; color: #b34a00; font-style: italic; padding: 40px; background: #fff8f0; border-radius: 12px; margin-top: 20px; }
        .no-results i { font-size: 3rem; color: var(--primary); margin-bottom: 15px; display: block; }
        .section-title{
            font-size:1.6rem;color:#e65c00;margin-bottom:25px;font-weight:600;
            border-bottom:2px solid #ffe0c2;padding-bottom:10px;
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
            .filter-row { grid-template-columns: 1fr; }
            .filter-actions { flex-direction: column; width: 100%; }
            .btn-filter, .btn-clear { width: 100%; flex: none; }
            .stats-row { 
                flex-direction: column; 
                align-items: flex-start;
            }
            .stats { 
                flex-direction: column; 
                gap: 10px; 
                align-items: flex-start;
                width: 100%;
            }
            .pagination-controls {
                width: 100%;
                justify-content: flex-start;
            }
            table { display: block; overflow-x: auto; }
        }
        
        @media (max-width: 576px) {
            .filter-row {
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
                    <li><a href="testet" class="<?= $paginaAtual == 'testet' ? 'active' : '' ?>">
                        <i class="fas fa-plus-circle"></i> Novo Teste
                    </a></li>
                    <li><a href="consultatestes" class="<?= $paginaAtual == 'consultatestes' ? 'active' : '' ?>">
                        <i class="fas fa-search"></i> Consultar
                    </a></li>
                    <li><a href="consultatestes" class="<?= $paginaAtual == 'relatorios' ? 'active' : '' ?>">
                        <i class="fas fa-chart-bar"></i> Relatórios
                    </a></li>
                    <li><a href="dashboard" class="<?= $paginaAtual == 'dashboard' ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a></li>
                    <li><a href="configuracoes" class="<?= $paginaAtual == 'configuracoes' ? 'active' : '' ?>">
                        <i class="fas fa-cog"></i> Configurações
                    </a></li>
                    <li><a href="usuarios" class="<?= $paginaAtual == 'usuarios' ? 'active' : '' ?>">
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

        <form method="GET" class="filters" id="filterForm">
            <div class="filter-row">
                <div class="filter-group">
                    <label><i class="fas fa-user"></i> Nome do Tester</label>
                    <input type="text" name="tester" value="<?= htmlspecialchars($_GET['tester'] ?? '') ?>" placeholder="Digite o nome...">
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-map-marker-alt"></i> Estado</label>
                    <select name="estado">
                        <option value="">Todos os estados</option>
                        <?php foreach (['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf): ?>
                        <option value="<?= $uf ?>" <?= ($_GET['estado'] ?? '') === $uf ? 'selected' : '' ?>><?= $uf ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-mobile-alt"></i> E-Pratika</label>
                    <select name="versao_epratika">
                        <option value="">Todas as versões</option>
                        <?php foreach (['04.06.23043','4.6.12','4.6.15','4.6.20','4.6.22','4.6.23','5.0.0','5.0.1','5.0.2','5.0.3','5.0.4','5.0.5','5.0.7','5.1.0'] as $v): ?>
                        <option value="<?= $v ?>" <?= ($_GET['versao_epratika'] ?? '') === $v ? 'selected' : '' ?>><?= $v ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-microchip"></i> Tipo Umed</label>
                    <select name="umed_tipo">
                        <option value="">Todos os tipos</option>
                        <option value="Full" <?= ($_GET['umed_tipo'] ?? '') === 'Full' ? 'selected' : '' ?>>Umed Full</option>
                        <option value="Lite" <?= ($_GET['umed_tipo'] ?? '') === 'Lite' ? 'selected' : '' ?>>Umed Lite</option>
                    </select>
                </div>
            </div>
            <div class="filter-row">
                <div class="filter-group">
                    <label><i class="fas fa-calendar-alt"></i> Data Início</label>
                    <input type="date" name="data_inicio" value="<?= htmlspecialchars($_GET['data_inicio'] ?? '') ?>">
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-calendar-check"></i> Data Fim</label>
                    <input type="date" name="data_fim" value="<?= htmlspecialchars($_GET['data_fim'] ?? '') ?>">
                </div>
                <div class="filter-group">
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Filtrar</button>
                        <button type="button" class="btn-clear" onclick="limparFiltros()"><i class="fas fa-eraser"></i> Limpar</button>
                    </div>
                </div>
            </div>
        </form>

        <div style="padding:35px;">
            <h2 class="section-title">Consulta de Testes</h2>
            <div class="stats-row">
                <div class="stats">
                    <span><i class="fas fa-database"></i> <strong><?= number_format($totalRegistros, 0, ',', '.') ?></strong> teste(s) encontrado(s)</span>
                    <span><i class="fas fa-file-alt"></i> Página <strong><?= $paginaAtual ?></strong> de <strong><?= $totalPaginas ?></strong></span>
                </div>
                <div class="pagination-controls">
                    <label>
                        <i class="fas fa-list-ol"></i>
                        Itens por página:
                    </label>
                    <select id="itensPorPagina" onchange="alterarItensPorPagina(this.value)">
                        <option value="5" <?= $itensPorPagina == 5 ? 'selected' : '' ?>>5</option>
                        <option value="10" <?= $itensPorPagina == 10 ? 'selected' : '' ?>>10</option>
                        <option value="25" <?= $itensPorPagina == 25 ? 'selected' : '' ?>>25</option>
                        <option value="50" <?= $itensPorPagina == 50 ? 'selected' : '' ?>>50</option>
                        <option value="100" <?= $itensPorPagina == 100 ? 'selected' : '' ?>>100</option>
                    </select>
                </div>
            </div>

            <?php if ($testes): ?>
            <table>
                <thead>
                    <tr>
                        <th onclick="ordenar('data_teste')">
                            <i class="fas fa-clock"></i> Data/Hora
                            <?= $ordemColuna === 'data_teste' ? ($ordemDirecao === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>' ?>
                        </th>
                        <th onclick="ordenar('tester_nome')">
                            <i class="fas fa-user"></i> Tester
                            <?= $ordemColuna === 'tester_nome' ? ($ordemDirecao === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>' ?>
                        </th>
                        <th onclick="ordenar('estado')">
                            <i class="fas fa-map-marker-alt"></i> Estado
                            <?= $ordemColuna === 'estado' ? ($ordemDirecao === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>' ?>
                        </th>
                        <th onclick="ordenar('versao_epratika')">
                            <i class="fas fa-mobile-alt"></i> E-Pratika
                            <?= $ordemColuna === 'versao_epratika' ? ($ordemDirecao === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>' ?>
                        </th>
                        <th><i class="fas fa-fingerprint"></i> E-Biométrica</th>
                        <th><i class="fas fa-rocket"></i> Launcher</th>
                        <th><i class="fas fa-magic"></i> Magisk</th>
                         <th onclick="ordenar('umed_tipo')" style="text-align: center; white-space: nowrap;">
                            <i class="fas fa-microchip"></i> Umed
                            <?= $ordemColuna === 'umed_tipo' ? ($ordemDirecao === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>' ?>
                        </th>
                        <th style="text-align: center; white-space: nowrap;"><i class="fas fa-eye"></i> Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testes as $t): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($t['data_teste'])) ?></td>
                        <td><strong><?= htmlspecialchars($t['tester_nome']) ?></strong></td>
                        <td><strong><?= htmlspecialchars($t['estado']) ?></strong></td>
                        <td><?= htmlspecialchars($t['versao_epratika']) ?></td>
                        <td><?= htmlspecialchars($t['versao_ebiometrica']) ?></td>
                        <td><?= htmlspecialchars($t['versao_launcher']) ?></td>
                        <td><?= htmlspecialchars($t['versao_magisk']) ?></td>
<td style="text-align: center;">
                            <span class="badge <?= $t['umed_tipo'] == 'Full' ? 'badge-full' : 'badge-lite' ?>">
                                <?= $t['umed_tipo'] == 'Full' ? 'Umed Full' : 'Umed Lite' ?>
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="relatorios.php?id=<?= $t['id'] ?>" class="btn-view" title="Ver relatórios">
                                <i class="fas fa-chart-bar"></i> Visualizar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="no-results">
                <i class="fas fa-search-minus"></i>
                <strong>Nenhum teste encontrado</strong>
                <p>Tente ajustar os filtros ou limpe-os para ver todos os registros.</p>
            </div>
            <?php endif; ?>

            <?php if ($totalPaginas > 1): ?>
            <div class="pagination-wrapper">
                <div class="pagination">
                    <a href="?<?= manterParams(['pagina' => 1]) ?>" class="page-btn <?= $paginaAtual == 1 ? 'disabled' : '' ?>" title="Primeira página">
                        <i class="fas fa-angle-double-left"></i>
                    </a>
                    <a href="?<?= manterParams(['pagina' => max(1, $paginaAtual - 1)]) ?>" class="page-btn <?= $paginaAtual == 1 ? 'disabled' : '' ?>" title="Página anterior">
                        <i class="fas fa-angle-left"></i>
                    </a>

                    <?php
                    $inicio = max(1, $paginaAtual - 2);
                    $fim = min($totalPaginas, $paginaAtual + 2);
                    
                    if ($inicio > 1) {
                        echo '<a href="?' . manterParams(['pagina' => 1]) . '" class="page-btn">1</a>';
                        if ($inicio > 2) {
                            echo '<span class="page-btn disabled">...</span>';
                        }
                    }
                    
                    for ($i = $inicio; $i <= $fim; $i++):
                    ?>
                    <a href="?<?= manterParams(['pagina' => $i]) ?>" class="page-btn <?= $i == $paginaAtual ? 'active' : '' ?>"><?= $i ?></a>
                    <?php 
                    endfor;
                    
                    if ($fim < $totalPaginas) {
                        if ($fim < $totalPaginas - 1) {
                            echo '<span class="page-btn disabled">...</span>';
                        }
                        echo '<a href="?' . manterParams(['pagina' => $totalPaginas]) . '" class="page-btn">' . $totalPaginas . '</a>';
                    }
                    ?>

                    <a href="?<?= manterParams(['pagina' => min($totalPaginas, $paginaAtual + 1)]) ?>" class="page-btn <?= $paginaAtual == $totalPaginas ? 'disabled' : '' ?>" title="Próxima página">
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <a href="?<?= manterParams(['pagina' => $totalPaginas]) ?>" class="page-btn <?= $paginaAtual == $totalPaginas ? 'disabled' : '' ?>" title="Última página">
                        <i class="fas fa-angle-double-right"></i>
                    </a>
                </div>
                
                <div class="pagination-info">
                    <i class="fas fa-info-circle"></i>
                    Exibindo registros <?= number_format(($paginaAtual - 1) * $itensPorPagina + 1, 0, ',', '.') ?> a <?= number_format(min($paginaAtual * $itensPorPagina, $totalRegistros), 0, ',', '.') ?> de <?= number_format($totalRegistros, 0, ',', '.') ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function limparFiltros() {
            window.location.href = window.location.pathname;
        }

        function alterarItensPorPagina(quantidade) {
            const params = new URLSearchParams(window.location.search);
            params.set('itens', quantidade);
            params.set('pagina', '1');
            window.location.search = params.toString();
        }

        function ordenar(coluna) {
            const params = new URLSearchParams(window.location.search);
            const direcaoAtual = params.get('dir') || 'DESC';
            const colunaAtual = params.get('ordem') || 'data_teste';

            let novaDirecao = 'DESC';
            if (colunaAtual === coluna && direcaoAtual === 'DESC') {
                novaDirecao = 'ASC';
            }

            params.set('ordem', coluna);
            params.set('dir', novaDirecao);
            params.set('pagina', '1');
            window.location.search = params.toString();
        }

        document.querySelector('.btn-clear').addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Limpando...';
            setTimeout(limparFiltros, 300);
        });

        document.getElementById('filterForm').addEventListener('submit', function() {
            const btn = document.querySelector('.btn-filter');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Filtrando...';
        });
    </script>
</body>
</html>