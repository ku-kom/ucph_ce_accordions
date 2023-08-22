<?php


/*
 * This file is part of the package ucph_ce_accordions.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die('Access denied.');


call_user_func(function ($extKey ='ucph_ce_accordions', $contentType ='ucph_ce_accordions') {
    // Add Content Element
    if (!is_array($GLOBALS['TCA']['tt_content']['types'][$contentType] ?? false)) {
        $GLOBALS['TCA']['tt_content']['types'][$contentType] = [];
    }

    // Allowed CTypes inside accordions
    $allowedCTypes = 'ucph_ce_text, ucph_ce_image, ucph_ce_textimage';

    // UCPH TYPO3 content element "Accordions" container
    // Activate extension container if extension is activated
    if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('container')) {
        \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
            (
                new \B13\Container\Tca\ContainerConfiguration(
                    $contentType, // CType
                    'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:label', // label
                    'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:description', // description
                    [
                        [
                            ['name' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:add_content', 'colPos' => 203, 'allowed' => ['CType' => $allowedCTypes]]
                        ]
                    ]
                )
            )
            ->setIcon('EXT:' . $extKey . '/Resources/Public/Icons/accordion.svg')
            // Wizard tab name
            ->setGroup('interactive')         
        );
    }
    // Assign Icon
    $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'][$contentType] = 'ucph-ce-accordions-icon';

    // Configure element type
    $GLOBALS['TCA']['tt_content']['types'][$contentType] = array_replace_recursive(
        $GLOBALS['TCA']['tt_content']['types'][$contentType],
        [
            'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
            --div--;LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:options,
                pi_flexform;LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:advanced,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                --palette--;;hidden,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                categories,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                rowDescription,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
            ',
            'columnsOverrides' => [
                'bodytext' => [
                    'config' => [
                        'enableRichtext' => true,
                        'richtextConfiguration' => 'default',
                    ],
                ],
            ],
        ]
    );

    // Add flexForms for content element configuration
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:' . $extKey . '/Configuration/FlexForms/ucphCeAccordions.xml',
        $contentType
    );
});
