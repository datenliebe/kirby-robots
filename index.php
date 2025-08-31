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

    // Blueprints
    'blueprints' => [
        // Tabs
        'tabs/robots' => __DIR__ . '/blueprints/tabs/robots.yml',
        // Fields
        'fields/robots-rules' => __DIR__ . '/blueprints/fields/rules.yml',
    ],

    // Plugin translations
    'translations' => [
        'de' => require __DIR__ . '/translations/de.php'
    ],

    // Default plugin options
    'options' => [
        'rules' => [], // Custom rules defined in config.php
    ]
]);
