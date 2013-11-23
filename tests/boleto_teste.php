<?php

include('../init.php');

$carteira = new Sloth_Carteira_ItauCarteira104;

$dadosBoleto = array(
'nosso_numero' => '1',
'data_vencimento' => '25/11/2013',
'valor_boleto' => '19,90',
'data_documento' => '22/11/2013',
'pagador' => 'Stefan Yohansson da Silva Areeira Pinto',
'pagador_endereco' => array('Rua Parraguaçu, 124', 'CEP: 59151-140'),
'pagador_instrucoes' => array('Não recebemos após o vencimento'),
'pagador_demonstrativo' => array('Adesão Cartão', 'Parcela: 1/1'),
'beneficiario' => 'STEPMONEY BRASIL LTDA - ME',
'beneficiario_agencia' => '9314',
'beneficiario_conta' => '29269',
'beneficiario_dv_conta' => '2',
'identificacao' => 'Boleto Itaú - STEPMONEY BRASIL LTDA - ME',
'beneficiario_cpf_cnpj' => '17.660.609/0001-90',
'beneficiario_endereco' => array('RUA CEL. MIGUEL ARCANJO GALVÃO, 1950 - SALA 305 - LAGOA NOVA'),
'beneficiario_cidade_estado' => 'NATAL / RN',
'especie' => 'R$',
'beneficiario_razao_social' => 'Stepmoney',
);

echo $carteira->gerarBoleto($dadosBoleto);

