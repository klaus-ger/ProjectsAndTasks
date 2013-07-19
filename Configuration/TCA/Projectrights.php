<?php

$TCA['tx_projectsandtasks_domain_model_projectrights'] = array(
    'ctrl' => $TCA['tx_projectsandtasks_domain_model_projectrights']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'projectrights_title,projectrights_short, projectrights_text;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css], projectrights_sort, projectrights_status, projectrights_typ, projectrights_parent'
    ),
    'types' => array(
        '1' => array('showitem' => 'projectrights_title,projectrights_short, projectrights_text;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css], projectrights_sort, projectrights_status,projectrights_typ, projectrights_parent')
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
                'foreign_table' => 'tx_projectsandtasks_domain_model_projectrights',
                'foreign_table_where' => 'AND tx_projectsandtasks_domain_model_projectrights.uid=###REC_FIELD_l18n_parent### AND tx_projectsandtasks_domain_model_projectrights.sys_language_uid IN (-1,0)',
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
        'projectrights_project' => array(
            'exclude' => 0,
            'label' => 'Project',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'tx_projectsandtasks_domain_model_project',
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
            )
        ),
        'projectrights_user' => array(
            'exclude' => 0,
            'label' => 'Text',
            'config' => array(
                'type' => 'text',
                'size' => 30,
            )
        ),
        'projectrights_rights' => array(
            'exclude' => 0,
            'label' => 'Sortierung',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
        'projectrights_sticky' => array(
            'exclude' => 0,
            'label' => 'Sortierung',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
        
    ),
);
?>