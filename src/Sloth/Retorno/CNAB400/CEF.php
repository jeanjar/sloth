<?php

class Sloth_Retorno_CNAB400_CEF extends Sloth_Retorno_CNAB400
{

    public $tamanho_permitido_linha;

    public $mapa_identificadores = array();

    public function __construct($nomeArquivo, $evento)
    {
        parent::__construct($nomeArquivo, $evento);

        $this->tamanho_permitido_linha = 400;

        $this->identificador_header = 0;

        $this->identificador_trailer = 9;

        $this->identificador_detalhe = 1;

        $banco = new Sloth_Banco_CEF(['assets' => '', 'rel_path' => '']);

        $this->banco = $banco;

        $this->mapa_identificadores = array(
            $this->identificador_header => [$this, 'processarHeader'],
            $this->identificador_trailer => [$this, 'processarTrailer'],
            $this->identificador_detalhe => [$this, 'processarDetalhe'],
        );
    }

    public function processarHeader($num, $linha)
    {
        /**
         * Conforme determinado pelo BCB, a partir de 02/04/2013 os boletos passam a vigorar com as alterações:
         * CEDENTE => Beneficiário
         * SACADO => Pagador
         */
        $mapaHeader = array(
			'registro' => ['posicao' => [1, 1]],
			'tipo_operacao' => ['posicao' => [2, 1]],
			'tipo_operacao_desc' => ['posicao' => [3, 7]],
			'tipo_servico' => ['posicao' => [10, 2]],
			'tipo_servico_desc' => ['posicao' => [12, 13]],
			'codigo_agencia' => ['posicao' => [27, 4]],
			'codigo_identificador_empresa' => ['posicao' => [31, 6]],
			'uso_exclusivo' => ['posicao' => [37, 10]],
			'nome_empresa' => ['posicao' => [47, 30]],
			'codigo_banco' => ['posicao' => [77, 3]],
			'nome_banco' => ['posicao' => [80, 13]],
			'data_geracao' => ['posicao' => [95, 6], 'formatter' => ['Sloth_TxtHelper', 'formataData']],
			'mensagem' => ['posicao' => [101, 58]],
			'uso_exclusivo_2' => ['posicao' => [159, 231]],
			'sequencial_a' => ['posicao' => [390, 5]],
			'sequencial_b' => ['posicao' => [395, 6]],
        );

        $mapaFormatado = Sloth_TxtHelper::toraLinha($linha, $mapaHeader);

        return $mapaFormatado;
    }

    public function processarDetalhe($num, $linha)
    {
        $mapaDetalhe = array(
            'registro' => ['posicao' => [1, 1]],
            'tipo_inscricao' => ['posicao' => [2, 2]],
            'numero_inscricao' => ['posicao' => [4, 14]],
            'agencia' => ['posicao' => [18, 4]],
            'codigo_beneficiario' => ['posicao' => [22, 6]],
            'id_emissao' => ['posicao' => [28, 1]],
            'id_postagem' => ['posicao' => [29, 1]],
            'uso_exclusivo' => ['posicao' => [30, 2]],
            'uso_empresa' => ['posicao' => [32, 25]],
            'nosso_numero_identificacao' => ['posicao' => [57, 2]],
            'nosso_numero_identificacao_caixa' => ['posicao' => [59, 15]],
            'uso_exclusivo_2' => ['posicao' => [74, 6]],
            'codigo_rejeicao' => [ 'posicao' => [80,3] ],
            'uso_exclusivo_3' => [ 'posicao' => [83,25] ],
            'carteira' => [ 'posicao' => [107,2] ],
            'codigo_ocorrencia' => [ 'posicao' => [109,2] ],
            'data_ocorrencia' => [ 'posicao' => [111,6], 'formatter' => ['Sloth_TxtHelper', 'formataData'] ],
            'numero_documento' => [ 'posicao' => [117,10] ],
            'uso_exclusivo_4' => [ 'posicao' => [127,20] ],
            'data_vencimento' => [ 'posicao' => [147,6], 'formatter' => ['Sloth_TxtHelper', 'formataData'] ],
            'valor_titulo' => [ 'posicao' => [153,13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero'] ],
            'codigo_banco' => [ 'posicao' => [166,3] ],
            'agencia_cobradora' => [ 'posicao' => [169,5] ],
            'especie' => [ 'posicao' => [174,2] ],
            'liquidacao_valor_tarifa' => [ 'posicao' => [176,13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero'] ],
            'liquidacao_codigo_canal' => [ 'posicao' => [189,3] ],
            'liquidacao_codigo_formapagamento' => [ 'posicao' => [192,1] ],
            'liquidacao_float' => [ 'posicao' => [193,2] ],
            'liquidacao_data_debito' => [ 'posicao' => [195,6], 'formatter' => ['Sloth_TxtHelper', 'formataData'] ],
            'uso_exclusivo_5' => [ 'posicao' => [201,14] ],
            'valor_iof' => [ 'posicao' => [215,13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero'] ],
            'valor_abatimento' => [ 'posicao' => [228,13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero'] ],
            'valor_descontos' => [ 'posicao' => [241,13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero'] ],
            'valor_principal' => [ 'posicao' => [254,13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero'] ],
            'valor_juros' => [ 'posicao' => [267,13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero'] ],
            'valor_multa' => [ 'posicao' => [280, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero'] ],
            'codigo_moeda' => [ 'posicao' => [293,1] ],
            'data_credito' => [ 'posicao' => [294,6], 'formatter' => ['Sloth_TxtHelper', 'formataData'] ],
            'uso_exclusivo_6' => [ 'posicao' => [300,95] ],
            'sequencial' => [ 'posicao' => [395,6] ],
        );

        $mapaFormatado = Sloth_TxtHelper::toraLinha($linha, $mapaDetalhe);

        return $mapaFormatado;
    }

    public function processarTrailer($num, $linha)
    {
        $mapaTrailer = array(
			'registro' => ['posicao' => [1, 1]],
			'retorno' => ['posicao' => [2, 1]],
			'codigo_servico' => ['posicao' => [3, 2]],
			'codigo_banco' => ['posicao' => [5, 3]],
			'uso_exclusivo' => ['posicao' => [8, 387]],
			'sequencial' => ['posicao' => [395, 6]],
        );

        $mapaFormatado = Sloth_TxtHelper::toraLinha($linha, $mapaTrailer);

        return $mapaFormatado;
    }

    public function processarLinha($num, $linha)
    {
        $tamanho_linha = strlen($linha);

        $linha = " $linha";

        $tipo_linha = substr($linha, 1, 1);

        if (in_array($tipo_linha, array_keys($this->mapa_identificadores)))
        {
            $linha_array_formatada = call_user_func_array($this->mapa_identificadores[$tipo_linha], [$num, $linha]);
        }
        else
        {
            $linha_array_formatada = [];
        }

        return $linha_array_formatada;
    }

    public function processar()
    {
        parent::processar();
    }

}
