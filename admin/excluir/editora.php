<?php
    //verificar se não está logado
    if ( !isset ($_SESSION["hqs"]["id"] ) ) {
        exit;
    }

    //verificar se id está vazia
    if (empty ($id)) {
        echo "<script>
                alert('Não foi possível excluir o registro');history.back();
            </script>";
            exit;
    }

    //verificar se existe um quadrinho cadastrado com essa editora
    $sql = "SELECT id
            FROM quadrinho
            WHERE editora_id = ?
            LIMIT 1";
    //prepara a sql para executar
    $consulta = $pdo->prepare($sql);
    //passar o id do parametro
    $consulta->bindParam(1,$id);
    //executa o sql
    $consulta->execute();
    //recuperar os dados selecionados
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    //se existir  avisar e voltar
    if (!empty ($dados->id)) {
        //se o id não está vazio, não posso excluir
        
        echo "<script>
                alert('Não é possível excluir este registro 
                    pois existe um quadrinho relacionado.');history.back();
            </script>";
    }

    //se existir, avisar e voltar
    

    //excluir a editora
    $sql = "DELETE FROM editora WHERE id = ? limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    //verificar se não executou
    if (!$consulta->execute()){

        //consulta erros - sempre depois do execute
        echo $consulta->errorInfo()[2];

        echo "<script>
                alert('Erro ao excluir');javascript:history.back();
            </script>";
    }

    //redirecionar para a listagem de editoras
    echo "<script>location.href='listar/editora'</script>"

?>