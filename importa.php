<?php

    session_start();

    // Verifica se o usuário está logado e é administrador
    if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != 1) {
        echo "<script>alert('Acesso negado.');</script>";
        echo "<script>location.href='index.php';</script>";
        exit;
    }

    include('config.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importa CSV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body >
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">Sistema Bruno Ambev</a>
            <?php
                print "Olá, " . $_SESSION["nome"];
                print "<a href='administradores.php' class='btn btn-outline-success'>Home</a>";
                print "<a href='dashboard.php' class='btn btn-outline-success'>Dashboard</a>";
                print "<a href='importa.php' class='btn btn-outline-success'>Upload Planilha</a>"; // Botão para pagina de upload.
                print "<a href='logout.php' class='btn btn-danger'>Sair</a>";
            ?>
        </div>
    </nav>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="container">
        <div class="row">
            <!-- Card de Importação -->
            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h1 class="card-title">Importa Excel - CSV</h1>
                        <form action="processacsv.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="arquivo" class="form-label">Arquivo:</label>
                                <input type="file" name="arquivo" id="arquivo" class="form-control" accept="text/csv">
                            </div>
                            <input type="submit" value="Enviar" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card de Apagamento de Dados -->
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h2 class="card-title">Apaga Arquivo Antigo</h2>
                        <p class="card-text">Para evitar erros nos dados, apague os dados antigos antes de realizar o novo upload.</p>
                        <form method="POST">
                            <button type="submit" name="delete_all" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja apagar todos os dados?');">Apagar Todos os Dados</button>
                        </form>
                        <?php
                        if (isset($_POST['delete_all'])) {
                            // Conecte-se ao banco de dados
                            $conn = new mysqli('localhost', 'root', '', 'brunoambev');

                            // Verifique a conexão
                            if ($conn->connect_error) {
                                die("Falha na conexão: " . $conn->connect_error);
                            }

                            // SQL para apagar todos os dados de todas as tabelas
                            $tables = ['dados_motorista']; // Liste todas as tabelas que você deseja esvaziar

                            foreach ($tables as $table) {
                                $sql = "DELETE FROM $table";
                                if ($conn->query($sql) !== TRUE) {
                                    echo "Erro ao apagar dados da tabela $table: " . $conn->error;
                                }
                            }

                            echo "<p class='mt-3 text-success'>Todos os dados foram apagados com sucesso!</p>";
                            $conn->close();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

</body>
</html>
