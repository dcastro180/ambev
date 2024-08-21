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
    $funcao = $_POST['funcao'];
    $tipo_carro = $_POST['tipo_carro'];
    $cpfdomotorista = $_POST['cpfmotorista'];
    $observacao = $_POST['observacao'];
    $tipo_usuario = isset($_POST['tipo_usuario']) ? 1 : 2; // Default to 2 if checkbox is not checked
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Usar prepared statements para prevenir SQL injection
    $sql = $conn->prepare("INSERT INTO motoristas (nome, funcao, tipo_carro, cpfmotorista, observacao, tipo_usuario, usuario, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sssssiss", $nome, $funcao, $tipo_carro, $cpfdomotorista, $observacao, $tipo_usuario, $usuario, $senha);

    if ($sql->execute()) {
        echo "<script>alert('Motorista cadastrado com sucesso.');</script>";
        echo "<script>location.href='administradores.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar motorista.');</script>";
        echo "<script>location.href='cadastro_motorista.php';</script>";
    }

    $sql->close();
    $conn->close();
}
?>
