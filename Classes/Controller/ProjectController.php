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
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {
        if (isset($this->arguments['project'])) {
        $commentConfiguration = $this->arguments['project']->getPropertyMappingConfiguration();
        $commentConfiguration->allowAllProperties();
        $commentConfiguration
                ->setTypeConverterOption(
                ' TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter',
                 \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED,
                TRUE
        );
        }
        if (isset($this->arguments['project'])) {
            $this->arguments['project']
                    ->getPropertyMappingConfiguration()
                    ->forProperty('projectRevisionDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
        }
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
        foreach($subProjects as $single){
            $single ->setProjectOpenTodos($this->countTodos($single->getUid()));
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
        $this->view->assign('projectuser', $this->projectrightsRepository->findByProjectrightsProject($project->getUid()) );
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
        $this->view->assign('projectuser', $this->projectrightsRepository->findByProjectrightsProject($project->getUid()) );
        
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
        if($this->request->hasArgument('userrights')){
            $userrights = $this->request->getArgument('userrights');
        }
  //     \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($userrights);
        if($userrights['uid'] == null) {
            $rights = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Projectrights');
            $action = 'new';
        }
        if($userrights['uid'] != null) {
            $rights = $this->projectrightsRepository->findByUid($projectright['uid']);
            $action = 'update';
        }
        
        $rights->setProjectrightsProject($userrights['projectrightsProject']);
        $rights->setProjectrightsUser($userrights['projectrightsUser']);
        $rights->setProjectrightsRights($userrights['projectrightsRights']);
        
        if($action == 'new'){
            $this->projectrightsRepository->add($rights);
        }
        if($action == 'update'){
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
              
        $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface')->persistAll();
        
        //create the userrights
        $rights = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Projectrights');
        $rights->setProjectrightsProject($project->getUid());
        $rights->setProjectrightsUser($userUid);
        $rights->setProjectrightsRights('1');
        $this->projectrightsRepository->add($rights);
        
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
        if ($todoLists[1] != '') {
            $todos['list'] = 'multi';
        }
        if (($todoLists[1] == '') && ($todoLists[0] != '')) {
            $todos['listUid'] = $todoLists[0]->getUid();
            $todos['list'] = 'single';
        }
        if ($todoLists[0] == '') {
            $todos['list'] = 'new';
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
    public function findProjectLevel($project){
        
        if($project->getProjectParent() == 0){
            $projectLevel = '1';
        }else {
            $parent = $this->projectRepository->findByUid($project->getProjectParent() );
            if($parent->getProjectParent == 0) {
                $projectLevel = '2';
            } else {
               $parent = $this->projectRepository->findByUid($parent->getProjectParent() );
               if($parent->getProjectParent == 0) {
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
    public function findProjectSelectArray(){
        
        $firstLevel = $this->projectRepository->findByProjectParent('0');
        foreach ($firstLevel as $first){
            $projectSelect[$first->getUid()]['node'] = $first;
            
            $secondLevel = $this->projectRepository->findByProjectParent($first->getUid());
            if($secondLevel[0] != ''){
            foreach ($secondLevel as $second){
                $projectSelect[$first->getUid()]['subnodes'][$second->getUid()]['node'] = $second;
                
                $thirdLevel = $this->projectRepository->findByProjectParent($second->getUid());
                if($thirdLevel != ''){
                foreach ($thirdLevel as $third){
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
    public function countTodos($projectUid){
        $count = 0;
        $todolists = $this->todolistRepository->findByTodolistProject($projectUid);
        if($todolists[0] != ''){
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