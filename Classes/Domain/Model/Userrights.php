<?php

namespace T3developer\ProjectsAndTasks\Domain\Model;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Klaus Heuer <klaus.heuer@t3-developer.com>
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
class Userrights extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * Right group Titel
     * @var \string
     * 
     */
    protected $rightName;

    /**
     * Project Menu
     * @var \int
     * 
     */
    protected $showProjectMenu;

    /**
     * Ticket Menu
     * @var \int
     * 
     */
    protected $showTicketMenu;

    /**
     * Times Menu
     * @var \int
     * 
     */
    protected $showTimeMenu;

    /**
     * Adress Menu
     * @var \int
     * 
     */
    protected $showAddressMenu;

    /**
     * Whiteboard Menu
     * @var \int
     * 
     */
    protected $showWhiteboardMenu;
    
       /**
     * Whiteboard Menu
     * @var \int
     * 
     */
    protected $showSettingMenu;

    /**
     * Construct
     */
    public function __construct() {
        $this->initStorageObjects();
    }

    /**
     * Initializes properties.
     *
     * @return void
     */
    protected function initStorageObjects() {
        $this->showProjectMenu = TRUE;
        $this->showTicketMenu = TRUE;
        $this->showTimeMenu = TRUE;
        $this->showAddressMenu = TRUE;
        $this->showWhiteboardMenu = TRUE;
        $this->showSettingMenu = TRUE;
    }

    public function getRightName() {
        return $this->rightName;
    }

    public function setRightName($rightName) {
        $this->rightName = $rightName;
    }

    public function getShowProjectMenu() {
        return $this->showProjectMenu;
    }

    public function setShowProjectMenu($showProjectMenu) {
        $this->showProjectMenu = $showProjectMenu;
    }

    public function getShowTicketMenu() {
        return $this->showTicketMenu;
    }

    public function setShowTicketMenu($showTicketMenu) {
        $this->showTicketMenu = $showTicketMenu;
    }

    public function getShowTimeMenu() {
        return $this->showTimeMenu;
    }

    public function setShowTimeMenu($showTimeMenu) {
        $this->showTimeMenu = $showTimeMenu;
    }

    public function getShowAddressMenu() {
        return $this->showAddressMenu;
    }

    public function setShowAddressMenu($showAddressMenu) {
        $this->showAddressMenu = $showAddressMenu;
    }

    public function getShowWhiteboardMenu() {
        return $this->showWhiteboardMenu;
    }

    public function setShowWhiteboardMenu($showWhiteboardMenu) {
        $this->showWhiteboardMenu = $showWhiteboardMenu;
    }

    public function getShowSettingMenu() {
        return $this->showSettingMenu;
    }

    public function setShowSettingMenu($showSettingMenu) {
        $this->showSettingMenu = $showSettingMenu;
    }

}

?>