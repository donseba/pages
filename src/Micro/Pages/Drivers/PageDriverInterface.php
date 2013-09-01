<?php


namespace Micro\Pages\Drivers;


interface PageDriverInterface {



    public function firstPage();


    public function page( $current, $parent = '' );




}