<?php

class Sloth_Retorno_CNAB400_Brasil extends Sloth_Retorno_CNAB400
{

    public $tamanho_permitido_linha;
    
    public static $codigo_ocorrencia_map = [
        // True (instruções que aceitam o boleto)
        1 => [
            '02' => ['index' => 'mensagem_info'],
            '04' => ['Alteração de Dados - Nova Entrada ou Alteração/Exclusão de Dados Acatada'],
            '05' => ['Alteração de Dados - Baixa'],
            '06' => ['Liquidação Normal'],
            '07' => ['Liquidação Parcial - Cobrança Inteligente'],
            '08' => ['Liquidação em Cartório'],
            '09' => ['Baixa Simples'],
            '10' => ['Baixa por ter sido liquidado'],
            '12' => ['Abatimento Concebido'],
        ],
        // False (instruções que rejeitam) 
        0 => [
            '03' => ['index' => 'mensagem_info'],
            '13' => ['Abatimento Cancelado'],
            '15' => ['Baixas Rejeitadas'],
            '16' => ['index' => 'mensagem_info'],
            '19' => ['Confirma Recebimento de Instrução de Protesto'],
            '20' => ['Confirma Recebimento de Instrução de Sustanção de Protesto/Tarifa'],
            '21' => ['Confirma Recebimento de Instrução de Não Protestar'],
            '29' => ['Tarifa de Manutenção de Títulos Vencidos'],
            '32' => ['Baixa por ter sido protestado'],
            '57' => ['Instrução Cancelada'],
        ],
    ];

    public $mapa_identificadores = array();

    public function __construct($nomeArquivo, $evento)
    {
        parent::__construct($nomeArquivo, $evento);

        $this->tamanho_permitido_linha = 400;

        $this->identificador_header = 0;
        
        $this->identificador_trailer = 9;
        
        $this->identificador_detalhe = 7;
        
        $banco = new Sloth_Banco_Brasil(['assets' => '', 'rel_path' => '']);
        
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
			'tipo_servico_desc' => ['posicao' => [12, 8]],
			'brancos_1' => ['posicao' => [20, 7]],
			'agencia_beneficiario' => ['posicao' => [27, 4]],
			'dv_agencia_beneficiario' => ['posicao' => [31, 1]],
			'conta_beneficiario' => ['posicao' => [32, 8]],
			'dv_conta_beneficiario' => ['posicao' => [40, 1]],
			'zeros' => ['posicao' => [41, 6]],
			'nome_beneficiario' => ['posicao' => [47, 30]],
			'banco' => ['posicao' => [77, 18]],
			'data_gravacao' => ['posicao' => [95, 6], 'formatter' => ['Sloth_TxtHelper', 'formataData']],
			'sequencial_retorno' => ['posicao' => [101, 7]],
			'brancos_2' => ['posicao' => [108, 42]],
			'numero_convenio' => ['posicao' => [150, 7]],
			'brancos_3' => ['posicao' => [157, 238]],
			'sequencial_registro' => ['posicao' => [395, 6]],
        );

        $mapaFormatado = Sloth_TxtHelper::toraLinha($linha, $mapaHeader);

