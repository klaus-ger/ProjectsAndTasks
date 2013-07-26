<?php
$extensionPath = t3lib_extMgm::extPath('projects_and_tasks');
return array(
	'tcpdf' => $extensionPath . 'Classes/Utility/Tcpdf/tcpdf.php',
        'Tx_ProjectsAndTasks_Controller_TodoController' => $extensionPath . 'Classes/Controller/TodoController.php',
);
?>