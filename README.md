ActiveMenuItemBundle
====================

The bundle provides a few simple Twig filters and functions that help to highlight
current active menu items of simple HTML menu in Twig templates by adding specific
CSS classes.

## How to Install

Install the bundle with `Composer`:

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

But if you use Symfony Flex - it was already done automatically for you :)

## How to Use

To check whether the menu item route is active, simply use `is_active` Twig filter:

```twig
{{ 'route_name'|is_active }}
````

Or use `is_active_uri` Twig filter for check if menu item's request URI is active:

```twig
{{ path('route_name')|is_active_uri }}
```

If the route or the request URI is matched, filters return `current active` string
that you will need to use in `class` attribute of the menu item tag. Then, all you
need to do is add your custom CSS rules for those classes in your stylesheets.

### How to Use with Multi-level Nested Menu

To check an array of possible routes use `is_active()` Twig function where pass an array
of routes (all submenu item route names of the current item) as the first argument and
the current item route name as the second one.

For example, there is a simple HTML menu with nested submenu:

```html
<ul>
    <li class="{{ is_active([
        'subcategory1_route_name',
        'subcategory2_route_name',
    ], 'all_categories_route_name') }}">
        <a href="{{ path('all_categories_route_name') }}">All categories</a>
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
and its parent item - `all_categories_route_name` route - will have only `active` class.

And same for request URIs with `is_active_uri()` Twig function, but instead of passing
an array of routes, pass an array of URIs.

## Demo

This bundle has a demo page with an example of simple multi-level HTML menu. Create the next
file to see the demo in `dev` Symfony mode:
```yaml
# config/routes/dev/bw_active_menu_item.yaml

bw_active_menu_item:
    resource: "@BWActiveMenuItemBundle/Resources/config/routing.yml"
    prefix:   /bw/demo/active-menu-item
```

Then, run Symfony's built-in web server with `symfony serve` and go to:
https://localhost:8000/bw/demo/active-menu-item/index.
 
## Under the Hood

There are only [a few][1] simple Twig filters and functions, that's it!

*Simple, isn't it? :)*


[1]: https://github.com/bocharsky-bw/ActiveMenuItemBundle/blob/master/src/Twig/BWExtension.php
