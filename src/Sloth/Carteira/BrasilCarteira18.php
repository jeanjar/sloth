<?php

class Sloth_Carteira_BrasilCarteira18 extends Sloth_Banco_Brasil
{

    public function __construct($args)
    {
        parent::__construct($args);

        $this->indice = 18;
        $this->descricao = 'Cobrança Simples';
        $this->permite_retorno = true;
        $this->permite_remessa = false;
        $this->template_boleto = 'Sloth_Boleto_Brasil';

        $this->arquivos = array(
            'retorno' => 'Sloth_Retorno_CNAB400',
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

    public function gerarBoleto($dadosBoleto)
    {
        $boleto = new $this->template_boleto;
        $boleto->convenio = $this->convenio;

        if(!empty($dadosBoleto))
        {
            $dadosBoleto['carteira'] = $this->indice;
            $dadosBoleto['banco_codigo'] = $this->banco_codigo;
            $dadosBoleto['numero_moeda'] = $this->numero_moeda;
        }
        $retorno = $boleto->configurarBoleto($dadosBoleto);

        if(empty($retorno))
        {
            ob_start();
                $boleto->renderizar($this->template_path, $this->template_name);
            return ob_get_clean();
        }

        return $retorno;
    }
}
