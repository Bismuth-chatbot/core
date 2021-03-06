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

namespace Bismuth\Http;

use Bismuth\Model\User;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Client
{
    private HttpClientInterface $client;
    private string $httpHost;

    private SerializerInterface $serializer;

    public function __construct(HttpClientInterface $client, string $httpHost, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->httpHost = $httpHost;
        $this->serializer = $serializer;
    }

    public function postMessage(string $service, string $message)
    {
        return $this->client->request('POST', 'http://'.$this->httpHost.'/'.$service, [
            'json' => ['message' => $message],
        ]);
    }

    public function postUser(User $user)
    {
        return $this->client->request('POST', 'http://'.$this->httpHost.'/user', [
            'json' => json_decode($this->serializer->serialize($user, 'json'), true),
        ]);
    }

    public function postPing()
    {
        return $this->client->request('POST', 'http://'.$this->httpHost.'/ping', [
            'json' => ['message' => 'ping'],
        ]);
    }
}
