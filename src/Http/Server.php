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

use React\EventLoop\LoopInterface;
use React\Http\Server as HttpServer;
use React\Socket\Server as ServerSocket;

final class Server
{
    private string $httpHost;

    public function __construct(string $httpHost)
    {
        $this->httpHost = $httpHost;
    }

    public function run(LoopInterface $loop, callable $func)
    {
        $server = new HttpServer($loop, $func);
        $server->listen(new ServerSocket('tcp://'.$this->httpHost, $loop));
    }

    public function getHttpHost()
    {
        return $this->httpHost;
    }
}
