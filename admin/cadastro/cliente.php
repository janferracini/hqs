<?php
//verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
    exit;
}

if (!isset($id)) $id = "";

$nome = $cpf = $datanascimento = $email = $senha = $cep = $endereco = $complemento = $bairro = $cidade_id = $nome_cidade = $foto = $telefone = $celular = $estado = '';
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

<!-- PRIMEIRA LINHA ID e Nome-->
            <div class="col-12 col-md-2">
                <label for="id">ID</label>
                <input type="text" class="form-control" name="id" id="id" readonly value="<?= $id ?>">
            </div>
            <div class="col-12 col-md-10">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Preencha o campo nome" value="<?= $nome ?>" placeholder="Digite seu nome completo">
            </div>

<!-- SEGUNDA LINHA CPF, Nascimento e Foto -->
            <div class="col-12 col-md-4">
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" id="cpf" class="form-control"
                required data-parsley-required-message="Preencha o campo CPF" value="<?= $cpf ?>"
                placeholder="Digite seu CPF" onblur="verificarCpf(this.value)">
            </div>
            <div class="col-12 col-md-4">
                <label for="datanascimento">Data de Nascimento:</label>
                <input type="text" name="datanascimento" id="datanascimento" class="form-control" required data-parsley-required-message="Preencha a data de nascimento" value="<?= $datanascimento ?>" placeholder="Digite a data de nascimento">
            </div>

            <div class="col-12 col-md-4">
                <label for="foto">Foto(.jpg):</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>

<!-- TERCEIRA LINHA E-mail e Senha-->
            <div class="col-12 col-md-4">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control" required data-parsley-required-message="Preencha o email" value="<?= $email ?>" placeholder="Digite seu email" data-parsley-type-message="Digite um e-mail válido">
                <!-- data-parsley-type-message para mensagem por TIPO, no caso, e-mail -->
            </div>
            <div class="col-12 col-md-4">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite a senha">
            </div>
            <div class="col-12 col-md-4">
                <label for="senha">Confirme sua Senha:</label>
                <input type="password" name="senha2" id="senha2" class="form-control" placeholder="Digite a senha novamente">
            </div>

<!-- QUARTA LINHA Telefone e Celular-->

            <div class="col-12 col-md-6">
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" class="form-control" value="<?= $telefone ?>" placeholder="Digite seu telefone (00) 0000-0000">
            </div>
            <div class="col-12 col-md-6">
                <label for="celular">Celular:</label>
                <input type="text" name="celular" id="celular" class="form-control" required data-parsley-required-message="Preencha o telefone" value="<?= $celular ?>" placeholder="Digite o celular (00)00000-0000">
            </div>

<!-- QUINTA LINHA CEP, Cidade e Estado-->

            <div class="col-12 col-md-4">
                <label for="cep">CEP:</label>
                <input type="text" name="cep" id="cep" class="form-control" required data-parsley-required-message="Preencha o CEP" value="<?= $cep ?>" placeholder="Digite seu CEP">
            </div>

            <div class="col-12 col-md-4" hidden>
                <label for="cidade_id" hidden>ID Cidade:</label>
                <input type="text" name="cidade_id" id="cidade_id" class="form-control"
                readonly hidden data-parsley-required-message="Preencha o cidade" value="<?= $cidade_id ?>"
                placeholder="Digite seu cidade">
            </div>

            <div class="col-12 col-md-4">
                <label for="nome_cidade">Nome da Cidade:</label>
                <input type="text" id="nome_cidade" class="form-control"
                readonly data-parsley-required-message="Preencha a cidade" value="<?= $nome_cidade ?>"
                placeholder="Digite seu cidade"> 
                <!-- Sem name para não ir com o POST -->
            </div>
            <div class="col-12 col-md-4">
                <label for="estado">Estado:</label>
                <input type="text" id="estado" class="form-control"
                required data-parsley-required-message="Preencha o estado" value="<?= $estado ?>"
                placeholder="Digite o Estado">
            </div>

<!-- SEXTA LINHA Endereço, Complemento e Bairro-->
            <div class="col-12 col-md-12">
                <label for="endereco">Endereco:</label>
                <input type="text" name="endereco" id="endereco" class="form-control"
                required data-parsley-required-message="Preencha o endereco" value="<?= $endereco ?>"
                placeholder="Digite o endereco">
            </div>
            <div class="col-12 col-md-6">
                <label for="complemento">Número e Complemento:</label>
                <input type="text" name="complemento" id="complemento" class="form-control"
                value="<?= $complemento ?>" placeholder="Digite o número da casa e o complemento">
            </div>

        <div class="col-12 col-md-6">
                <label for="bairro">Bairro:</label>
                <input type="text" name="bairro" id="bairro" class="form-control" required data-parsley-required-message="Preencha o bairro" value="<?= $bairro ?>" placeholder="Digite o bairro">
        </div>

        <button type="submit" class="btn btn-success margin">
            <i class="fas fa-check"></i> Gravar Dados
        </button>

    </form>
<!-- Scripts -->
    <?php
        //verificar se id é vazio
        if (empty ($id)) $id = 0;
    ?>
    <script>
        $(document).ready(function() {
            $("#datanascimento").inputmask("99/99/9999");
            $("#cpf").inputmask("999.999.999-99");
            $("#telefone").inputmask("(99) 9999-9999");
            $("#celular").inputmask("(99) 99999-9999");
            $("#cep").inputmask("99.999-999");
        });

        function verificarCpf(cpf) {
            //ajax verificação CPF
            //faz o get para o arquivo indicado e a variável e o retorno
            $.get("verificarCpf.php", {cpf:cpf, id:<?=$id;?>}, 
                function(dados){
                    if (dados != "") {
                        // retorno da mensagem da verificação de erro
                        alert(dados);
                        //zera o CPF
                        $("#cpf").val("");
                    }
                })
        }

        $("#cep").blur(function(){
            //pega valor do CEP
            cep = $("#cep").val();
            cep = cep.replace(/\D/g, '');
            if (cep == ""){
                alert ("Preencha o CEP");
            } else {

				//Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    $("#nome_cidade").val(dados.localidade);
                    $("#estado").val(dados.uf);
                    $("#endereco").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                })
            }
        })
    </script>

</div>