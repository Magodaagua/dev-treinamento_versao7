<?php
    $id = $_POST['id'];
    $password = $_POST['password'];

    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $dbname = "devportalcop";

    //Criar a conexao
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

    if($password == "" or $password == " "){
        $password = "SELECT senha FROM usuario WHERE ID_usuario = '$id'";
        header("Location: menu.php");
    }

    $result_usuario = "UPDATE usuario SET senha = '$password' WHERE ID_usuario = '$id'";
    $resultado_usuario = mysqli_query($conn, $result_usuario);

    header("Location: ../menu.php");
?>