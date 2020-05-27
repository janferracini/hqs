<?php
//verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
    exit;
}
include "functions.php";

if (!isset($id)) {
    $id = "";
} //cria a id se não existir
$titulo = $data = $numero = $resumo =  $capa = $valor = $tipo_id = $editora_id = $imagem = $tipo = $nome = '';

// Verificar se existe um id
if (!empty($id)) {
    // Selecionar os dados do banco
    $sql = "SELECT q.id, q.titulo, date_format(q.data, '%d/%m/%Y') dt,
                        q.numero, q.resumo, q.capa, q.valor, q.tipo_id, q.editora_id,
                        t.tipo,
                        e.nome
                FROM quadrinho q
                inner join editora e on (e.id = q.editora_id)
                inner join tipo t on (q.tipo_id = t.id)
                WHERE q.id = :id LIMIT 1";

    $consulta = $pdo->prepare($sql);

    $consulta->bindParam(":id", $id); //segurança

    // id - linha 255 do index.php
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    // Separar os dados
    $id         = $dados->id;
    $titulo     = $dados->titulo;
    $data       = $dados->dt;
    $numero     = $dados->numero;
    $resumo     = $dados->resumo;
    $capa       = $dados->capa; //apenas o valor
    $valor      = number_format($dados->valor, 2, ",", ".");
    $tipo_id    = $dados->tipo_id;
    $editora_id = $dados->editora_id;
    $nome    = $dados->nome;
    $tipo       = $dados->tipo;

    $imagem     = "../fotos/" . $capa . "p.jpg"; //foto
} else
    $id = '';
?>

<div class="container">
    <h1 class="float-left">Cadastro de Quadrinho <?=$id?></h1>
    <div class="float-right">
        <a href="cadastro/quadrinho" class="btn btn-success">Novo Registro</a>
        <a href="listar/quadrinho" class="btn btn-info">Listar Registro</a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->

    <form action="salvar/quadrinho" name="formCadastro" method="post" data-parsley-validate enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 col-md-2">
                <label for="id">ID</label>
                <input type="text" readonly class="form-control" name="id" id="id" value="<?= $id ?>">
            </div>
            <div class="col-12 col-md-10">
                <label for="titulo">Título do Quadrinho</label>
                <input type="text" class="form-control" name="titulo" id="titulo" required data-parsley-required-message="Preencha o campo" value="<?= $titulo ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="tipo_id">Tipo de Quadrinho</label>
                <select name="tipo_id" id="tipo_id" class="form-control" required data-parsley-required-message="Selecione uma opção">
                    <option value="">
                        <?php 
                            if(!empty($tipo)){ 
                            echo $tipo;
                        } ?>
                    </option>

                    <?php
                    $sql = "SELECT id, tipo
                    FROM tipo
                    ORDER BY tipo";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
                        //separar os dados
                        $tipo_id     = $d->id;
                        $tipo   = $d->tipo;

                        echo '<option value="' . $tipo_id . '">' . $tipo . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-12 col-md-6">
                <!-- Listagem da Editora -->
                <label for="editora_id">Editora</label>
                <input type="text" name="editora_id" id="editora_id" class="form-control" list="listaEditoras"
                data-parsley-required-message="Selecione uma editora" value="<?php
                    if (!empty($editora_id)) {
                        echo "$nome - $editora_id";
                    }
                    ?>">
                <datalist id="listaEditoras">
                    <?php
                    $sql = "SELECT id, nome
                            FROM editora
                            ORDER BY nome";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
                        //separar os dados
                        $editora_id = $d->id;
                        $nome       = $d->nome;

                        echo '<option value=" ' . $nome . ' - ' . $editora_id . '">';
                    };
                    ?>
                </datalist>
            </div>

            <div class="col-12 col-md-3">
                <!-- CADASTRA O NUMETO DA EDIÇÃO -->
                <label for="numero">Número da Edição</label>
                <input type="text" name="numero" id="numero" class="form-control" required data-parsley-required-message="Preencha esse campo" value="<?= $numero ?>">
            </div>
            <!-- CADASTRA A DATA DE NASCIMENTO -->
            <div class="col-12 col-md-3">
                <label for="data">Data de Lançamento</label>
                <input type="text" id="data" name="data" class="form-control" required data-parsley-required-message="Preencha esse campo" value="<?= $data ?>">
            </div>
            <div class="col-12 col-md-3">
                <!-- CADASTRA O VALOR -->
                <label for="valor">Valor</label>
                <input type="text" id="valor" name="valor" class="form-control" required data-parsley-required-message="Preencha esse campo" value="<?= $valor ?>">
            </div>

            <div class="col-12 col-md-10">
                <!-- CADASTRA O RESUMO -->
                <label for="resumo">Resumo / Descrição</label>
                <textarea type="text" name="resumo" id="resumo" class="form-control" required data-parsley-required-message="Preencha esse campo"><?= $resumo ?></textarea>
            </div>

            <!-- CADASTRO DA CAPA -->
            <div class="col-12 col-md-12">
                <?php
                $r = 'required data-parsley-required-message="Selecione uma foto"';
                //vai mostrar que o campo é requirido por padrão, a não ser que seja uma edição 
                //se não tiver vazio o ID, quer dizer que é inserção e não aparece o required
                if (!empty($id)) $r = '';
                ?>

                <label for="capa">Capa</label>
                <!-- guarda o nome da capa para quando editar -->
                <input type="hidden" name="capa" value="<?= $capa; ?>">
                <input type="file" name="capa" id="capa" class="form-control" accept=".jpeg, .jpg" <?= $r; ?>>
                <?php
                if (!empty($capa)) {
                    echo "<img src='$imagem' alt='$titulo' width='100px'>";
                }
                ?>
            </div>
            <button type="submit" class="btn btn-success margin">
                <i class="fas fa-check"></i> Gravar Dados
            </button>
    </form>


</div>

<script>
    $(document).ready(function() {
        $('#resumo').summernote();

        $('#valor').maskMoney({
            thousands: ".",
            decimal: ",",
            //prefix: "R$ "
        });

        $("#data").inputmask("99/99/9999");
        $("#numero").inputmask("9999");
    });
</script>