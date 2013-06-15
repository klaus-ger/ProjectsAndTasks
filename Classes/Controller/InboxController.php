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
    
    /**
     * Index Action
     * 
     * Shows the index Page of this extension
     */

    public function indexAction() {
        $this->checkLogIn();

        $projects = $this->projectRepository->findByOwner($this->user->getUid());

        $this->view->assign('inboxHeader', $this->searchHeaderData());
        $this->view->assign('user', $this->user);
        $this->view->assign('projects', $projects);
        $this->view->assign('menu', '1');
    }

    /**
     * show Work / Leistungen
     * 
     * shows a overview of actual work per user
     */
    public function showWorkAction(){
        $this->checkLogIn();
        //timestamps for actual week
        $wochentag=date(w);
        $aktuell=date('d,m,Y');
        $aktuellArray = explode(',', $aktuell);
        $moWT = intval($aktuellArray[0])-intval($wochentag)+1;
        
        $mo = mktime(0,0,0,$aktuellArray[1],$moWT, $aktuellArray[2]);
        $di = mktime(0,0,0,$aktuellArray[1],$moWT +1 , $aktuellArray[2]);
        $mi = mktime(0,0,0,$aktuellArray[1],$moWT +2 , $aktuellArray[2]);
        $do = mktime(0,0,0,$aktuellArray[1],$moWT +3 , $aktuellArray[2]);
        $fr = mktime(0,0,0,$aktuellArray[1],$moWT +4 , $aktuellArray[2]);
        $sa = mktime(0,0,0,$aktuellArray[1],$moWT +5 , $aktuellArray[2]);
        $so = mktime(0,0,0,$aktuellArray[1],$moWT +6 , $aktuellArray[2]);
        $next = mktime(0,0,0,$aktuellArray[1],$moWT +7 , $aktuellArray[2]);
        
        $work['week']['mo']['date']= $mo;
        $work['week']['di']['date']= $di;
        $work['week']['mi']['date']= $mi;
        $work['week']['do']['date']= $do;
        $work['week']['fr']['date']= $fr;
        $work['week']['sa']['date']= $sa;
        $work['week']['so']['date']= $so;
        $work['week']['mo']['results']=$this->workRepository->findWorkByStartEndUser($mo, $di, $this->user->getUid());
        $work['week']['di']['results']=$this->workRepository->findWorkByStartEndUser($di, $mi, $this->user->getUid());
        $work['week']['mi']['results']=$this->workRepository->findWorkByStartEndUser($mi, $do, $this->user->getUid());
        $work['week']['do']['results']=$this->workRepository->findWorkByStartEndUser($do, $fr, $this->user->getUid());
        $work['week']['fr']['results']=$this->workRepository->findWorkByStartEndUser($fr, $sa, $this->user->getUid());
        $work['week']['sa']['results']=$this->workRepository->findWorkByStartEndUser($sa, $so, $this->user->getUid());
        $work['week']['so']['results']=$this->workRepository->findWorkByStartEndUser($so, $next, $this->user->getUid());
        
        $this->view->assign('work', $work);
        $this->view->assign('menu', '5');
      
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