<?php
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASS', '');
    define('BASE', 'brunoambev');

    $conn = new MySQLi(HOST, USER, PASS, BASE);
    //echo "conexão feita com sucesso";
/*    if (!$conn) {echo "Não foi possível conectar ao banco MySQL.";
        exit;
    }else{
        echo "Parabéns!! A conexão ao banco de dados ocorreu normalmente!.";
    }
*/
