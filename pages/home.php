<?php
session_start();

if (isset($_GET['sair']) && $_GET['sair'] == 'true') {
    session_unset();     // Limpa as variáveis
    session_destroy();   // Destrói a sessão
    header("Location: home.php"); 
    exit();
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../src/css/all.css">
        <link rel="stylesheet" href="../src/css/home.css">
        <link rel="stylesheet" href="../src/css/header.css">
        <title>Yggdrasil</title>
        <style>
            
            .quiz-card-fix {
                position: relative !important;
                inset: auto !important;
                transform: none !important;
                margin-top: 2rem !important; 
                margin-bottom: 2rem !important;
                width: 100% !important; 
                max-width: 500px; 
            }
        </style>
    </head>
    <body id="homebody">
    <header class=" sticky-top">
        <nav class="container d-flex justify-content-between align-items-center py-3">
            <h1 class="title m-0 fs-3">Yggdrasil</h1>
            
            <div class="nav-links d-flex align-items-center">
                <a href="cladograma.html" class="text-white px-3 text-decoration-none">Cladograma</a>
                
                <?php if(isset($_SESSION['usuario_id'])): ?>
                    
                    <div class="dropdown ms-2">
                        <a href="#" class="text-white px-3 text-decoration-none dropdown-toggle d-flex align-items-center" id="menuUsuario" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fs-5 me-2"><img src="../src/imgs/do-utilizador.png" style="width: 16px"></span> 
                            <?php 
                                if($_SESSION['usuario_email'] === 'pipocagamer2004@gmail.com') {
                                    echo "<b>Administrador</b>";
                                } else {
                                    $primeiro_nome = explode(' ', trim($_SESSION['usuario_nome']))[0];
                                    echo "<b>" . htmlspecialchars($primeiro_nome) . "</b>";
                                }
                            ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="menuUsuario">
                            <?php if($_SESSION['usuario_email'] === 'pipocagamer2004@gmail.com'): ?>
                                <li><a class="dropdown-item" href="/Yggdrasil/bd/admin.php"> Painel Admin</a></li>
                                <li><hr class="dropdown-divider"></li>
                            <?php endif; ?>
                            
                            <li><a class="dropdown-item text-danger" href="home.php?sair=true"> Desconectar</a></li>
                        </ul>
                    </div>

                <?php else: ?>
                    <a href="/Yggdrasil/bd/login.php" class="text-white px-3 text-decoration-none fw-bold">Login/Cadastro</a>
                <?php endif; ?>
                </div>
        </nav>
    </header>

    <main class="container my-5">
    <div class="row align-items-start mb-5 pt-3">
        
        <div class="col-lg-6 d-flex flex-column"> <h2 class="display-4 fw-bold text-success mb-4">Bem Vindo</h2>
            <p class="lead text-dark">
                Similarmente à árvore da mitologia nórdica <strong>Yggdrasil</strong>, a árvore evolutiva dos mamíferos é enorme e extensa...
            </p>
            <p class="text-muted">Clique abaixo para acessar o Cladograma interativo:</p>
            
            <div> <a href="cladograma.html" class="btn btn-success btn-lg px-5 py-3 shadow mt-3 mb-4 d-inline-block">
                    Acessar Cladograma
                </a>
            </div>

            <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,600;0,700;1,600&family=Nunito:wght@400;500;600&display=swap" rel="stylesheet">
            
            <div class="quiz-card shadow-sm quiz-card-fix">
                <div class="quiz-header">
                <div class="paw-icon">🐾</div>
                <h1 class="quiz-title">Qual animal<br><em>você seria?</em></h1>
                <p class="quiz-subtitle">Responda com honestidade...</p>
                </div>

                <div class="progress-bar-track">
                <div class="progress-bar-fill" id="progressBar"></div>
                </div>
                <div class="progress-label" id="progressLabel">Pergunta 1 de 5</div>

                <div class="quiz-body" id="quizBody"></div>

                <div class="quiz-result" id="quizResult"></div>
            </div>
            </div> <div class="col-lg-6 text-center position-relative mt-4 mt-lg-0">
            <div class="dino-frame p-3 shadow-lg bg-white rounded">
                <img class="img-fluid rounded" src="../src/imgs/Mammal.png" alt="Mamalia">
                <img class="d-none d-md-block" src="../src/imgs/image 5.png" style="position:absolute; width: 120px; top: -20px; right: 50px;">
            </div>
        </div>
    </div>

    <hr class="my-1 opacity-0"> 
  
    <div class="row align-items-center ">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="p-2 shadow-lg bg-white rounded border border-success border-2">
                <img class="img-fluid rounded w-100" src="../src/imgs/cladogramaEx.png" alt="Cladograma Exemplo">
            </div>
        </div>
        
        <div class="col-lg-6 ps-lg-5">
            <h2 class="display-4 fw-bold text-success mb-4">O que é um Cladograma?</h2>
            <p class="lead text-dark">
                Imagine a árvore genealógica da vida. Um cladograma é um diagrama que organiza os seres vivos baseando-se em suas relações de parentesco. Ele não mostra apenas quem veio antes, mas quem compartilha um ancestral comum exclusivo. Cada 'galho' representa uma nova característica evolutiva que surgiu.
            </p>
        </div>
    </div>
    
    <div class="row align-items-center pt-5">
        <div class="col-lg-6 ps-lg-5">
            <h2 class="display-4 fw-bold text-success mb-4">Um pouco da história dos mamíferos</h2>
            <p class="lead text-dark">
                Os mamíferos são os atuais descendentes dos sinapsídeos, o primeiro grupo bem estabelecido de amniotas que surgiu no Carbonífero Superior. Os sinapsídeos apresentavam várias características mamíferas, notadamente a existência de uma única fossa temporal de cada lado do crânio e a diferenciação de dentes molares, mas no essencial, a sua anatomia manteve-se tipicamente reptiliana, com membros transversais, coanas e uma pequena cavidade neurocraniana.
            </p>
        </div>

        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="p-2 shadow-lg bg-white rounded border border-success border-2">
                <img class="img-fluid rounded w-100" src="../src/imgs/ancestral.jpg" alt="Ancestral">
            </div>
        </div>
        <p class="lead text-dark" style = "padding: 0px 45px" > Os primeiros mamíferos, ou mammaliaformes como são tipicamente conhecidos, apareceram no Período Triássico. Durante todo o restante da era Mesozoica, estes primitivos mamíferos, conhecidos em sua maioria por poucos esqueletos e de considerável número de crânios, mandíbulas e dentes, foram animais de tamanho diminuto e ecologicamente insignificantes. Entretanto, sua contribuição foi especialmente importante para a evolução, pois foi durante o final do Jurássico e início do Cretáceo que estes animais estabeleceram as características básicas mamíferas que levaram a uma tremenda variedade de formas que viveram durante a era Cenozoica.</p>
    </div>

    </main>

    <script src="../src/script/home.js"></script>
    </body>
</html>