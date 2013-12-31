<?php

abstract class Sloth_Arquivo
{

    /**
     * @property string $nomeArquivo Nome do arquivo de remessa que será gerado ao fim do processamento
     */
    protected $nomeArquivo = '';

    public function defineNomeArquivo($arquivo)
    {
        $this->nomeArquivo = $arquivo;
        return $this;
    }

    public function obterNomeArquivo()
    {
        return $this->nomeArquivo;
    }

    /**
     * @property string $eventoProcessamentoLinha Evento chamado após processar uma linha para ações futuras
     */
    protected $eventoProcessamentoLinha;

    public function defineEvento($evento)
    {
        $this->eventoProcessamentoLinha = $evento;
        return $this;
    }

    public function obterEvento()
    {
        return $this->eventoProcessamentoLinha;
    }

    public function __construct($nomeArquivo = null, $evento = null)
    {
        if ($nomeArquivo)
        {
            $this->defineNomeArquivo($nomeArquivo);
        }
        $this->defineEvento($evento);
    }

    public abstract function processarLinha($num, $linha);
}
