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

namespace Bismuth\Mercure;

class Topic
{
    public static function create(array $params): string
    {
        $uri = 'https://twitch.tv/<channel>';
        if (isset($params['<command>'])) {
            $uri = $uri.'/command/<command>';
        }

        return strtr($uri, $params);
    }
}
