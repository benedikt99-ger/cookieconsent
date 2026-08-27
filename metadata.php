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
    'version'     => '0.1.0',
    'author'      => 'Nünemann',
    'url'         => 'https://github.com/benedikt99-ger/cookieconsent',
    'email'       => 'benedikt@nuenemann.de',
	'extend' => [
	],
    'controllers' => [

    ],	
    'templates' => [

    ],	
   'settings' => [
        [
            'group' => 'CookieConsentMain','name' => 'CookieConsentSitekey',
            'type' => 'str','value' => '','position' => 0
        ],
        [
            'group' => 'CookieConsentMain','name' => 'CookieConsentSecret',
            'type' => 'str','value' => '','position' => 1
        ],
        [
            'group' => 'CookieConsentMain','name' => 'CookieConsentReasons',
            'type' => 'aarr','value' => [
                'small' => 'zu klein',
                'large' => 'zu groß',
                'dislike' => 'nicht gefallen'
            ],'position' => 2
        ],
        [
            'group' => 'CookieConsentMain','name' => 'CookieConsentEmail',
            'type' => 'str','value' => '','position' => 3
        ]
    ]
];
