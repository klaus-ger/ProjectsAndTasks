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
class UserController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ProjectRepository   
     */
    protected $projectRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository   
     */
    protected $userRepository;

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\ProjectRepository $projectRepository
     * @return void
     */
    public function injectProjectRepository(\T3developer\ProjectsAndTasks\Domain\Repository\ProjectRepository $projectRepository) {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository $userRepository
     * @return void
     */
    public function injectUserRepository(\T3developer\ProjectsAndTasks\Domain\Repository\UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    
    public function indexAction() {
        
         $user = $GLOBALS['TSFE']->fe_user->user;
 
        if ($user == FALSE) {
          
            $this->redirect('logIn');
        } else {
           
            $this->redirect('index', 'Inbox');
        }
    }
    /*
     * Shows the log-in Form
     */

    public function checkLogIn() {

         $user = $GLOBALS['TSFE']->fe_user->user;

        if ($user == null) {
            $this->redirect('logIn');
        }
//        //check if user is admin
//        $usergroup = explode(',', $GLOBALS['TSFE']->fe_user->user['usergroup']);
//        if (!in_array($this->settings['usergroupAdmin'], $usergroup)) {
//            $user = 'admin';
//        } else {
//            $user = 'redakteur';
//        }
        return $user;
    }

    /*
     * Show the login Form
     * 
     * @param \t3developer\ProjectsAndTasks\Domain\Model\User $user
     * @dontvalidate $user
     */

    public function logInAction() {

            
            
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['loginFormOnSubmitFuncs'])) {
            $_params = array();
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['loginFormOnSubmitFuncs'] as $funcRef) {
                //list($onSub, $hid) = t3lib_div::callUserFunction($funcRef, $_params, $this);
             //   TYPO3\CMS\CoreUtility\GeneralUtility::callUserFunction
             list($onSub, $hid) = \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($funcRef, $_params, $this);         
                $onSubmitAr[] = $onSub;
                $extraHiddenAr[] = $hid;
            }
        }

        if (count($onSubmitAr)) {
            $onSubmit = implode('; ', $onSubmitAr) . '; return true;';
        }

        if (count($extraHiddenAr)) {
            $extraHidden = implode(LF, $extraHiddenAr);
        }
        $this->view->assign('storagePid', $this->settings['storagePid']);
        $this->view->assign('onSubmit', $onSubmit);
        $this->view->assign('extraHidden', $extraHidden);
        $this->view->assign('currentPid', \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('id'));
    }

    /*
     * Shows all User
     */

    public function showAllUsersAction() {
        $user = $this->objectManager->create('T3developer\ProjectsAndTasks\Domain\Model\User');
        //$users = $this->userRepository->findByUid('4');
        $users = $this->userRepository->findUsers();
        $this->view->assign('user', $user);
        $this->view->assign('users', $users);
    }

    /*
     * Shows a Form to create a new User
     */

    public function userNewAction() {

        $user = $this->objectManager->create('T3developer\ProjectsAndTasks\Domain\Model\User');

        $this->view->assign('user', $user);
    }

    /*
     * Shows a Form to create a new User
     * 
     * @param T3developer\ProjectsAndTasks\Domain\Model\User $user
     * @dontvalidate $user
     * @return void
     */

    public function userCreateAction(\T3developer\ProjectsAndTasks\Domain\Model\User $user) {

        $this->userRepository->add($user);

        $this->redirect('showAllUsers');
    }
    
    

}

?>