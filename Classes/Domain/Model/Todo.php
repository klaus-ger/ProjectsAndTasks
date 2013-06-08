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
 * @package commentreply
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Todo extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {


    
    
    /**
     * The ProjectTitle
     * @var \int
     * 
     */
    protected $todoList;

    /**
     * The ProjectShort
     * @var \int
     * 
     */
    protected $todoTyp;

    /**
     * The ProjectText
     * @var \T3developer\ProjectsAndTasks\Domain\Model\User
     * 
     */
    protected $todoAssigned ;

    /**
     * The Task ProjectSort
     * @var \string
     * 
     */
    protected $todoTitle;

    /**
     * The Task ProjectStatus
     * @var \string
     * 
     */
    protected $todoDescription;

    /**
     * The Task ProjectStatus
     * @var \int
     * 
     */
    protected $todoStatus;
    
       /**
     * The Task ProjectStatus
     * @var \DateTime
     * 
     */
    protected $todoDate;
    
    /**
     * The Task ProjectStatus
     * @var \DateTime
     * 
     */
    protected $todoEnd;

    /**
     * The Task ProjectStatus
     * @var \int
     * 
     */
    protected $todoPlantime;
    
        /**
     * The Todo NR (fortlaufend innerhalb der einzelnen TOdo Liste)
     * @var \int
     * 
     */
    protected $todoNr;
    
    public function getTodoList() {
        return $this->todoList;
    }

    public function setTodoList($todoList) {
        $this->todoList = $todoList;
    }

    public function getTodoTyp() {
        return $this->todoTyp;
    }

    public function setTodoTyp($todoTyp) {
        $this->todoTyp = $todoTyp;
    }

    public function getTodoAssigned() {
        return $this->todoAssigned;
    }

    public function setTodoAssigned($todoAssigned) {
        $this->todoAssigned = $todoAssigned;
    }

    public function getTodoTitle() {
        return $this->todoTitle;
    }

    public function setTodoTitle($todoTitle) {
        $this->todoTitle = $todoTitle;
    }

    public function getTodoDescription() {
        return $this->todoDescription;
    }

    public function setTodoDescription($todoDescription) {
        $this->todoDescription = $todoDescription;
    }

    public function getTodoStatus() {
        return $this->todoStatus;
    }

    public function setTodoStatus($todoStatus) {
        $this->todoStatus = $todoStatus;
    }

    public function getTodoDate() {
        return $this->todoDate;
    }

    public function setTodoDate($todoDate) {
//        $date = explode(".", $todoDate);
//        $timestamp = '@' . mktime(0, 0, 0, $date[1], $date[0], $date[2]);
//        $this->todoDate = new DateTime($timestamp);
        $this->todoDate = $todoDate;
    }

    public function getTodoEnd() {
        return $this->todoEnd;
    }

    public function setTodoEnd($todoEnd) {
        $this->todoEnd = $todoEnd;
    }

    public function getTodoPlantime() {
        return $this->todoPlantime;
    }

    public function setTodoPlantime($todoPlantime) {
        $this->todoPlantime = $todoPlantime;
    }

    public function getTodoNr() {
        return $this->todoNr;
    }

    public function setTodoNr($todoNr) {
        $this->todoNr = $todoNr;
    }



}

?>