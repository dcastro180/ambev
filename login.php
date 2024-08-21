<?php
session_start();
include('config.php');

if (empty($_POST) || empty($_POST["usuario"]) || empty($_POST["senha"])) {
    echo "<script>location.href='index.php';</script>";
    exit;
}

$usuario = $_POST["usuario"];
$senha = $_POST["senha"];

// Consultar a tabela 'usuarios' para o login
$sql = $conn->prepare("SELECT nome, tipo FROM usuarios WHERE usuario = ? AND senha = ?");
$sql->bind_param("ss", $usuario, $senha);
$sql->execute();
$res = $sql->get_result();

if ($res->num_rows > 0) {
    // Usuário encontrado na tabela 'usuarios'
    $row = $res->fetch_assoc();
    $_SESSION["usuario"] = $usuario;
    $_SESSION["nome"] = $row['nome'];
    $_SESSION["tipo"] = $row['tipo'];
    
    // Gerar um token único se o tipo for 2
    if ($_SESSION["tipo"] == 2) {
        $token = bin2hex(random_bytes(32)); // Gera um token de 64 caracteres
        
        // Armazenar o token no banco de dados
        $sql = $conn->prepare("UPDATE motoristas SET token = ? WHERE usuario = ? AND senha = ?");
        $sql->bind_param("sss", $token, $usuario, $senha);
        $sql->execute();
        
        // Armazenar o token em um cookie
        setcookie('auth_token', $token, time() + 3600, "/", "", false, true); // 1 hora de expiração
    }

    // Redirecionar de acordo com o tipo
    if ($_SESSION["tipo"] == 1) {
        echo "<script>location.href='administradores.php';</script>";
    } elseif ($_SESSION["tipo"] == 2) {
        echo "<script>location.href='motorista.php';</script>";
    } else {
        echo "<script>alert('Tipo de usuário desconhecido.');</script>";
        echo "<script>location.href='index.php';</script>";
    }
} else {
    // Consultar a tabela 'motoristas' para o login
    $sql = $conn->prepare("SELECT nome FROM motoristas WHERE usuario = ? AND senha = ?");
    $sql->bind_param("ss", $usuario, $senha);
    $sql->execute();
    $res = $sql->get_result();

    if ($res->num_rows > 0) {
        // Usuário encontrado na tabela 'motoristas'
        $row = $res->fetch_assoc();
        $_SESSION["usuario"] = $usuario;
        $_SESSION["nome"] = $row['nome'];
        $_SESSION["tipo"] = 2; // Define o tipo como 2 para motorista

        // Gerar um token único
        $token = bin2hex(random_bytes(32)); // Gera um token de 64 caracteres
        
        // Armazenar o token no banco de dados
        $sql = $conn->prepare("UPDATE motoristas SET token = ? WHERE usuario = ? AND senha = ?");
        $sql->bind_param("sss", $token, $usuario, $senha);
        $sql->execute();
        
        // Armazenar o token em um cookie
        setcookie('auth_token', $token, time() + 3600, "/", "", false, true); // 1 hora de expiração
        
        // Redirecionar para a página de motorista
        echo "<script>location.href='motorista.php';</script>";
    } else {
        echo "<script>alert('Usuário ou senha inválidos');</script>";
        echo "<script>location.href='index.php';</script>";
    }
}

$sql->close();
$conn->close();
?>
