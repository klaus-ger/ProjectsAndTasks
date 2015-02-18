<?php

namespace T3developer\ProjectsAndTasks\Controller;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Klaus Heuer <klaus.heuer@t3-developer.com> 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * A base controller that implements basic functions that are needed
 * all over the project.
 *
 * @version 0.1
 * @copyright Copyright belongs to the respective authors
 * @package ProjectsAndTasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Klaus Heuer <klaus.heuer@t3-developer.com>
 */
class BaseController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository   
     * @inject
     */
    protected $userRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\TicketsRepository   
     * @inject
     */
    protected $ticketsRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\TicketresponseRepository   
     * @inject
     */
    protected $ticketresponseRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ProjectsRepository   
     * @inject
     */
    protected $projectsRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\MilestonesRepository   
     * @inject
     */
    protected $milestonesRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ProjectcatsRepository   
     * @inject
     */
    protected $projectcatsRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ProjectteamRepository   
     * @inject
     */
    protected $projectteamRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\SprintsRepository   
     * @inject
     */
    protected $sprintRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\DocumentsRepository   
     * @inject
     */
    protected $documentsRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\FileRepository   
     * @inject
     */
    protected $fileRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\FileReferenceRepository   
     * @inject
     */
    protected $fileReferenceRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Utility\Pdf  
     * @inject
     */
    protected $pdfUtility;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\StatusRepository   
     * @inject
     */
    protected $statusRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\CompanyRepository   
     * @inject
     */
    protected $companyRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\StatisticRepository   
     * @inject
     */
    protected $statisticRepository;



    /**
     * getUserRights Function - set the logged in User to $this->user
     * 
     * @return void 
     */
    public function getUserRights() {
        $user = $GLOBALS['TSFE']->fe_user->user;

        if ($user == NULL) {
            $this->redirect('logIn', 'Login');
        } else {
            $this->user = $this->userRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
            $this->settings['username'] = $this->user->getUsername();
            $this->setUserRights();
          
        }
    }

    /**
     * Ticket Edit Permission
     * 
     * Checks if a user is admin, ticket owner or project owner
     * @param int $ticketUid
     * @return boolean
     */
    public function getTicketEditPermission($ticketUid){
        //check if user is allowed to change ticket
        $ticketEditPermission = false;
        $ticket = $this->ticketsRepository->findByUid($ticketUid);
        
        //admin
        if($this->user->getPatGroup() == 'pat-admin') {
            return true;
        }
        
        //project owner
        if($this->user == $ticket->getTicketProject()->getProjectOwner()){
            return true;
        }
        
        //ticket owner
        if($this->user == $ticket->getTicketAssigned()) {
            return true;
        }
        
    }

    /**
     * set the pat-Usergroupname to the user
     * the usergroups mus defined as (case-sensitive spelling!)
     * pat-admin
     * pat-intern
     * pat-extern
     */
    private function setUserRights() {
        
       $userGroups = explode(',', $this->user->getUsergroup());
        
       if(in_array($this->settings['externalgroup'], $userGroups)){
           $this->user->setPatGroup('pat-extern');
       }
       
       if(in_array($this->settings['internalgroup'], $userGroups)){
           $this->user->setPatGroup('pat-intern');
       }
       
       if(in_array($this->settings['admingroup'], $userGroups)){
           $this->user->setPatGroup('pat-admin');
       }
        
        
    }
            


}

?>