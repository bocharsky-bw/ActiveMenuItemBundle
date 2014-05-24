<?php

namespace BW\ActiveMenuItemBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class BWExtension extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface The service container
     */
    protected $container;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * Constructor
     * 
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->request = $this->container->get('request');
    }


    public function getName()
    {
        return 'bw_active_menu_item.twig.bw_extension';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('is_active', array($this, 'isActiveFunction')),
            new \Twig_SimpleFunction('is_active_route', array($this, 'isActiveRouteFunction')),
        );
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('is_active', array($this, 'isActiveFilter')),
            new \Twig_SimpleFilter('is_active_route', array($this, 'isActiveRouteFilter')),
        );
    }

    /**
     * Check the active menu item by request URI
     *     Example: {{ path('route')|is_active }}
     *
     * @param string $requestUri The request URI
     *
     * @return string Empty string or "active current" string
     */
    public function isActiveFilter($requestUri)
    {
        $isActive = false;

        if (0 === strcasecmp(
            $this->request->getRequestUri(),
            $requestUri
        )) {
            $isActive = true;
        }

        return $this->buildClassAttr($isActive, $isActive);
    }

    /**
     * Check the active menu item by array of possible request URIs
     *     Example: {{ is_active([path('route_1'), path('route_2'), path('route_3')]) }}
     *
     * @param array $requestUriArray The array of possible request URIs
     * @param null|string $currentRequestUri The request URI of current menu item
     *
     * @return string The empty string or "active" string
     */
    public function isActiveFunction(array $requestUriArray, $currentRequestUri = null)
    {
        $isCurrent = false;
        $isActive = false;

        // Check whether current request URI is active
        if (null !== $currentRequestUri) {
            if (0 === strcasecmp(
                $this->request->getRequestUri(),
                $currentRequestUri
            )) {
                $isCurrent = true;
            }
        }

        // Check whether request URI is active
        if (true !== $isCurrent) {
            foreach ($requestUriArray as $requestUri) {
                if (0 === strcasecmp(
                    $this->request->getRequestUri(),
                    $requestUri
                )) {
                    $isActive = true;
                    break;
                }
            }
        }

        return $this->buildClassAttr($isCurrent, $isActive);
    }

    /**
     * Check the active menu item by route name
     *     Example: {{ 'route'|is_active_route }}
     *
     * @param string $route The route name
     *
     * @return string Empty string or "active current" string
     */
    public function isActiveRouteFilter($route)
    {
        $isActive = false;

        if (0 === strcasecmp(
            $this->request->attributes->get('_route'),
            $route
        )) {
            $isActive = true;
        }

        return $this->buildClassAttr($isActive, $isActive);
    }

    /**
     * Check active menu item by array of possible route names
     *     Example: {{ is_active_route(['route_1', 'route_2', 'route_3']) }}
     *
     * @param array $routes The array of possible route names
     * @param null|string $currentRoute The request URI of current menu item
     *
     * @return string Empty string or "active" string
     */
    public function isActiveRouteFunction(array $routes, $currentRoute = null)
    {
        $isCurrent = false;
        $isActive = false;

        // Check whether current route is active
        if (null !== $currentRoute) {
            if (0 === strcasecmp(
                $this->request->attributes->get('_route'),
                $currentRoute
            )) {
                $isCurrent = true;
            }
        }

        // Check whether route is active
        if (true !== $isCurrent) {
            foreach ($routes as $route) {
                if (0 === strcasecmp(
                    $this->request->attributes->get('_route'),
                    $route
                )) {
                    $isActive = true;
                    break;
                }
            }
        }

        return $this->buildClassAttr($isCurrent, $isActive);
    }

    /**
     * Create string of class attributes
     * @param $isCurrent
     * @param $isActive
     * @return string The string of class attributes
     */
    protected function buildClassAttr($isCurrent, $isActive) {
        $result = '';

        if (true === $isCurrent) {
            $result = 'current active';
        } elseif (true === $isActive) {
            $result = 'active';
        }

        return $result;
    }

}