<?php

abstract class Sloth_Retorno extends Sloth_Arquivo
{
    public static $identificador_header;
    public static $identificador_trailer;
    public static $identificador_detalhe;

    public function __construct($nomeArquivo = null, $evento = null)
    {
        parent::__construct($nomeArquivo, $evento);
    }

    public function processar()
    {
        $linhas = file($this->obterNomeArquivo());
        
        foreach($linhas as $num => $linha)
        {
            $linha_retorno = $this->processarLinha($num, $linha);

            if($this->eventoProcessamentoLinha)
            {
                call_user_func_array($this->eventoProcessamentoLinha, array($linha_retorno)); 
            }
        }

    }
} 
