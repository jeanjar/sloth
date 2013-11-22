<?php

include('../init.php');

$carteira = new Sloth_Carteira_ItauCarteira104;

$dadosBoleto = array(
'nosso_numero' => '1',
'data_vencimento' => '10/12/2013',
'valor_boleto' => '19,90',
'data_documento' => '20/11/2013',
'pagador' => 'Stefan Yohansson',
'pagador_endereco' => array('todo doido'),
'pagador_instrucoes' => array('todo torto'),
'beneficiario' => 'Stepmoney Brasil',
'beneficiario_agencia' => '34234',
'beneficiario_conta' => '324324',
'beneficiario_dv_conta' => '2',
'identificacao' => 'Nome do cidadão',
'beneficiario_cpf_cnpj' => '068.627.124-62',
'beneficiario_endereco' => array('Rua Parraguaçu, 123'),
'beneficiario_cidade_estado' => 'Natal / RN',
'especie' => 'R$',
'beneficiario_razao_social' => 'Stepmoney',
);

echo $carteira->gerarBoleto($dadosBoleto);

