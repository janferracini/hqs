<?php
//verificar se não está logado
    if (!isset($_SESSION["hqs"]["id"])) {
        exit;
    }
    include "functions.php";

    if (!isset($id)) $id = "";
    $titulo = $site = $data = $numero = $tipo =$resumo =  '';

    // Verificar se existe um id
    if (!empty($id)) {
        // Selecionar os dados do banco
        $sql = "SELECT * 
                FROM quadrinho 
                WHERE id = ? 
                LIMIT 1";

        $consulta = $pdo->prepare($sql);

        $consulta->bindParam(1, $id); //segurança

        // id - linha 255 do index.php
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        // Separar os dados
        $id = $dados->id;
        $titulo = $dados->titulo;
    } else {
        $id = '';
    }
?>

<div class="container">
    <h1 class="float-left">Cadastro de Quadrinho</h1>
    <div class="float-right">
        <a href="cadastro/quadrinho" class="btn btn-success">Novo Registro</a>
        <a href="listar/quadrinho" class="btn btn-info">Listar Registro</a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->

    <form action="salvar/quadrinho" name="formCadastro" method="post"
        data-parsley-validate enctype="multipart/form-data">

        <label for="id">ID</label>
        <input type="text" class="form-control" name="id" id="id" readonly value="<?= $id ?>">

        <label for="titulo">Título do Quadrinho</label>
        <input type="text" class="form-control" name="titulo" id="titulo"
            required data-parsley-required-message="Preencha o campo" value="<?= $titulo ?>">

        <label for="tipo_id">Tipo de Quadrinho</label>
        <select name="tipo_id" id="tipo_id" class="form-control"
            required data-parsley-required-message="Selecione uma opção">
            <option value=""></option>
            <?php
            $sql = "SELECT id, tipo
                    FROM tipo
                    ORDER BY tipo";
            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
                //separar os dados
                $id     = $d->id;
                $tipo   = $d->tipo;

                echo '<option value="' . $id . '">' . $tipo . '</option>';
            }
            ?>
        </select>

        <label for="editora_id">Editora</label>
        <input type="text" name="editora" id="">
            <datalist id="listaEditoras">
                <?php
                    $sql = "SELECT id, nome
                            FROM editora
                            ORDER BY nome";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
                        //separar os dados
                        $id     = $d->id;
                        $nome   = $d->nome;

                        echo "<option value='".$id." - "." $titulo'> </option>"; // ********************************************
                    };
                ?>
            </datalist>




        <select name="editora_id" id="editora_id" class="form-control"
            required data-parsley-required-message="Selecione uma opção">
            <option value=""></option>
            <?php
                $sql = "SELECT id, nome
                        FROM editora
                        ORDER BY nome";
                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
                    //separar os dados
                    $id     = $d->id;
                    $nome   = $d->nome;

                    echo '<option value="' . $id . '">' . $nome . '</option>';
                }
            ?>
        </select>
        
        <!-- CADASTRO DA CAPA -->
        <?php
            $r = 'required data-parsley-required-message="Selecione uma foto"';

            if (empty ($id) ) $r = '';
        ?>

        <label for="capa">Capa</label>
        <input type="file" name="capa" id="capa" class="form-control" accept=".jpg, .jpeg" <?php $r; ?> >
        <input type="hidden" name="capa" value="<?$capa?>">

        <label for="numero">Número da Edição</label>
        <input type="text" name="numero" id="numero" class="form-control" required
                data-parsley-required-message="Preencha esse campo">

        <label for="data">Data de Lançamento</label>
        <input type="text" id="data" name="data" class="form-control" required
                data-parsley-required-message="Preencha esse campo">

        <label for="valor">Valor</label>
        <input type="text" id="valor" name="valor" class="form-control" required
                data-parsley-required-message="Preencha esse campo">

        <label for="resumo">Resumo / Descrição</label>
        <textarea type="text" name="resumo" id="resumo" class="form-control" required
                data-parsley-required-message="Preencha esse campo"></textarea>

        <button type="submit" class="btn btn-success margin">
            <i class="fas fa-check"></i> Gravar Dados
        </button>
    </form>

</div>

<script>
    $(document).ready(function(){
        $('#resumo').summernote();

        $('#valor').maskMoney({
            thousands:".",
            decimal:",",
            //prefix: "R$ "
        });

        $("#data").inputmask("99/99/9999");
        $("#numero").inputmask("9999");
    });
</script>