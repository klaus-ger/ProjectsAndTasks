<?php
if (!defined ('TYPO3_MODE'))  die ('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'T3developer.' . $_EXTKEY,
	'patsystem',
	array(
		
                'Inbox'   => 'index',
		'Project' => 'index, projectNew, projectCreate, projectShow, projectEdit, projectUpdate',
                'User'    => ' showAllUsers, userCreate, userNew, checkLogIn, logIn',
                'Todo'    => 'todoListNew, todoListCreate, todoNew, todoCreate, todoEdit, todoUpdate, showPdf, todoShowMulti',
                'Work'    => 'workNew, workCreate, workEdit, workUpdate'
                
	),
	// non-cacheable actions
	array(
                
		'Inbox' => 'index',
		'Project' => 'index, projectNew, projectCreate, projectShow, projectEdit, projectUpdate',
                'User' => ' showAllUsers, userCreate, userNew, checkLogIn, logIn',
                'Todo'    => 'todoListNew, todoListCreate, todoNew, todoCreate, todoEdit, todoUpdate, showPdf, todoShowMulti',
                'Work'    => 'workNew, workCreate, workEdit, workUpdate'
                
	)
);

//$TYPO3_CONF_VARS['FE']['eID_include']['ajaxDispatcher'] = 'EXT:projects_and_tasks/Classes/EidDispatcher.php';
$TYPO3_CONF_VARS['FE']['eID_include']['ajaxDispatcher'] = t3lib_extMgm::extPath('projects_and_tasks').'Classes/EidDispatcher.php';

?>