<?php
include '../init.php';

$banco = new Banco_Itau;

echo $banco->nome . PHP_EOL;
echo $banco->info . PHP_EOL;

?>
