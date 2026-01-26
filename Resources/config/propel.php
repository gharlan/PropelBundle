<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Propel\Bundle\PropelBundle;

return static function (ContainerConfigurator $container) {
    $services = $container->services();
    $parameters = $container->parameters();

    $parameters->set('propel.dbal.default_connection', 'default');

    $parameters->set('propel.schema_locator.class', PropelBundle\Service\SchemaLocator::class);
    $parameters->set('propel.data_collector.class', PropelBundle\DataCollector\PropelDataCollector::class);
    $parameters->set('propel.logger.class', PropelBundle\Logger\PropelLogger::class);
    $parameters->set('propel.twig.extension.syntax.class', PropelBundle\Twig\Extension\SyntaxExtension::class);
    $parameters->set('form.type_guesser.propel.class', PropelBundle\Form\TypeGuesser::class);
    $parameters->set('propel.form.type.model.class', PropelBundle\Form\Type\ModelType::class);
    $parameters->set('propel.dumper.yaml.class', PropelBundle\DataFixtures\Dumper\YamlDataDumper::class);
    $parameters->set('propel.loader.yaml.class', PropelBundle\DataFixtures\Loader\YamlDataLoader::class);
    $parameters->set('propel.loader.xml.class', PropelBundle\DataFixtures\Loader\XmlDataLoader::class);

    $services->set('propel.schema_locator', '%propel.schema_locator.class%')
        ->public()
        ->args([
            service('file_locator'),
            '%propel.configuration%',
        ]);

    $services->set('propel.logger', '%propel.logger.class%')
        ->public()
        ->args([
            service('logger')->nullOnInvalid(),
            service('debug.stopwatch')->nullOnInvalid(),
        ])
        ->tag('monolog.logger', ['channel' => 'propel']);

    $services->set('propel.data_collector', '%propel.data_collector.class%')
        ->private()
        ->args([service('propel.logger')])
        ->tag('data_collector', ['template' => '@Propel/Collector/propel', 'id' => 'propel']);

    $services->set('propel.twig.extension.syntax', '%propel.twig.extension.syntax.class%')
        ->tag('twig.extension');

    $services->set('form.type_guesser.propel', '%form.type_guesser.propel.class%')
        ->tag('form.type_guesser');

    $services->set('propel.form.type.model', '%propel.form.type.model.class%')
        ->tag('form.type', ['alias' => 'model']);

    $services->set('propel.dumper.yaml', '%propel.dumper.yaml.class%')
        ->args([
            '%kernel.project_dir%',
            '%propel.configuration%',
        ]);

    $services->set('propel.loader.yaml', '%propel.loader.yaml.class%')
        ->args([
            '%kernel.project_dir%',
            '%propel.configuration%',
            service('faker.generator')->nullOnInvalid(),
        ]);

    $services->set('propel.loader.xml', '%propel.loader.xml.class%')
        ->args([
            '%kernel.project_dir%',
            '%propel.configuration%',
        ]);

    $services->set(PropelBundle\Controller\PanelController::class)
        ->public()
        ->args([
            service('parameter_bag'),
            service('twig'),
            service('profiler'),
        ]);
};
