<?php

abstract class Sloth_Retorno extends Sloth_Arquivo
{

    public $identificador_header;

    public $identificador_trailer;

    public $identificador_detalhe;

    public function __construct($nomeArquivo = null, $evento = null)
    {
        parent::__construct($nomeArquivo, $evento);
    }

    public function processar()
    {
        if (is_string($this->obterNomeArquivo()) {
            $linhas = file($this->obterNomeArquivo());
        } else {
            $linhas = $this->obterNomeArquivo();
        }

        foreach ($linhas as $num => $linha)
        {
            $linha_retorno = $this->processarLinha($num, $linha);

            if ($this->eventoProcessamentoLinha)
            {
                call_user_func_array($this->eventoProcessamentoLinha, array($linha_retorno));
            }
        }
    }

}
