<?php

class Banco_Itau extends Banco
{
    public function __construct()
    {
        parent::__construct();

        $this->banco_nome = 'Itaú';
        $this->banco_sigla = 'i';
        $this->banco_info = 'Informações adicionais sobre o banco';
        $this->banco_codigo = 341;
    }

}
