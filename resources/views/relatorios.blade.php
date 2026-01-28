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
    <title>Relatórios - E-Pratika</title>
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
        
        /* CONTAINER PRINCIPAL */
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
        
        /* CONTENT */
        .content {
            padding: 35px;
        }
        
        .report-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .report-card {
            background: #fffaf0;
            border: 2px solid var(--border);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .report-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--dark));
        }
        
        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(255, 140, 66, 0.2);
            border-color: var(--primary);
        }
        
        .report-card i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .report-card h3 {
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 1.3rem;
        }
        
        .report-card p {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        
        .quick-stats {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .quick-stats h3 {
            color: var(--dark);
            margin-bottom: 20px;
            font-size: 1.4rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .stat-item {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid var(--border);
        }
        
        .stat-item i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }
        
        .btn-redirect {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 15px;
        }
        
        .btn-redirect:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 140, 66, 0.3);
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
            .report-grid {
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
                    <li><a href="relatorios" class="<?= $paginaAtual == 'relatorios' ? 'active' : '' ?>">
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

        <div class="content">
            <h2 class="section-title">Relatórios e Análises</h2>
            
            <!-- ESTATÍSTICAS RÁPIDAS -->
            <div class="quick-stats">
                <h3><i class="fas fa-chart-line"></i> Estatísticas Rápidas</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <i class="fas fa-clipboard-check"></i>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Testes Realizados</div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-users"></i>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Testers Ativos</div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Estados Cobertos</div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-check-circle"></i>
                        <div class="stat-number">0%</div>
                        <div class="stat-label">Taxa de Sucesso</div>
                    </div>
                </div>
            </div>

            <!-- RELATÓRIOS DISPONÍVEIS -->
            <div class="report-grid">
                <div class="report-card" onclick="window.location.href='consultatestes'">
                    <i class="fas fa-database"></i>
                    <h3>Consulta de Testes</h3>
                    <p>Visualize e filtre todos os testes realizados pelos testers com detalhes completos</p>
                    <a href="consultatestes" class="btn-redirect">
                        <i class="fas fa-arrow-right"></i> Acessar Consulta
                    </a>
                </div>
                
                <div class="report-card">
                    <i class="fas fa-chart-pie"></i>
                    <h3>Relatório de Versões</h3>
                    <p>Análise detalhada das versões testadas e suas taxas de sucesso</p>
                    <a href="#" class="btn-redirect">
                        <i class="fas fa-arrow-right"></i> Gerar Relatório
                    </a>
                </div>
                
                <div class="report-card">
                    <i class="fas fa-map"></i>
                    <h3>Mapa de Cobertura</h3>
                    <p>Visualização geográfica dos testes realizados por estado</p>
                    <a href="#" class="btn-redirect">
                        <i class="fas fa-arrow-right"></i> Ver Mapa
                    </a>
                </div>
                
                <div class="report-card">
                    <i class="fas fa-calendar-alt"></i>
                    <h3>Timeline de Testes</h3>
                    <p>Histórico cronológico de todos os testes e suas evoluções</p>
                    <a href="#" class="btn-redirect">
                        <i class="fas fa-arrow-right"></i> Ver Timeline
                    </a>
                </div>
                
                <div class="report-card">
                    <i class="fas fa-trophy"></i>
                    <h3>Ranking de Testers</h3>
                    <p>Classificação dos testers por quantidade e qualidade dos testes</p>
                    <a href="#" class="btn-redirect">
                        <i class="fas fa-arrow-right"></i> Ver Ranking
                    </a>
                </div>
                
                <div class="report-card">
                    <i class="fas fa-download"></i>
                    <h3>Exportar Dados</h3>
                    <p>Baixe todos os dados em formatos Excel, PDF ou CSV</p>
                    <a href="#" class="btn-redirect">
                        <i class="fas fa-arrow-right"></i> Exportar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Adicionar interatividade aos cards
        document.querySelectorAll('.report-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.borderColor = 'var(--primary)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.borderColor = 'var(--border)';
            });
        });
    </script>
</body>
</html>