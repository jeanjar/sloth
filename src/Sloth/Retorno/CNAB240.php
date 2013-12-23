<?php

class Sloth_Retorno_CNAB240 extends Sloth_Retorno
{
    public $tamanho_permitido_linha;
    public $mapa_identificadores = array();

    public function __construct($nomeArquivo, $evento)
    {
        parent::__construct($nomeArquivo, $evento);
        
        $this->tamanho_permitido_linha = 240;

        $this->identificador_header = 0;
        $this->identificador_trailer = 9;
        $this->identificador_detalhe = 1;

        $this->mapa_identificadores = array(
            $this->identificador_header => [$this, 'processarHeader'],
            $this->identificador_trailer => [$this, 'processarTrailer'],
            $this->identificador_detalhe =>[$this, 'processarDetalhe'],
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
            'dv_agencia_beneficiario' => ['posicao' => [31, 1]],
            'conta_beneficiario' => ['posicao' => [32, 8]],
            'dv_conta_beneficiario' => ['posicao' => [40, 1]],
            'nome_beneficiario' => ['posicao' => [47, 30]],
            'banco' => ['posicao' => [77, 18]],
            'data_gravacao' => ['posicao' => [95, 6], 'formatter' => ['Sloth_TxtHelper', 'formataData']],
            'sequencial_registro' => ['posicao' => [395, 6]]
 
        );
        
        $mapaFormatado = Sloth_TxtHelper::toraLinha($linha, $mapaHeader);
        
        return $mapaFormatado;
    }

    public function processarDetalhe($num, $linha)
    {
        $mapaDetalhe = array(
            'registro' => ['posicao' => [1, 1]],
            'agencia' => ['posicao' => [18, 4]],
            'dv_agencia' => ['posicao' => [22, 1]],
            'conta_corrente_beneficiario' => ['posicao' => [23, 8]], 
            'dv_conta_corrente_beneficario' => ['posicao' => [31, 1]],
            'taxa_desconto' => ['posicao' => [96, 5], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'taxa_iof' => ['posicao' => [101, 5]],

            'carteira' => ['posicao' => [197, 2]],
            'comando' => ['posicao' => [109, 2]],
            'data_ocorrencia' => ['posicao' => [111, 6], 'formatter' => ['Sloth_TxtHelper', 'formataData']],
            'numero_titulo' => ['posicao' => [117, 10]],
            'data_vencimento' => ['posicao' => [147, 6], 'formatter' => ['Sloth_TxtHelper', 'formataData']],
            'valor' => ['posicao' => [153, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],

            'codigo_banco' => ['posicao' => [166, 3]],
            'agencia' => ['posicao' => [169, 4]],
            'dv_agencia' => ['posicao' => [173, 1]],
            'especie' => ['posicao' => [174, 2]],
            'data_credito' => ['posicao' => [176, 6]],
            'valor_tarifa' => ['posicao' => [182, 7], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'outras_despesas' => ['posicao' => [189, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'juros_desconto' => ['posicao' => [202, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'iof_desconto' => ['posicao' => [215, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'valor_abatimento' => ['posicao' => [228, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'desconto_concedido' => ['posicao' => [241, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'valor_recebido' => ['posicao' => [254, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'juros_mora' => ['posicao' => [267, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'outros_recebimentos' => ['posicao' => [280, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'abatimento_nao_aproveitado' => ['posicao' => [293, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],
            'valor_lancamento' => ['posicao' => [306, 13], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],

            'indicativo_debito_credito' => ['posicao' => [319, 1]],
            'indicador_valor' => ['posicao' => [320, 1]],
            'valor_ajuste' => ['posicao' => [321, 12], 'formatter' => ['Sloth_TxtHelper', 'formataNumero']],

            'canal_pagamento_titulo' => ['posicao' => [393, 2]],
            'sequencial' => ['posicao' => [395, 6]]
        );

        $mapaFormatado = Sloth_TxtHelper::toraLinha($linha, $mapaDetalhe);

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
            'cobranca_simples_valor_total' => ['posicao' => [26, 14]],
            'cobranca_simples_numero_aviso' => ['posicao' => [40, 8]],
            
            'cobranca_vinculada_quantidade_titulos' => ['posicao' => [58, 8]],
            'cobranca_vinculada_valor_total' => ['posicao' => [66, 14]],
            'cobranca_vinculada_numero_aviso' => ['posicao' => [80, 8]],

            'cobranca_caucionada_quantidade_titulos' => ['posicao' => [98, 8]],
            'cobranca_caucionada_valor_total' => ['posicao' => [106, 14]],
            'cobranca_caucionada_numero_aviso' => ['posicao' => [120, 8]],

            'cobranca_vendor_quantidade_titulos' => ['posicao' => [218, 8]],
            'cobranca_vendor_valor_total' => ['posicao' => [226, 14]],
            'cobranca_vendor_numero_aviso' => ['posicao' => [240, 8]],

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
        
        if(in_array($tipo_linha, array_keys($this->mapa_identificadores)))
        {
            $linha_array_formatada = call_user_func_array($this->mapa_identificadores[$tipo_linha], [$num, $linha]);
        } else {
            $linha_array_formatada = [];
        }

        return $linha_array_formatada;

    } 

    public function processar()
    {
        parent::processar();
    }
}
