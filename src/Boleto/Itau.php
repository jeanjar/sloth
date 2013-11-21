<?php

class Boleto_Itau extends Boleto
{
    public function __construct()
    {
        parent::__construct();
        $this->dadosBoletoRequeridos = array_merge($this->dadosBoletoRequeridos, ['especie']);
     
    }

    public function configurarBoleto($dadosBoleto = array())
    {
        $chaves_requeridas = array_diff_key(array_flip($this->dadosBoletoRequeridos), $dadosBoleto);

        $this->dadosBoleto = $dadosBoleto;
        $this->formatarValores();

        return array_keys($chaves_requeridas);  
    }

    private function formatarValores()
    {
        if(empty($this->dadosBoleto))
        {
            return false;
        }

        $this->dadosBoleto['banco_codigo_dv'] = $this->gerarCodigoBancoComDigitoVerificador($this->dadosBoleto['banco_codigo']);
        $this->dadosBoleto['fator_vencimento'] = $this->gerarFatorVencimento($this->dadosBoleto['data_vencimento']); 
        $this->dadosBoleto['valor_boleto'] = $this->acolchoarNumero($this->dadosBoleto['valor_boleto'], 10, 0);
    }

    function geraCodigoBancoComDigitoVerificador($numero) {
        $parte1 = substr($numero, 0, 3);
        $parte2 = $this->modulo11($parte1);
        return $parte1 . "-" . $parte2;
    }
} 
