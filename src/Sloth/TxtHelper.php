<?php

class Sloth_TxtHelper
{
    public function formataNumero($valor, $numCasasDecimais=2)
    {
        if($valor=="")
            return 0;
        $casas = $numCasasDecimais;
        if($casas > 0) {
            $valor = substr($valor, 0, strlen($valor)-$casas) . "." . substr($valor, strlen($valor)-$casas, $casas);
            $valor = (float)$valor;
        } else $valor = (int)$valor;

        return $valor;
    }
    
    public function formataDinheiro($valor)
    {
        return 'R$ ' . number_format($valor, 2, ',', '.');
    }
    
    public static function formataConvenio($numero, $loop, $insert)
    {
        while(strlen($numero)<$loop){
            $numero = $numero . $insert;
        }
        
        return $numero;
    }

    public function formataData($data)
    {
        if($data == "00000000" or $data == "000000")
            return "";
            
        if(trim($data)=="")
            return "";
         //formata a data para o padrão americano MM/DD/AAAA ou MM/DD/AA (dependendo do tamanho da string $data)
         $iano = 4; //posicao onde inicia o ano
         $data =  substr($data, 2, 2) . "/". substr($data, 0, 2) . "/" . substr($data, $iano, strlen($data)-$iano);
         //formata a data, a partir do padrão americano, para o padrão DD/MM/AAAA
         return date("d/m/Y", strtotime($data));        
    }
    
    public function formataHora($hora)
    {
        if( $hora == "000000" )
            return "";
    
        if( trim($hora) == "" )
            return "";
    
        return date("H:i:s", strtotime($hora));
    }
    
    public static function toraLinha($linha, $mapa)
    {
        $mapaFormatado = array();

        foreach($mapa as $chave => $valor)
        {
            $valor_formatado = '';
            if(in_array('posicao', array_keys($valor)))
            {
                $valor_formatado = trim(substr($linha, $valor['posicao'][0], $valor['posicao'][1]));
            }

            if($valor_formatado && in_array('formatter', array_keys($valor)))
            {
                $f_class = new $valor['formatter'][0];
                $valor_formatado = call_user_func_array([$f_class, $valor['formatter'][1]], [$valor_formatado]);
            }

            $mapaFormatado[$chave] = $valor_formatado;
        }

        return $mapaFormatado;
    }

    public static function acolchoarNumero($numero, $tamanho_numero, $penas_ganso)
    {
        $numero = str_replace(",", "", $numero);
        if(strlen($numero) < $tamanho_numero)
        {
            return str_pad($numero, $tamanho_numero, $penas_ganso, STR_PAD_LEFT);
        }

        return $numero;
    }

    public static function mask($mask, $string)
    {
        $string = str_replace(" ", "", $string);
        for ($i = 0; $i < strlen($string); $i++)
        {
            $pos = strpos($mask, "#");
            if ($pos !== false)
            {
                $mask[$pos] = $string[$i];
            }
            else
            {
                $mask .= $string[$i];
            }
        }
        return $mask;
    }
}
