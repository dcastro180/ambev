<?php
    session_start();
    include_once ('config.php');

    // Consulta SQL para selecionar todos os dados de "dados_motorista"
    $sql = "SELECT * FROM dados_motorista ORDER BY id";
    $result = $conn->query($sql);
    
    if(empty($_SESSION)){
        print "<script>location.href='index.php';</script>";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bruno Ambev</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">Sistema Bruno Ambev</a>
            <?php
                print "Olá, " .$_SESSION["nome"];
                print "<a href='administradores.php' class= 'btn btn-secondary'>Cadastro</a>";
                print "<a href='logout.php' class= 'btn btn-danger'>Sair</a>";
            ?>
        </div>
    </nav>
<div class="tab_motorista">
    <h2>Lista de Fretes</h2>
    <div class="card">
        <div class="card-body">
        <?php if ($result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead class="thead-dark">
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
        </div>
    </div>      
</div>

    <footer>
    <footer class="footer bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2>DIOGO CASTRO</h2>
                </div>
                <div class="col-md-3">
                    <h5>About Us</h5>
                    <p>"Desenvolvido por Diogo Castro, um desenvolvedor em constante busca por conhecimento. Este sistema foi projetado para ser simples, funcional e de fácil acesso via internet." <br>Se precisar de ajustes ou algo mais específico, é só avisar!
                   </p>
                </div>
                <div class="col-md-3">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li>Email: dcastrocs@gmail.com</li>
                        <li>Phone: +55 (41) 99571-3341</li>
                        
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                    <ul class="list-inline footer-links">      
                        <li class="list-inline-item">
                            <a href="https://www.linkedin.com/in/diogo-vidal-de-castro1985/">
                            <i class="bi bi-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2024 Website. All rights reserved.</p>
                </div>
                
            </div>
        </div>
    </footer>
    </footer>    
</body>
</html>