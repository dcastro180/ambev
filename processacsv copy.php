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
        // Captura o cabeçalho e ignora a primeira linha
        $cabecalho = fgetcsv($dados_arquivo, 1000, ";");

        // Percorre cada linha do arquivo CSV
        while ($linha = fgetcsv($dados_arquivo, 1000, ";")) {
            if ($primeira_linha) {
                $primeira_linha = false;
                continue;
            }
            // Converte a linha para UTF-8
            array_walk_recursive($linha, 'converter');

            // Atribui os valores a variáveis individuais
            $data1 = !empty($linha[0]) ? $linha[0] : NULL;
            $mapa = !empty($linha[13]) ? $linha[13] : NULL;
            $cxentreg = !empty($linha[16]) ? $linha[16] : NULL;
            $tempointerno = !empty($linha[47]) ? $linha[47] : NULL;
            $hrjornadaliq = !empty($linha[67]) ? $linha[67] : NULL;
            $qtentregasentreg_rv = !empty($linha[103]) ? $linha[103] : NULL;
            $cpfmotorista = !empty($linha[106]) ? $linha[106] : NULL;
            $cpfajudante1 = !empty($linha[107]) ? $linha[107] : NULL;
            $cpfajudante2 = !empty($linha[108]) ? $linha[108] : NULL;

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