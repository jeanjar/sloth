<?php

class Sloth_Boleto_CEF extends Sloth_Boleto
{
    public $template = 'boleto_cef';
    public $convenio;

    public function __construct()
    {
        parent::__construct();
        $this->dadosBoletoRequeridos = array_merge($this->dadosBoletoRequeridos, [
            'especie',
            'aceite',
            'especie_doc',
            'numero_documento',
            'contrato',
            'pagador_identificador',
            'data_processamento',
            'nosso_numero_constante_1',
            'nosso_numero_constante_2',
        ]);
    }

    public function configurarBoleto($dadosBoleto = array())
    {
        $chaves_requeridas = array_diff_key(array_flip($this->dadosBoletoRequeridos), $dadosBoleto);

        $this->dadosBoleto = $dadosBoleto;
        $this->formatarValores();

        return array_keys($chaves_requeridas);
    }

    private function formatarValores()
    {
        if(empty($this->dadosBoleto))
        {
            return false;
        }

        $nosso_numero_split = array(
            'nosso_numero1' => ['posicao' => array(0, 3)],
            'nosso_numero2' => ['posicao' => array(4, 3)],
            'nosso_numero3' => ['posicao' => array(5, 9)],
        );

        $this->dadosBoleto['nosso_numero_tored'] = Sloth_TxtHelper::toraLinha($this->dadosBoleto['nosso_numero'], $nosso_numero_split);

        $this->dadosBoleto['convenio'] = $this->convenio;
        $this->dadosBoleto['banco_codigo_dv'] = $this->gerarCodigoBancoComDigitoVerificador($this->dadosBoleto['banco_codigo']);
        $this->dadosBoleto['fator_vencimento'] = $this->gerarFatorVencimento($this->dadosBoleto['data_vencimento']);
        $this->dadosBoleto['zeros_livre'] = '000000';

        $this->dadosBoleto['valor_boleto_acolchoado'] = Sloth_TxtHelper::acolchoarNumero($this->dadosBoleto['valor_boleto'], 10, 0);
        $this->dadosBoleto['nosso_numero_acolchoado'] = Sloth_TxtHelper::acolchoarNumero($this->dadosBoleto['nosso_numero'], 17, 0);
        $this->dadosBoleto['beneficiario_agencia_acolchoado'] = Sloth_TxtHelper::acolchoarNumero($this->dadosBoleto['beneficiario_agencia'], 4, 0);
        $this->dadosBoleto['beneficiario_conta_acolchoado'] = Sloth_TxtHelper::acolchoarNumero($this->dadosBoleto['beneficiario_conta'], 5, 0);
        $this->dadosBoleto['beneficiario_conta_dv'] = $this->digitoVerificador($this->dadosBoleto['beneficiario_conta']);

        $this->dadosBoleto['campo_livre'] = $this->gerarCampoLivre();
        $this->dadosBoleto['campo_livre_dv'] = $this->digitoVerificador($this->dadosBoleto['campo_livre']);
        $this->dadosBoleto['campo_livre_com_dv'] = $this->dadosBoleto['campo_livre'] . $this->dadosBoleto['campo_livre_dv'];

        $this->formatarNossoNumero();

        $this->dadosBoleto['codigo_barras'] = $this->gerarCodigoBarras();
        $linha = $this->dadosBoleto['linha_digitavel'] = $this->montarLinhaDigitavel();

        // @TODO: ajeitar isso aqui..
        $this->dadosBoleto['beneficiario_agencia_codigo'] = $this->dadosBoleto['beneficiario_agencia_acolchoado']." / ". $this->dadosBoleto['beneficiario_conta']."-".$this->modulo10($this->dadosBoleto['beneficiario_agencia_acolchoado'].$this->dadosBoleto['beneficiario_conta_acolchoado'], 2);

    }

    private function gerarCampoLivre()
    {
        $campo_livre = $this->dadosBoleto['beneficiario_conta'] . $this->dadosBoleto['beneficiario_conta_dv'] . $this->dadosBoleto['nosso_numero_tored']['nosso_numero1'] . $this->dadosBoleto['nosso_numero_constante_1'] . $this->dadosBoleto['nosso_numero_tored']['nosso_numero2'] . $this->dadosBoleto['nosso_numero_constante_2'] . $this->dadosBoleto['nosso_numero_tored']['nosso_numero3'];

        return $campo_livre;
    }

    private function formatarNossoNumero()
    {
        $nnum = $this->dadosBoleto['nosso_numero_constante_1'] . $this->dadosBoleto['nosso_numero_constante_2'] . Sloth_TxtHelper::acolchoarNumero($this->dadosBoleto['nosso_numero_tored']['nosso_numero1'], 3, 0) . Sloth_TxtHelper::acolchoarNumero($this->dadosBoleto['nosso_numero_tored']['nosso_numero2'], 3, 0) . Sloth_TxtHelper::acolchoarNumero($this->dadosBoleto['nosso_numero_tored']['nosso_numero3'], 9, 0);
        $nossonumero = $nnum . $this->digitoVerificador($nnum);
        $this->dadosBoleto['nosso_numero_formatado'] = $nossonumero;
        $this->dadosBoleto['nosso_numero'] = $nossonumero;

    }

