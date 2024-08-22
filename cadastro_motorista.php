<?php
session_start();

if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != 1) {
    echo "<script>alert('Acesso negado.');</script>";
    echo "<script>location.href='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Motorista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
        }
        button {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Motorista</h1>
        <form action="processar_cadastro_motorista.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="funcao">Função:</label>
            <input type="text" id="funcao" name="funcao" required>

            <label for="tipo_carro">Tipo de Carro:</label>
            <select id="tipo_carro" name="tipo_carro" required>
                <option value="moto">Moto</option>
                <option value="carro">Carro</option>
                <option value="caminhao">Caminhão</option>
            </select>

            <label for="cpfmotorista">CPF do Motorista:</label>
            <input type="text" id="cpfmotorista" name="cpfmotorista" required>

            <label for="observacao">Observação:</label>
            <textarea id="observacao" name="observacao" rows="4"></textarea>

            <label for="tipo_usuario">Administrador:</label>
            <input type="checkbox" id="tipo_usuario" name="tipo_usuario" value="1">

            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <div class="buttons">
                <button type="submit">Salvar</button>
                <button type="button" onclick="location.href='administradores.php'">Cancelar</button>
                <button type="button" onclick="location.href='administradores.php'">Voltar</button>
            </div>
        </form>
    </div>
</body>
</html>
