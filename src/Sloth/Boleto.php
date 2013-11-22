<?php

class Sloth_Boleto
{
    public $boleto_template;
    public $dadosBoleto;
    public $dadosBoletoRequeridos = array(
        'nosso_numero',
        'data_vencimento',
        'valor_boleto',
        'data_documento',
        'pagador',
        'pagador_endereco',
        'pagador_instrucoes',
        'beneficiario',
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
        ob_start();
        include('Boleto/templates/' . $this->template . '.phtml');
        echo ob_get_clean();
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

        $resto = $soma % 11;
        
        if($resto)
        {
            return $resto;
        }

        $digito = abs(11 - $resto);
        return $digito;
    }

    public function modulo10($numero, $base, $resto = false)
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
            } else {
                $fator = 2;
            }
        }

        $resto = $soma % 10;

        if($resto)
        {
            return $resto;
        }

        $digito = abs(10 - $resto);

        return $digito;
        
    }

}
