<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Propel\Bundle\PropelBundle\ValueResolver;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->set(ValueResolver\ModelValueResolver::class)
        ->tag('controller.argument_value_resolver', ['priority' => 200]);
};
