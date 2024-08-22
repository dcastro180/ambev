<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $tipo = intval($_POST['tipo']);

    // Verifica se os campos obrigatórios estão preenchidos
    if (empty($nome) || empty($email) || empty($usuario) || empty($senha) || empty($tipo)) {
        echo "<script>alert('Preencha todos os campos obrigatórios.');</script>";
        echo "<script>location.href='cadastro_usuario.php';</script>";
        exit;
    }

    // Preparar a consulta SQL
    $sql = $conn->prepare("INSERT INTO usuarios (nome, email, usuario, senha, tipo, date) VALUES (?, ?, ?, ?, ?, NOW())");

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($sql) {
        $sql->bind_param("ssssi", $nome, $email, $usuario, $senha, $tipo);
        if ($sql->execute()) {
            echo "<script>alert('Usuário cadastrado com sucesso.');</script>";
            echo "<script>location.href='administradores.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar usuário: " . $sql->error . "');</script>";
        }
    } else {
        echo "<script>alert('Erro na preparação da consulta: " . $conn->error . "');</script>";
    }

    $sql->close();
    $conn->close();
} else {
    echo "<script>alert('Método de requisição inválido.');</script>";
    echo "<script>location.href='cadastro_usuario.php';</script>";
}
?>
