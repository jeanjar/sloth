<?php

include('../init.php');

$carteira = new Sloth_Carteira_BrasilCarteira18(['assets' => Sloth_Config::BOLETO_ASSETS,'rel_path' => Sloth_Config::REL_PATH]);
$carteira->convenio = 2624780;

$dadosBoleto = array(
'nosso_numero' => '1',
'data_vencimento' => '25/11/2013',
'valor_boleto' => '12,90',
'data_documento' => '22/11/2013',
'pagador' => 'Stefan Yohansson da Silva Areeira Pinto',
'pagador_identificador' => '068.627.124-62',
'pagador_endereco' => array('Rua Palhinhas, 124', 'CEP: 59151-120'),
'pagador_instrucoes' => array('Não recebemos após o vencimento'),
'pagador_demonstrativo' => array('Adesão', 'Parcela: 1/1'),
'beneficiario' => 'TESTE - ME',
'beneficiario_agencia' => '9314',
'beneficiario_conta' => '29429',
'beneficiario_dv_conta' => '2',
'identificacao' => 'Boleto Itaú - TESTE - ME',
'beneficiario_cpf_cnpj' => '17.560.249/0006-20',
'beneficiario_endereco' => array('RUA DE TESTE'),
'beneficiario_cidade_estado' => 'NATAL / RN',
'especie' => 'R$',
'beneficiario_razao_social' => 'TESTE',
'aceite' => 'N',
'especie_doc' => 'DM',
'numero_documento' => '84001123456',
'contrato' => '19.246.846',
);

echo $carteira->gerarBoleto($dadosBoleto);

