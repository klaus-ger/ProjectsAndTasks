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
     * In Box Menu
     * @var \int
     * 
     */
    protected $hideInboxMenu;

    /**
     * Project Menu
     * @var \int
     * 
     */
    protected $hideProjectMenu;

    /**
     * Ticket Menu
     * @var \int
     * 
     */
    protected $hideTicketMenu;

    /**
     * Times Menu
     * @var \int
     * 
     */
    protected $hideTimeMenu;

    /**
     * Adress Menu
     * @var \int
     * 
     */
    protected $hideAddressMenu;

    /**
     * Whiteboard Menu
     * @var \int
     * 
     */
    protected $hideWhiteboardMenu;

    /**
     * Settings Menu
     * @var \int
     * 
     */
    protected $hideSettingMenu;

    public function getRightName() {
        return $this->rightName;
    }

    public function setRightName($rightName) {
        $this->rightName = $rightName;
    }

    public function getHideInboxMenu() {
        return $this->hideInboxMenu;
    }

    public function setHideInboxMenu($hideInboxMenu) {
        $this->hideInboxMenu = $hideInboxMenu;
    }

    public function getHideProjectMenu() {
        return $this->hideProjectMenu;
    }

    public function setHideProjectMenu($hideProjectMenu) {
        $this->hideProjectMenu = $hideProjectMenu;
    }

    public function getHideTicketMenu() {
        return $this->hideTicketMenu;
    }

    public function setHideTicketMenu($hideTicketMenu) {
        $this->hideTicketMenu = $hideTicketMenu;
    }

    public function getHideTimeMenu() {
        return $this->hideTimeMenu;
    }

    public function setHideTimeMenu($hideTimeMenu) {
        $this->hideTimeMenu = $hideTimeMenu;
    }

    public function getHideAddressMenu() {
        return $this->hideAddressMenu;
    }

    public function setHideAddressMenu($hideAddressMenu) {
        $this->hideAddressMenu = $hideAddressMenu;
    }

    public function getHideWhiteboardMenu() {
        return $this->hideWhiteboardMenu;
    }

    public function setHideWhiteboardMenu($hideWhiteboardMenu) {
        $this->hideWhiteboardMenu = $hideWhiteboardMenu;
    }

    public function getHideSettingMenu() {
        return $this->hideSettingMenu;
    }

    public function setHideSettingMenu($hideSettingMenu) {
        $this->hideSettingMenu = $hideSettingMenu;
    }

}

?>