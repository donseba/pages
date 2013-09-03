<?php


namespace Micro\Pages\Drivers;


interface PageDriverInterface {


    public function __construct();


    public function firstPage();


    public function page( $current, $parent = array() );


    public function noPage();


}