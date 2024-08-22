<?php
session_start();
include('config.php');

// Verifica se o usuário está logado e é administrador
if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != 1) {
    echo "<script>alert('Acesso negado.');</script>";
    echo "<script>location.href='index.php';</script>";
    exit;
}

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = intval($_GET['id']);
    
    if ($type == 'user') {
        $sql = "DELETE FROM usuarios WHERE id = $id";
    } elseif ($type == 'driver') {
        $sql = "DELETE FROM motoristas WHERE id = $id";
    } else {
        echo "<script>alert('Tipo inválido.');</script>";
        echo "<script>location.href='administradores.php';</script>";
        exit;
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registro excluído com sucesso.');</script>";
    } else {
        echo "<script>alert('Erro ao excluir registro: " . $conn->error . "');</script>";
    }

    echo "<script>location.href='administradores.php';</script>";
} else {
    echo "<script>alert('Parâmetros inválidos.');</script>";
    echo "<script>location.href='administradores.php';</script>";
}

$conn->close();
?>
