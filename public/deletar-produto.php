<?php

require "../src/Database/DB.php";
require "../src/Model/Product.php";
require "../src/Repository/RepositoryProduct.php";

$repositoryProducts = new RepositoryProduct();
$repositoryProducts->delete($_POST['id']);

header("Location: admin.php");