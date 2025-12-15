<?php
session_start();
if (!isset($_SESSION['tester_nome'])) {
    $_SESSION['tester_nome'] = 'Tester Exemplo';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Pratika Geren. de Testes</title>
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
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body{
            font-family:'Poppins',sans-serif;
            background:linear-gradient(135deg,#ffd9b3 0%,#ff8c42 50%,#e65c00 100%);
            min-height:100vh;
            color:var(--text);
            padding:20px;
        }
        .container{
            max-width:1100px;
            margin:30px auto;
            background:white;
            border-radius:24px;
            overflow:hidden;
            box-shadow:0 20px 50px var(--shadow);
        }
        .header{
            background:linear-gradient(135deg,#ff8c42 0%,#e65c00 100%);
            color:white;
            padding:35px 20px;
            text-align:center;
        }
        .header h1{font-size:2.8rem;font-weight:700;text-shadow:0 2px 8px rgba(0,0,0,.2);}
        .header p{font-size:1.2rem;opacity:.95;margin-top:8px;}
        .nav-tabs{display:flex;background:#fff5eb;border-bottom:1px solid #ffe0c2;}
        .nav-tab{
            flex:1;padding:18px;text-align:center;font-weight:600;cursor:pointer;
            transition:all .3s;color:#b34a00;
        }
        .nav-tab:hover{background:#ffe0c2;}
        .nav-tab.active{
            background:white;color:#e65c00;border-bottom:4px solid #ff8c42;font-weight:700;
        }
        .tab-content{display:none;padding:35px;animation:fadeIn .5s;}
        .tab-content.active{display:block;}
        @keyframes fadeIn{from{opacity:0;transform:translateY(15px);}to{opacity:1;transform:translateY(0);}}
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
        textarea{resize:vertical;min-height:130px;}
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
            background:linear-gradient(135deg,#3BD42F 0%);
            color:white;width:100%;box-shadow:0 6px 15px rgba(255,140,66,.3);
        }
        .btn-success:hover{
            transform:translateY(-3px);box-shadow:0 12px 25px rgba(255,140,66,.4);
        }
        .btn-success i{font-size:1.3rem;}

        /* BOTÃO GRAVAR – VERDINHO */
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
        .test-card{
            background:#fff5eb;padding:22px;border-radius:14px;margin-bottom:18px;
            border-left:5px solid #ff8c42;transition:all .3s;
        }
        .test-card:hover{
            transform:translateX(8px);box-shadow:0 8px 20px rgba(255,140,66,.15);
        }
        .test-info{
            display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
            gap:14px;margin-top:12px;
        }
        .info-item{
            background:white;padding:12px;border-radius:10px;
            box-shadow:0 2px 6px rgba(0,0,0,.05);
        }
        .info-label{
            font-size:.85rem;color:#b34a00;font-weight:600;
        }
        .info-value{
            font-weight:600;color:#2c1810;margin-top:4px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>E-Pratika</h1>
        <p>Gerenciamento de Testes em Campo</p>
    </div>

    <div class="nav-tabs">
        <button class="nav-tab active" onclick="showTab('cadastro')">Novo Teste</button>
        <button class="nav-tab" onclick="showTab('lista')">Lista de Testes</button>
        <button class="nav-tab" onclick="showTab('relatorio')">Relatórios</button>
    </div>

    <!-- CADASTRO -->
    <div id="cadastro" class="tab-content active">
        <h2 class="section-title">Cadastro de Novo Teste</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'cadastrar') {
            try {
                $pdo = new PDO("mysql:host=localhost;dbname=epratika_tests;charset=utf8mb4", 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "INSERT INTO testes 
                        (tester_nome, versao_epratika, versao_ebiometrica, versao_launcher, versao_magisk, estado, umed_tipo,
                         desc_atualizacao, desc_aulas, desc_interface, desc_desempenho, desc_sincronizacao, desc_regras)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $_SESSION['tester_nome'],
                    $_POST['versao_epratika'],
                    $_POST['versao_ebiometrica'],
                    $_POST['versao_launcher'],
                    $_POST['versao_magisk'],
                    $_POST['estado'],
                    $_POST['umed_tipo'],
                    $_POST['desc_atualizacao'] ?? '',
                    $_POST['desc_aulas'] ?? '',
                    $_POST['desc_interface'] ?? '',
                    $_POST['desc_desempenho'] ?? '',
                    $_POST['desc_sincronizacao'] ?? '',
                    $_POST['desc_regras'] ?? ''
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
                    </select>
                </div>
            </div>

            <!-- SEÇÃO 1 -->
            <div class="section">
                <div class="section-header" onclick="toggle(this)">Atualização e Inicialização <span class="plus">+</span></div>
                <div class="section-content">
                    <ul>
                        <li>Corrigido o problema que exigia reinicialização do Tablet para concluir a atualização.</li>
                        <li>Corrigido o problema em que o aplicativo fechava após o download sem concluir a atualização.</li>
                        <li>Corrigido o processo de atualização manual, garantindo execução completa.</li>
                        <li>Correção aplicada no acompanhamento da instalação, garantindo funcionamento normal.</li>
                        <li>Corrigido o problema em que o Tablet não recebia atualizações pontuais liberadas.</li>
                    </ul>
                    <textarea name="desc_atualizacao" placeholder="Descreva os resultados observados..."></textarea>
                    <button type="button" class="btn btn-gravar" onclick="alert('Seção Atualização salva localmente!')">
                        <i class="fas fa-save"></i> Gravar
                    </button>
                </div>
            </div>

            <!-- SEÇÃO 2 -->
            <div class="section">
                <div class="section-header" onclick="toggle(this)">Aulas e Coletas <span class="plus">+</span></div>
                <div class="section-content">
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
                    <textarea name="desc_aulas" placeholder="Descreva os resultados observados..."></textarea>
                    <button type="button" class="btn btn-gravar" onclick="alert('Seção Aulas salva localmente!')">
                        <i class="fas fa-save"></i> Gravar
                    </button>
                </div>
            </div>

            <!-- SEÇÃO 3 -->
            <div class="section">
                <div class="section-header" onclick="toggle(this)">Interface e Mensagens <span class="plus">+</span></div>
                <div class="section-content">
                    <ul>
                        <li>Corrigido o alerta exibido ao finalizar retorno informando “Nenhum usuário para validação.”</li>
                        <li>Corrigida a mensagem constante “Aguarde, conectado ao serviço de atividade.”</li>
                        <li>Corrigido o erro que abria a câmera do Tablet em vez do módulo e-Biometrika.</li>
                    </ul>
                    <textarea name="desc_interface" placeholder="Descreva os resultados observados..."></textarea>
                    <button type="button" class="btn btn-gravar" onclick="alert('Seção Interface salva localmente!')">
                        <i class="fas fa-save"></i> Gravar
                    </button>
                </div>
            </div>

            <!-- SEÇÃO 4 -->
            <div class="section">
                <div class="section-header" onclick="toggle(this)">Desempenho e Estabilidade <span class="plus">+</span></div>
                <div class="section-content">
                    <ul>
                        <li>Corrigido o travamento causado pelas mensagens “MAGISK parou” e “Launcher não respondendo.”</li>
                        <li>Corrigido o travamento do Tablet na solicitação de permissão de superusuário.</li>
                        <li>Corrigido o travamento da tela branca ao iniciar a segunda aula.</li>
                        <li>Corrigido o looping na captura da foto final de percurso.</li>
                        <li>Corrigido o looping na captura da foto final da aula.</li>
                        <li>Corrigida a falha que ocasionava a interrupção inesperada do aplicativo e-PRÁTIKA.</li>
                    </ul>
                    <textarea name="desc_desempenho" placeholder="Descreva os resultados observados..."></textarea>
                    <button type="button" class="btn btn-gravar" onclick="alert('Seção Desempenho salva localmente!')">
                        <i class="fas fa-save"></i> Gravar
                    </button>
                </div>
            </div>

            <!-- SEÇÃO 5 -->
            <div class="section">
                <div class="section-header" onclick="toggle(this)">Sincronização e Agendamento <span class="plus">+</span></div>
                <div class="section-content">
                    <ul>
                        <li>Corrigido o problema de sincronização que impedia a abertura da aula.</li>
                        <li>Corrigido o problema que impedia a exibição do horário de agendamento no Tablet.</li>
                        <li>Corrigido o problema de exibição incorreta do horário durante aula em andamento.</li>
                        <li>Corrigido o erro que registrava aulas finalizadas como canceladas.</li>
                        <li>Corrigido o bloqueio que impedia a finalização após atingir o tempo total da aula.</li>
                        <li>Corrigido o erro em que a aula em andamento desaparecia do Tablet.</li>
                        <li>Corrigido o cronômetro que exibia tempo negativo durante a aula.</li>
                    </ul>
                    <textarea name="desc_sincronizacao" placeholder="Descreva os resultados observados..."></textarea>
                    <button type="button" class="btn btn-gravar" onclick="alert('Seção Sincronização salva localmente!')">
                        <i class="fas fa-save"></i> Gravar
                    </button>
                </div>
            </div>

            <!-- SEÇÃO 6 -->
            <div class="section">
                <div class="section-header" onclick="toggle(this)">Regras Específicas <span class="plus">+</span></div>
                <div class="section-content">
                    <ul>
                        <li>Corrigida a regra de agendamento da Bahia, garantindo que aulas após 17h possuam duração mínima de 45 minutos.</li>
                    </ul>
                    <textarea name="desc_regras" placeholder="Descreva os resultados observados..."></textarea>
                    <button type="button" class="btn btn-gravar" onclick="alert('Seção Regras salva localmente!')">
                        <i class="fas fa-save"></i> Gravar
                    </button>
                </div>
            </div>

            <!-- BOTÃO DE ENVIO (Menu Enviar todos os Testes) -->
            <button type="submit" class="btn btn-success">
                <i class="fas fa-paper-plane"></i> Enviar Todos os Testes
            </button>
        </form>
    </div>

    <!-- LISTA -->
    <div id="lista" class="tab-content">
        <h2 class="section-title">Testes Realizados</h2>
        <?php
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=epratika_tests;charset=utf8mb4", 'root', '');
            $stmt = $pdo->query("SELECT * FROM testes ORDER BY data_teste DESC");
            while ($t = $stmt->fetch()) {
                $umed = $t['umed_tipo'] == 'Full' ? 'Umed Full' : ($t['umed_tipo'] == 'Lite' ? 'Umed Lite' : '—');
                echo "<div class='test-card'>
                    <h3>{$t['tester_nome']} - {$t['estado']} ({$umed})</h3>
                    <div class='test-info'>
                        <div class='info-item'><div class='info-label'>Data</div><div class='info-value'>".date('d/m/Y H:i',strtotime($t['data_teste']))."</div></div>
                        <div class='info-item'><div class='info-label'>E-Pratika</div><div class='info-value'>{$t['versao_epratika']}</div></div>
                        <div class='info-item'><div class='info-label'>E-Biométrica</div><div class='info-value'>{$t['versao_ebiometrica']}</div></div>
                        <div class='info-item'><div class='info-label'>Launcher</div><div class='info-value'>{$t['versao_launcher']}</div></div>
                        <div class='info-item'><div class='info-label'>MAGISK</div><div class='info-value'>{$t['versao_magisk']}</div></div>
                        <div class='info-item'><div class='info-label'>Umed</div><div class='info-value'>{$umed}</div></div>
                    </div>
                </div>";
            }
        } catch(Exception $e) {
            echo "<p>Erro ao carregar testes: ".htmlspecialchars($e->getMessage())."</p>";
        }
        ?>
    </div>

    <!-- RELATÓRIO -->
    <div id="relatorio" class="tab-content">
        <h2 class="section-title">Gerar Relatório PDF</h2>
        <form method="POST" action="gerar_pdf.php" target="_blank">
            <div class="form-group">
                <label>Filtrar por Estado</label>
                <select name="estado">
                    <option value="">Todos</option>
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
            <button type="submit" class="btn btn-primary">
                Gerar PDF
            </button>
        </form>
    </div>
</div>

<script>
function showTab(id){
    document.querySelectorAll('.tab-content').forEach(c=>c.classList.remove('active'));
    document.querySelectorAll('.nav-tab').forEach(t=>t.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    event.target.classList.add('active');
}
function toggle(el){
    const content = el.nextElementSibling;
    content.style.display = content.style.display === 'block' ? 'none' : 'block';
    el.classList.toggle('open');
}
</script>
</body>
</html>