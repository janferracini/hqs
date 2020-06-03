<?php
    //verificar se está logado
    if (!isset ($_SESSION['hqs']['id'])) {
        exit;
    }
?>

<div class="container">
    <h1 class="float-left">Listar Personagens</h1>
    <div class="float-right">
        <a href="cadastro/tipo" class="btn btn-success">Novo Registro</a>
        <a href="listar/tipo" class="btn btn-info">Listar Registros</a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover" id="tabTipo">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo de Quadrinho</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Buscar as editoras alfabeticamente
            $sql = "SELECT * 
                    FROM tipo 
                    ORDER BY tipo";
                    
            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                // Separar os dados
                $id = $dados->id;
                $tipo = $dados->tipo;

                // Mostrar na tela
                echo '<tr>
                        <td>' . $id . '</td>
                        <td>' . $tipo . '</td>
                        <td><a href="cadastro/tipo/' . $id . '" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i></a>
                            
                            <a href="javascript:excluir('.$id.')" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i></a>
                        </td>
                    </tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<script>

    //função para perguntar se deseja excluir. Se sim, direcionar para o endereço de exclusão
    function excluir ( id ) {
        //perguntar
        if (confirm ("Deseja mesmo excluir?")){
            //direcionar para exclusão
            location.href="excluir/tipo/"+id;
        }
    }

    $(document).ready(function() {
        $("#tabTipo").DataTable({
            "language": {
				"search": "Buscar",
                "lengthMenu": "Mostrar _MENU_ tipos por página",
                "zeroRecords": "Não encontramos nada :( ",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Não tem nada aqui :( ",
                "infoFiltered": "(filtrado de _MAX_  no total)",
                "paginate": {
                    "first":      "Primeira",
                    "last":       "Ultima",
                    "next":       ">>",
                    "previous":   "<<"
            }
            }
        });
	})
</script>