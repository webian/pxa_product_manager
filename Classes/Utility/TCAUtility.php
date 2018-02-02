<?php
declare(strict_types=1);

namespace Pixelant\PxaProductManager\Utility;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Pavlo Zaporozkyi <pavlo@pixelant.se>, Pixelant
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Pixelant\PxaProductManager\Domain\Model\Attribute;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Class TCAUtility
 * @package Pixelant\PxaProductManager\Utility
 */
class TCAUtility
{
    /**
     * Return TCA configuration of different types of attributes
     *
     * @return array
     */
    public static function getDefaultAttributesTCAConfiguration(): array
    {
        return [
            Attribute::ATTRIBUTE_TYPE_INPUT => [
                'exclude' => 0,
                'label' => '',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim',
                ]
            ],

            Attribute::ATTRIBUTE_TYPE_TEXT => [
                'exclude' => 0,
                'label' => '',
                'config' => [
                    'type' => 'text',
                    'cols' => '48',
                    'rows' => '8',
                    'eval' => 'trim'
                ]
            ],

            Attribute::ATTRIBUTE_TYPE_CHECKBOX => [
                'exclude' => 0,
                'label' => '',
                'config' => [
                    'type' => 'check',
                ]
            ],

            Attribute::ATTRIBUTE_TYPE_DROPDOWN => [
                'exclude' => 0,
                'label' => '',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [],
                    'size' => 1,
                    'maxitems' => 1
                ]
            ],

            Attribute::ATTRIBUTE_TYPE_MULTISELECT => [
                'exclude' => 0,
                'label' => '',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectMultipleSideBySide',
                    'items' => [],
                    'size' => 10,
                    'maxitems' => 99,
                    'multiple' => 0,
                ]
            ],

            Attribute::ATTRIBUTE_TYPE_DATETIME => [
                'exclude' => 0,
                'label' => '',
                'config' => [
                    'type' => 'input',
                    'renderType' => 'inputDateTime',
                    'eval' => 'datetime'
                ]
            ],

            Attribute::ATTRIBUTE_TYPE_LINK => [
                'exclude' => 0,
                'config' => [
                    'type' => 'input',
                    'size' => '30',
                    'max' => '256',
                    'eval' => 'trim',
                    'renderType' => 'inputLink',
                    'softref' => 'typolink'
                ],
            ],

            Attribute::ATTRIBUTE_TYPE_LABEL => [
                'exclude' => 0,
                'label' => '',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim',
                ]
            ]
        ];
    }

    /**
     * Fal image dynamic configuration
     *
     * @param string $field
     * @param int $uid
     * @param string $name
     * @return array
     */
    public static function getImageFieldTCAConfiguration(string $field, int $uid, string $name): array
    {
        return [
            'exclude' => 0,
            'label' => '',
            // @codingStandardsIgnoreStart
            'config' => ExtensionManagementUtility::getFileFieldTCAConfig(
                $field,
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                        'showPossibleLocalizationRecords' => false,
                        'showRemovedLocalizationRecords' => true,
                        'showAllLocalizationLink' => false,
                        'showSynchronizationLink' => false
                    ],
                    'foreign_match_fields' => [
                        'fieldname' => 'attribute_images',
                        'tablenames' => 'tx_pxaproductmanager_domain_model_product',
                        'table_local' => 'sys_file',
                        'pxa_attribute' => $uid
                    ],
                    'overrideChildTca' => [
                        'columns' => [
                            'pxa_attribute' => [
                                'config' => [
                                    'items' => [
                                        [
                                            $name,
                                            $uid
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'types' => [
                            '0' => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;pxaProductManagerPaletteAttribute,
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ],
                            File::FILETYPE_TEXT => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;pxaProductManagerPaletteAttribute,
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ],
                            File::FILETYPE_IMAGE => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;pxaProductManagerPaletteAttribute,
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ],
                            File::FILETYPE_AUDIO => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;pxaProductManagerPaletteAttribute,
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ],
                            File::FILETYPE_VIDEO => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;pxaProductManagerPaletteAttribute,
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ],
                            File::FILETYPE_APPLICATION => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;pxaProductManagerPaletteAttribute,
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ]
                        ]
                    ]
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )
            // @codingStandardsIgnoreEnd
        ];
    }
}