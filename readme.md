Micro Pages
===========

[![Latest Stable Version](https://poser.pugx.org/micro/pages/v/stable.png)](https://packagist.org/packages/micro/pages)
[![Total Downloads](https://poser.pugx.org/micro/pages/downloads.png)](https://packagist.org/packages/micro/pages)

Micro Pages is an component to translate URL slugs `http://domain.tld/slug-1/slug-2/slug-3` and find the respective resources.

# Drivers working on
* Json -> Local json file with all page content
* Database -> use the database connection to get contents relative to the slug.
 
# Drivers to come
* JsonE    -> fetch results from external Json source
* XML      -> For the enterprise ^-^
 
# Installation in Laravel 4.x

Add provider to the Providers array `app/config/app.php`
```
    'Micro\Pages\PagesServiceProvider',
```

Add Facade to the Facades array `app/config/app.php`
```
    'Micro\Pages\Support\Facades\Pages',
```

Add the following in your `app/routes.php` 

best would be to add this at the end. This will CATCH all routes.

```
Route::any('{all}', function() { 
    $page = Pages::getPage(); 
    
    return View::make('base', ( is_array($page) ? $page : array() ) );
    
})->where('all', '.*');
```

Replace `base` with the view you want to use for your pages. For now $page will consist of the following : 

```
$page = array(
    'id'        => (int)    1
    'parent_id' => (int)    0,
    'public'    => (int)    1,
    'title'     => (string) 'Page title',
    'slug'      => (string) 'page-slug',
    'content'   => (string) 'The content of your page',
);
```

# Examples
### JSON Configuration File 
See the config file for the json file location : 

```
[{
    "en" => {
        "1" => {
            "parent_id" => "0"
            "slug"      => "one",
            "title"     => "Title of page one"
            "content"   => "Some content for the first page"
            "public"    => "1"
        },
        "2" => {
            "parent_id" => "1"
            "slug"      => "two",
            "title"     => "Title of second page"
            "content"   => "Some content for the third page <br/> And additional line of text"
            "public"    => "1"
        },
        "3" => {
            "parent_id" => "2"
            "slug"      => "three",
            "title"     => "Title of page three"
            "content"   => "Some content for the third page"
            "public"    => "0"
        },
        "4" => {
            "parent_id" => "0"
            "slug"      => "four",
            "title"     => "Title of page four"
            "content"   => "Some content for the fourth page"
            "public"    => "1"
        }
    }
}]
```

### Database Driver
Mandatory of this driver is that it needs an active database connection.

In the config you need to provite the table to look for, and asign the table fields. 
This may be different if you are comming from another system. 

As long as you are using eloquent this should work fluent-ly ;)

```
    'database' => array(
            'table'       => 'pages',
            'id'          => 'id',
            'parent_id'   => 'parent_id',
            'language_id' => 'language_id',
            'title'       => 'title',
            'content'     => 'content'
        ),
```
