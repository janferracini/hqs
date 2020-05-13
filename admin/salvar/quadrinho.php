<?php
// Verificar se não está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

// Verificar se existem dados no POST
if ($_POST) {

    include "functions.php";

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if( empty ($titulo)) {
        echo "<script>alert('Preencha o Título');history.back();</script>";
        exit;
    } else if( empty ($tipo_id)) {
        echo "<script>alert('Selecione o Tipo do Quadrinho');history.back();</script>";
        exit;
    }
    
    //iniciar uma transação
    $pdo->beginTransaction();

    
    //formatando os valores
    $data = formatar($data);
    $numero = retirar($numero);
    $valor = formatarValor($valor);
    
    //salva a time da máquina + a id de quem está na sessão
    $arquivo = time()."-".$_SESSION["hqs"]["id"];
    

    if (empty ($id)) {
        //insert
        $sql = "INSERT INTO quadrinho
                    (titulo, numero, data, capa, resumo, valor, tipo_id, editora_id)
                values 
                    (:titulo, :numero, :data, :capa, :resumo, :valor, :tipo_id, :editora_id)";
        $consulta = $pdo->prepare($sql);
        $consulta -> bindParam(":titulo", $titulo);
        $consulta -> bindParam(":numero", $numero);
        $consulta -> bindParam(":data", $data);
        $consulta -> bindParam(":capa", $arquivo);
        $consulta -> bindParam(":resumo", $resumo);
        $consulta -> bindParam(":valor", $valor);
        $consulta -> bindParam(":tipo_id", $tipo_id);
        $consulta -> bindParam(":editora_id", $editora_id);

    } else {
        //update
        //qual arquivo irá ser gravado
        if (!empty ($_FILES["capa"]["name"])) 
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

    //executar SQL
    if ( $consulta-> execute() ) {

        //verifica se o arquivo não está sendo enviado
        if (  ( empty($_FILES["capa"]["type"]) ) and (!empty($id))  ) {
            
        }

        //verificar se a imagem é .jpeg
        if ($_FILES["capa"]["type"] != "image/jpeg") {
            echo "<script>alert('Selecione uma imagem JPG válida.');hystory.back();</script>";
            exit;
        }

        //copiar a imagem para o servidor
        if (move_uploaded_file ($_FILES["capa"]["tmp_name"], "../fotos/".$_FILES["capa"]["name"]) ) {
            
            
            //redimencionar as imagens
            $pastaFotos = "../fotos/";
            $imagem     = $_FILES["capa"]["name"];
            $nome       = $arquivo;

            redimensionarImagem($pastaFotos, $imagem, $nome);

            print_r($arquivo);
            
            //gravar no DB se tudo estiver OK
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/quadrinho';</script>;";
            exit;
        }
        
        //erro ao gravar
        echo "<script>alert('Erro ao salvar ou enviar arquivo para o servidor');history.back();</script>;";
        exit;

    }
    
    exit;

    
} 
    // Mensagem de erro
    // Javascript - mensagem alert
    // Retornar history.back()
    echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
