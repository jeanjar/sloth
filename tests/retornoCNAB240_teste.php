<?php

include('../init.php');


function salvarNoBanco($array_de_fora)
{
    var_dump($array_de_fora);

}

$file = 'files/retorno_cnab240conv6.ret';
$evento = 'salvarNoBanco';
$retorno = new Retorno_CNAB240($file, $evento);
$retorno->processar();

