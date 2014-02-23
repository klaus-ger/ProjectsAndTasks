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
class TicketController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\StatusRepository   
     * @inject
     */
    protected $statusRepository;

    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {

        $user = $GLOBALS['TSFE']->fe_user->user;
        if ($user == NULL) {
            $this->redirect('logIn', 'Login');
        }


        // this configures the parsing
        if (isset($this->arguments['ticket'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['ticket']
                    ->getPropertyMappingConfiguration()->allowProperties('ticketDate')
                    ->forProperty('ticketDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d');
        }
                // this configures the parsing
        if (isset($this->arguments['response'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['response']
                    ->getPropertyMappingConfiguration()->allowProperties('trDate')
                    //->getPropertyMappingConfiguration()->allowProperties('trStart')
                    //->getPropertyMappingConfiguration()->allowProperties('trEnd')
                    ->forProperty('trDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d');
        }
        if (isset($this->arguments['response'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['response']
                    ->getPropertyMappingConfiguration()->allowProperties('trStart')
                    ->forProperty('trStart')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\StringConverter');
        }
        if (isset($this->arguments['response'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['response']
                    ->getPropertyMappingConfiguration()->allowProperties('trEnd')
                    ->forProperty('trEnd')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\StringConverter');
        }
    }

    /**
     * Index Action: Shows a list of all User
     */
    public function indexAction() {

        $tickets = $this->ticketsRepository->findOpenTickets();

        $this->view->assign('tickets', $tickets);
    }

        /**
     * Index Action: Shows a list of all User
     */
    public function ticketListDateAction() {

        $tickets = $this->ticketsRepository->findOpenTickets();

        $this->view->assign('tickets', $tickets);
        $this->view->assign('mainmenu', '1');
    }
    
            /**
     * Index Action: Shows a list of all User
     */
    public function ticketListScheduledAction() {

        $tickets = $this->ticketsRepository->findOpenTicketsScheduled();

        $this->view->assign('tickets', $tickets);
        $this->view->assign('mainmenu', '2');
    }
    
    /**
     * Shows a form for a new Ticket
     */
    public function ticketNewAction() {
        $ticket = new \T3developer\ProjectsAndTasks\Domain\Model\Tickets;

        $projects = $this->projectsRepository->findAll();
        $status = $this->statusRepository->findAll();

        $this->view->assign('ticket', $ticket);
        $this->view->assign('projects', $projects);
        $this->view->assign('status', $status);
    }

    /**
     * Shows a form to edit a Ticket
     */
    public function ticketEditAction() {
        if ($this->request->hasArgument('uid')) {
            $ticketUid = $this->request->getArgument('uid');
        }

        $ticket = $this->ticketsRepository->findByUid($ticketUid);
        $projects = $this->projectsRepository->findAll();
        $status = $this->statusRepository->findAll();

        $this->view->assign('ticket', $ticket);
        $this->view->assign('projects', $projects);
        $this->view->assign('status', $status);
    }

    /**
     * Shwos a form for a nw Ticket
     */
    public function ticketDetailAction() {
        if ($this->request->hasArgument('uid')) {
            $ticketUid = $this->request->getArgument('uid');
        }

        $ticket = $this->ticketsRepository->findByUid($ticketUid);
        $projects = $this->projectsRepository->findAll();
        $status = $this->statusRepository->findAll();
        $responses = $this->ticketresponseRepository->findByTrTicket($ticketUid);
        $response = new \T3developer\ProjectsAndTasks\Domain\Model\Ticketresponse;

        $this->view->assign('ticket', $ticket);
        $this->view->assign('projects', $projects);
        $this->view->assign('status', $status);
        $this->view->assign('responses', $responses);
    }

    /**
     * Save a ticket (new and update)
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Tickets $ticket Description
     */
    public function ticketSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Tickets $ticket) {

        if ($ticket->getUid()) {
            $this->ticketsRepository->update($ticket);
        } else {
            $this->ticketsRepository->add($ticket);
        }

        $this->redirect('index');
    }
    
    
    /**
     * Save a ticketresponse (new and update)
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Ticketresponse $response Description
     */
    public function ticketResponseSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Ticketresponse $response) {
       
        if($response->getTrStart() && $response->getTrEnd()){
            $startArray = explode(":", $response->getTrStart());
            $endArray = explode(":", $response->getTrEnd());
            $hours = $endArray[0] - $startArray[0];
            $minutes = $endArray[1] - $startArray[1];
            $time = ($hours * 60 * 60) + ($minutes * 60);
            $response->setTrTime($time);
        }
        if ($response->getUid()) {
            $this->ticketresponseRepository->update($response);
        } else {
            $this->ticketresponseRepository->add($response);
        }
         // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($endArray);
        $this->redirect('index');
    }
}

?>