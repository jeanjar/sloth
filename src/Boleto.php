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

    public function gerarFatorVencimento($data_vencimento)
    {
        $data_vencimento = date('Y-m-d', strtotime($data_vencimento));
        $data_vencimento = strtotime($data_vencimento);

        $date = strtotime("1997-10-07");

        $datediff = abs($data_vencimento - $date);

        return floor($datediff / (60*60*24));
    }

    public function modulo11($numero, $base, $resto = false)
    {
        $soma = 0;
        $fator = 2;
        $numero_reverso = str_split(strrev($numero));

        foreach($numero_reverso as $numeral)
        {
            $soma += $numeral * $fator;

            if($fator == $base)
            {
                $fator = 1;
            }
            $fator++;
        }
        
        $soma *= 10;
        $digito = ($soma % 11) == 10 ? $soma % 11 : 0;

        if($resto)
        {
            $resto = $soma % 11;
            return $resto;
        }

        return $digito;
    }

}
