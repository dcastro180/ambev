<?php
session_start();

// Verifica se o usuário está logado e é administrador
if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != 1) {
    echo "<script>alert('Acesso negado.');</script>";
    echo "<script>location.href='index.php';</script>";
    exit;
}

include('config.php');

// Captura os dados do formulário
$nome = $_POST['nome'];
$funcao = $_POST['funcao'];
$tipo_carro = $_POST['tipo_carro'];
$cpfdomotorista = $_POST['cpfmotorista'];
$observacao = $_POST['observacao'];
$tipo_usuario = isset($_POST['tipo_usuario']) ? 1 : 2; // 1 para administrador, 2 para usuário comum

// Insere os dados no banco de dados usando prepared statements
$stmt = $conn->prepare("INSERT INTO motoristas (nome, funcao, tipo_carro, rotas, observacao, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssi", $nome, $funcao, $tipo_carro, $cpfdomotorista, $observacao, $tipo_usuario);

if ($stmt->execute()) {
    echo "<script>alert('Motorista cadastrado com sucesso!');</script>";
    echo "<script>location.href='administradores.php';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar motorista.');</script>";
    echo "<script>location.href='administradores.php';</script>";
}

$stmt->close();
$conn->close();
?>
