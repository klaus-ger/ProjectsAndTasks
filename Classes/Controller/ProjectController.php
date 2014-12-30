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
 * The Project controller - serves the project section
 *
 * @version 0.1
 * @copyright Copyright belongs to the respective authors
 * @package ProjectsAndTasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Klaus Heuer <klaus.heuer@t3-developer.com>
 */
class ProjectController extends \T3developer\ProjectsAndTasks\Controller\BaseController {

    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {

        $this->getUserRights();
        $this->configureParsing();
    }

    /**
     * Index Action: Shows a list of all Projects
     * Ordered by Category
     */
    public function allProjectsByCatAction() {

        $catArray = array();

        //search all projects without cat
        $projectsWithoutCat = $this->projectsRepository->findByProjectCatAndStatus(0, 0);
        if ($projectsWithoutCat[0] != 0) {
            foreach ($projectsWithoutCat as $proWithoutCat) {
                $proWithoutCat->setOpenTickets($this->ticketsRepository->countOpenTicketsByProject($proWithoutCat->getUid()));
            }
        }

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
        $this->view->assign('topmenu', 1);
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
        $projectteam = $this->projectteamRepository->findByPtProject($projectuid);

        $ticketsWithoutMS = $this->ticketsRepository->findTicketsByProjectMsAndStatus($projectuid, 0, 0);

        //search for the first open milestones with tickets
        $milestones = $this->milestonesRepository->findByMsProject($projectuid);
        foreach ($milestones as $mile) {
            $tickets = $this->ticketsRepository->findTicketsByProjectMsAndStatus($projectuid, $mile->getUid(), 0);
            if ($tickets[0] != '') {
                $nextMilestone = $mile;
                $nextMilestonesTickets = $tickets;
                break;
            }
        }


        $this->view->assign('project', $project);
        $this->view->assign('nextMilestone', $nextMilestone);
        $this->view->assign('nextMilestonesTickets', $nextMilestonesTickets);
        $this->view->assign('ticketsWithoutMS', $ticketsWithoutMS);
        $this->view->assign('projectteam', $projectteam);
        $this->view->assign('ticketsSummary', $this->calculateTicketSummary($projectuid));
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

        $this->view->assign('user', $persons = $this->userRepository->findAll());
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
        $project = $milestone->getMsProject();
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
        $project = $ticket->getTicketProject();
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
        $this->view->assign('projectHours', $this->calculateProjectHours($project->getUid()));
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
        $sprints = $this->sprintRepository->findBySprintProject($project->getUid());
        $status = $this->statusRepository->findByStatusTyp(2);
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
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('milestones', $milestones);
        $this->view->assign('sprints', $sprints);
        $this->view->assign('status', $status);
        $this->view->assign('projectteam', $pteam);
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
        $project = $ticket->getTicketProject();
        $milestones = $this->milestonesRepository->findByMsProject($project->getUid());
        $sprints = $this->sprintRepository->findBySprintProject($project->getUid());
        $status = $this->statusRepository->findByStatusTyp(2);
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
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('milestones', $milestones);
        $this->view->assign('sprints', $sprints);
        $this->view->assign('status', $status);
        $this->view->assign('projectteam', $pteam);
        $this->view->assign('typ', $typ);
        $this->view->assign('mainmenu', '4');
    }

