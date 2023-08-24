<?php

defined('TYPO3') or die('Access denied.');

call_user_func(function () {
    /**
     * Temporary variables
     */
    $extensionKey = 'ucph_content_accordions';

    /**
     * Default TypoScript for ucph_content_accordions
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'UCPH TYPO3 content element "Accordions"'
    );
});
