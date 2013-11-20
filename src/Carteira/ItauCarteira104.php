<?php

class Carteira_ItauCarteira104 extends Carteira_ItauCarteira
{
    public function __construct()
    {
        parent::__construct();

        $this->indice = 104;
        $this->descricao = 'Cobrança Simples';
        $this->permite_retorno = true;
        $this->permite_remessa = true;
        $this->arquivos = array(
            'retorno' => 'Retorno_CNAB240',
            'remessa' => '',
        );
    }

    public function processarRetorno($caminho_arquivo, $evento)
    {
        if($this->permite_retorno && array_key_exists('retorno', $this->arquivos))
        {
            $retorno = new $this->arquivos['retorno']($caminho_arquivo, $evento);
            $retorno->processar();

            return true;
        }

        return false;
    }
}
