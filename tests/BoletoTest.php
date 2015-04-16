<?php

class BoletoTest extends PHPUnit_Framework_TestCase
{

    public function test_boleto_true()
    {
        $banco = array(
            'bb' => 'Sloth_Carteira_BrasilCarteira18',
            'itau' => 'Sloth_Carteira_ItauCarteira104',
            'cef' => 'Sloth_Carteira_CEFCarteiraSIGCB'
        );

        foreach($banco as $key => $class)
        {
            $boleto = new $class(['rel_path' => '', 'assets' => '']);
            $boleto->convenio = '12345678';

            $fs_class = 'get_boleto_data';
            $boletoHtml = $boleto->gerarBoleto(Fixtures::$fs_class($key, true));

            $this->assertTrue(is_string($boletoHtml));
        }
    }

}
