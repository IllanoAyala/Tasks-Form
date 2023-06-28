<?php 
    $dbHost = 'Localhost';
    $dbUsername = 'root';
    $dbPassoword = '';
    $dbName = 'tarefas';

    $conexao = new mysqli($dbHost, $dbUsername, $dbPassoword, $dbName);

    //if($conexao -> connect_errno){
    //    echo "Erro.";
    //}
    //else{
    //    echo "Sucesso.";
    //};

?>