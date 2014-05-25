ActiveMenuItemBundle
====================
The active menu item highlight of simple HTML menu for Symfony framework

## How to install
Pretty simple with `Composer`, add to `composer.json` file:

    {
        "require": {
            "bw/active-menu-item-bundle": "~1.1"
        }
    }

and run `$ composer update` command.

### How to include 
To use filters and functions in `Twig`, register `BWActiveMenuItemBundle` 
in `app/AppKernel.php`: 

    public function registerBundles()
    {
        $bundles = array(
            // other bundles...
            new \BW\ActiveMenuItemBundle\BWActiveMenuItemBundle(),
        );

## How to use
To check whether menu item route is active, simply use `is_active` twig filter:

    {{ path('route_name')|is_active }}

or use `is_active_uri` twig filter for check whether menu item request URI is active:

    {{ 'route_name'|is_active_uri }}

If route or request URI is match, filters return `current active` string.

### How to use with multilevel menu
To check array of possible routes use `is_active` function, 
passed array of routes (all submenu item routes of current item) 
as a first parameter and the current item route as a second parameter. 

For example, there are simple HTML menu with submenu:

    <ul>
        <li class="{{ is_active([
            'subcategory1',
            'subcategory2',
        ], 'all_categories') }}">
            <a href="{{ path('all_categories') }}">All categories</a>
            <ul>
                <li class="{{ 'subcategory1'|is_active }}">
                    <a href="{{ path('subcategory1') }}">Subcategory 1</a>
                </li>
                <li class="{{ 'subcategory2'|is_active }}">
                    <a href="{{ path('subcategory2') }}">Subcategory 2</a>
                </li>
            </ul>
        </li>
    </ul>

If the current route is `subcategory1`, it has `current active` class 
and them parent item with `all_categories` route has only `active` class.

And same for request URIs with `is_active_uri` function.

## Demo page
Bundle has demo page with example of simple multilevel HTML menu.
Add to `app/config/routing_dev.yml` file: 

    bw_active_menu_item:
        resource: "@BWActiveMenuItemBundle/Resources/config/routing.yml"
        prefix:   /bw/demo/active-menu-item
 
Run built in server `php app/console server:run` and demo page will be available
at `http://localhost:8000/bw/demo/active-menu-item/index`.
 
## Under the hood
There are only [few][1] additional simple `Twig` filters and functions for use.

*It's simple, isn't it? :)*

[1]: https://github.com/bocharsky-bw/ActiveMenuItemBundle/blob/master/src/BW/ActiveMenuItemBundle/Twig/BWExtension.php