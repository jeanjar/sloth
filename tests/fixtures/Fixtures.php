<?php

class Fixtures {

    public static function get_boleto_data($banco = null, $boolean)
    {
        $data = FixturesData::get_default_data();
        $getbanco = 'get_'.$banco;

        if(method_exists('FixturesData', $getbanco))
        {
            $data = array_merge($data, FixturesData::$getbanco());
        }

        return $data;
    }

}
