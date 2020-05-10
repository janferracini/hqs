<?php
//verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
    exit;
}

// Iniciar as variaveis
$id = $nome = $site = '';

// Verificar se existe um id
if (!empty($id)) {
    // Selecionar os dados do banco
    $sql = "SELECT * 
            FROM editora 
            WHERE id = ? 
            LIMIT 1";

    $consulta = $pdo->prepare($sql);

    $consulta->bindParam(1, $id); //segurança

    // id - linha 255 do index.php
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    // Separar os dados
    $id = $dados->id;
    $nome = $dados->nome;
    $site = $dados->site;
} else {
    $id = '';
}
?>

<div class="container">
    <h1 class="float-left">Cadastro de Editora</h1>
    <div class="float-right">
        <a href="cadastro/editora" class="btn btn-success">Novo Registro</a>
        <a href="listar/editora" class="btn btn-info">Listar Registro</a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->

    <form action="salvar/editora" name="formCadastro" 
    method="post" data-parsley-validade>
        <label for="id">ID</label>
        <input type="text" name="id" id="id" 
        class="form-control" 
        readonly value="<?= $id ?>">

        <label for="nome">Nome da Editora</label>
        <input type="text" name="nome" id="nome" class="form-control"
        required data-parsley-required-message="Preencha esse campo"
        value="<?= $nome ?>">

        <label for="site">Site da Editora</label>
        <input type="text" name="site" id="site" class="form-control"
        required data-parsley-required-message="Preencha esse campo"
        value="<?= $site ?>">

        <button type="submit" class="btn btn-success margin">
            <i class="fas fa-check"></i>Gravar Dados</button>
    </form>
</div>
<!--fim do container-->