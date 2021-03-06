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

namespace Bismuth\Service;

use Bismuth\Service\Exception\ClientServiceNotFoundException;

class ClientCollection implements IClient
{
    private iterable $clients;

    public function __construct(iterable $clients)
    {
        $this->clients = $clients;
    }

    public function sendMessage(string $message): void
    {
        /** @var IClient $client */
        foreach ($this->clients as $client) {
            $client->sendMessage($message);
        }
    }

    public function emit(string $messageType, array $content): void
    {
        /** @var IClient $client */
        foreach ($this->clients as $client) {
            $client->emit($messageType, $content);
        }
    }

    public function get(string $service): IClient
    {
        /** @var IClient $client */
        foreach ($this->clients as $client) {
            if (get_class($client) === $service) {
                return $client;
            }
        }
        throw new ClientServiceNotFoundException();
    }
}
