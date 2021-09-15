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

use function Symfony\Component\String\u;

class RouteResolver
{
    private const SUFFIX_COMMAND_CONTROLLER = 'Command';

    public static function resolve(string $verb, string $path): string
    {
        return (string) u($path)->slice(1)->lower()->camel()->title().'\\'.u($verb)->lower()->camel()->title().self::SUFFIX_COMMAND_CONTROLLER;
    }
}
