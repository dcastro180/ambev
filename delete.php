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
    
    // Verifica se o ID é válido
    if ($id > 0) {
        if ($type == 'user') {
            $sql = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        } elseif ($type == 'driver') {
            $sql = $conn->prepare("DELETE FROM motoristas WHERE id = ?");
        } else {
            echo "<script>alert('Tipo inválido.');</script>";
            echo "<script>location.href='administradores.php';</script>";
            exit;
        }

        // Executa a consulta somente se foi preparada corretamente
        if ($sql) {
            $sql->bind_param("i", $id);
            if ($sql->execute()) {
                echo "<script>alert('Registro excluído com sucesso.');</script>";
            } else {
                echo "<script>alert('Erro ao excluir registro: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Erro na preparação da consulta.');</script>";
        }
    } else {
        echo "<script>alert('ID inválido.');</script>";
    }

    echo "<script>location.href='administradores.php';</script>";
} else {
    echo "<script>alert('Parâmetros inválidos.');</script>";
    echo "<script>location.href='administradores.php';</script>";
}

$conn->close();
