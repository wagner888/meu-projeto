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
    <title><?php echo isset($page_title) ? $page_title : 'E-Pratika Geren. de Testes'; ?></title>
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
        select,textarea,input[disabled],input[type="text"],input[type="email"],input[type="password"]{
            width:100%;padding:14px;border:2px solid #ffe0c2;border-radius:12px;
            font-size:1rem;transition:all .3s;background:#fffaf0;
        }
        select:focus,textarea:focus,input:focus{
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
        <!-- HEADER -->
        <div class="header">
            <h1><?php echo isset($header_title) ? $header_title : 'E-Pratika'; ?></h1>
            <p><?php echo isset($header_subtitle) ? $header_subtitle : 'Gerenciamento de Testes em Campo'; ?></p>
        </div>

        <!-- NAVIGATION TABS -->
        <?php if (isset($navigation)) echo $navigation; ?>

        <!-- CONTEÚDO PRINCIPAL -->
        <?php if (isset($content)) echo $content; ?>

        <!-- FOOTER -->
        <?php if (isset($footer)): ?>
            <div class="footer">
                <?php echo $footer; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- SCRIPTS -->
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