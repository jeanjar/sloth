<?php

class Sloth_Banco_Brasil extends Sloth_Banco
{
    public function __construct($args)
    {
        parent::__construct($args);

        $this->banco_nome = 'Banco do Brasil';
        $this->banco_sigla = 'bb';
        $this->banco_info = 'Informações adicionais sobre o banco';
        $this->banco_codigo = 341;
        $this->numero_moeda = 9;
    }

}
