<?php
//verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
	exit;
}

//verificar se existem dados no POST
if ($_POST) {

	//recuperar os dados do formulario
	$id = $cidade = $estado = "";

	foreach ($_POST as $key => $value) {
		//guardar as variaveis
		$$key = trim($value);
		//$id
	}

	//validar os campos - em branco
	if (empty($cidade)) {
		echo '<script>alert("Preencha o nome da cidade");history.back();</script>';
		exit;
	}
	//validar se é uma URL válida
	else if (empty($estado)) {
		echo '<script>alert("Preencha o estado da cidade");history.back();</script>';
		exit;
	}


	//se o id estiver em branco - insert
	//se o id estiver preenchido - update
	if (empty($id)) {
		//inserir os dados no banco
		$sql = "insert into cidade (cidade, estado)
  		values( ? , ? )";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $cidade);
		$consulta->bindParam(2, $estado);
	} else {
		//atualizar os dados  	
		$sql = "update cidade set cidade = ?, 
  		estado = ? where id = ? limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $cidade);
		$consulta->bindParam(2, $estado); 
		$consulta->bindParam(3, $id); 

	}
	//executar e verificar se deu certo
	if ($consulta->execute()) {
		echo '<script>alert("Registro Salvo");location.href="listar/cidade";</script>';
	} else {
		echo '<script>alert("Erro ao salvar");history.back();</script>';
		exit;
	}
} else {
	//mensagem de erro
	//javascript - mensagem alert
	//retornar hostory.back
	echo '<script>alert("Erro ao realizar requisição");history.back();</script>';
}
