<?php
namespace T3developer\ProjectsAndTasks\Domain\Model;

/***************************************************************
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
 ***************************************************************/

/**
 *
 *
 * @package projects_and_tasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Message extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {


    
    
    /**
     * The ProjectTitle
     * @var \string
     * 
     */
    protected $message_title;

    /**
     * The ProjectShort
     * @var \string
     * 
     */
    protected $messageText;

    /**
     * The ProjectText
     * @var \DateTime
     * 
     */
    protected $messageDate ;

    /**
     * The Task ProjectSort
     * @var \int
     * 
     */
    protected $messageProject;

    /**
     * The Task ProjectStatus
     * @var \int
     * 
     */
    protected $messageStatus;

    /**
     * The Task ProjectStatus
     * @var \int
     * 
     */
    protected $messageSender;
    
    public function getMessage_title() {
        return $this->message_title;
    }

    public function setMessage_title($message_title) {
        $this->message_title = $message_title;
    }

    public function getMessageText() {
        return $this->messageText;
    }

    public function setMessageText($messageText) {
        $this->messageText = $messageText;
    }

    public function getMessageDate() {
        return $this->messageDate;
    }

    public function setMessageDate($messageDate) {
        $this->messageDate = $messageDate;
    }

    public function getMessageProject() {
        return $this->messageProject;
    }

    public function setMessageProject($messageProject) {
        $this->messageProject = $messageProject;
    }

    public function getMessageStatus() {
        return $this->messageStatus;
    }

    public function setMessageStatus($messageStatus) {
        $this->messageStatus = $messageStatus;
    }

    public function getMessageSender() {
        return $this->messageSender;
    }

    public function setMessageSender($messageSender) {
        $this->messageSender = $messageSender;
    }





}

?>