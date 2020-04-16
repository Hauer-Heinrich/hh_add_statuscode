<?php
declare(strict_types = 1);
namespace HauerHeinrich\HhAddStatuscode\Middleware;

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
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Checks mount points, shortcuts and redirects to the target.
 * Alternatively, checks if the current page is a redirect to an external page
 *
 * @internal this middleware might get removed in TYPO3 v10.x.
 */
class ShortcutMiddleware implements MiddlewareInterface {

    /**
     * @var TypoScriptFrontendController
     */
    private $controller;

    public function __construct() {
        $this->controller = $GLOBALS['TSFE'];
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        // Check for shortcut page and mount point redirect
        $redirectToUri = $this->getRedirectUri($request);
        if ($redirectToUri !== null && $redirectToUri !== (string)$request->getUri() && $this->controller->getRedirectUriForShortcut($request) !== null) {

            // Get sourcePage - the redirect page not the destination
            // check witch TYPO3 version
            // TODO: constant TYPO3_branch Deprecation
            // https://docs.typo3.org/c/typo3/cms-core/master/en-us/Changelog/10.3/Deprecation-90007-GlobalConstantsTYPO3_versionAndTYPO3_branch.html
            $TYPO3version = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_branch) >= \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger('10');
            if ($TYPO3version) { // >= 10
                $pageRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Domain\Repository\PageRepository::class);
            } else {
                $pageRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\Page\PageRepository::class);
            }

            $sourcePage = $pageRepository->getPage($this->controller->getRequestedId());
            if($sourcePage['status_code'] > 0) {
                return new RedirectResponse($redirectToUri, $sourcePage['status_code']);
            }

            return new RedirectResponse($redirectToUri, 307);
        }

        return $handler->handle($request);
    }

    protected function getRedirectUri(ServerRequestInterface $request): ?string {
        $redirectToUri = $this->controller->getRedirectUriForShortcut($request);
        if ($redirectToUri !== null) {
            return $redirectToUri;
        }

        return $this->controller->getRedirectUriForMountPoint($request);
    }
}
