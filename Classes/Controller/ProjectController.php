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
        
    public function indexAction() {
        $projects = $this->projectRepository->findAll();
        $this->view->assign('test', 'test');
    }

    /*
     * Show Project Action
     */

    public function projectShowAction(\t3developer\ProjectsAndTasks\Domain\Model\Project $project) {
        $this->checkLogIn();
        
        //load todo lists, todos and count itemss
        $todoLists = $this->todolistRepository->findByTodolistProject($project->getUid());
        if ($todoLists[0] != ''){
            foreach ($todoLists as $lists){
                $todos[$lists->getUid()]['lists'] = $lists;
                $todos[$lists->getUid()]['all'] = $this->todoRepository->countAllPerList($lists->getUid());
                $todos[$lists->getUid()]['open'] = $this->todoRepository->countOpenPerList($lists->getUid());
                $todos[$lists->getUid()]['todos'] = $this->todoRepository->findByListAndStatus($lists->getUid(), '6');
            }
        }
        
        $work = $this->workRepository->findByWorkProject($project->getUid());

        
        $this->view->assign('projectHeader', $this->findProjectHeader($project->getUid()));
        $this->view->assign('user', $this->user);
        $this->view->assign('project', $project);
        $this->view->assign('todos', $todos);
        $this->view->assign('works', $work);
        $this->view->assign('menu', '1');
    }

    /*
     * New Project Action
     */

    public function projectNewAction() {

        $newproject = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Project');


        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('project', $newproject);
    }

    /*
     * Edit Project Action
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Project $project
     */

    public function projectEditAction(\T3developer\ProjectsAndTasks\Domain\Model\Project $project) {


        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('project', $project);
    }

    /*
     * Update Project Action
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Project $project
     * @dontvalidate $project
     * @return void
     */

    public function projectUpdateAction(\T3developer\ProjectsAndTasks\Domain\Model\Project $project) {

        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($project);
        $this->projectRepository->update($project);

        $this->redirect('index', 'Inbox');
    }

    /*
     * New Project Action
     * 
     * @param \t3developer\ProjectsAndTasks\Domain\Model\Project $project
     * @dontvalidate $project
     * @return void
     */

    public function projectCreateAction(\T3developer\ProjectsAndTasks\Domain\Model\Project $project) {
        $userUid = $GLOBALS['TSFE']->fe_user->user['uid'];

        $project->setProjectOwner($userUid);
        $this->projectRepository->add($project);

        $this->redirect('index', 'Inbox');
    }
    
    /*
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
            $end   = $single->getWorkEnd();
            $time = $end - $start;
            $istTime = $istTime + $time;
        }
        $budgetTime = $project->getProjectBudgetTime();
        $budgetTime = intval($budgetTime);
        if($budgetTime != 0) {
           $workTemp['percent'] = $istTime * 100 / intval($budgetTime);
        }
        
        //get the notes
        $notes = 'xy';
        
        //get the todos
        $todoLists = $this->todolistRepository->findByTodolistProject($project->getUid());
        $todos['all'] = 0;
        $todos['open'] = 0;
        if ($todoLists[0] != ''){
            foreach ($todoLists as $lists){
                $all = $this->todoRepository->countAllPerList($lists->getUid());
                $open = $this->todoRepository->countOpenPerList($lists->getUid());
                $todos['all'] = $todos['all'] + $all;
                $todos['open']= $todos['open'] + $open;
                }
        }
        if($todoLists[1] != '') {
            $todos['list']='multi';
        }
        if(($todoLists[1] == '') && ($todoLists[0] != '')){
            $todos['listUid']=$todoLists[0]->getUid();
            $todos['list']='single';
        }
        if($todoLists[0] == ''){
            $todos['list']='new';
        }    
           
        //get the work
        $work = '';
        $work['all'] = count($work = $this->workRepository->findByWorkProject($projectUid));
        $work['percent']=$workTemp['percent'] ; 
        //get the documents
        $documents = "xy";
        
        //get the dates
        $dates = 'xy';
        
        $projectHeader['project']   = $project;
        $projectHeader['istTime']   = $istTime;
        $projectHeader['notes']     = $notes;
        $projectHeader['todos']     = $todos;
        $projectHeader['work']      = $work;
        $projectHeader['documents'] = $documents;
        $projectHeader['dates']     = $dates;
        
        return $projectHeader;
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