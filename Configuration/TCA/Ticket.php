<?php

$TCA['tx_projectsandtasks_domain_model_ticket'] = array(
    'ctrl' => $TCA['tx_projectsandtasks_domain_model_ticket']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'calender_date, calender_user, calender_daynote;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css]'
    ),
    'types' => array(
        '1' => array('showitem' => 'calender_date, calender_user, calender_daynote;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css]')
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
                'foreign_table' => 'tx_projectsandtasks_domain_ticket',
                'foreign_table_where' => 'AND tx_projectsandtasks_domain_model_ticket.uid=###REC_FIELD_l18n_parent### AND tx_projectsandtasks_domain_model_ticket.sys_language_uid IN (-1,0)',
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
        'ticket_project' => array(
            'exclude' => 0,
            'label' => 'Projekt',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            )
        ),
        'ticket_customer' => array(
            'exclude' => 0,
            'label' => 'text',
            'config' => array(
                'type' => 'input',
                'size' => 8,
            )
        ),
        'ticket_title' => array(
            'exclude' => 0,
            'label' => 'TeTitel',
            'config' => array(
                'type' => 'text',
                'size' => 30,
            )
        ),
        'ticket_text' => array(
            'exclude' => 0,
            'label' => 'text',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        'ticket_time' => array(
            'exclude' => 0,
            'label' => 'text',
            'config' => array(
                'type' => 'input',
                'size' => 8,
            )
        ),
        'ticket_deadline' => array(
            'exclude' => 0,
            'label' => 'text',
            'config' => array(
                'type' => 'input',
                'size' => 8,
            )
        ),
        'ticket_date' => array(
            'exclude' => 0,
            'label' => 'text',
            'config' => array(
                'type' => 'input',
                'size' => 8,
            )
        ),
        'ticket_status' => array(
            'exclude' => 0,
            'label' => 'text',
            'config' => array(
                'type' => 'input',
                'size' => 8,
            )
        ),
        'ticket_owner' => array(
            'exclude' => 0,
            'label' => 'text',
            'config' => array(
                'type' => 'input',
                'size' => 8,
            )
        ),
        'ticket_assigned' => array(
            'exclude' => 0,
            'label' => 'text',
            'config' => array(
                'type' => 'input',
                'size' => 8,
            )
        ),
    ),
);
?>