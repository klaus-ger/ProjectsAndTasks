<?php
if (!defined ('TYPO3_MODE'))  die ('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'T3developer.' . $_EXTKEY,
	'patsystem',
	array(
		
                'Inbox'   => 'index, showWork, projectsShow, makeProjectSticky, showTodo, messagesShow',
		'Project' => 'projectShow, projectNew, projectCreate,  projectEdit, projectUpdate, projectShowDetails,projectEditUserRights, projectUpdateUserRights',
                'User'    => 'index, showAllUsers, userCreate, userNew, checkLogIn, logIn',
                'Todo'    => 'todoListNew, todoListCreate, todoNew, todoCreate, todoEdit, todoUpdate, showPdf, todoShowMulti, todoDelete, findTodoByAjax',
                'Work'    => 'workNew, workCreate, workEdit, workUpdate',
                'Message' => 'messageNew, messageCreate, messageEdit, messageUpdate',
                'Settings'=> 'index'
                
	),
	// non-cacheable actions
	array(
                
		'Inbox'   => 'index, showWork, projectsShow, makeProjectSticky, showTodo, messagesShow',
		'Project' => 'projectShow, projectNew, projectCreate,  projectEdit, projectUpdate, projectShowDetails,projectEditUserRights, projectUpdateUserRights',
                'User'    => 'index, showAllUsers, userCreate, userNew, checkLogIn, logIn',
                'Todo'    => 'todoListNew, todoListCreate, todoNew, todoCreate, todoEdit, todoUpdate, showPdf, todoShowMulti, todoDelete, findTodoByAjax',
                'Work'    => 'workNew, workCreate, workEdit, workUpdate',
                'Message' => 'messageNew, messageCreate, messageEdit, messageUpdate',
                'Settings'=> 'index'
                
	)
);

//$TYPO3_CONF_VARS['FE']['eID_include']['ajaxDispatcher'] = 'EXT:projects_and_tasks/Classes/EidDispatcher.php';
$TYPO3_CONF_VARS['FE']['eID_include']['ajaxDispatcher'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('projects_and_tasks').'Classes/EidDispatcher.php';

?>