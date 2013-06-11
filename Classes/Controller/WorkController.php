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
class WorkController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
     * @param \t3developer\ProjectsAndTasks\Domain\Repository\WorkRepository $workRepository     
     */
    public function injectWorkRepository(\t3developer\ProjectsAndTasks\Domain\Repository\WorkRepository $workRepository) {
        $this->workRepository = $workRepository;
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
        if (isset($this->arguments['work'])) {
            $this->arguments['work']
                    ->getPropertyMappingConfiguration()
                    ->forProperty('workDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
        }
    }

    /*
     * New Work Action
     */

    public function workNewAction() {
        $project = $this->request->getArgument('project');

        $newWork = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Work');
        $newWork->setWorkProject($project);

        $workList = $this->workRepository->findByWorkProject($project);

        
        $this->view->assign('projectHeader', $this->project->findProjectHeader($project));
        $this->view->assign('workstatus', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableWorkStatus());
        $this->view->assign('time', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableTime());
        $this->view->assign('works', $workList);
        $this->view->assign('work', $newWork);
        $this->view->assign('menu', '5');
    }

    /*
     * Create work Action
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Work $work
     * @dontvalidate $work
     * @return void
     */

    public function workCreateAction(\T3developer\ProjectsAndTasks\Domain\Model\Work $work) {
        $userUid = $GLOBALS['TSFE']->fe_user->user['uid'];

        //   $todo->setTodoOwner($userUid);
        $this->workRepository->add($work);
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($todo);

        $this->redirect('workNew', 'Work', NULL, Array('project' => $work->getWorkProject()));
    }

    /*
     * New Todo Action
     */

    public function workEditAction() {
        $workeditUid = $this->request->getArgument('work');

        $workEdit = $this->workRepository->findByUid($workeditUid);

        $workList = $this->workRepository->findByWorkProject($workEdit->getWorkProject());
        
        $this->view->assign('workstatus', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableWorkStatus());
        $this->view->assign('time', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableTime());
        $this->view->assign('projectHeader', $this->project->findProjectHeader($workEdit->getWorkProject()));
        $this->view->assign('works', $workList);
        $this->view->assign('work', $workEdit);
    }

    /*
     * Update Todolist Action
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Work $work
     * @dontvalidate $work
     * @return void
     */

    public function workUpdateAction(\T3developer\ProjectsAndTasks\Domain\Model\Work $work) {
        $userUid = $GLOBALS['TSFE']->fe_user->user['uid'];

        //   $todo->setTodoOwner($userUid);
        $this->workRepository->update($work);


        $this->redirect('workNew', 'Work', NULL, Array('project' => $work->getWorkProject()));
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