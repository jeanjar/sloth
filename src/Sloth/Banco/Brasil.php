<?php

class Sloth_Banco_Brasil extends Sloth_Banco
{
    public $convenio;
    
    public function __construct($args)
    {
        parent::__construct($args);

        $this->banco_nome = 'Banco do Brasil';
        $this->banco_sigla = 'i';
        $this->banco_info = 'Informações adicionais sobre o banco';
        $this->banco_codigo = '001';
        $this->numero_moeda = 9;
    }

}
