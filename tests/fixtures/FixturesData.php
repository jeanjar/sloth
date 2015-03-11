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
            "pagador_endereco" => "Rua dos bem-ti-vis, 23",
            "pagador_instrucoes" => "Não aceitar após vencimento.",
            "pagador_demonstrativo" => "",
            "beneficiario" => "Teste",
            "beneficiario_agencia" => "9314",
            "beneficiario_conta" => "423523",
            "beneficiario_dv_conta" => "3",
            "identificacao" => "32612453",
            "beneficiario_cpf_cnpj" => "068.627.124-62",
            "beneficiario_endereco" => "Rua da laranjeira, 32",
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
            "pagador_endereco" => "Rua dos bem-ti-vis, 23",
            "pagador_instrucoes" => "Não aceitar após vencimento.",
            "pagador_demonstrativo" => "",
            "beneficiario" => "Teste",
            "beneficiario_agencia" => "9314",
            "beneficiario_conta" => "423523",
            "beneficiario_dv_conta" => "3",
            "identificacao" => "32612453",
            "beneficiario_cpf_cnpj" => "068.627.124-62",
            "beneficiario_endereco" => "Rua da laranjeira, 32",
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
}
