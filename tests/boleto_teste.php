<?php

include('../init.php');

$boleto = new Boleto_Itau;

$dadosBoleto = array(
'nosso_numero' => '3412',
'data_vencimento' => '10/12/2013',
'valor_documento' => '19,90',
'data_documento' => '20/11/2013',
'pagador' => 'Stefan Yohansson',
'pagador_endereco' => array('todo doido'),
'pagador_instrucoes' => array('todo torto'),
'beneficiario_agencia' => '34234',
'beneficiario_conta' => '324324',
'beneficiario_dv_conta' => '2',
'identificacao' => '',
'beneficiario_cpf_cnpj' => '',
'beneficiario_endereco' => array(),
'beneficiario_cidade_estado' => 'Natal / RN',
//'especie' => 'R$',
//'beneficiario_razao_social' => 'Stepmoney',
);

/*
$dadosBoleto = array(
    'data_vencimento' => '19/08/1993',
    'valor_boleto' => '199,99',
    'agencia' => '1668',
    'dv_agencia' => '3',
    'conta' => '38366',
    'dv_conta' => 'X',
    'pagador' => '',
);
 */

$boleto->configurarBoleto($dadosBoleto);
$boleto->renderizar();
