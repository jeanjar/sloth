<?php

class Fixtures {

    public static function boleto_bb($assert = true)
    {
        if($assert)
        {
            return FixturesData::dados_bb_right();
        } else {
            return FixturesData::dados_bb_wrong();
        }

    }

}
