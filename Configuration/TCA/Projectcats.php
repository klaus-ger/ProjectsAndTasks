<?php

$TCA['tx_projectsandtasks_domain_model_projectcats'] = array(
    'ctrl' => $TCA['tx_projectsandtasks_domain_model_projectcats']['ctrl'],
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
                'foreign_table' => 'tx_projectsandtasks_domain_model_projectcats',
                'foreign_table_where' => 'AND tx_projectsandtasks_domain_model_projectcats.uid=###REC_FIELD_l18n_parent### AND tx_projectsandtasks_domain_model_projectcats.sys_language_uid IN (-1,0)',
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

        'cat_title' => array(
            'exclude' => 0,
            'label' => 'Titel',
            'config' => array(
                'type' => 'text',
                'size' => 30,
            )
        ),

        'cat_parent' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        
        'cat_order' => array(
            'exclude' => 0,
            'label' => 'Status',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        
        
    ),
);
?>