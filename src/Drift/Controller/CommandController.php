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

namespace Bismuth\Drift\Controller;

use Bismuth\Service\IClient;
use Psr\Http\Message\RequestInterface;
use React\Http\Message\Response;

interface CommandController
{
    public function __invoke(IClient $client, RequestInterface $request): Response;
}
