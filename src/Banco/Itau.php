<?php

class Banco_Itau extends Banco
{
    public function __construct()
    {
        parent::__construct();

        $this->nome = 'Itaú';
        $this->sigla = 'i';
        $this->info = 'Informações adicionais sobre o banco';
    }

}
