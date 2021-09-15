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

namespace Bismuth\Model;

class User
{
    private string $username;
    private int $score;

    public function __construct(string $username, int $score)
    {
        $this->score = $score;
        $this->username = $username;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }
}
