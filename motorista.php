<?php
    session_start();
    include_once ('config.php');

    // Consulta SQL para selecionar todos os dados de "dados_motorista"
    //$sql = "SELECT * FROM dados_motorista ORDER BY cpfmotorista";
    
    // Defina o CPF que você quer pesquisar
    $cpfMotorista = '10405247966';  // Substitua este valor pelo CPF desejado
   
    // Consulta SQL para selecionar o motorista pelo CPF
    $sql = "SELECT * FROM dados_motorista WHERE cpfmotorista = '$cpfMotorista'";
    $result = $conn->query($sql);
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

    <!-- Verifica se há resultados -->
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
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
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['data1']; ?></td>
                        <td><?php echo $row['mapa']; ?></td>
                        <td><?php echo $row['cxentreg']; ?></td>
                        <td><?php echo $row['tempointerno']; ?></td>
                        <td><?php echo $row['hrjornadaliq']; ?></td>
                        <td><?php echo $row['qtentregasentreg_rv']; ?></td>
                        <td><?php echo $row['cpfmotorista']; ?></td>
                        <td><?php echo $row['cpfajudante1']; ?></td>
                        <td><?php echo $row['cpfajudante2']; ?></td>
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
