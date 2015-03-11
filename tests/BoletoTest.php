<?php

class BoletoTest extends PHPUnit_Framework_TestCase
{
    public function test_boletobb_assert_true()
    {
        $boleto = new Sloth_Boleto_Brasil(['assets' => '', 'rel' => '']);
        $boleto->convenio = '12345678';
        $chavesRequeridas = $boleto->configurarBoleto(Fixtures::boleto_bb(true));

        $this->assertTrue(count($chavesRequeridas) == 0);
    }

    public function test_boletobb_assert_false()
    {
        $boleto = new Sloth_Boleto_Brasil(['assets' => '', 'rel' => '']);
        $boleto->convenio = '12345678';
        $chavesRequeridas = $boleto->configurarBoleto(Fixtures::boleto_bb(false));

        $this->assertFalse(count($chavesRequeridas) <= 0);
    }
}
