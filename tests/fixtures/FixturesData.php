<?php

class FixturesData {

    public static function dados_bb_right()
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

    public static function dados_bb_wrong()
    {
        return array(

        );
    }

    public static function dados_itau_right()
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
            "banco_codigo" => "341",
            "pagador_identificador" => ""
        );
    }

    public static function dados_itau_wrong()
    {
        return array(

        );
    }

    public static function dados_cef_right()
    {
        return array(
            "nosso_numero" => "00020004000000019",
            "data_vencimento" => "19/03/2015",
            "valor_boleto" => "190,00",
            "data_documento" => "13/01/2015",
            "pagador" => "Stefan Yohansson",
            "pagador_endereco" => array("Rua dos bem-ti-vis, 23"),
            "pagador_instrucoes" => array("Não aceitar após vencimento."),
            "pagador_demonstrativo" => array(""),
            "quantidade" => '1',
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
            "banco_codigo" => "104",
            "nosso_numero_constante_1" => "2",
            "nosso_numero_constante_2" => "3",
            "data_processamento" => "",
            "pagador_identificador" => ""
        );
    }
}
