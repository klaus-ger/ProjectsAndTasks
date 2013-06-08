<?php

namespace T3developer\Projectsandtasks\Controller;

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
 * @package commentreply
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
    public function injectPdf(\T3developer\ProjectsAndTasks\Utility\Pdf $pdfUtility ) {
        $this->pdfUtility  = $pdfUtility ;
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
     * New TodoList Action
     */

    public function todoListNewAction() {
        $project = $this->request->getArgument('project');
        //  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($project);

        $newtodolist = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Todolist');

        $newtodolist->setTodolistProject($project);

        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('todolist', $newtodolist);
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

        $newtodo = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Todo');
        $newtodo->setTodolist($list);
        $newtodo->setTodoNr($this->todoRepository->getNextNumber($list));

        $todoList = $this->todolistRepository->findByUid($list);
        $todosAllFromList = $this->todoRepository->findByTodoList($list);
        $project = $this->projectRepository->findByUid($todoList->getTodolistProject());

        $this->view->assign('user', $this->userRepository->findAll());
        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('plantime', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableWorkTime());
        $this->view->assign('typ', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableTodoTyp());
        $this->view->assign('project', $project);
        $this->view->assign('todolist', $todoList);
        $this->view->assign('todosAllFromList', $todosAllFromList);
        $this->view->assign('todo', $newtodo);
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
     * New Todo Action
     */

    public function todoEditAction() {
        $todoeditUid = $this->request->getArgument('todo');

        $todoEdit = $this->todoRepository->findByUid($todoeditUid);

        $todoList = $this->todolistRepository->findByUid($todoEdit->getTodoList());
        $todosAllFromList = $this->todoRepository->findByTodoList($todoEdit->getTodoList());
        $project = $this->projectRepository->findByUid($todoList->getTodolistProject());

        $this->view->assign('user', $this->userRepository->findAll());
        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('plantime', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableWorkTime());
        $this->view->assign('typ', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableTodoTyp());
        $this->view->assign('project', $project);
        $this->view->assign('todolist', $todoList);
        $this->view->assign('todosAllFromList', $todosAllFromList);
        $this->view->assign('todo', $todoEdit);
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
    
    /**
     * Show PDF Action
     *
     * 
     * @return void
     * 
     */
    public function showPdfAction() {
        $todoListUid = $this->request->getArgument('todolist');
        $todoList = $this->todolistRepository->findByUid($todoListUid );
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