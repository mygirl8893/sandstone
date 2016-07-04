<?php

namespace Eole\Sandstone\Push;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Eole\Sandstone\Push\Debug\TraceablePushServer;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@InheritDoc}
     */
    public function register(Container $app)
    {
        if (!$app->offsetExists('sandstone.push.enabled')) {
            $app['sandstone.push.enabled'] = true;
        }

        $app['sandstone.push.event_serializer'] = function () use ($app) {
            return new EventSerializer($app['serializer']);
        };

        $app['sandstone.push.event_forwarder'] = function () use ($app) {
            return new EventForwarder(
                $app['sandstone.push'],
                $app['dispatcher'],
                $app['sandstone.push.event_serializer'],
                $app['sandstone.push.enabled']
            );
        };
    }
}