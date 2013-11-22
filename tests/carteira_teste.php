<?php

include('../init.php');

$cobranca = new Sloth_Carteira_ItauCarteira104;

echo $cobranca->indice . PHP_EOL;
echo $cobranca->descricao . PHP_EOL;


function salvarNoBanco($array_de_fora)
{
    /**
     * Faça aqui a sua função de callback para cada linha
     */

}

$file = 'files/retorno_cnab240conv6.ret';
$evento = 'salvarNoBanco';

$result = $cobranca->processarRetorno($file, $evento);

if($result)
{
    echo "Arquivo processado com sucesso.";
} else {
    echo "Arquivo apresentou problemas na sua execução e/ou não pode ser salvo.";
}

echo PHP_EOL;
