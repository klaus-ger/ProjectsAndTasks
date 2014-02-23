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
 * @package t3gists
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Company extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * Company
     * @var \string
     * 
     */
    protected $cyName;

    /**
     * Company Short
     * @var \string
     * 
     */
    protected $cyShort;

    /**
     * Project Status
     * @var \string
     * 
     */
    protected $cyStreet;

    /**
     * Contract Status
     * @var \string
     * 
     */
    protected $cyPlz;

    /**
     * City
     * @var \string
     * 
     */
    protected $cyCity;

    /**
     * Contract Description
     * @var \string
     * 
     */
    protected $cyWeb;

    /**
     * Contract Description
     * @var \string
     * 
     */
    protected $cyMail;

    /**
     * cy_telephone
     * @var \string
     * 
     */
    protected $cyTelephone;

    /**
     * cy_customer
     * @var \string
     * 
     */
    protected $cyCustomer;

    /**
     * cy_comment
     * @var \string
     * 
     */
    protected $cyComment;

    public function getCyName() {
        return $this->cyName;
    }

    public function setCyName($cyName) {
        $this->cyName = $cyName;
    }

    public function getCyShort() {
        return $this->cyShort;
    }

    public function setCyShort($cyShort) {
        $this->cyShort = $cyShort;
    }

    public function getCyStreet() {
        return $this->cyStreet;
    }

    public function setCyStreet($cyStreet) {
        $this->cyStreet = $cyStreet;
    }

    public function getCyPlz() {
        return $this->cyPlz;
    }

    public function setCyPlz($cyPlz) {
        $this->cyPlz = $cyPlz;
    }

    public function getCyCity() {
        return $this->cyCity;
    }

    public function setCyCity($cyCity) {
        $this->cyCity = $cyCity;
    }

    public function getCyWeb() {
        return $this->cyWeb;
    }

    public function setCyWeb($cyWeb) {
        $this->cyWeb = $cyWeb;
    }

    public function getCyMail() {
        return $this->cyMail;
    }

    public function setCyMail($cyMail) {
        $this->cyMail = $cyMail;
    }

    public function getCyTelephone() {
        return $this->cyTelephone;
    }

    public function setCyTelephone($cyTelephone) {
        $this->cyTelephone = $cyTelephone;
    }

    public function getCyCustomer() {
        return $this->cyCustomer;
    }

    public function setCyCustomer($cyCustomer) {
        $this->cyCustomer = $cyCustomer;
    }

    public function getCyComment() {
        return $this->cyComment;
    }

    public function setCyComment($cyComment) {
        $this->cyComment = $cyComment;
    }

}

?>