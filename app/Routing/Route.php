<?php

declare(strict_types = 1);

namespace ImageModifier\Routing;

class Route
{
    /**
     * URL of this Route
     *
     * @var string
     */
    private $url;

    /**
     * Accepted HTTP methods for this route.
     *
     * @var string[]
     */
    private $methods;

    /**
     * Target for this route, can be anything.
     *
     * @var mixed
     */
    private $target;

    /**
     * The name of this route
     *
     * @var string
     */
    private $name;

    /**
     * Array containing parameters passed through request URL
     *
     * @var array
     */
    private $parameters = [];

    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $config;

    /**
     * @param $resource
     * @param array $config
     */
    public function __construct($resource, array $config)
    {
        $this->url        = $resource;
        $this->config     = $config;
        $this->methods    = isset($config['methods']) ? (array) $config['methods'] : [];
        $this->target     = isset($config['target']) ? $config['target'] : null;
        $this->name       = isset($config['name']) ? $config['name'] : null;
        $this->parameters = isset($config['parameters']) ? $config['parameters'] : [];
        $action           = explode('::', $this->config['_controller']);
        $this->action     = isset($action[1]) ? $action[1] : null;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $url = (string)$url;

        // make sure that the URL is suffixed with a forward slash
        if (substr($url, -1) !== '/') {
            $url .= '/';
        }

        $this->url = $url;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function setMethods(array $methods)
    {
        $this->methods = $methods;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = (string)$name;
    }

    public function getRegex()
    {
        return preg_replace('/(\:\w\+)/', '([\w-%]+)', $this->url);
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function dispatch()
    {
        $action = explode('::', $this->config['_controller']);
        $instance = new $action[0];

        if (empty($action[1]) || trim($action[1]) === '') {
            call_user_func_array($instance, $this->parameters);

            return ;
        }

        call_user_func_array(array($instance, $action[1]), $this->parameters);
    }

    public function getAction()
    {
        return $this->action;
    }
}
