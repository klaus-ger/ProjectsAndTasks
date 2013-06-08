<?php

namespace T3developer\ProjectsAndTasks\Domain\Model;

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

class User extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * The User uid
     * @var \int
     * 
     */
    
    protected $uid;
        /**
     * The User pid
     * @var \int
     * 
     */
    
    protected $pid;
    
       /**
     * The User uid
     * @var \int
     * 
     */
    
    protected $projectsAndTasksUser;
      /**
     * The User Firstname
     * @var \string
     * 
     */
    protected $username;
    
    /**
     * The User Firstname
     * @var \string
     * 
     */
    protected $firstName;

    /**
     * The User Lastname
     * @var \string
     * 
     */
    protected $userLastName;

    /**
     * The USer email
     * @var \string
     * 
     */
    protected $userEmail;

    /**
     * The User Telefon
     * @var \string
     * 
     */
    protected $userTel;

    /**
     * The User mobil
     * @var \string
     * 
     */
    protected $userMobil;

    /**
     * The User Icon
     * @var \string
     * 
     */
    protected $userIcon;

    /**
     * The User Pass
     * @var \string
     * 
     */
    protected $userPass;
    
             public function getUid() {
        return $this->uid;
    }  
                 public function getPid() {
        return $this->pid;
    }
    
           public function getProjectsAndTasksUser() {
        return $this->projectsAndTasksUser;
    }
    
    
       public function getUsername() {
        return $this->username;
    }

    /**
     *
     * @param \string $username
     * @return void
     *
     */
    public function setUsername($username) {
        $this->username = $username;
    } 

    
    
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     *
     * @param \string $firstname
     * @return void
     *
     */
    public function setfirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getUserLastName() {
        return $this->userLastName;
    }

    /**
     *
     * @param \string $userLastName
     * @return void
     *
     */
    public function setUserLastName($userLastName) {
        $this->userLastName = $userLastName;
    }

    public function getUserEmail() {
        return $this->userEmail;
    }

    /**
     *
     * @param \string $userEmail
     * @return void
     *
     */
    public function setUserEmail($userEmail) {
        $this->userEmail = $userEmail;
    }

    public function getUserTel() {
        return $this->userTel;
    }

    /**
     *
     * @param \string $userTel
     * @return void
     *
     */
    public function setUserTel($userTel) {
        $this->userTel = $userTel;
    }

    public function getUserMobil() {
        return $this->userMobil;
    }

    /**
     *
     * @param \string $userMobil
     * @return void
     *
     */
    public function setUserMobil($userMobil) {
        $this->userMobil = $userMobil;
    }

    public function getUserIcon() {
        return $this->userIcon;
    }

    /**
     *
     * @param \string $userIcon
     * @return void
     *
     */
    public function setUserIcon($userIcon) {
        $this->userIcon = $userIcon;
    }

    public function getUserPass() {
        return $this->userPass;
    }

    /**
     *
     * @param \string $userPass
     * @return void
     *
     */
    public function setUserPass($userPass) {
        $this->userPass = $userPass;
    }

}

?>