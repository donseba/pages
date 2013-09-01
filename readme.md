Micro Pages
===========

* INSTALLATION

Providers : 'Micro\Pages\PagesServiceProvider',
Facades   : 'Pages' => 'Micro\Pages\Support\Facades\Pages'

At the end of the routes add :


Route::any('{all}', function()
{
    $page = Pages::getPage();
    return View::make('base', ( is_array($page) ? $page : array() ) );

})->where('all', '.*');


For now ONLY json file supported. Database will follow soon.

more documentation will follow soon.