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
    <title>Painel do Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
        function showSection(section) {
            document.getElementById('usersSection').style.display = section === 'users' ? 'block' : 'none';
            document.getElementById('driversSection').style.display = section === 'drivers' ? 'block' : 'none';
        }
    </script>
</head>
<body>
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
    <div class="container">
        <h1>Painel do Administrador</h1>
        <div class="buttons">
            <button class="btn btn-primary" onclick="showSection('users')">Mostrar Usuários</button>
            <button class="btn btn-primary" onclick="showSection('drivers')">Mostrar Motoristas</button>
        </div>


        <!-- Seção de Usuários -->
        <div id="usersSection" style="display: none;">
            <h2>Usuários Cadastrados</h2>
            <button class="btn btn-primary" onclick="location.href='cadastro_usuario.php'">Cadastrar Novo Usuário</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Usuário</th>
                        <th>Tipo</th>
                        <th>Data de Criação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, nome, email, usuario, tipo, date FROM usuarios";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['nome']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['usuario']}</td>
                                    <td>" . ($row['tipo'] == 1 ? 'Admin' : 'Comum') . "</td>
                                    <td>{$row['date']}</td>
                                    <td><a href='delete.php?type=user&id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\");'>Excluir</a>
</td>

                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Nenhum usuário cadastrado</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Seção de Motoristas -->
        <div id="driversSection" style="display: none;">
            <h2>Motoristas Cadastrados</h2>
            <button class="btn btn-primary" onclick="location.href='cadastro_motorista.php'">Cadastrar Novo Motorista</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Função</th>
                        <th>Tipo de Carro</th>
                        <th>CPF do Motorista</th>
                        <th>Observação</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, nome, funcao, tipo_carro, cpfmotorista, observacao, tipo_usuario FROM motoristas";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['nome']}</td>
                                    <td>{$row['funcao']}</td>
                                    <td>{$row['tipo_carro']}</td>
                                    <td>{$row['cpfmotorista']}</td>
                                    <td>{$row['observacao']}</td>
                                    <td>" . ($row['tipo_usuario'] == 1 ? 'Admin' : 'Comum') . "</td>
                                    <td><a href='delete.php?type=driver&id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir este motorista?\");'>Excluir</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Nenhum motorista cadastrado</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
