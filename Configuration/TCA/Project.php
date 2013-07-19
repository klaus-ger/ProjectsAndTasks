<?php

$TCA['tx_projectsandtasks_domain_model_project'] = array(
    'ctrl' => $TCA['tx_projectsandtasks_domain_model_project']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'project_title,project_short, project_text;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css], project_sort, project_status, project_typ, project_parent'
    ),
    'types' => array(
        '1' => array('showitem' => 'project_title,project_short, project_text;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css], project_sort, project_status,project_typ, project_parent')
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
                'foreign_table' => 'tx_projectsandtasks_domain_project',
                'foreign_table_where' => 'AND tx_projectsandtasks_domain_model_project.uid=###REC_FIELD_l18n_parent### AND tx_projectsandtasks_domain_model_project.sys_language_uid IN (-1,0)',
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
        'project_title' => array(
            'exclude' => 0,
            'label' => 'Titel',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
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
        'project_short' => array(
            'exclude' => 0,
            'label' => 'Kurzbeschreibung',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            )
        ),
        'project_text' => array(
            'exclude' => 0,
            'label' => 'Text',
            'config' => array(
                'type' => 'text',
                'size' => 30,
            )
        ),
        'project_sort' => array(
            'exclude' => 0,
            'label' => 'Sortierung',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
        'project_status' => array(
            'exclude' => 0,
            'label' => 'Status',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
        'project_parent' => array(
            'exclude' => 0,
            'label' => 'Elternelement ID',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
        'project_owner' => array(
            'exclude' => 0,
            'label' => 'Owner Uid',
            'config' => array(
                'type' => 'input',
                'size' => 5,
            )
        ),
        'project_icon' => array(
            'exclude' => 0,
            'label' => 'Project Icon',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        'project_budget_time' => array(
            'exclude' => 0,
            'label' => 'Project Icon',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        'project_budget_money' => array(
            'exclude' => 0,
            'label' => 'Project Icon',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
        'project_level' => array(
            'exclude' => 0,
            'label' => 'Project Level',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),
                        'project_revision_date' => array(
            'exclude' => 0,
            'label' => 'Project Level',
            'config' => array(
                'type' => 'input',
                'size' => 100,
            )
        ),

    ),
);
?>