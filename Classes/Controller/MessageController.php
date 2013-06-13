<?php

namespace T3developer\Projectsandtasks\Controller;

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
class MessageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository   
     */
    protected $userRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\MessageRepository   
     */
    protected $messageRepository;

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
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\MessageRepository $messageRepository
     * @return void
     */
    public function injectMessageRepository(\T3developer\ProjectsAndTasks\Domain\Repository\MessageRepository $messageRepository) {
        $this->messageRepository = $messageRepository;
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
        if (isset($this->arguments['message'])) {
            $this->arguments['message']
                    ->getPropertyMappingConfiguration()
                    ->forProperty('messageDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
        }
    }

    /**
     * Shows the Message Page with a form to create Messages
     * 
     * @param int $project The projectUid of the actual project
     */
    public function messageNewAction() {
        $project = $this->request->getArgument('project');

        $newMessage = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Message');

        $newMessage->setMessageProject($project);


        $this->view->assign('projectHeader', $this->project->findProjectHeader($project));
        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('user', $this->userRepository->findAll());
        $this->view->assign('message', $newMessage);
        $this->view->assign('messageList', $this->messageRepository->findByMessageProject($project));
        $this->view->assign('menu', '3');
    }

    /**
     * Create a new Message from Form
     *
     *  @param \T3developer\ProjectsAndTasks\Domain\Model\Message $message
     * @dontvalidate $message
     * @return void
     */
    public function messageCreateAction(\T3developer\ProjectsAndTasks\Domain\Model\Message $message) {
        //  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($message);
        $this->messageRepository->add($message);

        $this->redirect('messageNew', 'Message', NULL, Array('project' => $message->getMessageProject()));
    }

    /**
     * Shows the Message Page with a form to edit Messages
     * 
     * @param int $messageUid The messageUid of the actual project
     */
    public function messageEditAction($messageUid) {

        $message = $this->messageRepository->findByUid($messageUid);
        $project = $this->projectRepository->findByUid($message->getMessageProject());

        $this->view->assign('projectHeader', $this->project->findProjectHeader($project));
        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('user', $this->userRepository->findAll());
        $this->view->assign('message', $message);
        $this->view->assign('menu', '3');
    }

    /**
     * Updates a new Message from Form
     *
     *  @param \T3developer\ProjectsAndTasks\Domain\Model\Message $message
     * @dontvalidate $message
     * @return void
     */
    public function messageUpdateAction(\T3developer\ProjectsAndTasks\Domain\Model\Message $message) {
        //  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($message);
        $this->messageRepository->update($message);

        $this->redirect('messageNew', 'Message', NULL, Array('project' => $message->getMessageProject()));
    }

}

?>