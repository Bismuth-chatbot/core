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

namespace Bismuth\Twitch;

use Bismuth\Mercure\Consumer as MercureConsumer;
use Bismuth\Transport\TransportInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Transport implements TransportInterface
{
    private MercureConsumer $mercureConsumer;
    private HttpClientInterface $httpClient;
    private string $twitchChannel;
    private string $httpHost;

    public function __construct(HttpClientInterface $httpClient, MercureConsumer $mercureConsumer, string $twitchChannel, string $httpHost)
    {
        $this->mercureConsumer = $mercureConsumer;
        $this->httpClient = $httpClient;
        $this->twitchChannel = $twitchChannel;
        $this->httpHost = $httpHost;
    }

    public function commands(string $command): \Iterator
    {
        $topics = [sprintf('https://twitch.tv/%s/command/%s', $this->twitchChannel, $command)];
        foreach ($this->mercureConsumer->__invoke($topics) as $message) {
            yield $message;
        }
    }

    public function send(string $message): void
    {
        $response = $this->httpClient->request('POST', sprintf('http://%s/twitch', $this->httpHost), [
            'json' => ['message' => $message],
        ]);
    }
}
