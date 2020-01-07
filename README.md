ActiveMenuItemBundle
====================

The active menu item highlight of simple HTML menu for Symfony framework

## How to install

Install it with `Composer` first:

```bash
composer require bw/active-menu-item-bundle
```

Then, to use filters and functions in Twig, register this bundle in `bundles.php`: 

```php
// config/bundles.php

return [
    // other bundles...
    BW\ActiveMenuItemBundle\BWActiveMenuItemBundle::class => ['all' => true],
};
```

## How to use

To check whether menu item route is active, simply use `is_active` Twig filter:

```twig
{{ 'route_name'|is_active }}
````

Or use `is_active_uri` Twig filter for check if menu item's request URI is active:

```twig
{{ path('route_name')|is_active_uri }}
```

If route or request URI is match, filters return `current active` string.

### How to use with multilevel menu

To check array of possible routes use `is_active()` Twig function,
passed array of routes (all submenu item routes of current item)
as a first parameter and the current item route as a second parameter.

For example, there are simple HTML menu with submenu:

```html
<ul>
    <li class="{{ is_active([
        'subcategory1_route_name',
        'subcategory2_route_name',
    ], 'all_categories') }}">
        <a href="{{ path('all_categories') }}">All categories</a>
        <ul>
            <li class="{{ 'subcategory1_route_name'|is_active }}">
                <a href="{{ path('subcategory1_route_name') }}">Subcategory 1</a>
            </li>
            <li class="{{ 'subcategory2_route_name'|is_active }}">
                <a href="{{ path('subcategory2_route_name') }}">Subcategory 2</a>
            </li>
        </ul>
    </li>
</ul>
```

If the current route is `subcategory1_route_name`, it will have `current active` class
and its parent item - `all_categories` route - will have only `active` class.

And same for request URIs with `is_active_uri()` Twig function, but instead of passing
an array of routes, pass the array of URIs.

## Demo page

Bundle has demo page with example of simple multilevel HTML menu.
```yaml
# config/routes/dev/bw_active_menu.yaml

bw_active_menu_item:
    resource: "@BWActiveMenuItemBundle/Resources/config/routing.yml"
    prefix:   /bw/demo/active-menu-item
```

Run built in server `symfony serve` (or `php bin/console server:run`) and demo page
will be available at http://localhost:8000/bw/demo/active-menu-item/index.
 
## Under the hood

There are only [a few][1] additional simple Twig filters and functions for use.

*It's simple, isn't it? :)*


[1]: https://github.com/bocharsky-bw/ActiveMenuItemBundle/blob/master/src/BW/ActiveMenuItemBundle/Twig/BWExtension.php
