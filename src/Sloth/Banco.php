<?php 

class Sloth_Banco extends Sloth_Cobranca
{
    public $banco_nome;
    public $banco_sigla;
    public $banco_info;
    public $banco_codigo;
    public $template_path;
    public $template_name;

    public function __construct($args)
    {
        parent::__construct($args);
    }
}
