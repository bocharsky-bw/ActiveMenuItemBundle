<?php

namespace BW\ActiveMenuItemBundle\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class BWExtension extends AbstractExtension
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * Constructor
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }


    public function getName()
    {
        return 'bw_active_menu_item.twig.bw_extension';
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('is_active', array($this, 'isActiveFunction')),
            new TwigFunction('is_active_uri', array($this, 'isActiveUriFunction')),
        );
    }

    public function getFilters()
    {
        return array(
            new TwigFilter('is_active', array($this, 'isActiveFilter')),
            new TwigFilter('is_active_uri', array($this, 'isActiveUriFilter')),
        );
    }

    /**
     * Check the active menu item by request URI
     *     Example: {{ path('route')|is_active_uri }}
     *
     * @param string $requestUri The request URI
     *
     * @return string Empty string or "active current" string
     */
    public function isActiveUriFilter($requestUri)
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
     *     Example: {{ is_active_uri([path('route_1'), path('route_2'), path('route_3')]) }}
     *
     * @param array $requestUriArray The array of possible request URIs
     * @param null|string $currentRequestUri The request URI of current menu item
     *
     * @return string The empty string or "active" string
     */
    public function isActiveUriFunction(array $requestUriArray, $currentRequestUri = null)
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
     *     Example: {{ 'route'|is_active }}
     *
     * @param string $route The route name
     *
     * @return string Empty string or "active current" string
     */
    public function isActiveFilter($route)
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
     *     Example: {{ is_active(['route_1', 'route_2', 'route_3']) }}
     *
     * @param array $routes The array of possible route names
     * @param null|string $currentRoute The request URI of current menu item
     *
     * @return string Empty string or "active" string
     */
    public function isActiveFunction(array $routes, $currentRoute = null)
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
