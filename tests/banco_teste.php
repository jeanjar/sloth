<?php
include '../init.php';

$banco = new Sloth_Banco_Itau;

echo $banco->banco_nome . PHP_EOL;
echo $banco->banco_info . PHP_EOL;

?>
