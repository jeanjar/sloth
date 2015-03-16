<?php

class BoletoTest extends PHPUnit_Framework_TestCase
{
    public function test_boletobb_assert_true()
    {
        $boleto = new Sloth_Carteira_BrasilCarteira18(['rel_path' => '', 'assets' => '']);
        $boleto->convenio = '12345678';
        $boletoHtml = $boleto->gerarBoleto(Fixtures::boleto_bb(true));

        $this->assertTrue(is_string($boletoHtml));
    }

    public function test_boletobb_assert_false()
    {
        $boleto = new Sloth_Carteira_BrasilCarteira18(['rel_path' => '', 'assets' => '']);
        $boleto->convenio = '12345678';
        $chavesRequeridas = $boleto->gerarBoleto(Fixtures::boleto_bb(false));

        $this->assertFalse(count($chavesRequeridas) <= 0);
    }

    public function test_boletoitau_assert_true()
    {
        $boleto = new Sloth_Boleto_Itau(['assets' => '', 'rel' => '']);
        $chavesRequeridas = $boleto->configurarBoleto(Fixtures::boleto_itau(true));

        $this->assertTrue(count($chavesRequeridas) == 0);
    }

    public function test_boletoitau_assert_false()
    {
        $boleto = new Sloth_Boleto_Itau(['assets' => '', 'rel' => '']);
        $chavesRequeridas = $boleto->configurarBoleto(Fixtures::boleto_itau(false));

        $this->assertFalse(count($chavesRequeridas) <= 0);
    }

    public function test_boletocef_assert_true()
    {
        $boleto = new Sloth_Carteira_CEFCarteiraSIGCB(['rel_path' => '', 'assets' => '']);
        $boleto->convenio = '12345678';
        $boletoHtml = $boleto->gerarBoleto(Fixtures::boleto_cef(true));

        $this->assertTrue(is_string($boletoHtml));
    }
    
}
