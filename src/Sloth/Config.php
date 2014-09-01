<?php

class Sloth_Config
{

    const REL_PATH = '/sloth/src/Sloth';
    const BOLETO_ASSETS = '/Boleto/templates/imagens';

    public static $assets = '/';
    public static $rel_path = '/';

    /**
     * 
     * @param array $args
     * @example $args = ['assets' => '/my/assets' ,'rel_path' => '/my/rel/path'] 
     * @abstract Configurações de caminhos
     */
    public static function init(array $args)
    {
        $required = ['assets', 'rel_path'];
        foreach ($required as $r)
        {
            if (!array_key_exists($r, $args))
            {
                die('key ' . $r . ' is required');
            }
            self::$$r = $args[$r];
        }
    }

}
