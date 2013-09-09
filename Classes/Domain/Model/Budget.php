<?php

namespace T3developer\ProjectsAndTasks\Domain\Model;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Klaus Heuer | <klaus.heuer@t3-developer.com>
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
class Budget extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * The Budgetproject
     * @var \int
     * 
     */
    protected $budgetProject;

    /**
     * Budget Title
     * @var \string
     * 
     */
    protected $budgetTitle;

    /**
     * Budget Text
     * @var \string
     * 
     */
    protected $budgetText;

    /**
     * Budget Value
     * @var \int
     * 
     */
    protected $budgetValue;

    /**
     * Budget Time
     * @var \int
     * 
     */
    protected $budgetTime;

    /**
     * Budget Invoice
     * @var \int
     * 
     */
    protected $budgetInvoice;

    public function getBudgetProject() {
        return $this->budgetProject;
    }

    public function setBudgetProject($budgetProject) {
        $this->budgetProject = $budgetProject;
    }

    public function getBudgetTitle() {
        return $this->budgetTitle;
    }

    public function setBudgetTitle($budgetTitle) {
        $this->budgetTitle = $budgetTitle;
    }

    public function getBudgetText() {
        return $this->budgetText;
    }

    public function setBudgetText($budgetText) {
        $this->budgetText = $budgetText;
    }

    public function getBudgetValue() {
        return $this->budgetValue;
    }

    public function setBudgetValue($budgetValue) {
        $this->budgetValue = $budgetValue;
    }

    public function getBudgetTime() {
        return $this->budgetTime;
    }

    public function setBudgetTime($budgetTime) {
        $this->budgetTime = $budgetTime;
    }

    public function getBudgetInvoice() {
        return $this->budgetInvoice;
    }

    public function setBudgetInvoice($budgetInvoice) {
        $this->budgetInvoice = $budgetInvoice;
    }

}

?>