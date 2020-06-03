<?php
//verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
	exit;
}

//verificar se existem dados no POST
if ($_POST) {

	include "functions.php";
	include "config/conexao.php";

	$id = $nome = $cpf = $datanascimento = $email = $senha = $cep =
		$endereco = $complemento = $bairro = $cidade_id = $cidade =
		$foto = $telefone = $celular = $estado = '';

	foreach ($_POST as $key => $value) {
		//guardar as variaveis
		$$key = trim($value);
		//$id
	}

	//validar os campos - em branco
	if (empty($nome)) {
		echo '<script>alert("Preencha o nome");history.back();</script>';
		exit;
	} else if (empty($cpf)) {
		echo '<script>alert("Preencha o CPF");history.back();</script>';
		exit;
	} else if (empty($datanascimento)) {
		echo '<script>alert("Preencha a data de nascimento");history.back();</script>';
		exit;
	} else if (empty($email)) {
		echo '<script>alert("Preencha o e-mail");history.back();</script>';
		exit;
	} else if (empty($cep)) {
		echo '<script>alert("Preencha o CEP");history.back();</script>';
		exit;
	} else if (empty($endereco)) {
		echo '<script>alert("Preencha o endereço");history.back();</script>';
		exit;
	} else if (empty($complemento)) {
		echo '<script>alert("Preencha o complemento");history.back();</script>';
		exit;
	} else if (empty($bairro)) {
		echo '<script>alert("Preencha o bairro");history.back();</script>';
		exit;
	} else if (empty($celular)) {
		echo '<script>alert("Preencha o número de celular");history.back();</script>';
		exit;
	} 

	$pdo->beginTransaction();
	$arquivo = $nome . "-" . $_SESSION["hqs"]["id"];


	//se o id estiver em branco - insert
	//se o id estiver preenchido - update
	if (empty($id)) {
		//inserir os dados no banco
		$sql = "INSERT INTO cliente (nome, cpf, datanascimento, email, senha, cep, endereco,
									complemento, bairro, cidade_id, foto, telefone, celular)
				VALUES( :nome, :cpf, :datanascimento, :email, :senha, :cep, :endereco,
						:complemento, :bairro, :cidade_id, :foto, :telefone, :celular )";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(":nome", $nome);
		$consulta->bindParam(":cpf", $cpf);
		$consulta->bindParam(":datanascimento", $datanascimento);
		$consulta->bindParam(":email", $email);
		$consulta->bindParam(":senha", $senha);
		$consulta->bindParam(":cep", $cep);
		$consulta->bindParam(":endereco", $endereco);
		$consulta->bindParam(":complemento", $complemento);
		$consulta->bindParam(":bairro", $bairro);
		$consulta->bindParam(":cidade_id", $cidade_id);
		$consulta->bindParam(":foto", $foto);
		$consulta->bindParam(":telefone", $telefone);
		$consulta->bindParam(":celular", $celular);

	} else {
		//editar os dados no banco
		if (!empty($_FILES["foto"]["name"])) //verifica se já tem a foto
			$foto = $arquivo;
			
		//atualizar os dados  	
		$sql = "UPDATE cliente
				SET nome			= :nome, 
					cpf				= :cpf, 
					datanascimento	= :datanascimento, 
					email			= :email,
					senha			= :senha,
					cep				= :cep,
					endereco		= :endereco,
					complemento		= :complemento,
					bairro			= :bairro,
					cidade_id		= :cidade_id,
					foto			= :foto,
					telefone		= :telefone,
					celular			= :celular  
				WHERE id = :id LIMIT 1";

		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(":nome", $nome);
		$consulta->bindParam(":cpf", $cpf);
		$consulta->bindParam(":datanascimento", $datanascimento);
		$consulta->bindParam(":email", $email);
		$consulta->bindParam(":senha", $senha);
		$consulta->bindParam(":cep", $cep);
		$consulta->bindParam(":endereco", $endereco);
		$consulta->bindParam(":complemento", $complemento);
		$consulta->bindParam(":bairro", $bairro);
		$consulta->bindParam(":cidade_id", $cidade_id);
		$consulta->bindParam(":foto", $foto);
		$consulta->bindParam(":telefone", $telefone);
		$consulta->bindParam(":celular", $celular);
		$consulta->bindParam(":id", $id);
	}
	//executar e verificar se deu certo
	if ($consulta->execute()) {

        //verifica se o arquivo não está sendo enviado
        if ((empty($_FILES["foto"]["type"])) and (!empty($id))) {
        }

        //verificar se a imagem é .jpeg
        if ($_FILES["foto"]["type"] != "image/jpeg") {
            echo "<script>alert('Selecione uma imagem JEPG válida.');hystory.back();</script>";
            exit;
        }

        //copiar a imagem para o servidor
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], "../fotos/clientes/" . $_FILES["foto"]["name"])) {

            //redimencionar as imagens
            $pastaFotos = "../fotos/clientes/";
            $imagem     = $_FILES["foto"]["name"];
            $nome       = $arquivo;
			fotoCliente($pastaFotos, $imagem, $nome);
			
            //gravar no DB se tudo estiver OK
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/cliente';</script>;";
            exit;
        }

        //erro ao gravar
        echo "<script>alert('Erro ao salvar ou enviar arquivo para o servidor');</script>;";
        exit;
    }
    echo $consulta->errorInfo()[2];
    exit;
}
// Mensagem de erro
// Javascript - mensagem alert
// Retornar history.back()
echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
echo $consulta->errorInfo()[2];
    exit;