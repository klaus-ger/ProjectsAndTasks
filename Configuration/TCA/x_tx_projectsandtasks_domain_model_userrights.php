<?php

return array(
    'ctrl' => array(
        'title' => 'Userrights',
        'label' => 'right_name',
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
        'searchFields' => 'bc_title',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('projects_and_tasks') . 'Resources/Public/Icons/tableicon.gif'
    ),
    'interface' => array(
        'showRecordFieldList' => '    right_name
                                    '
    ),
    'types' => array(
        '1' => array('showitem' => '  right_name
                                     
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
                'foreign_table' => 'tx_projectsandtasks_domain_model_userrights',
                'foreign_table_where' => 'AND tx_projectsandtasks_domain_model_userrights.uid=###REC_FIELD_l18n_parent### AND tx_projectsandtasks_domain_model_userrights.sys_language_uid IN (-1,0)',
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
        'right_name' => array(
            'exclude' => 0,
            'label' => 'Right Group',
            'config' => array(
                'type' => 'text',
                'size' => 30,
            )
        ),
        'show_project_menu' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'check'
            )
        ),
        'show_ticket_menu' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'check'
            )
        ),
        'show_time_menu' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'check'
            )
        ),
        'show_address_menu' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'check'
            )
        ),
        'show_whiteboard_menu' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'check'
            )
        ),
        'show_setting_menu' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'check'
            )
        ),
        
        'show_projects_section_detail' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'check'
            )
        ),
        'show_projects_section_milestones' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'check'
            )
        ),
        'show_projects_section_tickes' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'check'
            )
        ),
        'show_projects_section_sprints' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'check'
            )
        ),
        'show_projects_section_documents' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'check'
            )
        ),
        'show_projects_section_team' => array(
            'exclude' => 0,
            'label' => 'Date',
            'config' => array(
                'type' => 'check'
            )
        ),
        
    ),
);
?>