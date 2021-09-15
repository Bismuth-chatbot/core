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

namespace Bismuth\Mercure;

use Bismuth\Message\Message as Message;
use Bismuth\Twitch\Message as TwitchMessage;
use Symfony\Component\HttpClient\Chunk\ServerSentEvent;
use Symfony\Component\HttpClient\EventSourceHttpClient;
use Symfony\Component\Serializer\SerializerInterface;

final class Consumer
{
    private EventSourceHttpClient $client;
    private SerializerInterface $serializer;
    private string $mercureHubUrl;

    public function __construct(EventSourceHttpClient $client, SerializerInterface $serializer, string $mercureHubUrl)
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->mercureHubUrl = $mercureHubUrl;
    }

    /**
     * @return \ArrayIterator|\Bismuth\Message\MessageInterface[]
     */
    public function __invoke(array $topics): \Iterator
    {
        $url = $this->mercureHubUrl.'?topic='.implode('&topic=', $topics);
        $source = $this->client->connect($url);

        while ($source) {
            foreach ($this->client->stream($source, 2) as $r => $chunk) {
                if ($chunk->isTimeout() || $chunk->isFirst()) {
                    continue;
                }

                if ($chunk->isLast()) {
                    $source = null;

                    return;
                }

                if ($chunk instanceof ServerSentEvent) {
                    yield $this->serializer->deserialize($chunk->getData(), $this->getMessageClass($topics), 'json');
                }
            }
        }
    }

    private function getMessageClass(array $topics): string
    {
        if (strpos($topics[0], 'twitch.tv')) {
            return TwitchMessage::class;
        }

        return Message::class;
    }
}
