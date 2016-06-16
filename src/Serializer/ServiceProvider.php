<?php

namespace Eole\Sandstone\Serializer;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['serializer.builder'] = function () use ($app) {
            $builder = SerializerBuilder::create()
                ->setDebug($app['debug'])
                ->addMetadataDir(__DIR__)
            ;

            if ($app->offsetExists('serializer.cache_dir')) {
                $builder->setCacheDir($app['serializer.cache_dir']);
            }

            return $builder;
        };

        $app['serializer'] = function () use ($app) {
            return $app['serializer.builder']->build();
        };
    }
}
