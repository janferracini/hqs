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
				$sql = "select * from quadrinho 
				order by titulo";
				$consulta = $pdo->prepare($sql);
				$consulta->execute();

				while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
					//separar os dados
					$id 		= $dados->id;
					$titulo 	= $dados->titulo;
					//mostrar na tela
					echo '<tr>
						<td>'.$id.'</td>
						<td>'.$capa.'</td>
						<td>'.$titulo. "/" .$numero.'</td>
						<td>'.$data.'</td>
						<td>'.$valor.'</td>
						<td>'.$editora.'</td>
						<td>'.$titulo.'</td>
						<td>
							<a href="cadastro/cidade/'.$id.'" class="btn btn-success btn-sm">
								<i class="fas fa-edit"></i>
							</a>

							<a href="javascript:excluir('.$id.')" class="btn btn-danger btn-sm">
								<i class="fas fa-trash"></i>
							</a>
						</td>
					</tr>';
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