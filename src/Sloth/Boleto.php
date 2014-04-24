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

    public function renderizar($template = null, $arquivo = null)
    {
    	if(!$arquivo)
    	{
    		$arquivo = $this->template . '.phtml';
    	}
    	if(!$template)
    	{
    		$template = 'Boleto/templates/';
    	}
    	//var_dump($template . $arquivo);die;
        ob_start();
        	include($template . $arquivo);
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
        
    public function modulo11($num, $base, $retorne_resto = false)
    {
        $soma = 0;
        $fator = 2;

        /* Separacao dos numeros */
        for ($i = strlen($num); $i > 0; $i--)
        {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo falor
            $parcial[$i] = $numeros[$i] * $fator;
            // Soma dos digitos
            $soma += $parcial[$i];
            if ($fator == $base)
            {
                // restaura fator de multiplicacao para 2
                $fator = 1;
            }
            $fator++;
        }

        /* Calculo do modulo 11 */
        if ($retorne_resto == 0)
        {
            $soma *= 10;
            $digito = $soma % 11;
            if ($digito == 10)
            {
                $digito = 0;
            }
            return $digito;
        }
        elseif ($retorne_resto == 1)
        {
            $resto = $soma % 11;
            return $resto;
        }
    }

    public function modulo10($num, $base, $retorno_resto = false)
    {
        $numtotal10 = 0;
        $fator = 2;

        // Separacao dos numeros
        for ($i = strlen($num); $i > 0; $i--)
        {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo (falor 10)
            // 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Itaú
            $temp = $numeros[$i] * $fator;
            $temp0 = 0;
            foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v)
            {
                $temp0+=$v;
            }
            $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
            // monta sequencia para soma dos digitos no (modulo 10)
            $numtotal10 += $parcial10[$i];
            if ($fator == 2)
            {
                $fator = 1;
            }
            else
            {
                $fator = 2; // intercala fator de multiplicacao (modulo 10)
            }
        }

        // várias linhas removidas, vide função original
        // Calculo do modulo 10
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0)
        {
            $digito = 0;
        }

        return $digito;
    }

}
