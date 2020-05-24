<?php
// Verificar se não está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

// Verificar se existem dados no POST
if ($_POST) {

    include "functions.php";
    include "config/conexao.php";

    $id = $titulo = $data = $numero = $valor = $resumo = $tipo_id = $editora_id =  '';

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }


    if (empty($titulo)) {
        echo "<script>alert('Preencha o Título');history.back();</script>";
        exit;
    } else if (empty($tipo_id)) {
        echo "<script>alert('Selecione o Tipo do Quadrinho');history.back();</script>";
        exit;
    } else if (empty($editora_id)) {
        echo "<script>alert('Selecione a Editora');history.back();</script>";
        exit;
    }
    //***************COLOCAR O RESTO */
    //iniciar uma transação
    $pdo->beginTransaction();
    //formatando os valores
    $data   = formatar($data);
    $numero = retirar($numero);
    $valor  = formatarValor($valor);
    $editora_id = getEditora($editora_id);

    //salva a time da máquina + a id de quem está na sessão
    $arquivo = time() . "-" . $_SESSION["hqs"]["id"];

    echo print_r($_POST);
    if (empty($id)) {
        //insert
        $sql = "INSERT INTO quadrinho
                    (titulo, numero, data, capa, resumo, valor, tipo_id, editora_id)
                values 
                    (:titulo, :numero, :data, :capa, :resumo, :valor, :tipo_id, :editora_id)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":titulo", $titulo);
        $consulta->bindParam(":numero", $numero);
        $consulta->bindParam(":data", $data);
        $consulta->bindParam(":capa", $arquivo);
        $consulta->bindParam(":resumo", $resumo);
        $consulta->bindParam(":valor", $valor);
        $consulta->bindParam(":tipo_id", $tipo_id);
        $consulta->bindParam(":editora_id", $editora_id);
    } else {
        //update
        //qual arquivo irá ser gravado
        if (!empty($_FILES["capa"]["name"]))
            $capa = $arquivo;

        $sql = "update qudrinho set titulo = :titulo,
                                        numero = :numero,
                                        valor = :valor,
                                        resumo = :resumo,
                                        capa = :capa,
                                        tipo_id = :tipo_id,
                                        editora_id = :editora_id,
                                        data = :data
                    where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":titulo", $titulo);
        $consulta->bindParam(":numero", $numero);
        $consulta->bindParam(":valor", $valor);
        $consulta->bindParam(":resumo", $resumo);
        $consulta->bindParam(":capa", $capa);
        $consulta->bindParam(":tipo_id", $tipo_id);
        $consulta->bindParam(":editora_id", $editora_id);
        $consulta->bindParam(":data", $data);
        $consulta->bindParam(":id", $id);
    }

    //executar SQL depois de ver qual ele vai passar
    if ($consulta->execute()) {

        //verifica se o arquivo não está sendo enviado
        if ((empty($_FILES["capa"]["type"])) and (!empty($id))) {
        }

        //verificar se a imagem é .jpeg
        if ($_FILES["capa"]["type"] != "image/jpeg" or "image/jpg") {
            echo "<script>alert('Selecione uma imagem JEPG válida.');hystory.back();</script>";
            exit;
        }

        //copiar a imagem para o servidor
        if (move_uploaded_file($_FILES["capa"]["tmp_name"], "../fotos/" . $_FILES["capa"]["name"])) {

            //redimencionar as imagens
            $pastaFotos = "../fotos/";
            $imagem     = $_FILES["capa"]["name"];
            $nome       = $arquivo;
            redimensionarImagem($pastaFotos, $imagem, $nome);



            //gravar no DB se tudo estiver OK
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/quadrinho';</script>;";
            exit;
        }

        //erro ao gravar
        echo "<script>alert('Erro ao salvar ou enviar arquivo para o servidor');history.back();</script>;";
        exit;
    }
    echo $consulta->errorInfo()[2];
    exit;
}
// Mensagem de erro
// Javascript - mensagem alert
// Retornar history.back()
echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
