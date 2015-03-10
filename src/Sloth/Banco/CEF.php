<?php

class Sloth_Banco_CEF extends Sloth_Banco
{
    public $convenio;

    public function __construct($args)
    {
        parent::__construct($args);

        $this->banco_nome = 'Caixa Econômica Federal';
        $this->banco_sigla = 'cef';
        $this->banco_info = 'Informações adicionais sobre o banco';
        $this->banco_codigo = '104';
        $this->numero_moeda = 9;
    }

}
