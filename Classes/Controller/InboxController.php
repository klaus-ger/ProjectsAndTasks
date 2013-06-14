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
class InboxController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository   
     */
    protected $userRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ProjectRepository   
     */
    protected $projectRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\WorkRepository   
     */
    protected $workRepository;
    
        /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\TodoRepository   
     */
    protected $todoRepository;

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository $userRepository
     * @return void
     */
    public function injectUserRepository(\T3developer\ProjectsAndTasks\Domain\Repository\UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\ProjectRepository $mathUtility
     * @return void
     */
    public function injectProjectRepository(\T3developer\ProjectsAndTasks\Domain\Repository\ProjectRepository $projectRepository) {
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
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\TodoRepository $todoRepository
     * @return void
     */
    public function injectTodoRepository(\T3developer\ProjectsAndTasks\Domain\Repository\TodoRepository $todoRepository) {
        $this->todoRepository = $todoRepository;
    }
    
    /*
     * 
     */

    public function indexAction() {
//$newproject = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Project');
        $this->checkLogIn();

        $projects = $this->projectRepository->findByOwner($this->user->getUid());


        $this->view->assign('inboxHeader', $this->searchHeaderData());
        $this->view->assign('user', $this->user);
        $this->view->assign('projects', $projects);
    }

    /**
     * Writes the Array for header Navigation
     */
    public function searchHeaderData() {

        //projects
        $projectsAll = count($projects = $this->projectRepository->findByOwner($this->user->getUid()));


        //work
        $workAll = $this->workRepository->findByWorkStatus('5');
        $worktime = 0;
        foreach ($workAll as $work) {
            $start = $work->getWorkStart();
            $end   = $work->getWorkEnd();
            $time = $end - $start;
            $worktime = $worktime + $time;
        }
        
        //todo
        
       // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($open);
        $todosOpen = count($this->todoRepository->findByUserAndStatus($this->user->getUid(), '1'));
        $todosCheck = count($this->todoRepository->findByUserAndStatus($this->user->getUid(), '3'));
        $todosReady = count($this->todoRepository->findByUserAndStatus($this->user->getUid(), '6'));
        
        $todo['all'] = $todosOpen + $todosCheck + $todosReady;
        $todo['open']= $todosOpen;
        
        
        
        $inboxHeader['projects']['all'] = $projectsAll;
        $inboxHeader['work']['all'] = $worktime;
        $inboxHeader['todo']['all'] = $todo['all'];
        $inboxHeader['todo']['open'] = $todo['open'];

        return $inboxHeader;
    }

    /*
     * Shows the log-in Form
     */

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