<?php

/**
 * Copyright © benedikt nünemann. All rights reserved.
 */

$sMetadataVersion = '2.1';
/**
 * Module information
 */
$aModule = [
    'id'          => \nuenemann\cookieconsent\Module::MODULE_ID,
    'title'       => 'cookieconsent für OXID 7',
    'description' => 'cookieconsent für OXID 7',
    'thumbnail'   => 'bn_logo.png',
    'version'     => '0.4.1',
    'author'      => 'Nünemann',
    'url'         => 'https://github.com/benedikt99-ger/cookieconsent',
    'email'       => 'benedikt@nuenemann.de',
	'extend' => [
		\OxidEsales\Eshop\Core\ViewConfig::class => \nuenemann\cookieconsent\Core\ViewConfig::class,
	],
    'controllers' => [
		'cookieconsent'  => \nuenemann\cookieconsent\Controller\CookieconsentController::class,
    ],	
    'templates' => [    ],	
   'settings' => [
        [
            'group' => 'CookieConsentMain','name' => 'CookieconsentInfoLink',
            'type' => 'str','value' => '','position' => 0
        ],
        [
            'group' => 'CookieConsentMain','name' => 'CookieconsentCategories',
            'type' => 'aarr','value' => [
                'ESSENTIAL' => 'Technisch notwendig',
                'ANALYTICS' => 'Analyse',
                'MARKETING' => 'Marketing',
				'UNCATEGORIZED' => 'ohne Kategorie',
            ],'position' => 2
        ]
    ]
];
