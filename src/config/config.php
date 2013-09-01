<?php


return array(

    'languages' => array( 'en' => 'English' ),

    'driver' => 'json',

    'driverConfig' => array(

        // Get pages information from json
        'json' => array(
            'location' => app_path('contents.json')
        ),

        // ToDo XML will be added for corporate support ;)
        'xml' => array(

        ),

        // ToDo Database with one table
        'database' => array(
            'id'          => 'id',
            'parent_id'   => 'parent_id',
            'language_id' => 'language_id',
            'title'       => 'title',
            'content'     => 'content'
        ),

        // ToDo Database Mulitable ( Some like it this way )
        'databaseML' => array(
            'tableMain' => array(
                'id'        => 'id',
                'parent_id' => 'parent_id',
            ),
            'tableSub' => array(
                'language_id' => 'language_id',
                'parent_id'   => 'parent_id',
                'title'       => 'title',
                'content'     => 'content'
            )
        )
    )


);