<?php

namespace T3developer\ProjectsAndTasks\Domain\Model;

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
class User extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * Username
     * @var \string
     */
    protected $username;

    /**
     * Usergroup
     * @var \string
     */
    protected $usergroup;

    /**
     * First Name
     * @var \string 
     */
    protected $firstName;

    /**
     * Last Name
     * @var \string 
     */
    protected $lastName;

    /**
     * Adress
     * @var \string 
     */
    protected $address;

    /**
     * City
     * @var \string 
     */
    protected $city;

    /**
     * Zip
     * @var \string 
     */
    protected $zip;

    /**
     * Telephone
     * @var \string 
     */
    protected $telephone;

    /**
     * web
     * @var \string 
     */
    protected $web;

    /**
     * eail
     * @var \string 
     */
    protected $email;

    /**
     * Company
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Company
     */
    protected $company;

    /**
     * Passwod
     * @var \string
     */
    protected $password;

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getZip() {
        return $this->zip;
    }

    public function setZip($zip) {
        $this->zip = $zip;
    }

    public function getWeb() {
        return $this->web;
    }

    public function setWeb($web) {
        $this->web = $web;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getUsergroup() {
        return $this->usergroup;
    }

    public function setUsergroup($usergroup) {
        $this->usergroup = $usergroup;
    }

}

?>