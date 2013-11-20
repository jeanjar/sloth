<?php

include('../init.php');

$boleto = new Boleto_ItauBoleto;

$dadosBoleto = array(
    'data_vencimento' => '19/08/1993',
    'valor_boleto' => '199,99',
    'agencia' => '1668',
    'dv_agencia' => '3',
    'conta' => '38366',
    'dv_conta' => 'X',
    'pagador' => '',
);

$boleto->configurarBoleto($dadosBoleto);
$boleto->renderizar();
