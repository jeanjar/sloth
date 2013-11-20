<?php

class Boleto
{
    public $boleto_template;
    public $dadosBoleto;
    public $dadosBoletoRequeridos = array(
        'nosso_numero',
        'data_vencimento',
        'valor_documento',
        'data_documento',
        'pagador',
        'pagador_endereco',
        'pagador_instrucoes',
        'beneficiario_agencia',
        'beneficiario_conta',
        'beneficiario_dv_conta',
        'identificacao',
        'beneficiario_cpf_cnpj',
        'beneficiario_endereco',
        'beneficiario_cidade_estado',
        'beneficiario_razao_social',
    );

    public function __construct()
    {
    }

    public function renderizar()
    {

    }

}
