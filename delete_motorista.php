<?php
    if(!empty($_GET['id'])){
        include_once('config.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM motoristas WHERE id = '$id'";
        $result = mysqli_query($conn, $sqlSelect);

        if($result -> num_rows > 0){
            $sqlDelete = "DELETE FROM motoristas WHERE id = '$id'";
            $resultDelete = mysqli_query($conn, $sqlDelete);
        }
    }
    header('Location: administradores.php');
?>