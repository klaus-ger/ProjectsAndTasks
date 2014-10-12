<?php

return array(
   'ctrl' => array(
        'title' => 'Company',
        'label' => 'cy_short',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'dividers2tabs' => TRUE,
        'versioningWS' => 2,
        'versioning_followPages' => TRUE,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l18n_parent',
        'transOrigDiffSourceField' => 'l18n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'searchFields' => 'cat_titel',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('projects_and_tasks') . 'Resources/Public/Icons/tableicon.gif'
    ),
    'interface' => array(
        'showRecordFieldList' => '    calender_date
                                    , calender_user
                                    , calender_daynote;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css]'
    ),
    'types' => array(
        '1' => array('showitem' => '  calender_date
                                     , calender_user
                                     , calender_daynote;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css]
                                     ')
    ),
    'palettes' => array(
        '1' => array('showitem' => '')
    ),
    'columns' => array(
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.php:LGL.default_value', 0)
                )
            )
        ),
        'l18n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_projectsandtasks_domain_model_company',
                'foreign_table_where' => 'AND tx_projectsandtasks_domain_model_company.uid=###REC_FIELD_l18n_parent### AND tx_projectsandtasks_domain_model_company.sys_language_uid IN (-1,0)',
            )
        ),
        'l18n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough')
        ),
        't3ver_label' => array(
            'displayCond' => 'FIELD:t3ver_label:REQ:true',
            'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
            'config' => array(
                'type' => 'none',
                'cols' => 27
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check'
            )
        ),
        'crdate' => array(
            'exclude' => 0,
            'label' => 'crdate',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            )
        ),
        'cy_name' => array(
            'exclude' => 0,
            'label' => 'Titel',
            'config' => array(
                'type' => 'text',
                'size' => 30,
            )
        ),
        'cy_short' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        'cy_street' => array(
            'exclude' => 0,
            'label' => 'Status',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        'cy_plz' => array(
            'exclude' => 0,
            'label' => 'Text',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        'cy_city' => array(
            'exclude' => 0,
            'label' => 'Text',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        'cy_web' => array(
            'exclude' => 0,
            'label' => 'Text',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        'cy_mail' => array(
            'exclude' => 0,
            'label' => 'Text',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        'cy_telephone' => array(
            'exclude' => 0,
            'label' => 'Text',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        'cy_customer' => array(
            'exclude' => 0,
            'label' => 'Text',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        'cy_comment' => array(
            'exclude' => 0,
            'label' => 'Text',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
    ),
);
?>