<?php
session_start();

if (empty($_POST) || empty($_POST["usuario"]) || empty($_POST["senha"])) {
    echo "<script>location.href='index.php';</script>";
    exit;
}

include('config.php');

$usuario = $_POST["usuario"];
$senha = $_POST["senha"];

// Usar prepared statements para prevenir SQL injection
$sql = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND senha = ?");
$sql->bind_param("ss", $usuario, $senha);
$sql->execute();
$res = $sql->get_result();

$row = $res->fetch_object();

$qtd = $res->num_rows;

if ($qtd > 0) {
    $_SESSION["usuario"] = $usuario;
    $_SESSION["nome"] = $row->nome;
    $_SESSION["tipo"] = $row->tipo;

    if ($_SESSION["tipo"] == 1) {
        echo "<script>location.href='administradores.php';</script>";
    } elseif ($_SESSION["tipo"] == 2) {
        echo "<script>location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Tipo de usuário desconhecido.');</script>";
        echo "<script>location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Usuário ou senha inválidos');</script>";
    echo "<script>location.href='index.php';</script>";
}

$sql->close();
$conn->close();
?>
