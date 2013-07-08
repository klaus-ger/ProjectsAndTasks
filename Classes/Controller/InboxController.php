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
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\TodolistRepository    
     */
    protected $todolistRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\TodoRepository   
     */
    protected $todoRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\Projectrights  
     */
    protected $projectrightsRepository;

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
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\ProjectrightsRepository $projectrightsRepository
     * @return void
     */
    public function injectProjectrightsRepository(\T3developer\ProjectsAndTasks\Domain\Repository\ProjectrightsRepository $projectrightsRepository) {
        $this->projectrightsRepository = $projectrightsRepository;
    }

    /**
     * Index Action
     * 
     * Shows the index Page of this extension
     */
    public function indexAction() {
        $this->checkLogIn();

        //Widget Sticky Projects
        $projects = $this->projectrightsRepository->findByUserAndSticky($this->user->getUid());
        foreach ($projects as $single) {
            $countTodos = $this->countTodos($single->getProjectrightsProject()->getUid());
            $single ->getProjectrightsProject()->setProjectOpenTodos($countTodos);
            $widgetProjects[] = $single;
        }
        //   \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($widget);

        $this->view->assign('inboxHeader', $this->searchHeaderData());
        $this->view->assign('user', $this->user);
        $this->view->assign('widgetProjects', $widgetProjects);
        $this->view->assign('menu', '1');
    }

    /**
     * Project View
     * 
     * Shows all Projects for the user 
     */
    public function projectsShowAction() {
        $this->checkLogIn();
        
        $projects = $this->findProjectTree();

        $this->view->assign('inboxHeader', $this->searchHeaderData());
        $this->view->assign('user', $this->user);
        $this->view->assign('projects', $projects);
        $this->view->assign('menu', '2');
    }

    /**
     * show Work / Leistungen
     * 
     * shows a overview of actual work per user
     */
    public function showWorkAction() {
        $this->checkLogIn();

        //calculationg the actual week
        $wochentag = date(w);
        if ($wochentag == 0)
            $wochentag = 7;
        $aktuell = date('d,m,Y');
        $aktuellArray = explode(',', $aktuell);
        $moWT = intval($aktuellArray[0]) - intval($wochentag) + 1;

        $mo = mktime(0, 0, 0, $aktuellArray[1], $moWT, $aktuellArray[2]);
        $di = mktime(0, 0, 0, $aktuellArray[1], $moWT + 1, $aktuellArray[2]);
        $mi = mktime(0, 0, 0, $aktuellArray[1], $moWT + 2, $aktuellArray[2]);
        $do = mktime(0, 0, 0, $aktuellArray[1], $moWT + 3, $aktuellArray[2]);
        $fr = mktime(0, 0, 0, $aktuellArray[1], $moWT + 4, $aktuellArray[2]);
        $sa = mktime(0, 0, 0, $aktuellArray[1], $moWT + 5, $aktuellArray[2]);
        $so = mktime(0, 0, 0, $aktuellArray[1], $moWT + 6, $aktuellArray[2]);
        $next = mktime(0, 0, 0, $aktuellArray[1], $moWT + 7, $aktuellArray[2]);

        $work['week']['mo']['date'] = $mo;
        $work['week']['di']['date'] = $di;
        $work['week']['mi']['date'] = $mi;
        $work['week']['do']['date'] = $do;
        $work['week']['fr']['date'] = $fr;
        $work['week']['sa']['date'] = $sa;
        $work['week']['so']['date'] = $so;
        $work['week']['mo']['results'] = $this->workRepository->findWorkByStartEndUser($mo, $di, $this->user->getUid());
        $work['week']['di']['results'] = $this->workRepository->findWorkByStartEndUser($di, $mi, $this->user->getUid());
        $work['week']['mi']['results'] = $this->workRepository->findWorkByStartEndUser($mi, $do, $this->user->getUid());
        $work['week']['do']['results'] = $this->workRepository->findWorkByStartEndUser($do, $fr, $this->user->getUid());
        $work['week']['fr']['results'] = $this->workRepository->findWorkByStartEndUser($fr, $sa, $this->user->getUid());
        $work['week']['sa']['results'] = $this->workRepository->findWorkByStartEndUser($sa, $so, $this->user->getUid());
        $work['week']['so']['results'] = $this->workRepository->findWorkByStartEndUser($so, $next, $this->user->getUid());

        //calculationg the actual month
        $aktuell = date('d,m,Y');
        $aktuellArray = explode(',', $aktuell);
        $monthStart = mktime(0, 0, 0, $aktuellArray[1], 0, $aktuellArray[2]);
        $monthEnd = mktime(0, 0, 0, $aktuellArray[1] + 1, 0, $aktuellArray[2]);

        $internalWork = $this->workRepository->findWorkByStartEndUserStatus($monthStart, $monthEnd, $this->user->getUid(), '1');
        $customWork = $this->workRepository->findWorkByStartEndUserStatus($monthStart, $monthEnd, $this->user->getUid(), '5');
        $invoiceWork = $this->workRepository->findWorkByStartEndUserStatus($monthStart, $monthEnd, $this->user->getUid(), '6');

        $internalTime = 0;
        $customTime = 0;
        $invoiceTime = 0;


        if ($internalWork[0] != '') {
            foreach ($internalWork as $monthwork) {
                $start = $monthwork->getWorkStart();
                $end = $monthwork->getWorkEnd();
                $period = $end - $start;
                $internalTime = $internalTime + $period;
            }
        }
        if ($customWork[0] != '') {
            foreach ($customWork as $monthwork) {
                $start = $monthwork->getWorkStart();
                $end = $monthwork->getWorkEnd();
                $period = $end - $start;
                $customTime = $customTime + $period;
            }
        }
        if ($invoiceWork[0] != '') {
            foreach ($invoiceWork as $monthwork) {
                $start = $monthwork->getWorkStart();
                $end = $monthwork->getWorkEnd();
                $period = $end - $start;
                $invoiceTime = $invoiceTime + $period;
            }
        }
        //calculating percent wortime per month= 20 day a 10 h
        $monthsecond = 30 * 10 * 60 * 60;

        $work['actualMonth']['internal'] = $internalTime;
        $work['actualMonth']['custom'] = $customTime + $invoiceTime;
        $work['actualMonth']['total'] = $internalTime + $customTime + $invoiceTime;
        $work['actualMonth']['percent'] = intval($work['actualMonth']['total'] * 100 / $monthsecond);

        $this->view->assign('work', $work);
        $this->view->assign('menu', '5');
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($wochentag);
    }

    /**
     * show Todo Action
     * 
     * shows the page with all todos for the user
     */
    public function showTodoAction() {
       // $userUid = $GLOBALS['TSFE']->fe_user->user['uid'];
        $this->checkLogIn();
        $todos = $this->todoRepository->findByUserAndStatus($this->user->getUid(), '1');
        foreach ($todos as $todo) {
            $listUid = $todo->getTodoList();
            $list = $this->todolistRepository->findByUid($listUid);
            $projectUid = $list->getTodolistProject();
            $project = $this->projectRepository->findByUid($projectUid);
            $projectTitel = $project->getProjectTitle();
            
            $listi[$projectUid]['titel'] = $projectTitel;
            $listi[$projectUid]['todos'][$todo->getUid()]=$todo;
           // $listi[$projectUid] = $projectUid;
            
        }
       // $todos = $projects;

        $this->view->assign('inboxHeader', $this->searchHeaderData());
        $this->view->assign('todos', $listi);
        $this->view->assign('user', $this->user);
        $this->view->assign('menu', '4');
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
            $end = $work->getWorkEnd();
            $time = $end - $start;
            $worktime = $worktime + $time;
        }

        //todo
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($open);
        $todosOpen = count($this->todoRepository->findByUserAndStatus($this->user->getUid(), '1'));
        $todosCheck = count($this->todoRepository->findByUserAndStatus($this->user->getUid(), '3'));
        $todosReady = count($this->todoRepository->findByUserAndStatus($this->user->getUid(), '6'));

        $todo['all'] = $todosOpen + $todosCheck + $todosReady;
        $todo['open'] = $todosOpen;



        $inboxHeader['projects']['all'] = $projectsAll;
        $inboxHeader['work']['all'] = $worktime;
        $inboxHeader['todo']['all'] = $todo['all'];
        $inboxHeader['todo']['open'] = $todo['open'];

        return $inboxHeader;
    }

    /**
     * Project Tree
     * 
     * Shows the user projects as tree
     */
    public function findProjectTree() {
        $userUid = $GLOBALS['TSFE']->fe_user->user['uid'];

        $projects = $this->projectrightsRepository->findByProjectrightsUser($userUid);

        //write Array of all Porjects with user access
        foreach ($projects as $project) {
            $pro = $project->getProjectrightsProject();
            $proArr[] = $pro;
        }
        
        //adds the open Todos to each project
        foreach($proArr as $project){
            $countTodos = $this->countTodos($project->getUid());
            $project->setProjectOpenTodos($countTodos);
            $proArrAdded[] = $project;
        }
      //  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($proArrAdded, 'proArr');
        //the Array:
        //$returnedArray[0]['node']="Auto"
        //$returnedArray[0]['subnodes'][0]['node']="Opel"
        //$returnedArray[0]['subnodes'][1]['node']="Audi"
        //$returnedArray[1]['node']="Motorrad"
        //$returnedArray[1]['subnodes'][0]['node']="Yamaha"
        //$returnedArray[1]['subnodes'][0]['subnodes'][0]['node']="YZF R1"
        //$returnedArray[1]['subnodes'][0]['subnodes'][1]['node']="Tomcat"
        foreach ($proArrAdded as $single) {

            //Level 1 Project
            if ($single->getProjectParent() == 0) {
                $proSort[$single->getUid()]['node'] = $single;
            } else {
                $parent = $this->projectRepository->findByUid($single->getProjectParent());
                if ($parent->getProjectParent() == 0) {
                    //Level2 Cat
                    $proSort[$parent->getUid()]['subnodes'][$single->getUid()]['node'] = $single;
                } else {
                    $parent = $this->projectRepository->findByUid($parent->getProjectParent());
                    if ($parent->getProjectParent() == 0) {
                        $level2 = $single->getProjectParent();
                        $level1 = $this->projectRepository->findByUid($level2);
                        $level1 = $level1->getProjectParent();
                        $proSort[$level1]['subnodes'][$level2]['subnodes'][$single->getUid()]['node'] = $single;
                    } else {
                        //Level 4 Cat
                        $level3 = $single->getProjectParent();
                        $level2 = $this->projectRepository->findByUid($level3);
                        $level2 = $level2->getProjectParent();
                        $level1 = $this->projectRepository->findByUid($level2);
                        $level1 = $level1->getProjectParent();
                        $proSort[$level1]['subnodes'][$level2]['subnodes'][$level3]['subnodes'][$single->getUid()] = $single;
                        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($single, 'single');
                    }
                }
            }
        }


        //   
        return $proSort;
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

    /**
     * Sticks or unsticks a project in project widget for the User
     */
    public function makeProjectStickyAction() {
        $this->checkLogIn();

        if ($this->request->hasArgument('projectUid')) {
            $projectUid = $this->request->getArgument('projectUid');
        }

        $projectRights = $this->projectrightsRepository->findByProjectAndUser($projectUid, $this->user->getUid());
        $projectRights = $projectRights[0];
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($projectRights);
        $sticky = $projectRights->getProjectrightsSticky();
        if ($sticky == 0) {
            $projectRights->setProjectrightsSticky('1');
        } else {
            $projectRights->setProjectrightsSticky('0');
        }

        $this->projectrightsRepository->update($projectRights);

        $this->redirect('index', 'Inbox');
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($projectRights, 'project');
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