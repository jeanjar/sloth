<?php

class Boleto extends Carteira
{
    public $boleto_template;
    public static $dadosBoletoRequeridos = array(
        'nosso_numero',
        'data_vencimento',
        'valor_documento',
        'data_documento',
        'pagador',
        'endereco',
        'instrucoes'
    );

    public function __construct()
    {
        parent::__construct();
    }

}
