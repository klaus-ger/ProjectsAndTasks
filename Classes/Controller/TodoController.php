<?php

namespace T3Developer\ProjectsAndTasks\Controller;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Klaus Heuer <klaus.heuer@t3-developer.com>
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
class TodoController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
     * @var \T3developer\ProjectsAndTasks\Utility\Pdf  
     */
    protected $pdfUtility;

    /**
     * @var T3developer\ProjectsAndTasks\Controller\ProjectController  
     */
    protected $project;

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
     * @param \T3developer\ProjectsAndTasks\Utility\Pdf $pdfUtility    
     */
    public function injectPdf(\T3developer\ProjectsAndTasks\Utility\Pdf $pdfUtility) {
        $this->pdfUtility = $pdfUtility;
    }

    /**
     *       
     * @param \T3developer\ProjectsAndTasks\Controller\ProjectController $project
     */
    public function injectProject(\T3developer\ProjectsAndTasks\Controller\ProjectController $project) {
        $this->project = $project;
    }

    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {
        // this configures the parsing
        if (isset($this->arguments['todo'])) {
            $this->arguments['todo']
                    ->getPropertyMappingConfiguration()
                    ->forProperty('todoDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
        }
        if (isset($this->arguments['todo'])) {
            $this->arguments['todo']
                    ->getPropertyMappingConfiguration()
                    ->forProperty('todoEnd')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
        }
    }

    public function indexAction() {
        $projects = $this->projectRepository->findAll();
        $this->view->assign('test', 'test');
    }

    /*
     * Show Project Action
     */

    public function projectShowAction(\t3developer\ProjectsAndTasks\Domain\Model\Project $project) {
        $this->checkLogIn();
        $this->view->assign('user', $this->user);
        $this->view->assign('project', $project);
    }

    /*
     * Shows more than one todoList
     * 
     */

    public function todoShowMultiAction() {
        $project = $this->request->getArgument('project');
        //  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($project);

        //load todo lists, todos and count itemss
        $todoLists = $this->todolistRepository->findByTodolistProject($project);
        if ($todoLists[0] != ''){
            foreach ($todoLists as $lists){
                $todos[$lists->getUid()]['lists'] = $lists;
                $todos[$lists->getUid()]['all'] = $this->todoRepository->countAllPerList($lists->getUid());
                $todos[$lists->getUid()]['open'] = $this->todoRepository->countOpenPerList($lists->getUid());
                $todos[$lists->getUid()]['todos'] = $this->todoRepository->findByListAndStatus($lists->getUid(), '6');
            }
        }

        $this->view->assign('projectHeader', $this->project->findProjectHeader($project));
        $this->view->assign('todos', $todos);
        $this->view->assign('menu', '4');
    }

    /*
     * New TodoList Action
     */

    public function todoListNewAction() {
        $project = $this->request->getArgument('project');
        //  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($project);

        $newtodolist = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Todolist');

        $newtodolist->setTodolistProject($project);

        $this->view->assign('projectHeader', $this->project->findProjectHeader($project));
        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('todolist', $newtodolist);
        $this->view->assign('menu', '4');
    }

    /*
     * Create Todolist Action
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Todolist $todolist
     * @dontvalidate $todolist
     * @return void
     */

    public function todoListCreateAction(\T3developer\ProjectsAndTasks\Domain\Model\Todolist $todolist) {
        $userUid = $GLOBALS['TSFE']->fe_user->user['uid'];

        $todolist->setTodolistOwner($userUid);
        $this->todolistRepository->add($todolist);
// \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($todolist);
        $this->redirect('index', 'Inbox');
    }

    /*
     * New Todo Action
     */

    public function todoNewAction() {
        $list = $this->request->getArgument('list');

        
        //$newtodo = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Todo');
        //$newtodo->setTodolist($list);
        //$newtodo->setTodoNr($this->todoRepository->getNextNumber($list));

        $todoList = $this->todolistRepository->findByUid($list);
        $todosAllFromList = $this->todoRepository->findByTodoList($list);

        $this->view->assign('projectHeader', $this->project->findProjectHeader($todoList->getTodolistProject()));
        $this->view->assign('user', $this->userRepository->findAll());
        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('plantime', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableWorkTime());
        $this->view->assign('typ', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableTodoTyp());
        $this->view->assign('todolist', $todoList);
        $this->view->assign('todosAllFromList', $todosAllFromList);
        //$this->view->assign('todo', $newtodo);
        $this->view->assign('menu', '4');
    }

    /*
     * Create Todolist Action
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Todo $todo
     * @dontvalidate $todo
     * @return void
     */

    public function todoCreateAction(\T3developer\ProjectsAndTasks\Domain\Model\Todo $todo) {
        $userUid = $GLOBALS['TSFE']->fe_user->user['uid'];

        //   $todo->setTodoOwner($userUid);
        $this->todoRepository->add($todo);
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($todo);

        $this->redirect('todoNew', 'Todo', NULL, Array('list' => $todo->getTodolist()));
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
        
        if($todo['uid'] == ''){
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
        $startDate = mktime(0,0,0,$startMonth,$startDay,$startYear);
        
        $end = explode(".", $todo[todoEnd]);
        $endDay = $end[0];
        $endMonth = $end[1];
        $endYear = $end[2];
        $endDate = mktime(0,0,0,$endMonth,$endDay,$endYear);
        
        $toDoDB->setTodoList($todo['todoList']);
        $toDoDB->setTodoTyp($todo['todoTyp']);
        $todoAssigned = $this->userRepository->findByUid($todo['todoAssigned']);
        $toDoDB->setTodoAssigned($todoAssigned);
        $toDoDB->setTodoTitle($todo['todoTitle']);
        $toDoDB->setTodoDescription($todo['todoDescription']);
        $toDoDB->setTodoStatus($todo['todoStatus']);
        $toDoDB->setTodoDate($startDate);
        $toDoDB->setTodoEnd($endDate);
              
        if($action == 'new'){
            $this->todoRepository->add($toDoDB);
        }
        if($action == 'update'){
            $this->todoRepository->update($toDoDB);
        }
        $userUid = $GLOBALS['TSFE']->fe_user->user['uid'];

        //   $todo->setTodoOwner($userUid);
        //$this->todoRepository->add($todo);
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($todo);

        $this->redirect('todoNew', 'Todo', NULL, Array('list' => $toDoDB->getTodolist()));
    }
    /*
     * New Todo Action
     */

    public function todoEditAction() {
        $todoeditUid = $this->request->getArgument('todo');

        $todoEdit = $this->todoRepository->findByUid($todoeditUid);

        $todoList = $this->todolistRepository->findByUid($todoEdit->getTodoList());
        $todosAllFromList = $this->todoRepository->findByTodoList($todoEdit->getTodoList());
        $project = $this->projectRepository->findByUid($todoList->getTodolistProject());


        $this->view->assign('projectHeader', $this->project->findProjectHeader($project->getUid()));
        $this->view->assign('user', $this->userRepository->findAll());
        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('plantime', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableWorkTime());
        $this->view->assign('typ', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableTodoTyp());
        $this->view->assign('project', $project);
        $this->view->assign('todolist', $todoList);
        $this->view->assign('todosAllFromList', $todosAllFromList);
        $this->view->assign('todo', $todoEdit);
        $this->view->assign('menu', '4');
    }

    /*
     * Update Todolist Action
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Todo $todo
     * @dontvalidate $todo
     * @return void
     */

    public function todoUpdateAction(\T3developer\ProjectsAndTasks\Domain\Model\Todo $todo) {
        $userUid = $GLOBALS['TSFE']->fe_user->user['uid'];

        //   $todo->setTodoOwner($userUid);
        $this->todoRepository->update($todo);


        $this->redirect('todoNew', 'Todo', NULL, Array('list' => $todo->getTodolist()));
    }

        /*
     * Delete Todo Action
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Todo $todo
     * @dontvalidate $todo
     * @return void
     */

    public function todoDeleteAction(\T3developer\ProjectsAndTasks\Domain\Model\Todo $todo) {
        

        //   $todo->setTodoOwner($userUid);
        $this->todoRepository->remove($todo);


        $this->redirect('todoNew', 'Todo', NULL, Array('list' => $todo->getTodolist()));
    }
    
    
    /**
     * Find Todo by Ajax
     * 
     * @param: todoUid
     *  @param storagePid 
     */
    public function findTodoByAjaxAction(){
        if($this->request->hasArgument('uid')){
            $todoUid = $this->request->getArgument('uid');
        }
        if($this->request->hasArgument('storagePid')){
            $storagePid = $this->request->getArgument('storagePid');
        }
        $todo = $this->todoRepository->findTodoByUidAndPid($todoUid, $storagePid)->toArray();
        
        $start = date("d.m.Y",$todo[0]->getTodoDate()->getTimestamp() );
        if($todo[0]->getTodoEnd()){
        $end = date("d.m.Y",$todo[0]->getTodoEnd()->getTimestamp() );
        }
        $result['uid'] = $todo[0]->getUid();
        $result['todoTitel'] = $todo[0]->getTodoTitle();
        $result['todoTyp'] = $todo[0]->getTodoTyp();
        $result['todoAssigned'] = $todo[0]->getTodoAssigned()->getUid();
        $result['todoDescription'] = $todo[0]->getTodoDescription();
        $result['todoStatus'] = $todo[0]->getTodoStatus();
        $result['todoDate'] = $start;
        $result['todoEnd'] = $end;
        $result['todoPlantime'] = $todo[0]->getTodoPlantime();
        
        $arguments['storagePid'] = $storagePid;
        $arguments['todoUid'] = $todoUid;
        return json_encode($result);
    }

    /**
     * Show PDF Action
     *
     * 
     * @return void
     * 
     */
    public function showPdfAction() {
        $todoListUid = $this->request->getArgument('todolist');
        $todoList = $this->todolistRepository->findByUid($todoListUid);
        $todos = $this->todoRepository->findByTodoList($todoList->getUid());
        //  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($todoListUid);
        return $this->pdfUtility->createTodoPdf($todoList, $todos);
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