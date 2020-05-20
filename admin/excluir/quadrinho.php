<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }

  //verificar se o id esta vazio
  if ( empty ( $id ) ) {
  	echo "<script>alert('Não foi possível excluir o registro');history.back();</script>";
  	exit;
  }

  //verificar se existe um cliente cadastrado com esta cidade
  $sql = "SELECT id
  FROM cliente
  WHERE cidade_id = ?
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
          pois existe um cliente relacionado.');history.back();
  </script>";
}


//excluir o quadrinho
$sql = "DELETE FROM quadrinho WHERE id = ? limit 1";
$consulta = $pdo->prepare($sql);
$consulta->bindParam(1, $id);
//verificar se não executou
if (!$consulta->execute()){

//consulta erros - sempre depois do execute
//echo $consulta->errorInfo()[2];

echo "<script>
      alert('Erro ao excluir');javascript:history.back();
  </script>";
}
  //redirecionar para a listagem de quadrinhos
  echo "<script>location.href='listar/quadrinho';</script>";
