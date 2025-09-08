<?php

require "src/DB.php";
require "src/Modelo/Produto.php";
require "src/Repositorio/ProdutoRepositorio.php";

$produtoRepositorio = new ProdutoRepositorio();
$produtoRepositorio->deletar($_POST['id']);

header("Location: admin.php");