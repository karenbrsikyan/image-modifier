<?php

declare(strict_types = 1);

namespace ImageModifier\Routing;

/**
 * Routing class to match request URL's against given routes and map them to a controller action.
 */
class Router
{
    const METHOD_HEAD    = 'HEAD';
    const METHOD_GET     = 'GET';
    const METHOD_POST    = 'POST';
    const METHOD_PUT     = 'PUT';
    const METHOD_PATCH   = 'PATCH';
    const METHOD_DELETE  = 'DELETE';
    const METHOD_PURGE   = 'PURGE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_TRACE   = 'TRACE';
    const METHOD_CONNECT = 'CONNECT';

    /**
     * RouteCollection that holds all Route objects
     *
     * @var RouteCollection
     */
    private $routes = [];

    /**
     * Array to store named routes in, used for reverse routing.
     *
     * @var array
     */
    private $namedRoutes = [];

    /**
     * The base REQUEST_URI. Gets prepended to all route url's.
     *
     * @var string
     */
    private $basePath = '';

    /**
     * @param RouteCollection $collection
     */
    public function __construct(RouteCollection $collection)
    {
        $this->routes = $collection;

        foreach ($this->routes->all() as $route) {
            $name = $route->getName();
            if (null !== $name) {
                $this->namedRoutes[$name] = $route;
            }
        }
    }

    /**
     * Set the base _url - gets prepended to all route _url's.
     *
     * @param $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Matches the current request against mapped routes
     */
    public function matchCurrentRequest()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUrl = $_SERVER['REQUEST_URI'];

        // strip GET variables from URL
        if (($pos = strpos($requestUrl, '?')) !== false) {
            $requestUrl = substr($requestUrl, 0, $pos);
        }

        return $this->match($requestUrl, $requestMethod);
    }

    /**
     * Match given request _url and request method and see if a route has been defined for it
     * If so, return route's target
     * If called multiple times
     *
     * @param string $requestUrl
     * @param string $requestMethod
     *
     * @return bool|Route
     */
    public function match($requestUrl, $requestMethod = self::METHOD_GET)
    {
        $currentDir = dirname($_SERVER['SCRIPT_NAME']);

        foreach ($this->routes->all() as $routes) {
            // compare server request method with route's allowed http methods
            if (! in_array($requestMethod, (array)$routes->getMethods(), true)) {
                continue;
            }

            if ('/' !== $currentDir) {
                $requestUrl = str_replace($currentDir, '', $requestUrl);
            }

            $pattern = preg_quote($this->basePath) . $routes->getRegex();
            if (!preg_match($pattern, $requestUrl, $matches)) {
                continue;
            }

            $params = array_values(
                array_filter(
                    $matches,
                    function ($k) {
                        return !is_int($k);
                    },
                    ARRAY_FILTER_USE_KEY
                )
            );

            $routes->setParameters($params);
            $routes->dispatch();

            return $routes;
        }

        return false;
    }
}
