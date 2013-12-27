<?php

class Sloth_Cobranca
{
    public $recorrente;
    public $registrada;       
    
    public function __construct($args)
    {
        Sloth_Config::init($args);
    }
}
