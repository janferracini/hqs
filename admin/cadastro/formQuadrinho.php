<?php
    if (!isset($pagina)) exit;

?>
<hr>

<form name="formPersonagem" action="adicionarPersonagem.php" method="POST" data-parsley-validate="" target="personagens">
    <h3>Adicionar Personagens</h3>

    <input type="hidden" name="quadrinho_id" value="<?=$id?>">
    <div class="row">
        <div class="col-8">
            <select name="personagem_id" id="personagem_id" class="form-control"
                    required dara-parsley-required-message="Selecione um personagem">
                    <option value="">Selecione um Personagem</option>
                    <?php
                        $sql = "SELECT id, nome FROM personagem ORDER BY nome";
                        $consulta = $pdo->prepare($sql);
                        $consulta->execute();

                        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                            //separar var
                            $id_personagem   = $dados->id;
                            $nome_personagem = $dados->nome;

                            echo "<option value='$id_personagem'>$nome_personagem</option>";
                        }
                    ?>
            </select>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-success">OK</button>
            <button type="reset" class="btn btn-danger">Novo</button>
            
        </div>
    </div>
</form>

<iframe name="personagens" width="100%" height="300px" src="adicionarPersonagem.php?quadrinho_id=<?=$id?>">
    
</iframe>
