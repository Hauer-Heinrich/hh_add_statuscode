<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// Configure new fields:
$fields = [
    'status_code' => [
        'label' => 'Status code',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['307 - Temporary Redirect (default from TYPO3)', 0],
                ['301 - Moved Permanently', 301],
                ['302 - Found', 302],
                ['303 - See Other', 303],
                ['307 - Temporary Redirect (explicit)', 307],
            ],
        ],
    ],
];

// Add new fields to pages:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $fields);

// Make fields visible in the TCEforms:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages', // Table name
    'status_code', // Field list to add
    '4', // List of specific types to add the field list to. (If empty, all type entries are affected)
    'after:shortcut_mode' // Insert fields before (default) or after one, or replace a field
);
