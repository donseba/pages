<?php namespace Micro\Pages\Drivers;

use Illuminate\Support\Facades\DB;

class DatabaseDriver implements PageDriverInterface{

    protected $config;


    public function __construct( $config = array(), $language = '' )
    {
        $this->config = $config;
    }


    public function firstPage()
    {
        // get first public page with the default.

        $page = DB::table( $this->config['table'] )->where( $this->config['public'], '=', '1' )->first();

        if( null != $page )
        {
            return (object) $page;
        }

        return $this->noPage();
    }


    public function page( $current, $parent = '' )
    {
        $page = DB::table( $this->config['table'] )
                    ->where( $this->config['public'], '=', '1' )
                    ->where( $this->config['slug'], '=', $current )
                    ->first();

        if( is_array( $this->data ) )
        {
            foreach( $this->data AS $page )
            {
                if( $page['slug'] == $current && 1 == $page['public'] )
                {
                    if( '' == $parent && 0 == $page['parent'] ) // no parent slug is provided, so parent should be 0
                    {
                        return (object) $page;
                    }
                    elseif( (0 < $page['parent'] ) && $this->data[ $page['parent'] ]['slug'] == $parent )
                    {
                        return (object) $page;
                    }
                }
            }

            return $this->noPage();
        }
    }


    public function noPage()
    {
        if( is_array( $this->data ) && array_key_exists('P404', $this->data) )
        {
            return $this->data['P404'];
        }

        return (object) array(
            "parent"  => "0",
            "slug"    => "404",
            "title"   => "Whoops 404",
            "content" => "The page you where looking for doesn't exist",
            "public"  => "1"
        );
    }
}