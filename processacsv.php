<?php
include_once "config.php";

$arquivo = $_FILES['arquivo'];
$linhas_importadas = 0;
$linhas_nao_importadas = 0;
$motorista_nao_importado = "";
$primeira_linha = true;

if ($arquivo['type'] == 'text/csv') {
    $dados_arquivo = fopen($arquivo['tmp_name'], "r");

    if ($dados_arquivo !== FALSE) {
        // Captura o cabeçalho e cria um mapa de índices
        $cabecalho = fgetcsv($dados_arquivo, 2000, ";");
        $indices = array_flip($cabecalho);

        // Verifica se os índices necessários existem
        $campos_necessarios = ['Data', 'Mapa', 'CxEntreg', 'TempoInterno', 'HrJornadaLiq', 'QtEntregasEntreg(RV)', 'CPFMotorista', 'CPFAjudante1', 'CPFAjudante2'];
        foreach ($campos_necessarios as $campo) {
            if (!isset($indices[$campo])) {
                die("O campo '$campo' não foi encontrado no arquivo CSV.");
            }
        }

        // Percorre cada linha do arquivo CSV
        while ($linha = fgetcsv($dados_arquivo, 2000, ";")) {
            if ($primeira_linha) {
                $primeira_linha = false;
                continue;
            }

            // Converte a linha para UTF-8
            array_walk_recursive($linha, 'converter');

            // Atribui os valores a variáveis individuais usando os índices
            $data1 = !empty($linha[$indices['Data']]) ? $linha[$indices['Data']] : NULL;
            $mapa = !empty($linha[$indices['Mapa']]) ? $linha[$indices['Mapa']] : NULL;
            $cxentreg = !empty($linha[$indices['CxEntreg']]) ? $linha[$indices['CxEntreg']] : NULL;
            $tempointerno = !empty($linha[$indices['TempoInterno']]) ? $linha[$indices['TempoInterno']] : NULL;
            $hrjornadaliq = !empty($linha[$indices['HrJornadaLiq']]) ? $linha[$indices['HrJornadaLiq']] : NULL;
            $qtentregasentreg_rv = !empty($linha[$indices['QtEntregasEntreg(RV)']]) ? $linha[$indices['QtEntregasEntreg(RV)']] : NULL;
            $cpfmotorista = !empty($linha[$indices['CPFMotorista']]) ? $linha[$indices['CPFMotorista']] : NULL;
            $cpfajudante1 = !empty($linha[$indices['CPFAjudante1']]) ? $linha[$indices['CPFAjudante1']] : NULL;
            $cpfajudante2 = !empty($linha[$indices['CPFAjudante2']]) ? $linha[$indices['CPFAjudante2']] : NULL;

            // Prepara a query com placeholders `?`
            $query_motorista = "INSERT INTO dados_motorista (data1, mapa, cxentreg, tempointerno, hrjornadaliq, qtentregasentreg_rv, cpfmotorista, cpfajudante1, cpfajudante2)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepara o statement
            $cad_motorista = $conn->prepare($query_motorista);

            // Verifica se a preparação do statement foi bem sucedida
            if ($cad_motorista === false) {
                die('Erro na preparação da query: ' . htmlspecialchars($conn->error));
            }

            // Bindando os valores (NULL ou valor real)
            $cad_motorista->bind_param(
                "sssssssss", // tipos dos parâmetros: "s" para string, "i" para inteiro, etc.
                $data1,
                $mapa,
                $cxentreg,
                $tempointerno,
                $hrjornadaliq,
                $qtentregasentreg_rv,
                $cpfmotorista,
                $cpfajudante1,
                $cpfajudante2
            );

            // Executa o statement
            if ($cad_motorista->execute()) {
                $linhas_importadas++;
            } else {
                $linhas_nao_importadas++;
                $motorista_nao_importado .= "," . ($data1 ?? "NULL");
            }

            // Fechar o statement após a execução
            $cad_motorista->close();
        }

        echo "$linhas_importadas linha(s) Importada(s), $linhas_nao_importadas linha(s) não Importada(s). Informações do CSV não importada: $motorista_nao_importado"; 
        fclose($dados_arquivo);
    } else {
        echo "Erro ao abrir o arquivo CSV.";
    }
} else {
    echo "Arquivo não é CSV";
}

function converter(&$item) {
    // Converte os dados para utf-8
    $item = mb_convert_encoding($item, "UTF-8", "ISO-8859-1");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importação de CSV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 text-center">
                <!-- Botão para voltar ao dashboard -->
                <a href="dashboard.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

</body>
</html>
