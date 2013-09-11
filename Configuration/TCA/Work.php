<?php

$TCA['tx_projectsandtasks_domain_model_work'] = array(
    'ctrl' => $TCA['tx_projectsandtasks_domain_model_work']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'work_title,work_short, work_text;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css], work_sort, work_status, work_typ, work_parent'
    ),
    'types' => array(
        '1' => array('showitem' => 'work_title,work_short, work_text;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css], work_sort, work_status,work_typ, work_parent')
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
                'foreign_table' => 'tx_projectsandtasks_domain_work',
                'foreign_table_where' => 'AND tx_projectsandtasks_domain_model_work.uid=###REC_FIELD_l18n_parent### AND tx_projectsandtasks_domain_model_work.sys_language_uid IN (-1,0)',
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
        'work_project' => array(
            'exclude' => 0,
            'label' => 'Project',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            )
        ),
        'work_user' => array(
            'exclude' => 0,
            'label' => 'Text',
            'config' => array(
                'type' => 'text',
                'size' => 30,
            )
        ),
        'work_title' => array(
            'exclude' => 0,
            'label' => 'Sortierung',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
        'work_description' => array(
            'exclude' => 0,
            'label' => 'Status',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
        'work_status' => array(
            'exclude' => 0,
            'label' => 'Elternelement ID',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
        'work_date' => array(
            'exclude' => 0,
            'label' => 'Elternelement ID',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
        'work_end' => array(
            'exclude' => 0,
            'label' => 'Elternelement ID',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
        'work_start' => array(
            'exclude' => 0,
            'label' => 'Elternelement ID',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
        'work_ticket' => array(
            'exclude' => 0,
            'label' => 'Elternelement ID',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
    ),
);
?>