        return $mapaFormatado;
    }

    public function processarDetalhe($num, $linha)
    {
        $mapaDetalhe = array(
            'registro' => ['posicao' => [1, 1]],
            'zeros_1' => ['posicao' => [2, 2]],
            'zeros_2' => ['posicao' => [4, 14]],
            'agencia' => ['posicao' => [18, 4]],
            'dv_agencia' => ['posicao' => [22, 1]],
            'conta_corrente_cedente' => ['posicao' => [23, 8]],
            'dv_conta_corrente_cedente' => ['posicao' => [31, 1]],
            'numero_convenio_cobranca_cedente' => ['posicao' => [32, 7]],
            'numero_controle_participante' => ['posicao' => [39, 25]],
            'nosso_numero' => ['posicao' => [64, 17]],
            'tipo_cobranca' => ['posicao' => [81, 1]],
            'tipo_cobranca_especifico' => [ 'posicao' => [82,1] ],
            'dias_calculo' => [ 'posicao' => [83,4] ],
            'natureza_recebimento' => [ 'posicao' => [87,2] ],
            'prefixo_titulo' => [ 'posicao' => [89,3] ],
            'variacao_carteira' => [ 'posicao' => [92,3] ],
            'conta_caucao' => [ 'posicao' => [95,1] ],
            'taxa_desconto' => [ 'posicao' => [96,5] ],
            'taxa_iof' => [ 'posicao' => [101,4] ],
            'brancos_1' => [ 'posicao' => [106,1] ],
            'carteira' => [ 'posicao' => [107,2] ],
            'comando' => [ 'posicao' => [109,2] ],
            'data_liquidacao' => [ 'posicao' => [111,6] ],
            'numero_titulo_cedente' => [ 'posicao' => [117,10] ],
            'brancos_2' => [ 'posicao' => [127,20] ],
            'data_vencimento' => [ 'posicao' => [147,6] ],
            'valor_titulo' => [ 'posicao' => [153,11] ],
            'codigo_banco_recebedor' => [ 'posicao' => [166,3] ],
            'prefixo_agencia_recebedora' => [ 'posicao' => [169,4] ],
            'dv_prefixo_recebedora' => [ 'posicao' => [173,1] ],
            'especie_titulo' => [ 'posicao' => [174,2] ],
            'data_credito' => [ 'posicao' => [176,6] ],
            'valor_tarifa' => [ 'posicao' => [182,5] ],
            'outras_despesas' => [ 'posicao' => [189,11] ],
            'juros_desconto' => [ 'posicao' => [202,11] ],
            'iof_desconto' => [ 'posicao' => [215,11] ],
            'valor_abatimento' => [ 'posicao' => [228,11] ],
            'desconto_concedido' => [ 'posicao' => [241,11] ],
            'valor_recebido' => [ 'posicao' => [254,11] ],
            'juros_mora' => [ 'posicao' => [267,11] ],
            'outros_recebimentos' => [ 'posicao' => [280,11] ],
            'abatimento_nao_aproveitado_sacado' => [ 'posicao' => [293,11] ],
            'valor_lancamento' => [ 'posicao' => [306,11] ],
            'indicativo_deb_cred' => [ 'posicao' => [319,1] ],
            'indicador_valor' => [ 'posicao' => [320,1] ],
            'valor_ajuste' => [ 'posicao' => [321,10] ],
            'brancos_3' => [ 'posicao' => [333,1] ],
            'brancos_4' => [ 'posicao' => [334,9] ],
            'zeros_3' => [ 'posicao' => [343,7] ],
            'zeros_4' => [ 'posicao' => [350,9] ],
            'zeros_5' => [ 'posicao' => [359,7] ],
            'zeros_6' => [ 'posicao' => [366,9] ],
            'zeros_7' => [ 'posicao' => [375,7] ],
            'zeros_8' => [ 'posicao' => [382,9] ],
            'brancos_5' => [ 'posicao' => [391,2] ],
            'canal_pagamento_titulo' => [ 'posicao' => [393,2] ],
            'seq_registro' => [ 'posicao' => [395,6] ],
        );

        $mapaFormatado = Sloth_TxtHelper::toraLinha($linha, $mapaDetalhe);
        
        $mapaFormatado = $this->nossoNumeroSemConvenio($mapaFormatado);
//        $mapaFormatado = $this->transcreverMensagemInfo($mapaFormatado);

        return $mapaFormatado;
    }
    
    private function nossoNumeroSemConvenio($mapaFormatado)
    {
        $mapaFormatado['nosso_numero_convenio'] = $mapaFormatado['nosso_numero'];
        
        $mapaFormatado['nosso_numero'] = str_replace($this->banco->convenio, '', $mapaFormatado['nosso_numero']);
        
        return $mapaFormatado;
    }
    
    private function transcreverMensagemInfo($mapaFormatado)
    {
        /**
        *   Adicionando mensagem info a força de acordo com o retorno do banco (código ocorrência)
        **/
        if(!$mapaFormatado['mensagem_info'])
        {
            foreach(self::$codigo_ocorrencia_map as $key => $value)
            {
                if(!in_array($mapaFormatado['codigo_ocorrencia'], array_keys($value)))
                {
                    continue;
                }
                
                $k = key($value[$mapaFormatado['codigo_ocorrencia']]);
                
                if(is_int($k))
                {
                    $mapaFormatado['mensagem_info'] =  $mapaFormatado['codigo_ocorrencia'] . ' - ' . current($value[$mapaFormatado['codigo_ocorrencia']]);
                } else {
                    $mapaFormatado['mensagem_info'] = $mapaFormatado[$value[$mapaFormatado['codigo_ocorrencia']][$k]];
                }
                $mapaFormatado['codigo_ocorrencia_permite_processamento'] = (bool) $key;
            }
        }
        
        if(!isset($mapaFormatado['codigo_ocorrencia_permite_processamento']))
        {
           $mapaFormatado['codigo_ocorrencia_permite_processamento'] = true;
        }
        
        return $mapaFormatado;
    }

    public function processarTrailer($num, $linha)
    {
        $mapaTrailer = array(
			'registro' => ['posicao' => [1, 1]],
			'retorno' => ['posicao' => [2, 1]],
			'tipo_registro' => ['posicao' => [3, 2]],
			'001' => ['posicao' => [5, 3]],
			'brancos_1' => ['posicao' => [8, 10]],
			'cobranca_simples_quantidade_titulos' => ['posicao' => [18, 8]],
			'cobranca_simples_valor_total' => ['posicao' => [26, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
			'cobranca_simples_numero_aviso' => ['posicao' => [40, 8]],
			'brancos_2' => ['posicao' => [48, 10]],
			'cobranca_vinculada_quantidade_titulos' => ['posicao' => [58, 8]],
			'cobranca_vinculada_valor_total' => ['posicao' => [66, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
			'cobranca_vinculada_numero_aviso' => ['posicao' => [80, 8]],
			'brancos_3' => ['posicao' => [88, 10]],
			'cobranca_caucionada_quantidade_titulos' => ['posicao' => [98, 8]],
			'cobranca_caucionada_valor_total' => ['posicao' => [106, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
			'cobranca_caucionada_numero_aviso' => ['posicao' => [120, 8]],
            'brancos_4' => ['posicao' => [128, 10]],            
			'cobranca_descontada_quantidade_titulos' => ['posicao' => [138, 8]],
			'cobranca_descontada_valor_total' => ['posicao' => [146, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
			'cobranca_descontada_numero_aviso' => ['posicao' => [160, 8]],
            'brancos_5' => ['posicao' => [168, 50]],
			'cobranca_vendor_quantidade_titulos' => ['posicao' => [218, 8]],
			'cobranca_vendor_valor_total' => ['posicao' => [226, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
			'cobranca_vendor_numero_aviso' => ['posicao' => [240, 8]],
            'brancos_6' => ['posicao' => [248, 147]],
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
