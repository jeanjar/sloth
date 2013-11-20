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

        $this->dadosBanco['banco_codigo_dv'] = $this->gerarCodigoBancoComDigitoVerificador($this->dadosBanco['banco_codigo']);
        $this->dadosBanco['fator_vencimento'] = $this->gerarFatorVencimento($this->dadosBanco['data_vencimento']); 
        
    }
} 
