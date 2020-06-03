<?php
    //verificar se não está logado
    if ( !isset ($_SESSION["hqs"]["id"] ) ) {
        exit;
    }
?>

<div class="container">
    <h1 class="float-left">Listar Editora</h1>
    <div class="float-right">
        <a href="cadastro/editora" class="btn btn-success">Novo Registro</a>
        <a href="listar/editora" class="btn btn-info">Listar Registros</a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover" id="tabEditoras">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome da Editora</th>
                <th>Site da Editora</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Buscar as editoras alfabeticamente
            $sql = "SELECT * FROM editora ORDER BY nome";
            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                // Separar os dados
                $id = $dados->id;
                $nome = $dados->nome;
                $site = $dados->site;

                // Mostrar na tela
                echo '<tr>
                        <td>' . $id . '</td>
                        <td>' . $nome . '</td>
                        <td>' . $site . '</td>
                        <td><a href="cadastro/editora/' . $id . '" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i> </a>

                            <!-- inserção do btn deletar - insere a função de excluir, desse modo, aparece no rodapé a função
                            <a href="javascript:excluir  ('.$id.')" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i></a>
                            -->
                            
                            <button type="button" class="btn btn-danger btn-sm" onclick="excluir('.$id.')">
                                <i class="fas fa-trash"></i></a>
                            </button>
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
            location.href="excluir/editora/"+id;
        }
    }

    $(document).ready(function() {
        $("#tabEditoras").DataTable({
            "language": {
                "search": "Buscar",
                "lengthMenu": "Listar _MENU_ editoras por página",
                "zeroRecords": "Não encontramos nada :( ",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Não tem nada aqui :( ",
                "infoFiltered": "(no total de _MAX_ registros)",
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