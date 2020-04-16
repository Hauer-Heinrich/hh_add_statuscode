<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "hh_add_statuscode".
 *
 * Auto generated 19-02-2020 11:22
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF['hh_add_statuscode'] = [
    'title' => 'Hauer-Heinrich - hh_add_statuscode',
    'description' => 'Hauer-Heinrich - add statuscode select box for page type redirect/shortcut',
    'category' => 'fe',
    'author' => 'Christian Hackl',
    'author_email' => 'chackl@hauer-heinrich.de',
    'author_company' => 'www.hauer-heinrich.de',
    'state' => 'stable',
    'version' => '0.1.21',
    'constraints' => [
        'depends' => [
            'typo3' => '10.3.0-10.4.99'
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'HauerHeinrich\\HhAddStatuscode\\' => 'Classes'
        ],
    ],
];
