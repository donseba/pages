<?php namespace Micro\Pages;


class Pages {


    public static $listener  = null;


    public static $languages;


    public static $language;


    public static $languageForce = true;


    public static $page = null;


    public static $overhead = array();


    public static $baseURL = null;


    public static $driver       = 'json';
    public static $driverConfig = null;


    public static $segments;


    protected $driverInstance = null;


    public function __construct()
    {
        // check config if first URL Slug needs to be an language key
        if( !empty( static::$segments ) && array_key_exists( head( static::$segments ), static::$languages ) )
        {
            static::$language = head( static::$segments );
            array_shift( static::$segments );
        }
        elseif( true == static::$languageForce )
        {
            if( null !== static::$baseURL )
            {
                // redirect to base URL WITH language attribute
                header("Location: ".static::$baseURL );
                die();
            }
        }

        $this->driverInstance = Resource::driver( static::$driver, static::$driverConfig[ static::$driver ], static::$language );

        $parts = array_filter( array_reverse( static::$segments, true) );

        $this->loopParts( $parts );

        return static::$page;
    }


    public function loopParts( $parts=array() )
    {
        if( !empty( $parts ) )
        {
            foreach( $parts AS $key => $part )
            {
                $parentSlug = ( isset($parts[$key-1]) ? $parts[$key-1] : null );

                if( null !== $parentSlug )
                {
                    $result = $this->pageWithParent( $part, $parentSlug );
                }
                else
                {
                    $result = $this->pageWithoutParent( $part );
                }

                if( null != $result ){
                    static::$page     = $result;
                    static::$overhead = array_filter( array_slice( static::$segments, $key+1 ) );
                    break;
                }
            }
        }
        else
        {
            $this->homePage();
        }
    }


    public static function listen()
    {
        if( null == static::$listener )
        {
            static::$listener = new static;
        }

        return static::$listener;
    }


    public function getPage()
    {
        return static::$page;
    }


    public function homePage()
    {
        $page   = $this->driverInstance->firstPage();
        $result = $this->processResult( $page );

        if( null != $result ){
            static::$page = $result;
        }
    }


    public function pageWithoutParent( $current )
    {
        $result = $this->driverInstance->page( $current );

        return $this->processResult( $result );
    }


    public function pageWithParent( $current, $parent )
    {
        $result = $this->driverInstance->page( $current, $parent );


        return $this->processResult( $result );
    }


    public function processResult( $result )
    {
        if( null !== $result )
        {
            return $result;
        }

        return null;
    }

}