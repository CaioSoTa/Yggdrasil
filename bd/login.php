<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = $_POST['password'];

    // Nome da tabela já corrigido aqui também!
    $sql = "SELECT * FROM usuarios_ygg WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    // Verifica se encontrou alguém e joga os dados na variável
    if ($result && mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);
        
        // Verifica a criptografia da senha
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            
            // Login deu certo! Vai para o cladograma
            header("Location: ../pages/cladograma.html"); 
            exit();
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
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
        <title>Yggdrasil - Login</title>
    </head>
    <body id="homebody">
    <header class="shadow-sm sticky-top">
        <nav class="container d-flex justify-content-between align-items-center py-3">
            <a href="../pages/home.html" class="title m-0 fs-3 text-decoration-none text-white">Yggdrasil</a>
            <div class="nav-links">
                <a href="../pages/home.html" class="text-white px-3 text-decoration-none">Home</a>
                <a href="../pages/cladograma.html" class="text-white px-3 text-decoration-none">Cladograma</a>
                <a href="#" class="text-white px-3 text-decoration-none">Sobre</a>
                <a href="#" class="text-white px-3 text-decoration-none">FAQ</a>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h2 class="card-title text-center mb-4">Login</h2>
                        
                        <?php if(isset($erro)) echo "<div class='alert alert-danger text-center'>$erro</div>"; ?>

                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="seu@email.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">Entrar</button>
                            </div>
                            <hr class="my-4">
                            <p class="text-center">Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </body>
</html>