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

namespace Bismuth\Exception;

class TwitchConnectionFailedException extends \Exception
{
    public function __construct($socketError)
    {
        parent::__construct(sprintf('The connection to the irc chan failed: %s', $socketError));
    }
}
