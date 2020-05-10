<?php
    //verificar se não está logado
    if (!isset($_SESSION['hqs']['id'])) {
        exit;
    }

    //verifivar se existem dados no POST
    if ($_POST) {
        //recuperar os dados do formulário

        $id = $tipo = '';

        foreach ($_POST as $key => $value) {
            $$key = trim($value); //$$ é para ???
        }

        //validar os campos em branco

        if (empty($tipo)){
            echo '<script>alert("Preencha o Tipo")/history.back();</script>';
            exit;
        }

        //verificar se existe um cadastro com esse nome
        $sql = 'SELECT id
                FROM tipo
                WHERE tipo = ? AND id <> ?
                LIMIT 1 ';

        $consulta = $pdo->prepare($sql);
        
        //usar PDO -> prepara para executar
        $consulta->bindParam(1, $tipo);
        $consulta->bindParam(2, $id);

        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //Verifica se tem algum objeto com o mesmo nome
        if (!empty($dados->id)) {
            echo '<script>alert("Já existe uma editora com este nome registrada!");history.back();</script>';
            exit;
        }

        //se o id em branco -> insert
        //se o id estiver preenchido -> update

        if (empty($id)){
            //insere dados no banco
            $sql = "INSERT INTO tipo (tipo)
                    VALUES (?)";

            $consulta = $pdo->prepare($sql);

            $consulta->bindParam(1, $tipo) ;
        } else {
            //atualizar dados
            $sql = "UPDATE tipo SET tipo = ?
                    WHERE id = ? limit 1";
            
            $consulta = $pdo->prepare($sql);
            
            $consulta->bindParam(1, $tipo);
            $consulta->bindParam(2, $id);
        }

        //executa e verifica se deu certo

        if ($consulta->execute()){
            echo '<script>alert("Registro salvo!");location.href="listar/tipo";</script>';
        } else {
            echo '<script>alert("Erro ao salvar!);history.back();</script>';
        }
    } else {
        // Mensagem de erro
        // Javascript - mensagem alert
        // Retornar history.back()
        echo '<script>alert("Erro ao realizar requisição!");history.back();</script>';
    }