    /**
     * Save a ticket (new and update)
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Tickets $ticket Description
     */
    public function projectTicketSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Tickets $ticket) {

        if (!empty($_FILES['tx_projectsandtasks_pat'])) {

            /** @var \TYPO3\CMS\Core\Resource\StorageRepository $storageRepository */
            $storageRepository = $this->objectManager->get('TYPO3\CMS\Core\Resource\StorageRepository');
            /** @var \TYPO3\CMS\Core\Resource\ResourceStorage $storage */
            $storage = $storageRepository->findByUid('1');

            for ($index = 0; $index < count($_FILES['tx_projectsandtasks_pat']['name']['file']); $index++) {
                // setting up file data
                $fileData = array();
                $fileData['name'] = $_FILES['tx_projectsandtasks_pat']['name']['file'][$index];
                $fileData['type'] = $_FILES['tx_projectsandtasks_pat']['type']['file'][$index];
                $fileData['tmp_name'] = $_FILES['tx_projectsandtasks_pat']['tmp_name']['file'][$index];
                $fileData['size'] = $_FILES['tx_projectsandtasks_pat']['size']['file'][$index];

                if ($fileData['name']) {
                    // this will already handle the moving of the file to the storage:
                    $newFileObject = $storage->addFile(
                            $fileData['tmp_name'], $storage->getRootLevelFolder(), $fileData['name']
                    );
                    $newFileObject = $storage->getFile($newFileObject->getIdentifier());
                    $newFile = $this->fileRepository->findByUid($newFileObject->getProperty('uid'));

                    /** @var \T3developer\ProjectsAndTasks\Domain\Model\FileReference $newFileReference */
                    $newFileReference = $this->objectManager->get('T3developer\ProjectsAndTasks\Domain\Model\FileReference');
                    $newFileReference->setFile($newFile);

                    $ticket->addTicketImages($newFileReference);
                }
            }
        }
        
        if ($ticket->getUid()) {
            $this->ticketsRepository->update($ticket);
        } else {
            $this->ticketsRepository->add($ticket);
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

        $this->redirect('projectTicketDetail', 'Project', NULL, array('uid' => $ticket->getUid()));
    }

    /**
     * Deletes a ticket (and notes)
     * 
     */
    public function projectTicketDeleteAction() {
        if ($this->request->hasArgument('ticketUid')) {
            $ticketUid = $this->request->getArgument('ticketUid');
        }
        if ($this->request->hasArgument('projectUid')) {
            $projectUid = $this->request->getArgument('projectUid');
        }

        //find all notes from ticket and deletes them
        $notes = $this->ticketresponseRepository->findByTrTicket($ticketUid);
        if ($notes[0]) {
            foreach ($notes as $note) {
                $this->ticketresponseRepository->remove($note);
            }
        }

        //ticket delete
        $ticket = $this->ticketsRepository->findByUid($ticketUid);
        $this->ticketsRepository->remove($ticket);

        $this->redirect('projectTicketsOpen', 'Project', NULL, array('uid' => $projectUid));
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
        $response->setTrDate(time());
        $response->setTrOwner($this->user->getUid());

        $ticket = $this->ticketsRepository->findByUid($ticketuid);
        $project = $ticket->getTicketProject();

        $status = $this->statusRepository->findByStatusTyp(5);

        $this->view->assign('status', $status);
        $this->view->assign('response', $response);
        $this->view->assign('ticket', $ticket);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($project->getUid()));
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
        $ticket = $response->getTrTicket();
        $project = $ticket->getTicketProject();

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
            $tickets = $this->ticketsRepository->findTicketsByProjectMs($projectuid, $mile->getUid());
            // open tickets
            //$tickets = $this->ticketsRepository->findTicketsByProjectMsAndStatus($projectuid, $mile->getUid(), 0);
            if ($tickets[0] != '') {
                foreach($tickets as $ticket){
                     $tickArray[$mile->getUid()]['milestone'] = $mile;
                     $tickArray[$mile->getUid()]['ticket'][$ticket->getUid()]['ticket'] = $ticket;
                     $tickArray[$mile->getUid()]['ticket'][$ticket->getUid()]['notes'] = $this->ticketresponseRepository->findByTrTicket($ticket->getUid());
                }
                
                
            }
        }
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($tickArray);
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
     * Shows the Sprint Index Page
     */
    public function projectSprintEditAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        if ($this->request->hasArgument('sprintId')) {
            $sprintId = $this->request->getArgument('sprintId');
        }

        $project = $this->projectsRepository->findByUid($projectuid);
        $sprint = $this->sprintRepository->findByUid($sprintId);

        $this->view->assign('sprint', $sprint);
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
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Documents $newDocument
     */
    public function projectDocumentIndexAction(\T3developer\ProjectsAndTasks\Domain\Model\Documents $newDocument = NULL) {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }


        $project = $this->projectsRepository->findByUid($projectuid);

        $this->view->assign('documents', $this->documentsRepository->findByDocProject($projectuid));
        $this->view->assign('newDocument', $newDocument);
        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));
        $this->view->assign('mainmenu', '5');
        $this->view->assign('submenu', '1');
    }

    /**
     * save new Documents from upload form
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Documents $newDocument
     */
    public function projectDocumentSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Documents $newDocument) {

        if (!empty($_FILES['tx_projectsandtasks_pat'])) {

            /** @var \TYPO3\CMS\Core\Resource\StorageRepository $storageRepository */
            $storageRepository = $this->objectManager->get('TYPO3\CMS\Core\Resource\StorageRepository');
            /** @var \TYPO3\CMS\Core\Resource\ResourceStorage $storage */
            $storage = $storageRepository->findByUid('1');

            for ($index = 0; $index < count($_FILES['tx_projectsandtasks_pat']['name']['file']); $index++) {
                // setting up file data
                $fileData = array();
                $fileData['name'] = $_FILES['tx_projectsandtasks_pat']['name']['file'][$index];
                $fileData['type'] = $_FILES['tx_projectsandtasks_pat']['type']['file'][$index];
                $fileData['tmp_name'] = $_FILES['tx_projectsandtasks_pat']['tmp_name']['file'][$index];
                $fileData['size'] = $_FILES['tx_projectsandtasks_pat']['size']['file'][$index];

                if ($fileData['name']) {
                    // this will already handle the moving of the file to the storage:
                    $newFileObject = $storage->addFile(
                            $fileData['tmp_name'], $storage->getRootLevelFolder(), $fileData['name']
                    );
                    $newFileObject = $storage->getFile($newFileObject->getIdentifier());
                    $newFile = $this->fileRepository->findByUid($newFileObject->getProperty('uid'));

                    /** @var \T3developer\ProjectsAndTasks\Domain\Model\FileReference $newFileReference */
                    $newFileReference = $this->objectManager->get('T3developer\ProjectsAndTasks\Domain\Model\FileReference');
                    $newFileReference->setFile($newFile);

                    $newDocument->addFile($newFileReference);
                }
            }

            $this->documentsRepository->add($newDocument);
        }


        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($newDocument, 'dokument');
        $this->redirect('projectDocumentIndex', 'Project', NULL, array('uid' => $newDocument->getDocProject()));
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

        $projectteam = $this->projectteamRepository->findByPtProject($project->getUid());

        $persons = $this->userRepository->findAll();


        $this->view->assign('projectteam', $projectteam);
        $this->view->assign('persons', $persons);


        $this->view->assign('project', $project);
        $this->view->assign('projectHours', $this->calculateProjectHours($projectuid));

        $this->view->assign('mainmenu', '8');
        $this->view->assign('submenu', '1');
    }

    /**
     * projectCotractList
     * Shows a List of all OPEN Project Contracts
     */
    public function projectTeamDeleteAction() {
        if ($this->request->hasArgument('uid')) {
            $projectuid = $this->request->getArgument('uid');
        }
        if ($this->request->hasArgument('memberUid')) {
            $memberUid = $this->request->getArgument('memberUid');
        }
        $member = $this->projectteamRepository->findByUid($memberUid);
        $this->projectteamRepository->remove($member);

        $this->redirect('projectTeamList', 'Project', NULL, array('uid' => $projectuid));
    }

    /**
     * save Project Team
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Projectteam $teamMember
     */
    public function projectTeamSaveAction() {
        if ($this->request->hasArgument('teamMember')) {
            $formValue = $this->request->getArgument('teamMember');
        }
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($formValue);
        if ($formValue['ptUser'] == null) {
            $this->redirect('projectTeamList', 'Project', NULL, array('uid' => $formValue['projectUid']));
        } else {
            $member = new \T3developer\ProjectsAndTasks\Domain\Model\Projectteam;
            $member->setPtProject($this->projectcatsRepository->findByUid($formValue['projectUid']));
            $member->setPtUser($this->userRepository->findByUid($formValue['ptUser']));
            $this->projectteamRepository->add($member);

            // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($member);

            $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
            $persistenceManager->persistAll();
        }

        $this->redirect('projectTeamList', 'Project', NULL, array('uid' => $member->getPtProject()));
    }

    //**************************************************************************
    // Global Helper Functions 
    //**************************************************************************
    /**
     * Find Planed hours and efforts
     * 
     * @param int $projectID 
     * @return array $time 
     */
    private function calculateProjectHours($projectID) {
        $tickets = $this->ticketsRepository->findByTicketProject($projectID);

        //calculate Plan Effort
        //$plantime = 0;
        $plantime['total'] = 0;
        $plantime['open'] = 0;
        $worktime = 0;
        foreach ($tickets as $ticket) {
            //calculate Plan Time
            if ($ticket->getTicketScheduleTime() > 0) {
                $plantime['total'] = $plantime['total'] + $ticket->getTicketScheduleTime();
                if ($ticket->getTicketStatus()->getStatusBehaviour() == 0) {
                    $plantime['open'] = $plantime['open'] + $ticket->getTicketScheduleTime();
                }
            }
            //calculate IST Time
            $ticketresponses = $this->ticketresponseRepository->findByTrTicket($ticket->getUid());

            foreach ($ticketresponses as $response) {
                if ($response->getTrTime() > 0) {
                    $worktime = $worktime + $response->getTrTime();
                }
            }
        }
        $time['plan'] = $plantime;
        $time['work'] = $worktime;

        return ($time);
    }

    /**
     * Calculate Ticket Summary by Status for a Project
     * 
     * @param int $projectID 
     * @return array $tickets 
     */
    private function calculateTicketSummary($projectID) {

        $tickets['all'] = $this->ticketsRepository->countTicketsByProject($projectID);
        $tickets['open'] = $this->ticketsRepository->countOpenTicketsByProject($projectID);

        return ($tickets);
    }

    /**
     * configures the parsing in initialize Action
     */
    private function configureParsing() {
        if (isset($this->arguments['project'])) {
            // $propertyMappingConfiguration->allowProperties('projectDate');
            $this->arguments['project']
                    ->getPropertyMappingConfiguration()->allowProperties('projectDate')
                    ->forProperty('projectDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd-m-Y');
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
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd-m-Y');
        }
        if (isset($this->arguments['ticket'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['ticket']
                    ->getPropertyMappingConfiguration()->allowProperties('ticketScheduleDate')
                    ->forProperty('ticketScheduleDate')
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
            // ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\StringConverter',  \TYPO3\CMS\Extbase\Property\TypeConverter\StringConverter);
        }
        if (isset($this->arguments['response'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['response']
                    ->getPropertyMappingConfiguration()->allowProperties('trEnd')
                    ->forProperty('trEnd');
            //  ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\StringConverter',  \TYPO3\CMS\Extbase\Property\TypeConverter\StringConverter);
        }
        if (isset($this->arguments['milestone'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['milestone']
                    ->getPropertyMappingConfiguration()->allowProperties('msStart')
                    ->forProperty('msStart')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd-m-Y');
        }
        if (isset($this->arguments['milestone'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['milestone']
                    ->getPropertyMappingConfiguration()->allowProperties('msEnd')
                    ->forProperty('msEnd')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd-m-Y');
        }
        if (isset($this->arguments['sprint'])) {
            // $propertyMappingConfiguration->allowProperties('ticketDate');
            $this->arguments['sprint']
                    ->getPropertyMappingConfiguration()->allowProperties('sprintStart')
                    ->forProperty('sprintStart')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd-m-Y');
        }
        if (isset($this->arguments['sprint'])) {
            // sprint->allowProperties('ticketDate');
            $this->arguments['sprint']
                    ->getPropertyMappingConfiguration()->allowProperties('sprintEnd')
                    ->forProperty('sprintEnd')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd-m-Y');
        }
    }

}

?>