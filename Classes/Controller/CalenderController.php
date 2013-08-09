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
class CalenderController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\CalenderDaynotes  
     */
    protected $calenderDaynotesRepository;
    
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
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\CalenderDaynotesRepository $calenderDaynotesRepository
     * @return void
     */
    public function injectCalenderDaynotesRepository(\T3developer\ProjectsAndTasks\Domain\Repository\CalenderDaynotesRepository $calenderDaynotesRepository) {
        $this->calenderDaynotesRepository = $calenderDaynotesRepository;
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

    public function indexAction() {
        $this->checkLogIn();

        
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