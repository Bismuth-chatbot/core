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

namespace Bismuth\Drift\Controller\Twitch;

use Bismuth\Drift\Controller\CommandController;
use Bismuth\Service\IClient;
use Psr\Http\Message\RequestInterface;
use React\Http\Message\Response;

class PostCommand implements CommandController
{
    public function __invoke(IClient $client, RequestInterface $request): Response
    {
        $body = json_decode($request->getBody()->getContents(), true);
        $client->sendMessage($body['message']);

        return new Response(204);
    }
}
