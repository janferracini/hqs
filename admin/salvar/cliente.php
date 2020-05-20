<?php
//verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
	exit;
}

//verificar se existem dados no POST
if ($_POST) {

}

echo '<script>alert("Erro ao realizar requisição");history.back();</script>';