    private function digitoVerificador_barra($numero) {
        $resto2 = modulo_11($numero, 9, 1);
        if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
            $dv = 1;
        } else {
            $dv = 11 - $resto2;
        }
        return $dv;
    }

    private function montarLinhaDigitavel()
    {
        $codigo_barras = array(
            'campo1_parte1' => ['posicao' => [0,4]],
            'campo1_parte2' => ['posicao' => [19, 5]],

            'campo2_parte1' => ['posicao' => [24, 10]],

            'campo3_parte1' => ['posicao' => [34, 10]],

            'campo4' => ['posicao' => [4, 1]],

            'campo5' => ['posicao' => [5, 14]]
        );

        $codigo_barras_arr = Sloth_TxtHelper::toraLinha($this->dadosBoleto['codigo_barras'], $codigo_barras);

        // Campo 1
        $partes_concat = $codigo_barras_arr['campo1_parte1'] . $codigo_barras_arr['campo1_parte2'];
        $codigo_barras_arr['campo1_parte3'] = $this->modulo10($partes_concat, 2);
        $codigo_barras_arr['campo1_parte4'] = $partes_concat . $codigo_barras_arr['campo1_parte3'];

        $codigo_torado = array(
            'campo1_parte5' => ['posicao' => [0, 5]],
            'campo1_parte6' => ['posicao' => [5, 4]]
        );

        $campo1_tored = Sloth_TxtHelper::toraLinha($codigo_barras_arr['campo1_parte4'], $codigo_torado);

        $campo1 = $campo1_tored['campo1_parte5'] . $campo1_tored['campo1_parte6'];

        // Campo 2
        $codigo_barras_arr['campo2_parte2'] = $this->modulo10($codigo_barras_arr['campo2_parte1'], 2);
        $codigo_barras_arr['campo2_parte3'] = $codigo_barras_arr['campo2_parte1'] . $codigo_barras_arr['campo2_parte2'];

        $codigo_torado = array(
            'campo2_parte4' => ['posicao' => [0, 5]],
            'campo2_parte5' => ['posicao' => [5, 5]]
        );

        $campo2_tored = Sloth_TxtHelper::toraLinha($codigo_barras_arr['campo2_parte3'], $codigo_torado);

        $campo2 = $campo2_tored['campo2_parte4'] . $campo2_tored['campo2_parte5'];

        // Campo 3
        $codigo_barras_arr['campo3_parte2'] = $this->modulo10($codigo_barras_arr['campo3_parte1'], 2);
        $codigo_barras_arr['campo3_parte3'] = $codigo_barras_arr['campo3_parte1'] . $codigo_barras_arr['campo3_parte2'];

        $codigo_torado = array(
            'campo3_parte4' => ['posicao' => [0, 5]],
            'campo3_parte5' => ['posicao' => [5, 5]]
        );

        $campo3_tored = Sloth_TxtHelper::toraLinha($codigo_barras_arr['campo3_parte3'], $codigo_torado);


        $campo3 = $campo3_tored['campo3_parte4'] . $campo3_tored['campo3_parte5'];

        $dv1 = $this->modulo10($campo1, 2);
        $dv2 = $this->modulo10($campo2, 2);
        $dv3 = $this->modulo10($campo3, 2);

        $campo1 = Sloth_TxtHelper::mask('#####.#####', $campo1.$dv1);
        $campo2 = Sloth_TxtHelper::mask('#####.#####', $campo2.$dv2);
        $campo3 = Sloth_TxtHelper::mask('#####.#####', $campo3.$dv3);

        $campo4 = $codigo_barras_arr['campo4'];
        $campo5 = $codigo_barras_arr['campo5'];

        return "$campo1 $campo2 $campo3 $campo4 $campo5";
    }

    private function gerarCodigoBarras()
    {
        $dv = $this->gerarDigitoVerificadorCodigoBarras();

        $linha = $this->dadosBoleto['banco_codigo'] . $this->dadosBoleto['numero_moeda'] . $dv . $this->dadosBoleto['fator_vencimento'] . $this->dadosBoleto['valor_boleto_acolchoado'] . $this->dadosBoleto['campo_livre_com_dv'];

        return $linha;
    }

    private function digitoVerificador($numero)
    {
        $resto2 = $this->modulo11($numero, 9, 1);
        $digito = 11 - $resto2;
        if ($digito == 10 || $digito == 11) $digito = 0;
        $dv = $digito;
        return $dv;
    }

    private function gerarDigitoVerificadorCodigoBarras()
    {
        $codigo_digito = $this->dadosBoleto['banco_codigo'] . $this->dadosBoleto['numero_moeda'] . $this->dadosBoleto['fator_vencimento'] . $this->dadosBoleto['valor_boleto_acolchoado'] . $this->dadosBoleto['campo_livre_com_dv'];

        $digito = $this->modulo11($codigo_digito, 9, false);

        if(in_array($digito, [0, 1, 10, 11]))
        {
            $digito = 1;
        }

        return $digito;
    }

    public function modulo11($num, $base=9, $r=0)
    {
        $soma = 0;
        $fator = 2;
        for ($i = strlen($num); $i > 0; $i--) {
            $numeros[$i] = substr($num,$i-1,1);
            $parcial[$i] = $numeros[$i] * $fator;
            $soma += $parcial[$i];

            if ($fator == $base) {
                $fator = 1;
            }
            $fator++;
        }

        if (!$r) {
            $soma *= 10;
            $digito = $soma % 11;

            //corrigido
            if ($digito == 10) {
                $digito = "X";
            }


            if (strlen($num) == "43") {
                //então estamos checando a linha digitável
                if ($digito == "0" or $digito == "X" or $digito > 9) {
                    $digito = 1;
                }
            }
            return $digito;
        }
        else{
            $resto = $soma % 11;
            return $resto;
        }
    }

    private function gerarCodigoBancoComDigitoVerificador($numero) {
        $parte1 = substr($numero, 0, 3);
        $parte2 = $this->modulo11($parte1, 9);
        return $parte1 . "-" . $parte2;
    }

    public function imprimirCodigoBarras($codigo_barras)
    {
        $fino = 1;
        $largo = 3;
        $altura = 50;

         $barcodes[0] = "00110" ;
         $barcodes[1] = "10001" ;
          $barcodes[2] = "01001" ;
          $barcodes[3] = "11000" ;
          $barcodes[4] = "00101" ;
          $barcodes[5] = "10100" ;
          $barcodes[6] = "01100" ;
          $barcodes[7] = "00011" ;
          $barcodes[8] = "10010" ;
          $barcodes[9] = "01010" ;
          for($f1=9;$f1>=0;$f1--){
            for($f2=9;$f2>=0;$f2--){
              $f = ($f1 * 10) + $f2 ;
              $texto = "" ;
              for($i=1;$i<6;$i++){
                $texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
              }
              $barcodes[$f] = $texto;
            }
          }


        //Desenho da barra


        //Guarda inicial
        ?><img src=<?php echo Sloth_Config::$rel_path . Sloth_Config::$assets; ?>/p.png width=<?php echo $fino?> height=<?php echo $altura?> border=0><img
        src=<?php echo Sloth_Config::$rel_path . Sloth_Config::$assets; ?>/b.png width=<?php echo $fino?> height=<?php echo $altura?> border=0><img
        src=<?php echo Sloth_Config::$rel_path . Sloth_Config::$assets; ?>/p.png width=<?php echo $fino?> height=<?php echo $altura?> border=0><img
        src=<?php echo Sloth_Config::$rel_path . Sloth_Config::$assets; ?>/b.png width=<?php echo $fino?> height=<?php echo $altura?> border=0><img
        <?php
        $texto = $codigo_barras ;
        if((strlen($texto) % 2) <> 0){
                $texto = "0" . $texto;
        }

        // Draw dos dados
        while (strlen($texto) > 0) {
          $i = round($this->esquerda($texto,2));
          $texto = $this->direita($texto,strlen($texto)-2);
          $f = $barcodes[$i];
          for($i=1;$i<11;$i+=2){
            if (substr($f,($i-1),1) == "0") {
              $f1 = $fino ;
            }else{
              $f1 = $largo ;
            }
        ?>
            src=<?php echo Sloth_Config::$rel_path . Sloth_Config::$assets; ?>/p.png width=<?php echo $f1?> height=<?php echo $altura?> border=0><img
        <?php
            if (substr($f,$i,1) == "0") {
              $f2 = $fino ;
            }else{
              $f2 = $largo ;
            }
        ?>
            src=<?php echo Sloth_Config::$rel_path . Sloth_Config::$assets; ?>/b.png width=<?php echo $f2?> height=<?php echo $altura?> border=0><img
        <?php
          }
        }

        // Draw guarda final
        ?>
        src=<?php echo Sloth_Config::$rel_path . Sloth_Config::$assets; ?>/p.png width=<?php echo $largo?> height=<?php echo $altura?> border=0><img
        src=<?php echo Sloth_Config::$rel_path . Sloth_Config::$assets; ?>/b.png width=<?php echo $fino?> height=<?php echo $altura?> border=0><img
        src=<?php echo Sloth_Config::$rel_path . Sloth_Config::$assets; ?>/p.png width=<?php echo 1?> height=<?php echo $altura?> border=0>
          <?php
        } //Fim da função

        public function esquerda($entra,$comp){
                return substr($entra,0,$comp);
        }

        public function direita($entra,$comp){
                return substr($entra,strlen($entra)-$comp,$comp);
        }
}
