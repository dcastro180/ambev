<?php
session_start();

if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != 1) {
    echo "<script>alert('Acesso negado.');</script>";
    echo "<script>location.href='index.php';</script>";
    exit;
}

include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    // Usar prepared statements para prevenir SQL injection
    $sql = $conn->prepare("INSERT INTO usuarios (nome, email, usuario, senha, tipo, date) VALUES (?, ?, ?, ?, ?, NOW())");
    $sql->bind_param("sssss", $nome, $email, $usuario, $senha, $tipo);

    if ($sql->execute()) {
        echo "<script>alert('Usuário cadastrado com sucesso.');</script>";
        echo "<script>location.href='administradores.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar usuário.');</script>";
        echo "<script>location.href='cadastro_usuario.php';</script>";
    }

    $sql->close();
    $conn->close();
}
?>
