<?php
declare(strict_types = 1);
namespace HauerHeinrich\HhAddStatuscode\Xclass;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

// use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Core\Utility\HttpUtility;

class TypoScriptFrontendController extends \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController {

    /**
     * Builds a typolink to the current page, appends the type paremeter if required
     * and redirects the user to the generated URL using a Location header.
     */
    protected function redirectToCurrentPage() {
        $this->calculateLinkVars();
        // Instantiate \TYPO3\CMS\Frontend\ContentObject to generate the correct target URL
        /** @var $cObj ContentObjectRenderer */
        $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $parameter = $this->page['uid'];
        $type = GeneralUtility::_GET('type');

        if ($type && MathUtility::canBeInterpretedAsInteger($type)) {
            $parameter .= ',' . $type;
        }

        $redirectUrl = $cObj->typoLink_URL([
            'parameter' => $parameter,
            'addQueryString' => true,
            'addQueryString.' => [
                'exclude' => 'id'
            ]
        ]);

        // Prevent redirection loop
        if (!empty($redirectUrl) && GeneralUtility::getIndpEnv('REQUEST_URI') !== '/' . $redirectUrl) {
            // redirect and exit
            switch ($this->originalShortcutPage['status_code']) {
                case 303:
                    HttpUtility::redirect($redirectUrl, HttpUtility::HTTP_STATUS_303);
                    break;
                case 302:
                    HttpUtility::redirect($redirectUrl, HttpUtility::HTTP_STATUS_302);
                    break;
                case 301:
                    HttpUtility::redirect($redirectUrl, HttpUtility::HTTP_STATUS_301);
                    break;
                default:
                    HttpUtility::redirect($redirectUrl, HttpUtility::HTTP_STATUS_307);
                    break;
            }
        }
    }
}
