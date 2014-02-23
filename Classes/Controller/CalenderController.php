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
class CalenderController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\StatusRepository   
     * @inject
     */
    protected $statusRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\StatustypRepository   
     * @inject
     */
    protected $statustypRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ProjectcatsRepository   
     * @inject
     */
    protected $projectcatsRepository;

    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {
        $user = $GLOBALS['TSFE']->fe_user->user;

        if ($user == NULL) {
            $this->redirect('logIn', 'Login');
        }
    }

    //**************************************************************************
    //Caleder
    //**************************************************************************

    /**
     * Shows the List of Project cats
     */
    public function dayviewAction() {

        //search schedueled tickets for the day
        $start = mktime(0, 0, 0);
        $end = mktime(23, 59, 59);

        $ticketsToday = $this->ticketsRepository->findPerDayandStatus($start, $end, 0);
        $ticketsDelay = $this->ticketsRepository->findPerDelayedandStatus($start, 0);

        $notes = $this->ticketresponseRepository->findPerDate($start, $end);
        $i = 0;
        foreach ($notes as $note){
           $noteArray[$i]['title'] = $note->getTrTitel();
           $noteArray[$i]['ticket'] = $note->getTrTicket()->getTicketTitel();
           $noteArray[$i]['time'] = $note->getTrTime();
           $daystartPosition = $note->getTrStart() -28800; //Position 8 Uhr abziehen
           $daystartPosition = $daystartPosition/45.0;
           $noteArray[$i]['top'] = $daystartPosition-5;
           $i++;
        }
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($noteArray);
        $this->view->assign('notes', $noteArray);
        $this->view->assign('ticketsToday', $ticketsToday);
        $this->view->assign('ticketsDelay', $ticketsDelay);
        $this->view->assign('mainmenu', '1');
    }

}

?>