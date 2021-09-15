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

namespace Bismuth\Twitch;

use Bismuth\Message\AbstractMessage;

final class Message extends AbstractMessage
{
    public function isCommand(): bool
    {
        return 0 === strpos($this->message, '!');
    }

    public function getCommand(): string
    {
        return explode(' ', substr($this->message, 1))[0];
    }

    public function getCommandArguments(): array
    {
        $command = explode(' ', substr($this->message, 1));

        return array_splice($command, 1);
    }
}
