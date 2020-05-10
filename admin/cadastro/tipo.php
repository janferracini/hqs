<?php
//verificar se não está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

//iniciar as variáveis
$tipo = "";

//verificar se existe a id

if (!empty($id)) {

    $sql = "SELECT *
            FROM tipo
            WHERE id = ? 
            LIMIT 1";

    $consulta = $pdo->prepare($sql);

    $consulta->bindParam(1,$id); //segurança 

    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ); // ?????????

    //separar os dados
    $id     = $dados->id;
    $tipo   = $dados->tipo; 
} else {
    $id = '';
}
?>

<div class="container">
    <h1 class="float-left">Cadastro de Tipo de Quadrinho</h1>
    <div class="float-right">
        <a href="cadastro/tipo" class="btn btn-success">Novo Registro</a>
        <a href="listar/tipo" class="btn btn-info">Listar Registro</a>
    </div>

    <div class="clearfix"></div>

    <form action="salvar/tipo" name="formCadastro" 
    method="POST" data-parsley-validade>
        
        <label for="id">ID</label>
        <input type="text" name="id" id="id" 
        class="form-control"
        readonly value="<?=$id?>">

        <label for="tipo">Tipo de Quadrinho</label>
        <input type="text" name="tipo" id="tipo" class="form-control"
        required data-parsley-requered-message="Preencha esse campo"
        value="<?= $tipo ?>">

        <button type="submit" class="btn btn-success margin">
            <i class="fas fa-check"></i> Gravar Dados</button>
    </form>

</div>