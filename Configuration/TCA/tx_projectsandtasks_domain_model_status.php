<?php

return array(
    'ctrl' => array(
        'title' => 'Status',
        'label' => 'status_text',
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
        'searchFields' => 'status_text',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('projects_and_tasks') . 'Resources/Public/Icons/tableicon.gif'
    ),
    'interface' => array(
        'showRecordFieldList' => 'status_typ, status_text, status_behaviour'
    ),
    'types' => array(
        '1' => array('showitem' => 'status_typ, status_text, status_behaviour
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
                'foreign_table' => 'tx_projectsandtasks_domain_model_status',
                'foreign_table_where' => 'AND tx_projectsandtasks_domain_model_status.uid=###REC_FIELD_l18n_parent### AND tx_projectsandtasks_domain_model_status.sys_language_uid IN (-1,0)',
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

         'status_typ' => array(
            'exclude' => 0,
            'label' => 'Status Typ: 1 projekte, 2 Tickets',
            'config' => array(
                'type' => 'text',
                'size' => 30,
            )
        ),
        
        'status_text' => array(
            'exclude' => 0,
            'label' => 'Status text',
            'config' => array(
                'type' => 'text',
                'size' => 30,
            )
        ),

                'status_behaviour' => array(
            'exclude' => 0,
            'label' => 'Verhalten: 1 offen 2 erledigt',
            'config' => array(
                'type' => 'text',
                'size' => 30,
            )
        ),
        
     
        
    ),
);
?>