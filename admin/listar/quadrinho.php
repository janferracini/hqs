<?php
  //verificar se não está logado
	if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    	exit;
	}
?>

<div class="container">
	<h1 class="float-left">Listar Quadrinhos</h1>
	<div class="float-right">
		<a href="cadastro/quadrinho" class="btn btn-success">Novo Registro</a>
		<a href="listar/quadrinho" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<td>ID</td>
				<td>Foto</td>
				<td>Nome do Quadrinho / Número</td>
				<td>Data</td>
				<td>Valor</td>
				<td>Editora</td>
				<td>Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
				//buscar as cidades alfabeticamente
				$sql = "SELECT q.id, q.titulo, q.capa, q.valor, q.numero, date_format(q.data, '%d/%m/%Y') dt,e.nome editora
						FROM quadrinho q 
						INNER JOIN editora e 
						ON (e.id = q.editora_id)
						ORDER BY q.titulo";
				$consulta = $pdo->prepare($sql);
				$consulta->execute();

				while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
					//separar os dados
					$id 		= $dados->id;
					$titulo 	= $dados->titulo;
					$capa		= $dados->capa;
					$valor		= number_format($dados->valor,2, ",", ".");
					$numero		=$dados->numero;
					$data		=$dados->dt;
					$editora	=$dados->editora;

					$imagem = "../fotos/".$capa."p.jpg";

					//mostrar na tela
					echo "<tr>
						<td>$id</td>
						<td>
							<img src='$imagem' alt='$titulo' width='50px'></td>
						<td>$titulo / $numero</td>
						<td>$data</td>
						<td>$valor</td>
						<td>$editora</td>
						<td>
							<a href='cadastro/quadrinho/$id'  class='btn btn-success btn-sm'>
								<i class='fas fa-edit'></i>
							</a>
							<a href='javascript:excluir  ($id)' class='btn btn-danger btn-sm'>
                            <i class='fas fa-trash'></i></a>
						</td>
					</tr>";
				}
			?>
		</tbody>
	</table>
</div>
<script>
	//funcao para perguntar se deseja excluir
	//se sim direcionar para o endereco de exclusão
	function excluir( id ) {
		//perguntar - função confirm
		if ( confirm ( "Deseja mesmo excluir?" ) ) {
			//direcionar para a exclusao
			location.href="excluir/quadrinho/"+id;
		}
	}
</script>