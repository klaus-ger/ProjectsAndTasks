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
 * The Ticket controller - serves the ticket section pages
 *
 * @version 0.1
 * @copyright Copyright belongs to the respective authors
 * @package ProjectsAndTasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Klaus Heuer <klaus.heuer@t3-developer.com>
 */

class TicketController extends \T3developer\ProjectsAndTasks\Controller\BaseController {



    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {

        $this->getUserRights();

        // this configures the parsing
        if (isset($this->arguments['ticket'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['ticket']
                    ->getPropertyMappingConfiguration()->allowProperties('ticketDate')
                    ->forProperty('ticketDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd-m-Y');
        }
        // this configures the parsing
        if (isset($this->arguments['response'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['response']
                    ->getPropertyMappingConfiguration()->allowProperties('trDate')
                    //->getPropertyMappingConfiguration()->allowProperties('trStart')
                    //->getPropertyMappingConfiguration()->allowProperties('trEnd')
                    ->forProperty('trDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd-m-Y');
        }
        if (isset($this->arguments['response'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['response']
                    ->getPropertyMappingConfiguration()->allowProperties('trStart')
                    ->forProperty('trStart');
            // ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\StringConverter');
        }
        if (isset($this->arguments['response'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['response']
                    ->getPropertyMappingConfiguration()->allowProperties('trEnd')
                    ->forProperty('trEnd');
            // ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\StringConverter');
        }
    }


    /**
     * Shows a list of all tickets of the user
     */
    public function ticketListDateAction() {

        $tickets = $this->ticketsRepository->findOpenTicketsByUser($this->user->getUid());

        $this->view->assign('tickets', $tickets);
        $this->view->assign('mainmenu', '1');
        $this->view->assign('topmenu', 3);
    }

    /**
     * Shows a list of all tickets of the user
     */
    public function ticketListScheduledAction() {

        $tickets = $this->ticketsRepository->findOpenTicketsScheduled($this->user->getUid());

        $this->view->assign('tickets', $tickets);
        $this->view->assign('mainmenu', '2');
        $this->view->assign('topmenu', 3);
    }

    /**
     * Shows a list of all tickets of the user
     */
    public function ticketListProjectAction() {

        $tickets = $this->ticketsRepository->findOpenTicketsScheduled($this->user->getUid());

        $this->view->assign('tickets', $tickets);
        $this->view->assign('mainmenu', '3');
        $this->view->assign('topmenu', 3);
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
        $this->view->assign('topmenu', 3);
    }

    /**
     * Shows a form to edit a Ticket
     */
    public function ticketEditAction() {
        if ($this->request->hasArgument('uid')) {
            $ticketUid = $this->request->getArgument('uid');
        }
        
        $ticket = $this->ticketsRepository->findByUid($ticketUid);
        $project = $this->projectsRepository->findByUid($ticket->getTicketProject()->getUid());
        $projects = $this->projectsRepository->findAll();
        $status = $this->statusRepository->findByStatusTyp(2);
        $milestones = $this->milestonesRepository->findByMsProject($project->getUid());
        $sprints = $this->sprintRepository->findBySprintProject($project->getUid());
        $typ = $this->statusRepository->findByStatusTyp(3);
        
        //Build assigned to select options:
        if ($project->getProjectOwner()) {
            $pteam[0] = $project->getProjectOwner();
        }
        $projectteam = $this->projectteamRepository->findByPtProject($project->getUid());
        if ($projectteam[0]) {
            $i = 1;
            foreach ($projectteam as $pmember) {
                $pteam[$i] = $pmember->getPtUser();
                $i++;
            }
        }
        
        $this->view->assign('ticket', $ticket);
        $this->view->assign('projects', $projects);
        $this->view->assign('status', $status);
        $this->view->assign('milestones', $milestones);
        $this->view->assign('sprints', $sprints);
        $this->view->assign('typ', $typ);
        $this->view->assign('projectteam', $pteam);
        $this->view->assign('topmenu', 3);
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

        $this->view->assign('ticket', $ticket);
        $this->view->assign('projects', $projects);
        $this->view->assign('status', $status);
        $this->view->assign('responses', $responses);
        $this->view->assign('topmenu', 3);
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

        $this->redirect('ticketListDate');
    }

    /**
     * Shwos a form for a new Ticket Response
     */
    public function ticketResponseNewAction() {
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
        $this->view->assign('topmenu', 3);
    }

    /**
     * Shows a form for a new response
     * 
     */
    public function ticketResponseEditAction() {
        if ($this->request->hasArgument('uid')) {
            $responseuid = $this->request->getArgument('uid');
        }
        $response = $this->ticketresponseRepository->findByUid($responseuid);

        //calculate Start and end Time format
        if ($response->getTrStart()) {
            $start = $response->getTrStart();
            $startH = floor($start / 3600);
            $startS = $start - ($startH * 3600);
            $startM = $startS / 60;
            if ($startH < 10)
                $startH = '0' . $startH;
            if ($startM < 10)
                $startM = '0' . $startM;
            $response->setTrStart($startH . ':' . $startM);
        }
        if ($response->getTrEnd()) {
            $end = $response->getTrEnd();
            $endH = floor($end / 3600);
            $endS = $end - ($endH * 3600);
            $endM = $endS / 60;
            if ($endH < 10) {
                $endH = '0' . $endH;
            }
            if ($endM < 10) {
                $endM = '0' . $endM;
            }
            $response->setTrEnd($endH . ':' . $endM);
        }
        $ticket = $response->getTrTicket();
        $project = $ticket->getTicketProject();

        $status = $this->statusRepository->findByStatusTyp(5);

        $this->view->assign('status', $status);
        $this->view->assign('response', $response);
        $this->view->assign('ticket', $ticket);
        $this->view->assign('project', $project);
        $this->view->assign('topmenu', 3);
    }

    /**
     * Save a ticketresponse (new and update)
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Ticketresponse $response Description
     */
    public function ticketResponseSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Ticketresponse $response) {

        if ($response->getTrStart() && $response->getTrEnd()) {
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
        $this->redirect('ticketDetail', 'Ticket', NULL, array('uid' => $response->getTrTicket()));
    }

}

?>