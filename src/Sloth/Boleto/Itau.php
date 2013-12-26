<?php

class Sloth_Boleto_Itau extends Sloth_Boleto
{
    public $template = 'boleto_itau';
    
    public function __construct()
    {
        parent::__construct();
        $this->dadosBoletoRequeridos = array_merge($this->dadosBoletoRequeridos, ['especie']);
     
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

        $this->dadosBoleto['banco_codigo_dv'] = $this->gerarCodigoBancoComDigitoVerificador($this->dadosBoleto['banco_codigo']);
        $this->dadosBoleto['fator_vencimento'] = $this->gerarFatorVencimento($this->dadosBoleto['data_vencimento']); 
        
        $this->dadosBoleto['valor_boleto_acolchoado'] = Sloth_TxtHelper::acolchoarNumero($this->dadosBoleto['valor_boleto'], 10, 0);
        $this->dadosBoleto['nosso_numero_acolchoado'] = Sloth_TxtHelper::acolchoarNumero($this->dadosBoleto['nosso_numero'], 8, 0);
        $this->dadosBoleto['beneficiario_agencia_acolchoado'] = Sloth_TxtHelper::acolchoarNumero($this->dadosBoleto['beneficiario_agencia'], 4, 0);
        $this->dadosBoleto['beneficiario_conta_acolchoado'] = Sloth_TxtHelper::acolchoarNumero($this->dadosBoleto['beneficiario_conta'], 5, 0);
        $this->dadosBoleto['codigo_barras'] = $this->gerarCodigoBarras();
        $this->dadosBoleto['linha_digitavel'] = $this->montarLinhaDigitavel();
        
        $this->dadosBoleto['nosso_numero_formatado'] = Sloth_TxtHelper::mask('###/########-#', $this->dadosBoleto['carteira'] . $this->dadosBoleto['nosso_numero_acolchoado'] . $this->modulo10($this->dadosBoleto['beneficiario_agencia_acolchoado'] . $this->dadosBoleto['beneficiario_conta_acolchoado'] . $this->dadosBoleto['carteira'] . $this->dadosBoleto['nosso_numero_acolchoado'],2));
        // @TODO: ajeitar isso aqui..
        $this->dadosBoleto['beneficiario_agencia_codigo'] = $this->dadosBoleto['beneficiario_agencia_acolchoado']." / ". $this->dadosBoleto['beneficiario_conta']."-".$this->modulo10($this->dadosBoleto['beneficiario_agencia_acolchoado'].$this->dadosBoleto['beneficiario_conta_acolchoado'], 2); 

    }

    private function montarLinhaDigitavel()
    {
        $codigo_barras = array(
            'banco' => ['posicao' => [0, 3]],
            'moeda' => ['posicao' => [3, 1]],
            'ccc' => ['posicao' => [19, 3]],
            'ddnosso_numero' => ['posicao' => [22, 2]],
            
            'resnosso_numero' => ['posicao' => [24, 6]],
            'dac1' => ['posicao' => [30, 1]],
            'dddag' => ['posicao' => [31, 3]],

            'resag' => ['posicao' => [34, 1]],
            'contadac' => ['posicao' => [35, 6]],
            'zeros' => ['posicao' => [41, 3]],

            'dv4' => ['posicao' => [4, 1]],
            'fator' => ['posicao' => [5, 4]],
            'valor' => ['posicao' => [9, 10]],
        );

        $codigo_torado = array(
            'parte1' => ['posicao' => [0, 4]],
            'parte2' => ['posicao' => [4, 43]]
        );
        
        $codigo_barras_arr = Sloth_TxtHelper::toraLinha($this->dadosBoleto['codigo_barras'], $codigo_barras);

        $campo1 = $codigo_barras_arr['banco'] . $codigo_barras_arr['moeda'] . $codigo_barras_arr['ccc'] . $codigo_barras_arr['ddnosso_numero'];
        $campo2 = $codigo_barras_arr['resnosso_numero'] . $codigo_barras_arr['dac1'] . $codigo_barras_arr['dddag'];
        $campo3 = $codigo_barras_arr['resag'] . $codigo_barras_arr['contadac'] . $codigo_barras_arr['zeros']; 
        
        $dv1 = $this->modulo10($campo1, 2);
        $dv2 = $this->modulo10($campo2, 2);
        $dv3 = $this->modulo10($campo3, 2);
        
        $campo1 = Sloth_TxtHelper::mask('#####.##', $campo1.$dv1);
        $campo2 = Sloth_TxtHelper::mask('#####.##', $campo2.$dv2);
        $campo3 = Sloth_TxtHelper::mask('#####.##', $campo3.$dv3);
        $campo4 = $codigo_barras_arr['dv4'];
        $campo5 = $codigo_barras_arr['fator'] . $codigo_barras_arr['valor'];

        return "$campo1 $campo2 $campo3 $campo4 $campo5";
    }

    private function gerarCodigoBarras()
    {
        $codigo_barras = $this->dadosBoleto['banco_codigo'] . $this->dadosBoleto['numero_moeda'] . $this->dadosBoleto['fator_vencimento'] . $this->dadosBoleto['valor_boleto_acolchoado'] . $this->dadosBoleto['carteira'] . $this->dadosBoleto['nosso_numero_acolchoado'] . $this->modulo10($this->dadosBoleto['beneficiario_agencia_acolchoado'] . $this->dadosBoleto['beneficiario_conta_acolchoado'] . $this->dadosBoleto['carteira'] . $this->dadosBoleto['nosso_numero_acolchoado'], 2) . $this->dadosBoleto['beneficiario_agencia_acolchoado'] . $this->dadosBoleto['beneficiario_conta_acolchoado'] . $this->modulo10($this->dadosBoleto['beneficiario_agencia_acolchoado'] . $this->dadosBoleto['beneficiario_conta_acolchoado'], 2) . '000';
        $codigo_barras_dv = $this->gerarDigitoVerificadorCodigoBarras($codigo_barras);

        $linha = substr($codigo_barras, 0, 4) . $codigo_barras_dv . substr($codigo_barras, 4, 43);

        return $linha;
    }

    private function gerarDigitoVerificadorCodigoBarras($codigo_barras)
    {
        $digito = $this->modulo11($codigo_barras, 9, false);

        if(in_array($digito, [0, 1, 10, 11]))
        {
            $digito = 1;
        }

        return $digito;
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
