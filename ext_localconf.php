<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function() {
    $version9 = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_branch) >= \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger('9.3');
    // if TYPO3 version 9 or higher:
    if($version9) {
        // TYPO3 >= 9 uses middleware instead of XCLASSes
    } else {
        // Add XCLASSes TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController'] = [
            'className' => 'HauerHeinrich\\HhAddStatuscode\\Xclass\\TypoScriptFrontendController'
        ];
    }
});
