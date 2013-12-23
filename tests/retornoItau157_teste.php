<?php

include('../init.php');
ini_set('date.timezone', 'America/Recife');


function salvarNoBanco($array_de_fora)
{
    var_dump($array_de_fora);

}

$file = 'files/insira_aqui_seu_retorno_itau_carteira_157.RET';
$evento = 'salvarNoBanco';
$retorno = new Sloth_Retorno_CNAB240Itau($file, $evento);
$retorno->processar();

