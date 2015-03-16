<?php

class FixturesData {

    public static function get_default_data()
    {
        return array(
            "nosso_numero" => "1",
            "data_vencimento" => "19/03/2015",
            "valor_boleto" => "190,00",
            "data_documento" => "13/01/2015",
            "pagador" => "Stefan Yohansson",
            "pagador_endereco" => array("Rua dos bem-ti-vis, 23"),
            "pagador_instrucoes" => array("Não aceitar após vencimento."),
            "pagador_demonstrativo" => array(""),
            "beneficiario" => "Teste",
            "beneficiario_agencia" => "9314",
            "beneficiario_conta" => "423523",
            "beneficiario_dv_conta" => "3",
            "identificacao" => "32612453",
            "beneficiario_cpf_cnpj" => "068.627.124-62",
            "beneficiario_endereco" => array("Rua da laranjeira, 32"),
            "beneficiario_cidade_estado" => "Natal",
            "beneficiario_razao_social" => "Teste teste",
            "especie" => "R$",
            "aceite" => "N",
            'carteira' => '18',
            "especie_doc" => "",
            "numero_documento" => "1",
            "contrato" => "32654",
            "banco_codigo" => "001",
            "pagador_identificador" => ""
        );
    }

    public static function get_cef()
    {
        return array(
            "nosso_numero_constante_1" => "2",
            "nosso_numero_constante_2" => "4",
            "data_processamento" => "",
            "quantidade" => ""
        );
    }
}
