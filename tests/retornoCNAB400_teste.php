<?php

include('../init.php');


function salvarNoBanco($array_de_fora)
{
    var_dump($array_de_fora);

}

$file = 'files/RETORNOCEF050315.ret';
$evento = 'salvarNoBanco';
$retorno = new Sloth_Retorno_CNAB400_CEF($file, $evento);
$retorno->processar();
