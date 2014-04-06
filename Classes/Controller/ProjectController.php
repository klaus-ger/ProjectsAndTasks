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
class ProjectController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository   
     * @inject
     */
    protected $userRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\SprintsRepository   
     * @inject
     */
    protected $sprintRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ProjectsRepository   
     * @inject
     */
    protected $projectsRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ProjectteamRepository   
     * @inject
     */
    protected $projectteamRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ProjectcatsRepository   
     * @inject
     */
    protected $projectcatsRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\MilestonesRepository   
     * @inject
     */
    protected $milestonesRepository;

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
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ContractsRepository   
     * @inject
     */
    protected $contractsRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\CompanyRepository   
     * @inject
     */
    protected $companyRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\StatusRepository   
     * @inject
     */
    protected $statusRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Utility\Pdf  
     * @inject
     */
    protected $pdfUtility;

    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {

        $user = $GLOBALS['TSFE']->fe_user->user;
        if ($user == NULL) {
            $this->redirect('logIn', 'Login');
        } else {
            $this->user = $this->userRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
            $this->settings['username'] = $this->user->getUsername();
        }


        // this configures the parsing
        if (isset($this->arguments['project'])) {
            // $propertyMappingConfiguration->allowProperties('projectDate');
            $this->arguments['project']
                    ->getPropertyMappingConfiguration()->allowProperties('projectDate')
                    ->forProperty('projectDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d');
            $this->arguments['project']
                    ->getPropertyMappingConfiguration()->allowProperties('projectCat')
                    ->forProperty('projectCat')
            ;
        }
        if (isset($this->arguments['ticket'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['ticket']
                    ->getPropertyMappingConfiguration()->allowProperties('ticketDate')
                    ->forProperty('ticketDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d');
        }
        if (isset($this->arguments['ticket'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['ticket']
                    ->getPropertyMappingConfiguration()->allowProperties('ticketScheduleDate')
                    ->forProperty('ticketScheduleDate')
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
        if (isset($this->arguments['milestone'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['milestone']
                    ->getPropertyMappingConfiguration()->allowProperties('msStart')
                    ->forProperty('msStart')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d');
        }
        if (isset($this->arguments['milestone'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['milestone']
                    ->getPropertyMappingConfiguration()->allowProperties('msEnd')
                    ->forProperty('msEnd')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d');
        }
        if (isset($this->arguments['sprint'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['sprint']
                    ->getPropertyMappingConfiguration()->allowProperties('sprintStart')
                    ->forProperty('sprintStart')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d');
        }
        if (isset($this->arguments['sprint'])) {
            // sprint->allowProperties('ticketDate');
            $this->arguments['sprint']
                    ->getPropertyMappingConfiguration()->allowProperties('sprintEnd')
                    ->forProperty('sprintEnd')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d');
        }
    }

    /**
     * Index Action: Shows a list of all Projects
     * Ordered by Category
     */
    public function allProjectsByCatAction() {
        //search all projects without cat
        $projectsWithoutCat = $this->projectsRepository->findByProjectCatAndStatus(0, 0);


        //Search projects with cats
        $cats = $this->projectcatsRepository->findByCatParent(0);
        $i = 0;
        foreach ($cats as $cat) {
            $catArray[$i] = $cat;
            $subcats = $this->projectcatsRepository->findByCatParent($cat->getUid());
            foreach ($subcats as $sub) {
                $i++;
                $catArray[$i] = $sub;
            }
            $i++;
        }

        foreach ($catArray as $ca) {
            $projects = null;
            $projects = $this->projectsRepository->findByProjectCatAndStatus($ca->getUid(), 0);
            if ($projects[0] != '') {
                $projektArray[$ca->getUid()]['cat'] = $ca;
                foreach ($projects as $project) {
                    $project->setOpenTickets($this->ticketsRepository->countOpenTicketsByProject($project->getUid()));
                    $projektArray[$ca->getUid()]['pro'][$project->getUid()] = $project;
                }
            }
        }
        //    \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($projektArray);


        $this->view->assign('projectsByCat', $projektArray);
        $this->view->assign('projectsWithoutCat', $projectsWithoutCat);
        $this->view->assign('mainmenu', 1);
    }

    /**
     * Index Action: Shows a list of all Projects
     * Ordered by Num
     */
    public function allProjectsByNumAction() {
        $projects = $this->projectsRepository->findByProjectByStatus(0);

        foreach ($projects as $project) {
            $project->setOpenTickets($this->ticketsRepository->countOpenTicketsByProject($project->getUid()));
            $projectArray[$project->getUid()] = $project;
        }
        $this->view->assign('projects', $projectArray);
        $this->view->assign('mainmenu', 2);
    }

    /**
     * Index Action: Shows a list of all Projects
     * Ordered by Num
     */
    public function allProjectsByArchiveAction() {
        $projects = $this->projectsRepository->findByProjectByStatus(1);

        foreach ($projects as $project) {
            $project->setOpenTickets($this->ticketsRepository->countOpenTicketsByProject($project->getUid()));
            $projectArray[$project->getUid()] = $project;
        }
        $this->view->assign('projects', $projectArray);
        $this->view->assign('mainmenu', 3);
    }

    //**************************************************************************
    // Project Detail Actions 
    //**************************************************************************

    /**
     * Shows the Project Indexpage
     */
    public function projectIndexAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }

        $project = $this->projectsRepository->findByUid($projectuid);
        $tickets = $this->ticketsRepository->findByTicketProject($project->getUid());

        $this->view->assign('project', $project);
        $this->view->assign('tickets', $tickets);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('mainmenu', 1);
    }

    /**
     * Shwos a form for a new Project
     */
    public function projectNewAction() {
        $project = new \T3developer\ProjectsAndTasks\Domain\Model\Projects;
        $status = $this->statusRepository->findByStatusTyp(1);

        $clients = $this->companyRepository->findByCyCustomer(1);
        $this->view->assign('clients', $clients);

        //Buid Category Array
        $mainCats = $this->projectcatsRepository->findByCatParent(0);
        if ($mainCats[0] != '') {
            foreach ($mainCats as $main) {
                $cats[$main->getUid()]['main'] = $main;
                $cats[$main->getUid()]['subs'] = $this->projectcatsRepository->findByCatParent($main->getUid());
            }
            $this->view->assign('cats', $cats);
        }

        $this->view->assign('project', $project);
        $this->view->assign('status', $status);
    }

    /**
     * Save a project (new and update)
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Projects $project Description
     */
    public function projectSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Projects $project) {

        if ($project->getUid()) {
            $this->projectsRepository->update($project);
        } else {
            $project->setProjectOwner($this->user->getUid());
            $project->setProjectDate(time());
            $this->projectsRepository->add($project);
        }

        $this->redirect('allProjectsByCat');
    }

    /**
     * Shows the Project Detailpage
     */
    public function projectDetailAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }

        $project = $this->projectsRepository->findByUid($projectuid);
        $tickets = $this->ticketsRepository->findByTicketProject($project->getUid());

        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('tickets', $tickets);
        $this->view->assign('mainmenu', 2);
        $this->view->assign('submenu', 1);
    }

    /**
     * Shows the Project Detailpage
     */
    public function projectEditAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $project = $this->projectsRepository->findByUid($projectuid);
        $status = $this->statusRepository->findByStatusTyp(1);

        //Buid Category Array
        $mainCats = $this->projectcatsRepository->findByCatParent(0);
        if ($mainCats[0] != '') {
            foreach ($mainCats as $main) {
                $cats[$main->getUid()]['main'] = $main;
                $cats[$main->getUid()]['subs'] = $this->projectcatsRepository->findByCatParent($main->getUid());
            }
            $this->view->assign('cats', $cats);
        }

        $clients = $this->companyRepository->findByCyCustomer(1);
        $this->view->assign('clients', $clients);

        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('status', $status);
    }

    /**
     * Shows the Project Evaluation Page
     */
    public function projectDetailEvaluationAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $project = $this->projectsRepository->findByUid($projectuid);
        $status = $this->statusRepository->findByStatusTyp(1);

        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('status', $status);
        $this->view->assign('mainmenu', 2);
        $this->view->assign('submenu', 2);
    }

    /**
     * Shows the Project Offfers / Invoice Page
     */
    public function projectDetailCostsAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $project = $this->projectsRepository->findByUid($projectuid);
        $status = $this->statusRepository->findByStatusTyp(1);

        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('status', $status);
        $this->view->assign('mainmenu', 2);
        $this->view->assign('submenu', 3);
    }

    //**************************************************************************
    // Project Milestones Actions 
    //**************************************************************************
    /**
     * Shows the Milestones of the project
     */
    public function projectMilestoneListAllAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $project = $this->projectsRepository->findByUid($projectuid);
        $milestones = $this->milestonesRepository->findByMsProject($projectuid);

        //adds the open Tickets to Milestone Model
        foreach ($milestones as $mile) {
            $milestonesArray[$mile->getUid()] = $mile;
            $openTickets = 0;
            $openTickets = $this->ticketsRepository->countOpenTicketsByMilestone($mile->getUid());
            $milestonesArray[$mile->getUid()]->setMsTicketOpen($openTickets);
        }

        $this->view->assign('mainmenu', 3);
        $this->view->assign('submenu', 1);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('milestones', $milestonesArray);
    }

    /**
     * Shows the Milestones of the project
     */
    public function projectMilestoneListOpenAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $project = $this->projectsRepository->findByUid($projectuid);
        $milestones = $this->milestonesRepository->findByMilestoneByProjectAndStatus($projectuid, 0);

        //adds the open Tickets to Milestone Model
        foreach ($milestones as $mile) {
            $milestonesArray[$mile->getUid()] = $mile;
            $openTickets = 0;
            $openTickets = $this->ticketsRepository->countOpenTicketsByMilestone($mile->getUid());
            $milestonesArray[$mile->getUid()]->setMsTicketOpen($openTickets);
        }

        $this->view->assign('mainmenu', 3);
        $this->view->assign('submenu', 2);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('milestones', $milestonesArray);
    }

    /**
     * Shows the Milestones of the project
     */
    public function projectMilestoneListClosedAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $project = $this->projectsRepository->findByUid($projectuid);
        $milestones = $this->milestonesRepository->findByMilestoneByProjectAndStatus($projectuid, 1);

        //adds the open Tickets to Milestone Model
        foreach ($milestones as $mile) {
            $milestonesArray[$mile->getUid()] = $mile;
            $openTickets = 0;
            $openTickets = $this->ticketsRepository->countOpenTicketsByMilestone($mile->getUid());
            $milestonesArray[$mile->getUid()]->setMsTicketOpen($openTickets);
        }

        $this->view->assign('mainmenu', 3);
        $this->view->assign('submenu', 3);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('milestones', $milestonesArray);
    }

    /**
     * Shows a Form for a new Milestone
     */
    public function projectMilestonesNewAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $project = $this->projectsRepository->findByUid($projectuid);
        $status = $this->statusRepository->findByStatusTyp(4);

        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('status', $status);
    }

    /**
     * Shows a Form to edit Milestone
     */
    public function projectMilestonesEditAction() {
        if ($this->request->hasArgument('uid')) {
            $milestoneuid = $this->request->getArgument('uid');
        }
        $milestone = $this->milestonesRepository->findByUid($milestoneuid);
        $project = $this->projectsRepository->findByUid($milestone->getMsProject());
        $status = $this->statusRepository->findByStatusTyp(4);

        $this->view->assign('milestone', $milestone);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('status', $status);
    }

    /**
     * Save Milestone
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Milestones $milestone Description
     */
    public function projectMilestonesSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Milestones $milestone) {
        if ($milestone->getUid()) {
            $this->milestonesRepository->update($milestone);
        } else {
            $lastMSOrder = $this->milestonesRepository->countByProject($milestone->getMsProject());
            $milestone->setMsOrder($lastMSOrder + 1);
            $this->milestonesRepository->add($milestone);
        }
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->request->getArguments());
        $this->redirect('projectMilestoneListAll', 'Project', NULL, array('uid' => $milestone->getMsProject()));
    }

    /**
     * Move up the listposition of a milestone
     *
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Milestones $milestone
     */
    public function projectMilestonesMoveUpAction(\T3developer\ProjectsAndTasks\Domain\Model\Milestones $milestone) {
        $actualPosition = $milestone->getMsOrder();
        $newPosition = $actualPosition - 1;

        $milestoneMoveDown = $this->milestonesRepository->findByProjectAndOrder($milestone->getMsProject(), $newPosition);
        $milestoneMoveDown[0]->setMsOrder($actualPosition);
        $this->milestonesRepository->update($milestoneMoveDown[0]);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($milestoneMoveDown[0]);

        $milestone->setMsOrder($newPosition);
        $this->milestonesRepository->update($milestone);

        $this->redirect('projectMilestoneListAll', 'Project', NULL, array('uid' => $milestone->getMsProject()));
    }

    /**
     * Move up the listposition of a milestone
     *
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Milestones $milestone
     */
    public function projectMilestonesMoveDownAction(\T3developer\ProjectsAndTasks\Domain\Model\Milestones $milestone) {
        $actualPosition = $milestone->getMsOrder();
        $newPosition = $actualPosition + 1;

        $milestoneMoveDown = $this->milestonesRepository->findByProjectAndOrder($milestone->getMsProject(), $newPosition);
        $milestoneMoveDown[0]->setMsOrder($actualPosition);
        $this->milestonesRepository->update($milestoneMoveDown[0]);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($milestoneMoveDown[0]);

        $milestone->setMsOrder($newPosition);
        $this->milestonesRepository->update($milestone);

        $this->redirect('projectMilestoneListAll', 'Project', NULL, array('uid' => $milestone->getMsProject()));
    }

    //**************************************************************************
    // Project Ticket Actions 
    //**************************************************************************

    /**
     * Shows Project / Ticket Page Open Tickets by Cat
     */
    public function projectTicketsOpenAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $project = $this->projectsRepository->findByUid($projectuid);
        $tickets = $this->ticketsRepository->findTicketsByProjectAndStatus($project->getUid(), 0);

        // find tickets without milestone
        $ticketsNullMilestone = $this->ticketsRepository->findTicketsByProjectMsAndStatus($project->getUid(), 0, 0);


        $this->view->assign('ticketsNullMilestone', $ticketsNullMilestone);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('tickets', $tickets);
        $this->view->assign('mainmenu', '4');
    }

    /**
     * Shows Project / Ticket Page Open Tickets by Date
     */
    public function projectTicketsOpenNoAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $project = $this->projectsRepository->findByUid($projectuid);
        $tickets = $this->ticketsRepository->findTicketsByProjectAndStatusOrderDate($project->getUid(), 0);


        $this->view->assign('ticketsNullMilestone', $tickets);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('tickets', $tickets);
        $this->view->assign('mainmenu', '4');
    }

    /**
     * Shows Project / Ticket Page Close Tickets
     */
    public function projectTicketsCloseAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $project = $this->projectsRepository->findByUid($projectuid);
        $tickets = $this->ticketsRepository->findTicketsByProjectAndStatusOrderUid($project->getUid(), 1);


        $this->view->assign('ticketsNullMilestone', $tickets);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('tickets', $tickets);
        $this->view->assign('mainmenu', '4');
    }

    /**
     * Shows Project / Ticket Page All Tickets
     */
    public function projectTicketsAllAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $project = $this->projectsRepository->findByUid($projectuid);
        $tickets = $this->ticketsRepository->findByTicketProject($project->getUid());

        $this->view->assign('ticketsNullMilestone', $tickets);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('tickets', $tickets);
        $this->view->assign('mainmenu', '4');
    }

    /**
     * Shows Project / Ticket Detail Page
     */
    public function projectTicketDetailAction() {
        if ($this->request->hasArgument('uid')) {
            $ticketuid = $this->request->getArgument('uid');
        }
        $ticket = $this->ticketsRepository->findByUid($ticketuid);
        $project = $this->projectsRepository->findByUid($ticket->getTicketProject());
        $responses = $this->ticketresponseRepository->findByTrTicket($ticket->getUid());

        //find notes and write time
        $notes = $this->ticketresponseRepository->findByTrTicket($ticket->getUid());
        $worktime = 0;
        foreach ($notes as $note) {
            if ($note->getTrTime() > 0) {
                $worktime = $worktime + $note->getTrTime();
            }
        }

        $this->view->assign('ticket', $ticket);
        $this->view->assign('worktime', $worktime);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('responses', $responses);
        $this->view->assign('mainmenu', '4');
    }

    /**
     * Shows Project / Ticket Detail Page
     */
    public function projectTicketNewAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }

        $ticket = new \T3developer\ProjectsAndTasks\Domain\Model\Tickets;
        $ticket->setTicketProject($projectuid);
        $ticket->setTicketOwner($this->user->getUid());
        $ticket->setTicketDate(time());

        $project = $this->projectsRepository->findByUid($projectuid);
        $milestones = $this->milestonesRepository->findByMsProject($project->getUid());
        $status = $this->statusRepository->findByStatusTyp(2);
        $typ = $this->statusRepository->findByStatusTyp(3);

        $this->view->assign('ticket', $ticket);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('milestones', $milestones);
        $this->view->assign('status', $status);
        $this->view->assign('typ', $typ);
        $this->view->assign('mainmenu', '4');
    }

    /**
     * Shows Project / Ticket Detail Page
     */
    public function projectTicketEditAction() {
        if ($this->request->hasArgument('uid')) {
            $ticketuid = $this->request->getArgument('uid');
        }

        $ticket = $this->ticketsRepository->findByUid($ticketuid);
        $project = $this->projectsRepository->findByUid($ticket->getTicketProject());
        $milestones = $this->milestonesRepository->findByMsProject($project->getUid());
        $sprints = $this->sprintRepository->findBySprintProject($project->getUid());
        $status = $this->statusRepository->findByStatusTyp(2);
        $typ = $this->statusRepository->findByStatusTyp(3);

        $this->view->assign('ticket', $ticket);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('milestones', $milestones);
        $this->view->assign('sprints', $sprints);
        $this->view->assign('status', $status);
        $this->view->assign('typ', $typ);
        $this->view->assign('mainmenu', '4');
    }

    /**
     * Save a ticket (new and update)
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Tickets $ticket Description
     */
    public function projectTicketSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Tickets $ticket) {

        if ($ticket->getUid()) {
            $this->ticketsRepository->update($ticket);
        } else {
            $this->ticketsRepository->add($ticket);
        }

        $this->redirect('projectTicketsOpen', 'Project', NULL, array('uid' => $ticket->getTicketProject()));
    }

    /**
     * Shows a form for a new response
     * 
     */
    public function projectResponseNewAction() {

        if ($this->request->hasArgument('uid')) {
            $ticketuid = $this->request->getArgument('uid');
        }

        $response = new \T3developer\ProjectsAndTasks\Domain\Model\Ticketresponse;
        $response->setTrTicket($ticketuid);

        $ticket = $this->ticketsRepository->findByUid($ticketuid);
        $project = $this->projectsRepository->findByUid($ticket->getTicketProject());

        $status = $this->statusRepository->findByStatusTyp(5);

        $this->view->assign('status', $status);
        $this->view->assign('resonse', $response);
        $this->view->assign('ticket', $ticket);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('mainmenu', '4');
    }

    /**
     * Shows a form for a new response
     * 
     */
    public function projectResponseEditAction() {
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
        $ticket = $this->ticketsRepository->findByUid($response->getTrTicket());
        $project = $this->projectsRepository->findByUid($ticket->getTicketProject());

        $status = $this->statusRepository->findByStatusTyp(5);

        $this->view->assign('status', $status);
        $this->view->assign('response', $response);
        $this->view->assign('ticket', $ticket);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('mainmenu', '4');
    }

    /**
     * Saves a response
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Ticketresponse $response Description
     */
    public function projectResponseSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Ticketresponse $response) {
        //calculating worktime

        if ($response->getTrStart()) {
            $start = explode(':', $response->getTrStart());
            $startTime = ($start[0] * 3600) + ($start[1] * 60);
            $response->setTrStart($startTime);
        }
        if ($response->getTrEnd()) {
            $end = explode(':', $response->getTrEnd());
            $endTime = ($end[0] * 3600) + ($end[1] * 60);
            $response->setTrEnd($endTime);
        }

        if ($response->getTrStart() && $response->getTrEnd()) {
            $response->setTrTime($response->getTrEnd() - $response->getTrStart());
        }

        if ($response->getUid()) {
            $this->ticketresponseRepository->update($response);
        } else {
            $this->ticketresponseRepository->add($response);
        }
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($response);        
        $this->redirect('projectTicketDetail', 'Project', NULL, array('uid' => $response->getTrTicket()));
    }

    /**
     * Writes Ticket List
     */
    public function writePdfTicketlistAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $project = $this->projectsRepository->findByUid($projectuid);

        $milestones = $this->milestonesRepository->findByMsProject($project->getUid());

        foreach ($milestones as $mile) {
            $tickets = null;
            $tickets = $this->ticketsRepository->findTicketsByProjectMsAndStatus($projectuid, $mile->getUid(), 0);
            if ($tickets[0] != '') {
                $tickArray[$mile->getUid()]['milestone'] = $mile;
                $tickArray[$mile->getUid()]['tickets'] = $tickets;
            }
        }

        //$tickets = $this->ticketsRepository->findTicketsByProjectAndStatus($project->getUid(), 1);

        return $this->pdfUtility->createTodoPdf($tickArray, $project);
    }

    //**************************************************************************
    // Project Sprint Actions 
    //**************************************************************************
    /**
     * Shows the Sprint Index Page
     */
    public function projectSprintListOpenAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }

        $project = $this->projectsRepository->findByUid($projectuid);

        $sprints = $this->sprintRepository->findSprintsByProjectAndStatus($projectuid, 0);

        //build sprint / ticket Array
        foreach ($sprints as $sprint) {
            $sprintArray[$sprint->getUid()]['sprint'] = $sprint;
            $sprintArray[$sprint->getUid()]['tickets'] = $this->ticketsRepository->findTicketsByProjectSprintAndStatus($projectuid, $sprint->getUid(), 0);
        }

        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('sprints', $sprintArray);
        $this->view->assign('mainmenu', '7');
        $this->view->assign('submenu', '1');
    }

    /**
     * Shows the Sprint Index Page
     */
    public function projectSprintNewAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }

        $project = $this->projectsRepository->findByUid($projectuid);



        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('mainmenu', '7');
        $this->view->assign('submenu', '1');
    }

    /**
     * Save Sprint
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Sprints $sprint Description
     */
    public function projectSprintSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Sprints $sprint) {
        if ($sprint->getUid()) {
            $this->sprintRepository->update($sprint);
        } else {

            $this->sprintRepository->add($sprint);
        }
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->request->getArguments());
        $this->redirect('projectSprintListOpen', 'Project', NULL, array('uid' => $sprint->getSprintProject()));
    }

    //**************************************************************************
    // Project Documents Actions 
    //**************************************************************************

    /**
     * Shows the Document Index Page
     */
    public function projectDocumentIndexAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }

        $project = $this->projectsRepository->findByUid($projectuid);


        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('mainmenu', '5');
        $this->view->assign('submenu', '1');
    }

    //**************************************************************************
    // Project Contract Actions
    //**************************************************************************

    /**
     * projectCotractList
     * Shows a List of all OPEN Project Contracts
     */
    public function projectContractListAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $contracts = $this->contractsRepository->findByContractProject($projectuid);
        $project = $this->projectsRepository->findByUid($projectuid);


        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('contracts', $contracts);
        $this->view->assign('mainmenu', '6');
        $this->view->assign('submenu', '1');
    }

    /**
     * projectCotractDetail
     * Shows Detail Page Contracts
     */
    public function projectContractDetailAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        $contracts = $this->contractsRepository->findByContractProject($projectuid);
        $project = $this->projectsRepository->findByUid($projectuid);


        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('contracts', $contracts);
        $this->view->assign('mainmenu', '6');
    }

    /**
     * projectCotractNew
     * Shows a Form for a new Contract
     */
    public function projectContractNewAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }

        $project = $this->projectsRepository->findByUid($projectuid);


        $this->view->assign('project', $project);

        $this->view->assign('mainmenu', '6');
    }

    /**
     * Saves a Contract
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Contracts $contract
     */
    public function projectContractSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Contracts $contract) {

        if ($contract->getUid()) {
            $this->contractsRepository->update($contract);
        } else {
            $this->contractsRepository->add($contract);
        }

        $this->redirect('projectContractList', 'Project', NULL, array('uid' => $contract->getContractProject()));
    }

    //**************************************************************************
    // Project Team Actions 
    //**************************************************************************

    /**
     * projectCotractList
     * Shows a List of all OPEN Project Contracts
     */
    public function projectTeamListAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }

        $project = $this->projectsRepository->findByUid($projectuid);


        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));

        $this->view->assign('mainmenu', '8');
        $this->view->assign('submenu', '1');
    }

        //**************************************************************************
    // Global Helper Functions 
    //**************************************************************************
    /**
     * Find Planed haours and efforts
     */
    public function calculateProjectHours($projectID){
        $tickets = $this->ticketsRepository->findByTicketProject($projectID);
        
        //calculate Plan Effort
        $plantime = 0;
        $worktime = 0;
        foreach ($tickets as $ticket){
            //calculate Plan Time
            if( $ticket->getTicketScheduleTime() > 0){
                $plantime = $plantime + $ticket->getTicketScheduleTime();
            }
            //calculate IST Time
            $ticketresponses = $this->ticketresponseRepository->findByTrTicket($ticket->getUid());
            
            foreach( $ticketresponses as $response){
                if($response->getTrTime() > 0){
                    $worktime = $worktime + $response->getTrTime();
                }
            }
        }
        $time['plan'] = $plantime;
        $time['work'] = $worktime;
        
        return ($time);
    }
    
}

?>