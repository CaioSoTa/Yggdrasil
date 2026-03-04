<?php
session_start();
require 'conexao.php';

$email_admin = "pipocagamer2004@gmail.com"; 
# senha admin = LucasHesseViado

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_email'] !== $email_admin) {
    header("Location: ../pages/home.html"); 
    exit();
}

$acao = isset($_GET['acao']) ? $_GET['acao'] : 'listar';

if ($acao == 'deletar' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($conn, "DELETE FROM usuarios_ygg WHERE id = $id");
    header("Location: admin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_usuario']; 
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $data_nascimento = mysqli_real_escape_string($conn, $_POST['data_nascimento']);
    $animal_favorito = mysqli_real_escape_string($conn, $_POST['animal_favorito']);
    
    if (empty($id)) {
        $senha_hash = password_hash("123456", PASSWORD_DEFAULT); // Senha padrão para criados pelo admin
        $sql = "INSERT INTO usuarios_ygg (nome, email, senha, data_nascimento, animal_favorito) 
                VALUES ('$nome', '$email', '$senha_hash', '$data_nascimento', '$animal_favorito')";
    } else {
        $sql = "UPDATE usuarios_ygg SET nome='$nome', email='$email', data_nascimento='$data_nascimento', animal_favorito='$animal_favorito' WHERE id=$id";
    }
    
    mysqli_query($conn, $sql);
    header("Location: admin.php");
    exit();
}

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Yggdrasil - Painel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/all.css">
</head>
<body class="bg-light">
    
<main class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Área do Administrador</h2>
        <div>
            <a href="admin.php?acao=criar" class="btn btn-success">Criar Novo Usuário</a>
            <a href="../pages/cladograma.html" class="btn btn-secondary">Voltar ao Site</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            
            <?php 
            if ($acao == 'editar' || $acao == 'criar') { 
                
                $id = ''; $nome = ''; $email = ''; $data_nasc = ''; $animal = '';
                $titulo_form = "Criar Novo Usuário";

                if ($acao == 'editar' && isset($_GET['id'])) {
                    $id = (int)$_GET['id'];
                    $resultado = mysqli_query($conn, "SELECT * FROM usuarios_ygg WHERE id = $id");
                    $usuario_edit = mysqli_fetch_assoc($resultado);
                    
                    $nome = $usuario_edit['nome'];
                    $email = $usuario_edit['email'];
                    $data_nasc = $usuario_edit['data_nascimento'];
                    $animal = $usuario_edit['animal_favorito'];
                    $titulo_form = "Editar Usuário: " . $nome;
                }
            ?>
                <h4 class="mb-4"><?php echo $titulo_form; ?></h4>
                <form action="admin.php" method="POST">
                    <input type="hidden" name="id_usuario" value="<?php echo $id; ?>">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" value="<?php echo $nome; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" name="data_nascimento" value="<?php echo $data_nasc; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Animal Favorito</label>
                            <input type="text" class="form-control" name="animal_favorito" value="<?php echo $animal; ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="admin.php" class="btn btn-outline-danger">Cancelar</a>
                </form>

            <?php 
            } else { 
            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Nascimento</th>
                                <th>Animal Favorito</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM usuarios_ygg");
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $data_formatada = date('d/m/Y', strtotime($row['data_nascimento']));
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['nome'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $data_formatada . "</td>";
                                    echo "<td>" . $row['animal_favorito'] . "</td>";
                                    
                                    echo "<td>
                                            <a href='admin.php?acao=editar&id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Editar</a>
                                            <a href='admin.php?acao=deletar&id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Tem certeza que deseja excluir?');\">Deletar</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>Nenhum usuário encontrado.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            
        </div>
    </div>
</main>
</body>
</html>