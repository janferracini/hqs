<?php
// Verificar se não está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

// Verificar se existem dados no POST
if ($_POST) {
    // Recuperar os dados do formulário
    $id = $nome = $site = '';

    foreach ($_POST as $key => $value) {
        // Guardar as variáveis
        $$key = trim($value);
    }

    // Validar os campos em branco
    if (empty($nome)) {
        echo '<script>alert("Preencha o nome");history.back();</script>';
        exit;
    }   // Validar se é uma URL válida
        else if (!filter_var($site, FILTER_VALIDATE_URL)) {
        echo '<script>alert("Preencha com uma URL válida!");history.back();</script>';
        exit;
    }

    // Verificar se existe um cadastro com este nome
    $sql = "select id from editora 
    where nome = ? and id <> ? limit 1";

    // Usar o PDO / prepare para executar o sql
    $consulta = $pdo->prepare($sql);

    // Passando o parametro
    $consulta->bindParam(1, $nome);
    $consulta->bindParam(2, $id);

    // Executar o sql
    $consulta->execute();

    // Puxar os dados (id)
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    // Verificar se esta vazio, se tem algo é porque existe um registro com o mesmo nome
    if (!empty($dados->id)) {
        echo '<script>alert("Já existe uma editora com este nome registrada!");history.back();</script>';
        exit;
    }

    // Se o id estiver em branco - insert
    // Se o id estiver preenchido - update
    if (empty($id)) {
        // Inserir os dados no banco
        $sql = "insert into editora (nome, site) values (?, ?)";

        $consulta = $pdo->prepare($sql);

        $consulta->bindParam(1, $nome);
        $consulta->bindParam(2, $site);
    } else {
        // Atualizar os dados
        $sql = "update editora set nome = ?, site = ? 
        where id = ? limit 1";

        $consulta = $pdo->prepare($sql);

        $consulta->bindParam(1, $nome);
        $consulta->bindParam(2, $site);
        $consulta->bindParam(3, $id);
    }

    // Executar e verificar se deu certo
    if ($consulta->execute()) {
        echo '<script>alert("Registro salvo!");location.href="listar/editora";</script>';
    } else {
        echo '<script>alert("Erro ao salvar!);history.back();</script>';
    }
} else {
    // Mensagem de erro
    // Javascript - mensagem alert
    // Retornar history.back()
    echo '<script>alert("Erro ao realizar requisição!");history.back();</script>';
}