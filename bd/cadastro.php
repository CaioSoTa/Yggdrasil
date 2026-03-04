<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha_digitada = $_POST['password'];
    $confirmar_senha = $_POST['confirmar_senha']; 
    $data_nascimento = mysqli_real_escape_string($conn, $_POST['data_nascimento']);
    $animal_favorito = mysqli_real_escape_string($conn, $_POST['animal_favorito']);

    if ($senha_digitada !== $confirmar_senha) {
        $erro = "As senhas não coincidem. Por favor, digite novamente.";
    } else {
        $senha_hash = password_hash($senha_digitada, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios_ygg (nome, email, senha, data_nascimento, animal_favorito) 
                VALUES ('$nome', '$email', '$senha_hash', '$data_nascimento', '$animal_favorito')";

        if (mysqli_query($conn, $sql)) {
            header("Location: login.php?cadastro=sucesso");
            exit();
        } else {
            $erro = "Erro ao cadastrar: " . mysqli_error($conn);
        }
    }
}
?>

<!doctype html>
<html lang="pt-br">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <meta charset="utf-8">
        <title>Cadastro</title>
        <link rel="stylesheet" href="../src/css/all.css">
    </head>
    <body class="bg-light">
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h2 class="card-title text-center mb-4">Criar Conta</h2>
                        
                        <?php if(isset($erro)) echo "<div class='alert alert-danger'>$erro</div>"; ?>

                        <form action="cadastro.php" method="POST">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Senha</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirmar_senha" class="form-label">Confirmar Senha</label>
                                    <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                            </div>
                            <div class="mb-3">
                                <label for="animal_favorito" class="form-label">Seu Animal Favorito</label>
                                <input type="text" class="form-control" id="animal_favorito" name="animal_favorito" required>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Cadastrar</button>
                            </div>
                            <hr class="my-4">
                            <p class="text-center">Já tem uma conta? <a href="login.php">Faça login</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </body>
</html>