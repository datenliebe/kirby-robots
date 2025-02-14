<?php

Kirby::plugin('datenliebe/robots', [
    // Serve the robots.txt route
    'routes' => [
        [
            'pattern' => 'robots.txt',
            'method' => 'GET',
            'action' => function () {
                // Default disallow rules (always applied)
                $defaultDisallowPaths = [
                    '/kirby',
                    '/site',
                ];

                $defaultRules = "User-agent: *\n";
                foreach ($defaultDisallowPaths as $path) {
                    $defaultRules .= "Disallow: $path\n";
                }
                $defaultRules .= "\n";

                // Custom rules from config.php
                $customConfigRules = option('datenliebe.robots.rules', []);
                $configRules = '';
                foreach ($customConfigRules as $userAgent => $rules) {
                    $configRules .= "User-agent: $userAgent\n";
                    foreach ($rules as $type => $paths) {
                        foreach ($paths as $path) {
                            $configRules .= "$type: $path\n";
                        }
                    }
                    $configRules .= "\n";
                }

                // Custom rules from panel field
                $panelRules = site()->robotsRules()->value();

                // Combine all rules
                $content = $defaultRules . $configRules . $panelRules;

                // Serve the robots.txt content
                return new Kirby\Http\Response($content, 'text/plain');
            }
        ]
    ],

    // Plugin translations
    'translations' => [
        'en' => require __DIR__ . '/translations/en.php',
        'de' => require __DIR__ . '/translations/de.php'
    ],

    // Blueprint for the robots.txt field and tab
    'blueprints' => [
        'tabs/robots' => [
            'label' => 'datenliebe.robots.tab.robotsRules.label',
            'icon' => 'bug',
            'fields' => [
                'robotsRules' => [
                    'label' => 'datenliebe.robots.field.robotsRules.label',
                    'type' => 'textarea',
                    'buttons' => false,
                    'font' => 'monospace',
                    'help' => 'datenliebe.robots.field.robotsRules.help',
                ],
            ],
        ],
    ],

    // Default plugin options
    'options' => [
        'rules' => [], // Custom rules defined in config.php
    ]
]);
