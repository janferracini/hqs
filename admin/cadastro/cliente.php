<?php
//verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
    exit;
}

    if (!isset($id)) $id = '';

    $nome = $cpf = $datanascimento = $email = $senha = $cep = $endereco = $complemento = $bairro = $cidade_id = $foto = $telefone = $celular = '';
?>
<div class="container">
    <h1 class="float-left">Cadastro de Cliente</h1>
    <div class="float-right">
        <a href="cadastro/cliente" class="btn btn-success">Novo Registro</a>
        <a href="listar/cliente" class="btn btn-info">Listar Registro</a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->

    <form action="salvar/cliente" name="formCadastro" method="post" data-parsley-validate enctype="multipart/form-data">
        <div class="row">

        <!-- PRIMEIRA LINHA -->
            <div class="col-12 col-md-2">
                <label for="id">ID</label>
                <input type="text" class="form-control" name="id" id="id" readonly value="<?= $id ?>">
            </div>
            <div class="col-12 col-md-10">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control"
                        required data-parsley-required-message="Preencha o campo nome" value="<?= $nome ?>"
                        placeholder="Digite seu nome completo">
            </div>

            <!-- SEGUNDA LINHA -->
            <div class="col-12 col-md-4">
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" id="cpf" class="form-control"
                        required data-parsley-required-message="Preencha o campo CPF" value="<?= $cpf ?>"
                        placeholder="Digite seu CPF">
            </div>
            <div class="col-12 col-md-4">
                <label for="datanascimento">Data de Nascimento:</label>
                <input type="text" name="datanascimento" id="datanascimento" class="form-control"
                        required data-parsley-required-message="Preencha a data de nascimento" value="<?= $datanascimento ?>"
                        placeholder="Digite a data de nascimento">
            </div>

            <div class="col-12 col-md-4">
                <label for="foto">Foto:</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>

            <!-- TERCEIRA LINHA -->
            <div class="col-12 col-md-12">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control"
                        required data-parsley-required-message="Preencha o email" value="<?= $email ?>"
                        placeholder="Digite seu email" data-parsley-type-message="Digite um e-mail válido">
            </div>

            <!-- QUARTA LINHA -->
            <div class="col-12 col-md-6">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" class="form-control"
                        required data-parsley-required-message="Preencha a senha" value="<?= $senha ?>"
                        placeholder="Digite a senha">
            </div>
            <div class="col-12 col-md-6">
                <label for="senha">Confirme sua Senha:</label>
                <input type="password" name="senha" id="senha" class="form-control"
                        required data-parsley-required-message="Preencha a senha" value="<?= $senha ?>"
                        placeholder="Digite a senha">
            </div>
            
            <!-- QUINTA LINHA -->
            <div class="col-12 col-md-4">
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" class="form-control"
                        required data-parsley-required-message="Preencha o telefone" value="<?= $telefone ?>"
                        placeholder="Digite seu telefone">
            </div>
            <div class="col-12 col-md-4">
                <label for="celular">Celular:</label>
                <input type="text" name="celular" id="celular" class="form-control"
                        value="<?= $celular ?>"
                        placeholder="Digite o celular">
            </div>

            <div class="col-12 col-md-4">
                <label for="cep">CEP:</label>
                <input type="text" name="cep" id="cep" class="form-control"
                        required data-parsley-required-message="Preencha o cep" value="<?= $cep ?>"
                        placeholder="Digite seu cep">
            </div>

            <!-- SEXTA LINHA -->
            <div class="col-12 col-md-12">
                <label for="endereco">endereco:</label>
                <input type="text" name="endereco" id="endereco" class="form-control"
                        required data-parsley-required-message="Preencha o endereco" value="<?= $endereco ?>"
                        placeholder="Digite o endereco">
            </div>

            <!-- SETIMA LINHA -->
            <div class="col-12 col-md-4">
                <label for="complemento">complemento:</label>
                <input type="text" name="complemento" id="complemento" class="form-control"
                        value="<?= $complemento ?>"
                        placeholder="Digite seu complemento">
            </div>
            <div class="col-12 col-md-4">
                <label for="bairro">bairro:</label>
                <input type="text" name="bairro" id="bairro" class="form-control"
                        required data-parsley-required-message="Preencha o bairro" value="<?= $bairro ?>"
                        placeholder="Digite o bairro">
            </div>

            <div class="col-12 col-md-4">
                <label for="cidade">Cidade:</label>
                <input type="text" name="cidade" id="cidade" class="form-control"
                        required data-parsley-required-message="Preencha o cidade" value="<?= $cidade_id ?>"
                        placeholder="Digite seu cidade">
            </div>


        </div>

        <button type="submit" class="btn btn-success margin">
            <i class="fas fa-check"></i> Gravar Dados
        </button>

    </form>

    <script>
        $(document).ready(function(){
            $("#datanascimento").inputmask("99/99/9999");
            $("#cpf").inputmask("999.999.999-99");
            $("#telefone").inputmask("(99) 9999-9999");
            $("#celular").inputmask("(99) 99999-9999");
            $("#cep").inputmask("99.999-999");


        });
    </script>

</div>