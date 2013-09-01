<?php namespace Micro\Pages;


class Resource {

    public static function driver( $driver, $config = array(), $language )
    {
        $name = '\\Micro\\Pages\\Drivers\\'.ucfirst($driver).'Driver';

        return new $name( $config, $language );
    }

}