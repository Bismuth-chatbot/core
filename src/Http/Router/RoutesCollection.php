<?php

/*
 * This file is part of the Bizmuth Bot project
 *
 * (c) Lemay Marc <flugv1@gmail.com>
 *     Twitch channel : https://twitch.tv/flugv1
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @experimental
 */

declare(strict_types=1);

namespace Bismuth\Http\Router;

use Bismuth\Drift\Controller\CommandController;
use Bismuth\Http\Router\Exception\RouteNotFoundException;
use function Symfony\Component\String\u;

class RoutesCollection
{
    private iterable  $routes;

    public function __construct(iterable $routes)
    {
        $this->routes = $routes;
    }

    public function get(string $verb, string $path): CommandController
    {
        $resolver = RouteResolver::resolve($verb, $path);
        foreach ($this->routes as $route) {
            if (null !== u(get_class($route))->indexOf($resolver)) {
                return $route;
            }
        }
        throw new RouteNotFoundException();
    }
}
