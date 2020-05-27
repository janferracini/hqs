<?php 
    session_start();

    if (!isset($_SESSION["hqs"]["id"])) {
        exit;
    }

    $cidade = $_GET['cidade'] ?? "";
    $cidade = $_GET['cidade'] ?? "";

    if ((empty ($cidade) ) or (empty($estado) )) {
        echo "Erro";
    }
    include "config/conexao.php";
    $sql = "SELECT id FROM cidade where cidade = :cidade and estado = :estado limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":cidade", $cidade);
    $consulta->bindParam(":estado", $estado);
    $consulta = $pdo->execute;

