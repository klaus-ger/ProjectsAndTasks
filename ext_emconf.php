<?php

########################################################################
# Extension Manager/Repository config file for ext "".
#
# Auto generated 09-02-2012 21:22
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'project and tasks',
	'description' => 'Project and Tasks System',
	'category' => 'plugin',
	'author' => 'Klaus',
	'author_company' => 't3-developer.com',
	'author_email' => 'klaus.heuer@t3-developer.com',
        'createDirs'    => 'uploads/pat',
	'dependencies' => 'extbase,fluid',
	'clearCacheOnLoad' => 1,
	'version' => '0.1.10',
	'constraints' => array(
		'depends' => array(
			'php' => '5.3.0-5.4.0',
			'typo3' => '4.7.0-6.1.99',
			'extbase' => '4.7.0-6.1.99',
			'fluid' => '4.7.0-6.1.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:54:{s:22:"ext_autoload Kopie.php";s:4:"5257";s:16:"ext_autoload.php";s:4:"82b8";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"56e7";s:20:"ext_tables Kopie.php";s:4:"b92f";s:14:"ext_tables.php";s:4:"43d9";s:14:"ext_tables.sql";s:4:"bf2e";s:37:"Classes/Controller/BlogController.php";s:4:"162b";s:44:"Classes/Controller/ErscheinungController.php";s:4:"25b4";s:42:"Classes/Controller/LandkreisController.php";s:4:"9f38";s:37:"Classes/Controller/UserController.php";s:4:"532a";s:40:"Classes/Controller/UsertypController.php";s:4:"832f";s:29:"Classes/Domain/Model/Blog.php";s:4:"3aee";s:36:"Classes/Domain/Model/Erscheinung.php";s:4:"00fb";s:34:"Classes/Domain/Model/Landkreis.php";s:4:"f04e";s:34:"Classes/Domain/Model/Nachricht.php";s:4:"0cd2";s:29:"Classes/Domain/Model/User.php";s:4:"2d52";s:32:"Classes/Domain/Model/Usertyp.php";s:4:"0499";s:44:"Classes/Domain/Repository/BlogRepository.php";s:4:"80c7";s:51:"Classes/Domain/Repository/ErscheinungRepository.php";s:4:"ce2b";s:49:"Classes/Domain/Repository/LandkreisRepository.php";s:4:"b255";s:46:"Classes/Domain/Repository/ProfilRepository.php";s:4:"8647";s:44:"Classes/Domain/Repository/UserRepository.php";s:4:"37f9";s:47:"Classes/Domain/Repository/UsertypRepository.php";s:4:"fae8";s:44:"Classes/ViewHelpers/TimeFormatViewHelper.php";s:4:"313a";s:47:"Classes/ViewHelpers/Form/UserRoleViewHelper.php";s:4:"ddcf";s:45:"Configuration/FlexForms/ControllerActions.xml";s:4:"1968";s:26:"Configuration/TCA/Blog.php";s:4:"d526";s:29:"Configuration/TCA/Comment.php";s:4:"43b8";s:27:"Configuration/TCA/Entry.php";s:4:"3f95";s:31:"Configuration/TCA/Kategorie.php";s:4:"a1fc";s:34:"Configuration/TypoScript/setup.txt";s:4:"3aba";s:80:"Resources/Private/Language/locallang_csh_tx_jobtickets_domain_model_projects.xml";s:4:"eb07";s:79:"Resources/Private/Language/locallang_csh_tx_jobtickets_domain_model_tickets.xml";s:4:"eb07";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"6634";s:41:"Resources/Private/Partials/List/item.html";s:4:"b0c1";s:47:"Resources/Private/Partials/User/listherren.html";s:4:"b0c1";s:43:"Resources/Private/Templates/Blog/index.html";s:4:"56a0";s:42:"Resources/Private/Templates/User/list.html";s:4:"e72e";s:47:"Resources/Private/Templates/User/listdamen.html";s:4:"c4ec";s:48:"Resources/Private/Templates/User/listherren.html";s:4:"2fd7";s:46:"Resources/Private/Templates/User/listpaar.html";s:4:"0d1a";s:65:"Resources/Private/Templates/User/profiledit (27.01.12 09:15).html";s:4:"d69b";s:48:"Resources/Private/Templates/User/profiledit.html";s:4:"c3f3";s:48:"Resources/Private/Templates/User/profilview.html";s:4:"3a61";s:42:"Resources/Private/Templates/User/show.html";s:4:"ecb7";s:65:"Resources/Public/Icons/icon_tx_jobticket_domain_model_tickets.gif";s:4:"475a";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:71:"Resources/Public/Icons/tx_mittwaldtimetrack_domain_model_assignment.gif";s:4:"1103";s:68:"Resources/Public/Icons/tx_mittwaldtimetrack_domain_model_project.gif";s:4:"905a";s:65:"Resources/Public/Icons/tx_mittwaldtimetrack_domain_model_role.gif";s:4:"905a";s:68:"Resources/Public/Icons/tx_mittwaldtimetrack_domain_model_timeset.gif";s:4:"1103";s:41:"Resources/Public/Stylesheets/Listview.css";s:4:"58b4";s:43:"Resources/Public/Stylesheets/Profilview.css";s:4:"b3c5";}',
	'suggests' => array(
	),
	'conflicts' => '',
);

?>