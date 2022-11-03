<?php

declare(strict_types = 1);

namespace ImageModifier\Tests\Unit\Routing;

use PHPUnit\Framework\TestCase;
use ImageModifier\Routing\Route;
use ImageModifier\Routing\Router;
use ImageModifier\Routing\RouteCollection;

class RouterTest extends TestCase
{
    /**
     * @dataProvider matcherProvider
     *
     * @param Router $router
     * @param string $path
     * @param string $expected
     */
    public function testMatch($router, $path, $expected)
    {
        self::assertEquals($expected, (bool) $router->match($path));
    }

    public function testMatchWrongMethod()
    {
        $router = $this->getRouter();
        self::assertFalse($router->match('/some-resource', 'POST'));
    }

    /**
     * @return Router
     */
    private function getRouter()
    {
        $collection = new RouteCollection();
        $collection->attachRoute(new Route('/^\/some-resource$/', array(
            '_controller' => 'ImageModifier\Tests\Unit\Fixtures\SomeController::someResourceCreate',
            'methods' => 'GET',
        )));
        $collection->attachRoute(new Route('/^\/some-resource\/(?P<id>[0-9]+)$/', array(
            '_controller' => 'ImageModifier\Tests\Unit\Fixtures\SomeController::someResource',
            'methods' => 'GET',
        )));
        $collection->attachRoute(new Route('/^\/$/', array(
            '_controller' => 'ImageModifier\Tests\Unit\Fixtures\SomeController::indexAction',
            'methods' => 'GET',
        )));

        return new Router($collection);
    }

    /**
     * @return mixed[][]
     */
    private function matcherProvider()
    {
        $router = $this->getRouter();

        return array(
            array($router, '/', true),
            array($router, '/dummy', false),
            array($router, '/some-resource', true),
            array($router, '/some-resource-dummy', false),
            array($router, '/some-resource/1', true),
            array($router, '/some-resource/%E3%81%82', false),
        );
    }
}