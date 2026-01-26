<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Propel\Bundle\PropelBundle\Security;

return static function (ContainerConfigurator $container) {
    $services = $container->services();
    $parameters = $container->parameters();

    $parameters->set('propel.security.user.provider.class', Security\User\PropelUserProvider::class);

    $services->set('propel.security.user.provider', '%propel.security.user.provider.class%')
        ->private()
        ->abstract();
};
