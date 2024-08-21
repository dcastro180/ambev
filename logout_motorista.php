<?php
session_start();
include('config.php');

// Verificar se o usuário é um motorista e, se for, remover o token da tabela 'motoristas'
if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == 2) {
    $usuario = $_SESSION["usuario"];
    $senha = $_POST["senha"];  // Ajuste conforme necessário se você estiver coletando a senha no formulário de logout
    
    $sql = $conn->prepare("UPDATE motoristas SET token = NULL WHERE usuario = ? AND senha = ?");
    $sql->bind_param("ss", $usuario, $senha);
    $sql->execute();
    $sql->close();
}

// Limpar as variáveis de sessão
unset($_SESSION["usuario"]);
unset($_SESSION["nome"]);
unset($_SESSION["tipo"]);
session_destroy();

// Excluir o cookie de autenticação
if (isset($_COOKIE['auth_token'])) {
    setcookie('auth_token', '', time() - 3600, "/", "", false, true);
}

// Redirecionar para a página inicial
header("Location: index.php");
exit;
?>
