
<?php

$temporaryColumns = array(
    'tx_projectsandtasks_userrights' => array(
        'exclude' => 0,
        'label' => 'User Rightsgroup Projects And Tasks',
        'config' => array(
            'type' => 'input',
            'size' => 30,
        )
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'fe_users', $temporaryColumns, TRUE
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'fe_users', 'tx_projectsandtasks_userrights;;;;1-1-1'
);

?>
