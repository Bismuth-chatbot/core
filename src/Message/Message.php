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

namespace Bismuth\Message;

final class Message extends AbstractMessage
{
    public function isCommand(): bool
    {
        return false;
    }

    public function getCommand(): string
    {
        return '';
    }

    public function getCommandArguments(): array
    {
        return [];
    }
}
