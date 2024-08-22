<?php
session_start();
include_once('config.php');

// Verificar se o token está presente no cookie
if (!isset($_COOKIE['auth_token'])) {
    echo "<script>alert('Acesso não autorizado.');</script>";
    echo "<script>location.href='index.php';</script>";
    exit();
}

$auth_token = $_COOKIE['auth_token'];

// Verificar o token no banco de dados
$sql = $conn->prepare("SELECT cpfmotorista FROM motoristas WHERE token = ?");
$sql->bind_param("s", $auth_token);
$sql->execute();
$res = $sql->get_result();

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $_SESSION['cpfMotorista'] = $row['cpfmotorista'];

    // Consulta SQL para selecionar o motorista pelo CPF
    $cpf = $_SESSION['cpfMotorista'];
    $sql = $conn->prepare("SELECT * FROM dados_motorista WHERE cpfmotorista = ?");
    $sql->bind_param("s", $cpf);
    $sql->execute();
    $result = $sql->get_result();
} else {
    echo "<script>alert('Token inválido.');</script>";
    echo "<script>location.href='index.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados para o Motorista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Pagina com os dados para o motorista</h1>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">Sistema Bruno Ambev</a><br>
            <?php
                print "Olá, " .$_SESSION["nome"];
                print "<a href='logout.php' class= 'btn btn-danger'>Sair</a>";
            ?>
        </div>
    </nav>

    <!-- Verifica se há resultados -->
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Mapa</th>
                    <th>CX Entreg</th>
                    <th>Tempo Interno</th>
                    <th>Hora Jornada Liq</th>
                    <th>qtentregasentreg_rv</th>
                    <th>CPF Motorista</th>
                    <th>CPF Ajudante 1</th>
                    <th>CPF Ajudante 2</th>
                    <!-- Adicione outros cabeçalhos de acordo com as colunas da tabela -->
                </tr>
            </thead>
            <tbody>
                <!-- Itera sobre os resultados e exibe os dados em linhas da tabela -->
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['data1']); ?></td>
                        <td><?php echo htmlspecialchars($row['mapa']); ?></td>
                        <td><?php echo htmlspecialchars($row['cxentreg']); ?></td>
                        <td><?php echo htmlspecialchars($row['tempointerno']); ?></td>
                        <td><?php echo htmlspecialchars($row['hrjornadaliq']); ?></td>
                        <td><?php echo htmlspecialchars($row['qtentregasentreg_rv']); ?></td>
                        <td><?php echo htmlspecialchars($row['cpfmotorista']); ?></td>
                        <td><?php echo htmlspecialchars($row['cpfajudante1']); ?></td>
                        <td><?php echo htmlspecialchars($row['cpfajudante2']); ?></td>
                        <!-- Adicione outras colunas conforme necessário -->
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum dado encontrado.</p>
    <?php endif; ?>

</body>
</html>
<?php
$sql->close();
$conn->close();
?>
