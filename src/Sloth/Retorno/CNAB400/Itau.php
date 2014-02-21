<?php

class Sloth_Retorno_CNAB400_Itau extends Sloth_Retorno_CNAB400
{

    public $tamanho_permitido_linha;
    
    public static $codigo_ocorrencia_map = [
        // True (instruções que aceitam o boleto)
        1 => [
            '02' => ['index' => 'mensagem_info'],
            '04' => ['Alteração de Dados - Nova Entrada ou Alteração/Exclusão de Dados Acatada'],
            '05' => ['Alteração de Dados - Baixa'],
            '06' => ['Baixa Simples'],
            '07' => ['Liquidação Parcial - Cobrança Inteligente'],
            '08' => ['Liquidação em Cartório'],
            '09' => ['Baixa Simples'],
            '10' => ['Baixa por ter sido liquidado'],
            '12' => ['Abatimento Concebido'],
            '13' => ['Abatimento Cancelado'],
            
            
        ],
        // False (instruções que rejeitam) 
        0 => [
            '03' => ['index' => 'mensagem_info'],
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
        
        $this->identificador_detalhe = 1;

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
            'complemento' => ['posicao' => [20, 7]],
            'agencia_beneficiario' => ['posicao' => [27, 4]],
            'dv_agencia_beneficiario' => ['posicao' => [31, 2]],
            'conta_beneficiario' => ['posicao' => [33, 5]],
            'dv_conta_beneficiario' => ['posicao' => [38, 1]],
            'nome_beneficiario' => ['posicao' => [47, 30]],
            'codigo_banco' => ['posicao' => [77, 3]],
            'banco' => ['posicao' => [80, 15]],
            'data_gravacao' => ['posicao' => [95, 6], 'formatter' => ['Sloth_TxtHelper', 'formataData']],
            'densidade' => ['posicao' => [101, 5]],
            'unidade_densidade' => ['posicao' => [106, 3]],
            'sequencial_arquivo_retorno' => ['posicao' => [109, 5]],
            'data_credito' => ['posicao' => [114, 6], 'formatter' => ['Sloth_TxtHelper', 'formataData']],
            'brancos' => ['posicao' => [120, 275]],
            'sequencial_registro' => ['posicao' => [395, 6]]
        );

        $mapaFormatado = Sloth_TxtHelper::toraLinha($linha, $mapaHeader);

        return $mapaFormatado;
    }

    public function processarDetalhe($num, $linha)
    {
        $mapaDetalhe = array(
            'registro' => ['posicao' => [1, 1]],
            'codigo_inscricao' => ['posicao' => [2, 2]],
            'numero_inscricao' => ['posicao' => [4, 14]],
            'agencia' => ['posicao' => [18, 4]],
            'dv_agencia' => ['posicao' => [22, 2]],
            'conta_corrente_beneficiario' => ['posicao' => [24, 5]],
            'dv_conta_corrente_beneficario' => ['posicao' => [29, 1]],
            'brancos' => ['posicao' => [30, 8]],
            'uso_empresa' => ['posicao' => [38, 25]],
            'nosso_numero' => ['posicao' => [63, 8]],
            'brancos_nosso_numero' => ['posicao' => [71, 12]],
            'carteira' => ['posicao' => [83, 3]],
            'nosso_numero_nota' => ['posicao' => [86, 8]],
            'dac_nosso_numero' => ['posicao' => [94, 1]],
            'carteira_codigo' => ['posicao' => [108, 1]],
            'codigo_ocorrencia' => ['posicao' => [109, 2]],
            'data_ocorrencia' => ['posicao' => [111, 6], 'formatter' => ['Sloth_TxtHelper', 'formataData']],
            'numero_documento' => ['posicao' => [117, 10]],
            'nosso_numero_confirmacao' => ['posicao' => [127, 8]],
            'vencimento' => ['posicao' => [147, 6], 'formatter' => ['Sloth_TxtHelper', 'formataData']],
            'valor_titulo' => ['posicao' => [153, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'banco_codigo' => ['posicao' => [166, 3]],
            'agencia_cobradora' => ['posicao' => [169, 4]],
            'agencia_cobradora_dac' => ['posicao' => [173, 1]],
            'especie' => ['posicao' => [174, 2]],
            'tarifa_cobranca' => ['posicao' => [176, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'valor_iof' => ['posicao' => [215, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'valor_abatimento' => ['posicao' => [228, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'descontos' => ['posicao' => [241, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'valor_principal' => ['posicao' => [254, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'juros_mora' => ['posicao' => [267, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'outros_creditos' => ['posicao' => [280, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'boleto_dda' => ['posicao' => [293, 1]],
            'data_credito' => ['posicao' => [296, 6], 'formatter' => ['Sloth_TxtHelper', 'formataData']],
            'instrucao_cancelada' => ['posicao' => [302, 4]],
            'zeros' => ['posicao' => [312, 13]],
            'nome_pagador' => ['posicao' => [325, 30]],
            'mensagem_info' => ['posicao' => [378, 8]],
            'codigo_liquidacao' => ['posicao' => [393, 2]],
            'numero_sequencial' => ['posicao' => [395, 6]],
        );

        $mapaFormatado = Sloth_TxtHelper::toraLinha($linha, $mapaDetalhe);
        
        $mapaFormatado = $this->transcreverMensagemInfo($mapaFormatado);

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
        
        $mapaFormatado['codigo_ocorrencia_permite_processamento'] = true;
        
        return $mapaFormatado;
    }

    public function processarTrailer($num, $linha)
    {
        $mapaTrailer = array(
            'registro' => ['posicao' => [1, 1]],
            'retorno' => ['posicao' => [2, 1]],
            'tipo_registro' => ['posicao' => [3, 2]],
            'codigo_banco' => ['posicao' => [5, 3]],
            'cobranca_simples_quantidade_titulos' => ['posicao' => [18, 8]],
            'cobranca_simples_valor_total' => ['posicao' => [26, 14], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'cobranca_simples_numero_aviso' => ['posicao' => [40, 8]],
            'cobranca_vinculada_quantidade_titulos' => ['posicao' => [58, 8]],
            'cobranca_vinculada_valor_total' => ['posicao' => [66, 14], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'cobranca_vinculada_numero_aviso' => ['posicao' => [80, 8]],
            'cobranca_caucionada_quantidade_titulos' => ['posicao' => [178, 8]],
            'cobranca_caucionada_valor_total' => ['posicao' => [186, 14], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'cobranca_caucionada_numero_aviso' => ['posicao' => [200, 8]],
            'controle_arquivo' => ['posicao' => [208, 5]],
            'quantidade_detalhes' => ['posicao' => [213, 8]],
            'valor_total_titulos' => ['posicao' => [221, 14], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
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
