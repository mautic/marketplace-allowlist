<?php

return [
    'name'        => 'Mautic Check',
    'description' => 'Mautic Check is a plugin that checks quality and security issues in Plugins.',
    'version'     => '1.0.0',
    'author'      => 'Lenon Leite - lenonleite',
    'services'    => [
        'integrations' => [
            'mautic.integration.mauticcheck' => [
                'class' => \MauticPlugin\MauticCheckBundle\Integration\MauticCheckIntegration::class,
                'tags'  => [
                    'mautic.integration',
                    'mautic.basic_integration',
                ],
            ],
            'mautic.integration.mauticcheck.configuration' => [
                'class' => \MauticPlugin\MauticCheckBundle\Integration\Support\ConfigSupport::class,
                'tags'  => [
                    'mautic.config_integration',
                ],
            ],
            'mautic.integration.mauticcheck.config' => [
                'class' => \MauticPlugin\MauticCheckBundle\Integration\Config::class,
                'tags'  => [
                    'mautic.integrations.helper',
                ],
            ],
        ],
        'commands' => [
            'mautic.check.phpstan' => [
                'tag'       => 'console.command',
                'class'     => \MauticPlugin\MauticCheckBundle\Command\PHPStanCommand::class,
                'arguments' => [
                    'mautic.helper.paths',
                    'mautic.helper.core_parameters',
                ],
            ],
        ],
    ],
];
