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
 * @package projects_and_tasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ProjectController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository   
     */
    protected $userRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ProjectRepository   
     */
    protected $projectRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\TodolistRepository    
     */
    protected $todolistRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\TodoRepository   
     */
    protected $todoRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\WorkRepository   
     */
    protected $workRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\MessageRepository   
     */
    protected $messageRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\Projectrights  
     */
    protected $projectrightsRepository;
    
        /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\PBudget  
     */
    protected $budgetRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Utility\Pdf  
     */
    protected $pdfUtility;

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\TodolistRepository $todolistRepository
     * @return void
     */
    public function injectTodolistRepository(\T3developer\ProjectsAndTasks\Domain\Repository\TodolistRepository $todolistRepository) {
        $this->todolistRepository = $todolistRepository;
    }

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\TodoRepository $todoRepository
     * @return void
     */
    public function injectTodoRepository(\T3developer\ProjectsAndTasks\Domain\Repository\TodoRepository $todoRepository) {
        $this->todoRepository = $todoRepository;
    }

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository $userRepository
     * @return void
     */
    public function injectUserRepository(\T3developer\ProjectsAndTasks\Domain\Repository\UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     *       
     * @param \t3developer\ProjectsAndTasks\Domain\Repository\ProjectRepository $projectRepository     
     */
    public function injectProjectRepository(\t3developer\ProjectsAndTasks\Domain\Repository\ProjectRepository $projectRepository) {
        $this->projectRepository = $projectRepository;
    }

    /**
     *       
     * @param \t3developer\ProjectsAndTasks\Domain\Repository\WorkRepository $workRepository     
     */
    public function injectWorkRepository(\t3developer\ProjectsAndTasks\Domain\Repository\WorkRepository $workRepository) {
        $this->workRepository = $workRepository;
    }

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\MessageRepository $messageRepository
     * @return void
     */
    public function injectMessageRepository(\T3developer\ProjectsAndTasks\Domain\Repository\MessageRepository $messageRepository) {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\ProjectrightsRepository $projectrightsRepository
     * @return void
     */
    public function injectProjectrightsRepository(\T3developer\ProjectsAndTasks\Domain\Repository\ProjectrightsRepository $projectrightsRepository) {
        $this->projectrightsRepository = $projectrightsRepository;
    }
    
        /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\BudgetRepository $budgetRepository
     * @return void
     */
    public function injectBudgetRepository(\T3developer\ProjectsAndTasks\Domain\Repository\BudgetRepository $budgetRepository) {
        $this->budgetRepository = $budgetRepository;
    }

    /**
     *       
     * @param \T3developer\ProjectsAndTasks\Utility\Pdf $pdfUtility    
     */
    public function injectPdf(\T3developer\ProjectsAndTasks\Utility\Pdf $pdfUtility) {
        $this->pdfUtility = $pdfUtility;
    }

    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {
        if (isset($this->arguments['project'])) {
            $commentConfiguration = $this->arguments['project']->getPropertyMappingConfiguration();
            $commentConfiguration->allowAllProperties();
            $commentConfiguration
                    ->setTypeConverterOption(
                            ' TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, TRUE
            );
        }
        if (isset($this->arguments['project'])) {
            $this->arguments['project']
                    ->getPropertyMappingConfiguration()
                    ->forProperty('projectRevisionDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
        
            $this->arguments['project']
                    ->getPropertyMappingConfiguration()
                    ->forProperty('projectStartDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
            $this->arguments['project']
                    ->getPropertyMappingConfiguration()
                    ->forProperty('projectEndDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
        
        }
        $this->checkLogIn();
    }

    /*
     * Show Project Action
     */

    public function projectShowAction(\t3developer\ProjectsAndTasks\Domain\Model\Project $project) {
        $this->checkLogIn();
        
        //Widget ProjectView ToDos:
        //load todo lists, todos and count items
        //shows only the open todos per list
        $todoLists = $this->todolistRepository->findByTodolistProject($project->getUid());
        if ($todoLists[0] != '') {
            foreach ($todoLists as $lists) {
                $todos[$lists->getUid()]['lists'] = $lists;
                $todos[$lists->getUid()]['all'] = $this->todoRepository->countAllPerList($lists->getUid());
                $todos[$lists->getUid()]['open'] = $this->todoRepository->countOpenPerList($lists->getUid());
                $todos[$lists->getUid()]['todos'] = $this->todoRepository->findByListAndStatus($lists->getUid(), '6');
            }
        }

        $work = $this->workRepository->findByWorkProject($project->getUid());

        //Widget ProjectView: subProjects
        $subProjects = $this->projectRepository->findByProjectParent($project->getUid());
        foreach ($subProjects as $single) {
            $single->setProjectOpenTodos($this->countTodos($single->getUid()));
            $subPro[$single->getUid()] = $single;
        }

        //Widget ProejctView: Messages
        //find all open Messages for the Project
        $messages = $this->messageRepository->findByProjectAndStatus($project->getUid(), '1');

        $this->view->assign('projectHeader', $this->findProjectHeader($project->getUid()));
        $this->view->assign('user', $this->user);
        $this->view->assign('project', $project);
        $this->view->assign('subprojects', $subPro);
        $this->view->assign('todos', $todos);
        $this->view->assign('messages', $messages);
        $this->view->assign('works', $work);
        $this->view->assign('menu', '1');
    }

    /**
     * Show Project Details
     * 
     */
    public function projectShowDetailsAction(\t3developer\ProjectsAndTasks\Domain\Model\Project $project) {

        $this->view->assign('projectHeader', $this->findProjectHeader($project->getUid()));
        $this->view->assign('user', $this->user);
        $this->view->assign('project', $project);
        $this->view->assign('projectuser', $this->projectrightsRepository->findByProjectrightsProject($project->getUid()));
        $this->view->assign('menu', '2');
        $this->view->assign('submenu', '1');
    }

    /**
     * Show Project User Rights
     * 
     * Shows a list of all User of the project
     * Shows a Form to create or edit a new Userrights
     * 
     */
    public function projectEditUserRightsAction(\t3developer\ProjectsAndTasks\Domain\Model\Project $project) {

        $projectrights = $this->projectrightsRepository->findByProjectrightsProject($project->getUid());


        $this->view->assign('projectrights', $projectrights);
        $this->view->assign('projectHeader', $this->findProjectHeader($project->getUid()));
        $this->view->assign('user', $this->userRepository->findAll());
        $this->view->assign('rights', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableUserRights());
        $this->view->assign('projectuser', $this->projectrightsRepository->findByProjectrightsProject($project->getUid()));

        $this->view->assign('project', $project);
        $this->view->assign('menu', '2');
        $this->view->assign('submenu', '3');
    }

    /**
     * Updates or create a USer Right
     * 
     * We don't use objects here beacuse we manipulate the uid via jquery
     * 
     */
    public function projectUpdateUserRightsAction() {
        if ($this->request->hasArgument('userrights')) {
            $userrights = $this->request->getArgument('userrights');
        }
        //     \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($userrights);
        if ($userrights['uid'] == null) {
            $rights = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Projectrights');
            $action = 'new';
        }
        if ($userrights['uid'] != null) {
            $rights = $this->projectrightsRepository->findByUid($projectright['uid']);
            $action = 'update';
        }

        $rights->setProjectrightsProject($userrights['projectrightsProject']);
        $rights->setProjectrightsUser($userrights['projectrightsUser']);
        $rights->setProjectrightsRights($userrights['projectrightsRights']);

        if ($action == 'new') {
            $this->projectrightsRepository->add($rights);
        }
        if ($action == 'update') {
            $this->projectrightsRepository->update($rights);
        }

        $project = $this->projectRepository->findByUid($rights->getProjectrightsProject());

        $this->redirect('projectEditUserRights', 'Project', NULL, Array('project' => $project));
    }

    /*
     * New Project Action
     */

    public function projectNewAction() {

        $newproject = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Project');
        $projectSelect = $this->findProjectSelectArray();

        $this->view->assign('projectSelect', $projectSelect);
        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('project', $newproject);
    }

    /*
     * Edit Project Action
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Project $project
     */

    public function projectEditAction(\T3developer\ProjectsAndTasks\Domain\Model\Project $project) {

        $projectSelect = $this->findProjectSelectArray();

        $this->view->assign('projectHeader', $this->findProjectHeader($project->getUid()));
        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        //ToDo: remove the projects if new projectViewHelper works
        $this->view->assign('projects', $this->projectRepository->findAll());
        $this->view->assign('projectSelect', $projectSelect);

        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableProjectStatus());
        $this->view->assign('project', $project);
        $this->view->assign('user', $this->user);
        $this->view->assign('menu', '2');
        $this->view->assign('submenu', '2');
    }

    /*
     * Update Project Action
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Project $project
     * @dontvalidate $project
     * @return void
     */

    public function projectUpdateAction(\T3developer\ProjectsAndTasks\Domain\Model\Project $project) {
        $time = $project->getProjectBudgetTime();
        //
        $time = $time * 3600;
        $project->setProjectBudgetTime($time);
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($project);
        $this->projectRepository->update($project);

        //$this->redirect('index', 'Inbox');projectShowDetails
        $this->redirect('projectShowDetails', 'Project', NULL, Array('project' => $project));
    }

    /**
     * New Project Action
     * 
     * @param \t3developer\ProjectsAndTasks\Domain\Model\Project $project
     * @dontvalidate $project
     * @return void
     * 
     */
    public function projectCreateAction(\T3developer\ProjectsAndTasks\Domain\Model\Project $project) {
        $userUid = $GLOBALS['TSFE']->fe_user->user['uid'];
        
        $time = $project->getProjectBudgetTime();
        $time = $time * 3600;
        
        $project->setProjectBudgetTime($time);
        $project->setProjectOwner($userUid);
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($project);
        $this->projectRepository->add($project);

        $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface')->persistAll();

        //create the userrights
        $rights = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Projectrights');
        $rights->setProjectrightsProject($project->getUid());
        $rights->setProjectrightsUser($userUid);
        $rights->setProjectrightsRights('1');
        $this->projectrightsRepository->add($rights);

        $this->redirect('index', 'Inbox');
    }

    /**
     * Show Efforts
     * 
     * Displays a list and Form of all Efforts by Project
     * 
     * @param $projectUid
     */
    public function effortsShowAction() {
        $project = $this->request->getArgument('project');

        $newWork = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Work');
        $newWork->setWorkProject($project);

        $workList = $this->workRepository->findByWorkProject($project);

        $this->view->assign('project', $project);
        $this->view->assign('projectHeader', $this->findProjectHeader($project));
        $this->view->assign('workstatus', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableWorkStatus());
        $this->view->assign('time', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableTime());
        $this->view->assign('user', $this->user);
        $this->view->assign('works', $workList);
        $this->view->assign('work', $newWork);
        $this->view->assign('menu', '5');
    }

    /**
     * Save Efforts
     * 
     * Updates and creates an effort
     */
    public function effortsSaveAction() {

        $effort = $this->request->getArgument('work');

        if ($this->request->hasArgument('delete')) {
            $effort = $this->workRepository->findByUid($effort['uid']);
            $this->workRepository->remove($effort);
            $this->redirect('effortsShow', 'Project', NULL, Array('project' => $effort->getWorkProject()));
        }

        if ($effort['uid'] == '') {
            //Create New todo
            $effortDB = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Work');
            $effortDB->setWorkUser($GLOBALS['TSFE']->fe_user->user['uid']);
            $action = 'new';
        } else {
            //update Effort
            $effortDB = $this->workRepository->findByUid($effort['uid']);
            $action = 'update';
        }
        $date = explode(".", $effort[workDate]);
        $dateDay = $date[0];
        $dateMonth = $date[1];
        $dateYear = $date[2];
        $workDate = mktime(12, 0, 0, $dateMonth, $dateDay, $dateYear);

        $effortDB->setWorkProject($effort['workProject']);
        //$effortDB->setWorkUser($this->user);
        $effortDB->setWorkTitle($effort['workTitle']);
        $effortDB->setWorkDescription($effort['workDescription']);
        $effortDB->setWorkStatus($effort['workStatus']);
        $effortDB->setWorkDate($workDate);
        $effortDB->setWorkStart($effort['workStart']);
        $effortDB->setWorkEnd($effort['workEnd']);


        if ($action == 'new') {
            $this->workRepository->add($effortDB);
        }
        if ($action == 'update') {
            $this->workRepository->update($effortDB);
        }

        $this->redirect('effortsShow', 'Project', NULL, Array('project' => $effortDB->getWorkProject()));
    }

    /**
     * Delete Efforts
     * 
     * Delete an Effort
     */
    public function effortsDeleteAction() {
        //TODO: write function
    }

    /**
     * Effort By Ajax
     */
    public function effortByAjaxAction() {
        if ($this->request->hasArgument('uid')) {
            $effortUid = $this->request->getArgument('uid');
        }
        if ($this->request->hasArgument('storagePid')) {
            $storagePid = $this->request->getArgument('storagePid');
        }

        $effort = $this->workRepository->findWorkByUidAndPid($effortUid, $storagePid);
        if ($effort[0]->getWorkDate()) {
            $date = date("d.m.Y", $effort[0]->getWorkDate()->getTimestamp());
        }


        $result['uid'] = $effort[0]->getUid();
        $result['effortProject'] = $effort[0]->getWorkProject()->getUid();
        $result['effortUser'] = $effort[0]->getWorkUser()->getUsername();
        $result['effortTitel'] = $effort[0]->getWorkTitle();
        $result['effortDescription'] = $effort[0]->getWorkDescription();
        $result['effortStatus'] = $effort[0]->getWorkStatus();
        $result['effortDate'] = $date;
        $result['effortStart'] = $effort[0]->getWorkStart();
        $result['effortEnd'] = $effort[0]->getWorkEnd();


        return json_encode($result);
    }

    /**
     * TODO Show
     * 
     * Shows the TodoList and Edit/New Form
     */
    public function todoShowAction() {
        if($this->request->hasArgument('project')){
            $project = $this->request->getArgument('project');
        }
        if($this->request->hasArgument('todolist')){
            $todoList = $this->request->getArgument('todolist');
            $list = $this->todolistRepository->findByUid($todoList);
            $project = $list->getTodolistProject();
        } else{
            $todoListen = $this->todolistRepository->findByTodolistProject($project);
            if($todoListen[0] != '') $todoList = $todoListen[0]->getUid(); 
        }

        $todoAllLists = $this->todolistRepository->findByTodolistProject($project);
        
        //If a Project has a todoList: find first List and loads the todos
        if ($todoList != '') {
            $todosAllFromList = $this->todoRepository->findByTodoList($todoList);
            $todoList = $this->todolistRepository->findByUid($todoList);
        }

        $this->view->assign('projectHeader', $this->findProjectHeader($project));
        $this->view->assign('user', $this->userRepository->findAll());
        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('plantime', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableWorkTime());
        $this->view->assign('typ', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableTodoTyp());
        $this->view->assign('todolist', $todoList);
        $this->view->assign('allLists', $todoAllLists);
        $this->view->assign('todosAllFromList', $todosAllFromList);
        
        $this->view->assign('menu', '4');
    }

    /*
     * Save Todo Action
     * 
     * Important: The Form Values are set via Ajax. We have not a valid todo Object!
     * 
     * @return void
     */

    public function todoSaveAction() {

        $todo = $this->request->getArgument('todo');

        if ($this->request->hasArgument('delete')) {
            $todo = $this->todoRepository->findByUid($todo['uid']);
            $this->todoRepository->remove($todo);

            $todoList = $this->todolistRepository->findByUid($todo->getTodoList());
            $this->redirect('todoShow', 'Project', NULL, Array('project' => $todoList->getTodolistProject(), 'todolist' => $todo->getTodolist()));
        }
        if ($todo['uid'] == '') {
            //Create New todo
            $toDoDB = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Todo');
            $action = 'new';
            $toDoDB->setTodoNr($this->todoRepository->getNextNumber($todo['todoList']));
        } else {
            //update Todo
            $toDoDB = $this->todoRepository->findByUid($todo['uid']);
            $action = 'update';
        }
        $start = explode(".", $todo[todoDate]);
        $startDay = $start[0];
        $startMonth = $start[1];
        $startYear = $start[2];
        $startDate = mktime(0, 0, 0, $startMonth, $startDay, $startYear);

        $end = explode(".", $todo[todoEnd]);
        $endDay = $end[0];
        $endMonth = $end[1];
        $endYear = $end[2];
        $endDate = mktime(0, 0, 0, $endMonth, $endDay, $endYear);

        $toDoDB->setTodoList($todo['todoList']);
        $toDoDB->setTodoTyp($todo['todoTyp']);
        $todoAssigned = $this->userRepository->findByUid($todo['todoAssigned']);
        $toDoDB->setTodoAssigned($todoAssigned);
        $toDoDB->setTodoTitle($todo['todoTitle']);
        $toDoDB->setTodoDescription($todo['todoDescription']);
        $toDoDB->setTodoComment($todo['todoComment']);
        $toDoDB->setTodoStatus($todo['todoStatus']);
        $toDoDB->setTodoDate($startDate);
        $toDoDB->setTodoEnd($endDate);
        $toDoDB->setTodoPlantime($todo['todoPlantime']);

        if ($action == 'new') {
            $this->todoRepository->add($toDoDB);
        }
        if ($action == 'update') {
            $this->todoRepository->update($toDoDB);
        }

        //find project via todolist for redirect
        $todoList = $this->todolistRepository->findByUid($todo['todoList']);


        $this->redirect('todoShow', 'Project', NULL, Array('project' => $todoList->getTodolistProject(), 'todolist' => $toDoDB->getTodolist()));
    }

    /**
     * Find Todo by Ajax
     * 
     * @param: todoUid
     * @param storagePid 
     */
    public function todoByAjaxAction() {
        if ($this->request->hasArgument('uid')) {
            $todoUid = $this->request->getArgument('uid');
        }
        if ($this->request->hasArgument('storagePid')) {
            $storagePid = $this->request->getArgument('storagePid');
        }
        $todo = $this->todoRepository->findTodoByUidAndPid($todoUid, $storagePid)->toArray();
        if ($todo[0]->getTodoDate()) {
            $start = date("d.m.Y", $todo[0]->getTodoDate()->getTimestamp());
        }
        if ($todo[0]->getTodoEnd()) {
            $end = date("d.m.Y", $todo[0]->getTodoEnd()->getTimestamp());
        }
        $result['uid'] = $todo[0]->getUid();
        $result['todoTitel'] = $todo[0]->getTodoTitle();
        $result['todoTyp'] = $todo[0]->getTodoTyp();
        $result['todoAssigned'] = $todo[0]->getTodoAssigned()->getUid();
        $result['todoDescription'] = $todo[0]->getTodoDescription();
        $result['todoComment'] = $todo[0]->getTodoComment();
        $result['todoStatus'] = $todo[0]->getTodoStatus();
        $result['todoDate'] = $start;
        $result['todoEnd'] = $end;
        $result['todoPlantime'] = $todo[0]->getTodoPlantime();

        $arguments['storagePid'] = $storagePid;
        $arguments['todoUid'] = $todoUid;
        return json_encode($result);
    }

    /**
     * Save and Delete TodoList Action
     * 
     * Important: The Form Values are set via Ajax. We have not a valid todo Object!
     * 
     * @return void
     */
    public function todoListSaveAction() {

        $todoList = $this->request->getArgument('todoList');
        
        //delete Action: deltes also all toDos from List
        if ($this->request->hasArgument('delete')) {
            
            $todos = $this->todoRepository->findByTodoList($todoList['uid']);
            foreach($todos as $todo){
                $this->todoRepository->remove($todo);
             }
            $todoListDB = $this->todolistRepository->findByUid($todoList['uid']);
            $this->todolistRepository->remove($todoListDB);
            $this->redirect('todoShow', 'Project', NULL, Array('project' => $todoListDB->getTodolistProject() ));
        }
        
        //new and update Action
        if ($todoList['uid'] == '') {
            //Create New todo
            $todoListDB = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Todolist');
            $action = 'new';
        } else {
            //update Todo
            $todoListDB = $this->todolistRepository->findByUid($todoList['uid']);
            $action = 'update';
        }

        $todoListDB->setTodolistProject($todoList['todolistProject']);
        $todoListDB->setTodolistTitel($todoList['todolistTitle']);
        $todoListDB->setTodolistShortTitel($todoList['todolistShortTitle']);
        $todoListDB->setTodolistDescription($todoList['todolistDescription']);
        $todoListDB->setTodolistOwner($todoList['todolistOwner']);
      //  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($todoListDB);

        if ($action == 'new') {
            $this->todolistRepository->add($todoListDB);
        }
        if ($action == 'update') {
            $this->todolistRepository->update($todoListDB);
        }

        $this->redirect('todoShow', 'Project', NULL, Array('project' => $todoListDB->getTodolistProject(), 'list' => $todoListDB->getUid()));
    }
    
    /**
     * Shows the Budget List for Project
     * 
     */
    public function budgetShowAction(){
        if($this->request->hasArgument('project')){
            $project = $this->request->getArgument('project');
        }
        
        $budgets = $this->budgetRepository->findByBudgetProject($project);
        
        $this->view->assign('projectHeader', $this->findProjectHeader($project));
        $this->view->assign('budgets', $budgets);
        $this->view->assign('menu', '2');
        $this->view->assign('submenu', '4');
       
    }

    /**
     * Saves the values of the budget form
     * 
     */
    public function budgetSaveAction(){
        
        $budget = $this->request->getArgument('budget');
        
        //delete Action: deltes also all toDos from List
        if ($this->request->hasArgument('delete')) {
            
            $budget = $this->budgetRepository->findByUid($budget['uid']);
            $this->budgetRepository->remove($budget);
            
            $this->redirect('budgetShow', 'Project', NULL, Array('project' => $budget->getBudgetProject() ));
        }
        
        //new and update Action
        if ($budget['uid'] == '') {
            //Create New Budget
            $budgetDB = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Budget');
            $action = 'new';
        } else {
            //update Budget
            $budgetDB = $this->budgetRepository->findByUid($budget['uid']);
            $action = 'update';
        }

        $budgetDB->setBudgetTitle($budget['budgetTitle']);
        $budgetDB->setBudgetText(trim($budget['budgetText']));
        $budgetDB->setBudgetValue($budget['budgetValue']);
        $budgetDB->setBudgetTime($budget['budgetTime'] * 3600);
        $budgetDB->setBudgetProject($budget['budgetProject']);
        
         \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($budgetDB);
      //  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($todoListDB);

        if ($action == 'new') {
            $this->budgetRepository->add($budgetDB);
        }
        if ($action == 'update') {
            $this->budgetRepository->update($budgetDB);
        }

        $this->redirect('budgetShow', 'Project', NULL, Array('project' => $budgetDB->getBudgetProject()));
   
        
    }
    
        /**
     * Budget By Ajax
     */
    public function budgetByAjaxAction() {
        if ($this->request->hasArgument('uid')) {
            $budgetUid = $this->request->getArgument('uid');
        }
        if ($this->request->hasArgument('storagePid')) {
            $storagePid = $this->request->getArgument('storagePid');
        }

        $budget = $this->budgetRepository->findByUid($budgetUid);
        
        $result['uid'] = $budget->getUid();
        $result['budgetTitle'] = $budget->getBudgetTitle();
        $result['budgetText'] = $budget->getBudgetText();
        $result['budgetValue'] = $budget->getBudgetValue();
        $result['budgetTime'] = $budget->getBudgetTime() / 3600;
        $result['budgetProject'] = $budget->getBudgetProject();
        $result['budgetInvoice'] = $budget->getBudgetInvoice();
        $result2 = $budgetUid;
        return json_encode($result);
    }
    
    
    /**
     * Show PDF Action
     *
     * 
     * @return void
     * 
     */
    public function todoPdfAction() {
        $todoListUid = $this->request->getArgument('todolist');
        $todoList = $this->todolistRepository->findByUid($todoListUid);
        $project = $this->projectRepository->findByUid($todoList->getTodolistProject());
        $todos = $this->todoRepository->findByListAndStatus($todoList->getUid(), '6');
        //  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($todoListUid);
        return $this->pdfUtility->createTodoPdf($todoList, $todos, $project);
    }

    /**
     * Finds Data for Project Header Partial
     * @param $projectUid
     * @return array
     */
    function findProjectHeader($projectUid) {
        //get the project
        $project = $this->projectRepository->findByUid($projectUid);


        //get the worktime
        $work = $this->workRepository->findByWorkProject($projectUid);
        $istTime = 0;
        foreach ($work as $single) {
            $start = $single->getWorkStart();
            $end = $single->getWorkEnd();
            $time = $end - $start;
            $istTime = $istTime + $time;
        }
        $budgetTime = $project->getProjectBudgetTime();
        $budgetTime = intval($budgetTime);
        if ($budgetTime != 0) {
            $workTemp['percent'] = $istTime * 100 / intval($budgetTime);
        }

        //get the messages
        $messages['all'] = count($this->messageRepository->findByMessageProject($project->getUid()));

        //get the todos
        $todoLists = $this->todolistRepository->findByTodolistProject($project->getUid());
        $todos['all'] = 0;
        $todos['open'] = 0;
        if ($todoLists[0] != '') {
            foreach ($todoLists as $lists) {
                $all = $this->todoRepository->countAllPerList($lists->getUid());
                $open = $this->todoRepository->countOpenPerList($lists->getUid());
                $todos['all'] = $todos['all'] + $all;
                $todos['open'] = $todos['open'] + $open;
            }
        }

        //get the work
        $work = '';
        $work['all'] = count($work = $this->workRepository->findByWorkProject($projectUid));
        $work['open'] = count($this->workRepository->findByWorkByStatusAndProject('5', $projectUid));
        $work['percent'] = $workTemp['percent'];
        //get the documents
        $documents = "xy";

        //get the dates
        $dates = 'xy';

        $projectHeader['project'] = $project;
        $projectHeader['istTime'] = $istTime;
        $projectHeader['messages'] = $messages;
        $projectHeader['todos'] = $todos;
        $projectHeader['work'] = $work;
        $projectHeader['documents'] = $documents;
        $projectHeader['dates'] = $dates;

        return $projectHeader;
    }

    /**
     * Find Project Level
     * 
     * 
     */
    public function findProjectLevel($project) {

        if ($project->getProjectParent() == 0) {
            $projectLevel = '1';
        } else {
            $parent = $this->projectRepository->findByUid($project->getProjectParent());
            if ($parent->getProjectParent == 0) {
                $projectLevel = '2';
            } else {
                $parent = $this->projectRepository->findByUid($parent->getProjectParent());
                if ($parent->getProjectParent == 0) {
                    $projectLevel = '3';
                } else {
                    $projectLevel = '4';
                }
            }
        }

        return $projectLevel;
    }

    /**
     * Project Select Array
     * 
     * Find Projects and group them for the select field
     * 
     * We Use only the first 3 Project Levels (instead of 4) to avoid
     * a 5th project Level.
     * 
     * @return array
     */
    public function findProjectSelectArray() {

        $firstLevel = $this->projectRepository->findByProjectParent('0');
        foreach ($firstLevel as $first) {
            $projectSelect[$first->getUid()]['node'] = $first;

            $secondLevel = $this->projectRepository->findByProjectParent($first->getUid());
            if ($secondLevel[0] != '') {
                foreach ($secondLevel as $second) {
                    $projectSelect[$first->getUid()]['subnodes'][$second->getUid()]['node'] = $second;

                    $thirdLevel = $this->projectRepository->findByProjectParent($second->getUid());
                    if ($thirdLevel != '') {
                        foreach ($thirdLevel as $third) {
                            $projectSelect[$first->getUid()]['subnodes'][$second->getUid()]['subnodes'][$third->getUid()] = $third;
                        }
                    }
                }
            }
        }
        return $projectSelect;
    }

    /**
     * Count ToDos by project
     * 
     * The function finds all tododslist from a project and
     * counts the todos
     * 
     * @param int $projectUid
     * @return int $openTodos
     */
    public function countTodos($projectUid) {
        $count = 0;
        $todolists = $this->todolistRepository->findByTodolistProject($projectUid);
        if ($todolists[0] != '') {
            foreach ($todolists as $list) {
                $todos = $this->todoRepository->findByListAndStatus($list->getUid(), '6');
                $count = $count + count($todos);
            }
        }

        return $count;
    }

    public function checkLogIn() {

        $user = $GLOBALS['TSFE']->fe_user->user;
        
        if ($user == null) {
            $this->redirect('logIn', 'User');
        } else {
            $this->user = $this->userRepository->findByUid($user['uid']);
            
            
        }
    }

}

?>