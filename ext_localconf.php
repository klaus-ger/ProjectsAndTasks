<?php

if (!defined('TYPO3_MODE'))
    die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'T3developer.' . $_EXTKEY, 'pat', array(
    'Index' =>      'index',
            
    'Admin'    =>   'adminIndex',
            
    'Login' =>      'logIn',
    'Ticket' =>     ' ticketListDate
                    , ticketListScheduled
                    , ticketNew
                    , ticketEdit
                    , ticketSave
                    , ticketDelete
                    , ticketDetail
                    , ticketResponseSave',
            
    'Project' =>    ' allProjectsByCat
                    , allProjectsByNum
                    , allProjectsByArchive
                    
                    , projectIndex
                    , projectNew
                    , projectEdit
                    , projectSave
                    , projectDelete
                    
                    , projectDetail
                    , projectDetailEvaluation
                    , projectDetailCosts
                    
                    , projectMilestoneListAll
                    , projectMilestoneListOpen
                    , projectMilestoneListClosed
                    , projectMilestonesNew
                    , projectMilestonesEdit
                    , projectMilestonesSave
                    , projectMilestonesMoveUp
                    , projectMilestonesMoveDown
                    
                    , projectTicketsOpen
                    , projectTicketsOpenNo
                    , projectTicketsClose
                    , projectTicketsAll
                    , projectTicketDetail
                    , projectTicketNew
                    , projectTicketEdit
                    , projectTicketSave
                    
                    , projectResponseNew
                    , projectResponseEdit
                    , projectResponseSave
                    
                    , projectSprintListOpen
                    , projectSprintNew
                    , projectSprintEdit
                    , projectSprintSave
                    
                    , projectDocumentIndex
                    
                    , projectContractList
                    , projectContractDetail
                    , projectContractNew
                    , projectContractEdit
                    , projectContractSave
                    
                    , projectTeamList
                    , projectTeamNew
                    , projectTeamDelete
                    , projectTeamSave
                    
                    , writePdfTicketlist ',
        
     'Time'=>   ' timeMonth',
        
     'Address'=>    ' personList
                    , personEdit
                    , personNew
                    , personSave
                    , companyList
                    , companyEdit
                    , companyNew
                    , companySave ',
        
     'Whiteboard'=> ' whiteboardOverview',
            
     'Settings'=>   ' settingsProjectCat
                    , settingsProjectCatNew
                    , settingsProjectCatEdit
                    , settingsProjectCatSave
                    , settingsProjectCatUp
                    , settingsProjectCatDown
                    
                    , settingsStatus
                    , settingsStatusNew
                    , settingsStatusEdit
                    , settingsStatusSave'
                    
    ), array(
    'Index' =>      ' index',
            
    'Admin'    =>   ' adminIndex',
            
    'Login' =>      ' logIn',
            
    'Ticket' =>     ' ticketListDate
                    , ticketListScheduled
                    , ticketNew
                    , ticketEdit
                    , ticketSave
                    , ticketDelete
                    , ticketDetail
                    , ticketResponseSave',
            
    'Project' =>    ' allProjectsByCat
                    , allProjectsByNum
                    , allProjectsByArchive
                    
                    , projectIndex
                    , projectNew
                    , projectEdit
                    , projectSave
                    , projectDelete
                    
                    , projectDetail
                    , projectDetailEvaluation
                    , projectDetailCosts
                    
                    , projectMilestoneListAll
                    , projectMilestoneListOpen
                    , projectMilestoneListClosed
                    , projectMilestonesNew
                    , projectMilestonesEdit
                    , projectMilestonesSave
                    , projectMilestonesMoveUp
                    , projectMilestonesMoveDown
                    
                    , projectTicketsOpen
                    , projectTicketsOpenNo
                    , projectTicketsClose
                    , projectTicketsAll
                    , projectTicketDetail
                    , projectTicketNew
                    , projectTicketEdit
                    , projectTicketSave
                    
                    , projectResponseNew
                    , projectResponseEdit
                    , projectResponseSave
                    
                    , projectSprintListOpen
                    , projectSprintNew
                    , projectSprintEdit
                    , projectSprintSave
                    
                    , projectDocumentIndex
                    
                    , projectContractList
                    , projectContractDetail
                    , projectContractNew
                    , projectContractEdit
                    , projectContractSave
                    
                    , projectTeamList
                    
                    , writePdfTicketlist',
        
     'Time'=>       ' timeMonth',
        
     'Address'=>    ' personList
                    , personEdit
                    , personNew
                    , personSave
                    , companyList
                    , companyEdit
                    , companyNew
                    , companySave ',
        
     'Whiteboard'=> ' whiteboardOverview',
            
     'Settings'=>   ' settingsProjectCat
                    , settingsProjectCatNew
                    , settingsProjectCatEdit
                    , settingsProjectCatSave
                    , settingsProjectCatUp
                    , settingsProjectCatDown
                    
                    , settingsStatus
                    , settingsStatusNew
                    , settingsStatusEdit
                    , settingsStatusSave'
        )
);
?>