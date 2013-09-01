<?php namespace Micro\Pages\Drivers;


class JsonDriver implements PageDriverInterface{

    protected $data;


    public function __construct( $config = array(), $language = '' )
    {
        if( array_key_exists( 'location', $config ) )
        {
            $data = json_decode( file_get_contents( $config['location'] ), true);
        }

        if( is_array( $data ) && array_key_exists( $language, $data) )
        {
            $this->data = $data[ $language ];
        }
    }


    public function firstPage()
    {
        if( is_array( $this->data ) )
        {
            return head( $this->data );
        }

        return $this->noPage();
    }


    public function page( $current, $parent = '' )
    {
        if( is_array( $this->data ) )
        {
            foreach( $this->data AS $page )
            {
                if( $page['slug'] == $current && 1 == $page['public'] )
                {
                    if( '' == $parent && 0 == $page['parent'] ) // no parent slug is provided, so parent should be 0
                    {
                        return $page;
                    }
                    elseif( (0 < $page['parent'] ) && $this->data[ $page['parent'] ]['slug'] == $parent )
                    {
                        return $page;
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

        return array(
            "parent"  => "0",
            "slug"    => "404",
            "title"   => "Whoops 404",
            "content" => "The page you where looking for doesn't exist",
            "public"  => "1"
        );
    }
}