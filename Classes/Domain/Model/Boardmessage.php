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
class Boardmessage extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * Title
     * @var \string
     * 
     */
    protected $bmTitle;

    /**
     * text
     * @var \string
     * 
     */
    protected $bmText;

    /**
     * Image
     * @var \string
     * 
     */
    protected $bmImage;

    /**
     * Date
     * @var \DateTime
     * 
     */
    protected $bmDate;

    /**
     * user
     * @var \T3developer\ProjectsAndTasks\Domain\Model\User
     * 
     */
    protected $bmUser;
    
    /**
     * Topic
     * @var \int
     * 
     */
    protected $bmTopic;

    public function getBmTitle() {
        return $this->bmTitle;
    }

    public function setBmTitle($bmTitle) {
        $this->bmTitle = $bmTitle;
    }

    public function getBmText() {
        return $this->bmText;
    }

    public function setBmText($bmText) {
        $this->bmText = $bmText;
    }

    public function getBmImage() {
        return $this->bmImage;
    }

    public function setBmImage($bmImage) {
        $this->bmImage = $bmImage;
    }

    public function getBmDate() {
        return $this->bmDate;
    }

    public function setBmDate($bmDate) {
        $this->bmDate = $bmDate;
    }

    public function getBmUser() {
        return $this->bmUser;
    }

    public function setBmUser($bmUser) {
        $this->bmUser = $bmUser;
    }
    public function getBmTopic() {
        return $this->bmTopic;
    }

    public function setBmTopic($bmTopic) {
        $this->bmTopic = $bmTopic;
    }



}

?>