<?php

namespace T3developer\ProjectsAndTasks\Controller;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013 
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
 *
 *
 * @package ProjectsAndTasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class IndexController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {
        $user = $GLOBALS['TSFE']->fe_user->user;

        if ($user == NULL) {
            $this->redirect('logIn', 'Login');
        } else {
            $this->user =$this->userRepository->findByUid( $GLOBALS['TSFE']->fe_user->user['uid']);
            $this->settings['username'] = $this->user->getUsername();
        }
    }

    /**
     * Index Action: Shows a list of all User
     */
    public function indexAction() {
        //if loged in User is admin -> redirect to admin panel
        if($this->user->getUsername() == 'admin'){
            $this->redirect( 'adminIndex', 'Admin');
        }
        
        
        $openTickets = $this->ticketsRepository->findOpenTicketsByUser($this->user->getUid());
        $countOpenTickets = count($openTickets);
        
        $openTime = 0;
        $actualTime = time();
        $ticketAgeTotal = 0;
        foreach($openTickets as $openTi){
           $openTime = $openTime + $openTi->getTicketScheduleTime();
           $ticketdate = $openTi->getTicketDate()->getTimestamp();
           $ticketage = $actualTime - $ticketdate;
           $ticketAgeTotal = $ticketAgeTotal + $ticketage;
        }
        $averageTicketAge = $ticketAgeTotal / $countOpenTickets;
        $averageAge = $averageTicketAge / 3600 / 24;
        
        $this->view->assign('countOpenTickets', $countOpenTickets);
        $this->view->assign('openTime', $openTime);
        $this->view->assign('openAge', round($averageAge, 2));
        //$this->view->assign('user', $this->user);
    }

}

?>