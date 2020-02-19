<?php
return [
    'frontend' => [
        'hauerheinrich/ext/statuscode' => [
            'target' => \HauerHeinrich\HhAddStatuscode\Middleware\ShortcutMiddleware::class,
            'before' => [
                'typo3/cms-frontend/shortcut-and-mountpoint-redirect',
            ],
            'after' => [
                'typo3/cms-frontend/prepare-tsfe-rendering',
            ],
        ]
    ]
];
