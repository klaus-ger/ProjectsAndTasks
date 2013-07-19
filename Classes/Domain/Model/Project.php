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
class Project extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * The ProjectTitle
     * @var \string
     * 
     */
    protected $projectTitle;

    /**
     * The ProjectShort
     * @var \string
     * 
     */
    protected $projectShort;

    /**
     * The ProjectText
     * @var \string
     * 
     */
    protected $projectText;

    /**
     * The Task ProjectSort
     * @var \int
     * 
     */
    protected $projectSort;

    /**
     * The Task ProjectStatus
     * @var \int
     * 
     */
    protected $projectStatus;

    /**
     * The ProjectLevel
     * @var \int
     * 
     */
    protected $projectLevel;

    /**
     * The projectParent
     * @var \int
     * 
     */
    protected $projectParent;

    /**
     * The projectOwner
     * @var \int
     * 
     */
    protected $projectOwner;

    /**
     * The projectIcon
     * @var \string
     * 
     */
    protected $projectIcon;

    /**
     * The projectIcon
     * @var \int
     * 
     */
    protected $projectBudgetTime;

    /**
     * The projectIcon
     * @var \int
     * 
     */
    protected $projectBudgetMoney;

    /**
     * openTodos
     * @var \int
     */
    protected $projectOpenTodos;

        /**
     * openTodos
     * @var \DateTime
     */
    protected $projectRevisionDate;


    
    /**
     *
     * Gets the Crdate
     * @return \int
     *
     */
    Public Function getCrdate() {
        Return $this->crdate;
    }

    /**
     *
     * Gets the ProjectTitle
     * @return \string
     *
     */
    Public Function getProjectTitle() {
        Return $this->projectTitle;
    }

    /**
     *
     * Sets the ProjectTitle
     * @param \string $projectTitle
     * @return void
     *
     */
    Public Function setProjectTitle($projectTitle) {
        $this->projectTitle = $projectTitle;
    }

    /**
     *
     * Gets the ProjectShort
     * @return \string
     *
     */
    Public Function getProjectShort() {
        Return $this->projectShort;
    }

    /**
     *
     * Sets the ProjectShort
     * @param \string $projectShort
     * @return void
     *
     */
    Public Function setProjectShort($projectShort) {
        $this->projectShort = $projectShort;
    }

    /**
     *
     * Gets the ProjectText
     * @return \string
     *
     */
    Public Function getProjectText() {
        Return $this->projectText;
    }

    /**
     *
     * Sets the ProjectText
     * @param \string $projectText
     * @return void
     *
     */
    Public Function setProjectText($projectText) {
        $this->projectText = $projectText;
    }

    /**
     *
     * Gets the ProjectSort
     * @return \int
     *
     */
    Public Function getProjectSort() {
        Return $this->projectSort;
    }

    /**
     *
     * Sets the ProjectSort
     * @param \int $projectSort
     * @return void
     *
     */
    Public Function setProjectSort($projectSort) {
        $this->projectSort = $projectSort;
    }

    /**
     *
     * Gets the ProjectStatus
     * @return \string
     *
     */
    Public Function getProjectStatus() {
        Return $this->projectStatus;
    }

    /**
     *
     * Sets the ProjectStatus
     * @param \string $projectStatus
     * @return void
     *
     */
    Public Function setProjectStatus($projectStatus) {
        $this->projectStatus = $projectStatus;
    }

    /**
     *
     * Gets the ProjectParent
     * @return \int
     *
     */
    Public Function getProjectParent() {
        Return $this->projectParent;
    }

    /**
     *
     * Sets the ProjectParent
     * @param \int $projectParent
     * @return void
     *
     */
    Public Function setProjectParent($projectParent) {
        $this->projectParent = $projectParent;
    }

    /**
     *
     * Gets the ProjectOwner
     * @return \int
     *
     */
    Public Function getProjectOwner() {
        Return $this->projectOwner;
    }

    /**
     *
     * Sets the ProjectOwner
     * @param \int $projectOwner
     * @return void
     *
     */
    Public Function setProjectOwner($projectOwner) {
        $this->projectOwner = $projectOwner;
    }

    /**
     *
     * Gets the ProjectIcon
     * @return \string
     *
     */
    Public Function getProjectIcon() {
        Return $this->projectIcon;
    }

    /**
     *
     * Sets the ProjectIcon
     * @param \string $projectIcon
     * @return void
     *
     */
    Public Function setProjectIcon($projectIcon) {
        $this->projectIcon = $projectIcon;
    }

    public function getProjectBudgetTime() {
        return $this->projectBudgetTime;
    }

    public function setProjectBudgetTime($projectBudgetTime) {
        $this->projectBudgetTime = $projectBudgetTime;
    }

    public function getProjectBudgetMoney() {
        return $this->projectBudgetMoney;
    }

    public function setProjectBudgetMoney($projectBudgetMoney) {
        $this->projectBudgetMoney = $projectBudgetMoney;
    }

    public function getProjectLevel() {
        return $this->projectLevel;
    }

    public function setProjectLevel($projectLevel) {
        $this->projectLevel = $projectLevel;
    }

    public function getProjectOpenTodos($projectOpenTodos) {
        return $this->projectOpenTodos;
    }

    public function setProjectOpenTodos($projectOpenTodos) {
        $this->projectOpenTodos = $projectOpenTodos;
    }
    public function getProjectRevisionDate() {
        return $this->projectRevisionDate;
    }

    public function setProjectRevisionDate($projectRevisionDate) {
        $this->projectRevisionDate = $projectRevisionDate;
    }

}

?>