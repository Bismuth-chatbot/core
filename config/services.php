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

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Bismuth\Http\Router\RoutesCollection;
use Bismuth\Twitch\Client as TwitchClient;
use Symfony\Component\HttpClient\EventSourceHttpClient;
use Symfony\Component\Mercure\Jwt\StaticJwtProvider;
use Symfony\Component\Mercure\Publisher;
use Symfony\Contracts\HttpClient\HttpClientInterface;

return function (ContainerConfigurator $configurator) {
    $parameters = $configurator->parameters();
    $parameters->set('app.mercure.jwt', $_ENV['MERCURE_JWT_TOKEN'])
        ->set('app.mercure.hub', $_ENV['MERCURE_HUB_URL'])
    ;
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->bind('$twitchChannel', '%app.twitch.channel_name%')
        ->bind('$commands', ['app:logger'])
        ->bind('$httpHost', '0.0.0.0:8080')
        ->bind('$mercureHubUrl', '%app.mercure.hub%')

    ;
    /*
     * Twitch settings
     */
    $configurator->parameters()
        ->set('app.twitch.oauth_token', $_ENV['TWITCH_OAUTH_TOKEN'])
        ->set('app.twitch.bot_username', $_ENV['TWITCH_BOT_USERNAME'])
        ->set('app.twitch.channel_name', $_ENV['TWITCH_CHANNEL_NAME'])
    ;
    $services->load('Bismuth\\', '../src/*')
        ->exclude('../src/{DependencyInjection,Entity,Tests,Kernel.php}')
    ;
    // Register every commands
    $services->load('Bismuth\\Command\\', '../src/Command/')->tag('console.command');
    $services->set(StaticJwtProvider::class)->arg('$jwt', '%app.mercure.jwt%');
    $services->set(EventSourceHttpClient::class);
    $services->set(Publisher::class)
        ->args([
            '%app.mercure.hub%',
            service(StaticJwtProvider::class),
            service(HttpClientInterface::class),
        ])
    ;
    $services->get(TwitchClient::class)
        ->arg('$oauthToken', '%app.twitch.oauth_token%')
        ->arg('$botUsername', '%app.twitch.bot_username%')
        ->arg('$twitchChannel', '%app.twitch.channel_name%')
        ->call('setLogger', [service('logger')])
        ->tag('app.service.client')
    ;
    $services->set(RoutesCollection::class)
        ->args([tagged_iterator('app.controller.command')])
    ;
};
