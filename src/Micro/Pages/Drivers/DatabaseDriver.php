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


    public function page( $current, $parents = array() )
    {
        $base = DB::table( $this->config['table'].' AS p0' )
            ->select( 'p0.*' )
            ->where( 'p0.'.$this->config['public'], '=', '1' )
            ->where( 'p0.'.$this->config['slug'], '=', $current );

        if( !empty($parents) )
        {
            $allParents = array_values($parents);
            foreach( $allParents AS $key => $parentSlug ){

                $base->join( $this->config['table'].' AS p'.($key+1), function($join) use ($parentSlug, $key)
                {
                    $join->on( 'p'.$key.'.'.$this->config['parent_id'], '=', 'p'.($key+1).'.'.$this->config['id'] );
                })->where( 'p'.($key+1).'.'.$this->config['slug'], '=', $parentSlug );
            }
        }

        $page = $base->first();

        if( null != $page )
        {
            return $page;
        }

        return $this->noPage();
    }


    public function noPage()
    {
        if( is_array( $this->config ) && array_key_exists('P404', $this->config ) )
        {
            return $this->config['P404'];
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