<?php
require "vendor/autoload.php";
require "src/DB.php";
require "src/Modelo/Produto.php";
require "src/Repositorio/ProdutoRepositorio.php";

use Dompdf\Dompdf;

$produtoRepositorio = new ProdutoRepositorio();
$produtos = $produtoRepositorio->buscarTodos();

$css = file_get_contents(__DIR__ . '/css/pdf.css');

$html = '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
    <style>' . $css . '</style>
</head>
<body>
    <h1 class="container-admin-banner">Lista de Produtos</h1>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Tipo</th>
                <th>Descrição</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>';

foreach ($produtos as $produto) {
    $html .= '
            <tr>
                <td>' . htmlspecialchars($produto->getNome()) . '</td>
                <td>' . htmlspecialchars($produto->getTipo()) . '</td>
                <td>' . htmlspecialchars($produto->getDescricao()) . '</td>
                <td>' . htmlspecialchars($produto->getPrecoFormatado()) . '</td>
            </tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("produtos.pdf", ["Attachment" => false]);
