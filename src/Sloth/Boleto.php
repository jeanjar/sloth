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
        'pagador_demonstrativo',
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
        /*$data_vencimento = date('Y-m-d', strtotime($data_vencimento));
        $data_vencimento = strtotime($data_vencimento);

        $date = strtotime("1997-10-07");

        $datediff = abs($data_vencimento - $date);

        return floor($datediff / (60*60*24));*/
	    $data = explode("/",$data_vencimento); 
	    $ano = $data[2];
	    $mes = $data[1];
	    $dia = $data[0];
        return(abs(($this->_dateToDays("1997","10","07")) - ($this->_dateToDays($ano, $mes, $dia))));
     }

	public function _dateToDays($year,$month,$day) {
	    $century = substr($year, 0, 2);
	    $year = substr($year, 2, 2);
	    if ($month > 2) {
		    $month -= 3;
	    } else {
		    $month += 9;
		    if ($year) {
		        $year--;
		    } else {
		        $year = 99;
		        $century--;
		    }
	    }
	    return ( floor((  146097 * $century)    /  4 ) +
		    floor(( 1461 * $year)        /  4 ) +
		    floor(( 153 * $month +  2) /  5 ) +
			$day +  1721119);
	}
        
    public function modulo11($numero, $base, $retorne_resto = false)
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
        
        if($retorne_resto)
        {
            return $resto;
        }
        $digito = abs(11 - $resto);
                
        return $digito;
    }

    public function modulo10($numero, $base, $retorno_resto = false)
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

        if($retorno_resto)
        {
            return $resto;
        }

        $digito = abs(10 - $resto);

        return $digito;
        
    }

}
