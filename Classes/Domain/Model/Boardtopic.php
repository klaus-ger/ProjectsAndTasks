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
 * @package projects and tasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Boardtopic extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * Title
     * @var \string
     * 
     */
    protected $btTitle;

    /**
     * Text
     * @var \string
     * 
     */
    protected $btText;

    /**
     * Image
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3developer\ProjectsAndTasks\Domain\Model\FileReference>
     * 
     */
    protected $btImage;

    /**
     * Date
     * @var \DateTime
     * 
     */
    protected $btDate;

    /**
     * User
     * @var \int
     * 
     */
    protected $btUser;

    /**
     * User
     * @var \int
     * 
     */
    protected $btCat;

    /**
     * Count Messages - not stored in DB!
     * @var \int
     */
    protected $btMessages;

    /**
     * Count Messages - not stored in DB!
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Boardmessage
     */
    protected $btLastMessage;

    public function getBtTitle() {
        return $this->btTitle;
    }

    public function setBtTitle($btTitle) {
        $this->btTitle = $btTitle;
    }

    public function getBtText() {
        return $this->btText;
    }

    public function setBtText($btText) {
        $this->btText = $btText;
    }

    public function getBtDate() {
        return $this->btDate;
    }

    public function setBtDate($btDate) {
        $this->btDate = $btDate;
    }

    public function getBtUser() {
        return $this->btUser;
    }

    public function setBtUser($btUser) {
        $this->btUser = $btUser;
    }

    public function getBtCat() {
        return $this->btCat;
    }

    public function setBtCat($btCat) {
        $this->btCat = $btCat;
    }

    public function getBtMessages() {
        return $this->btMessages;
    }

    public function setBtMessages($btMessages) {
        $this->btMessages = $btMessages;
    }

    public function getBtLastMessage() {
        return $this->btLastMessage;
    }

    public function setBtLastMessage($btLastMessage) {
        $this->btLastMessage = $btLastMessage;
    }

    /**
     * Returns the files
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getBtImage() {
        return $this->$btImage;
    }

    /**
     * Sets the files
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $btImage
     * @return void
     */
    public function setBtImage($btImage) {
        $this->btImage = $btImage;
    }

    /**
     * Adds a file
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $btImage
     *
     * @return void
     */
    public function addBtImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $btImage) {
        $this->btImage->attach($btImage);
    }

}

?>