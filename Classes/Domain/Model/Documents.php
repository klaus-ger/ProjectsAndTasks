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
 * @package Projects And Tasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Documents extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * The Doc Typ: 1: Projekte, 2 Tickets
     * @var \int
     * 
     */
    protected $docTyp;

       /**
     * The Parent Object Project or Ticket uid
     * @var \int
     * 
     */
    protected $docParent;

    
    /**
     * The Status Typ
     * @var \string
     * 
     */
    protected $docTitel;

    /**
     * The Status Behaviour
     * @var \string
     * 
     */
    protected $docUrl;

    public function getDocTyp() {
        return $this->docTyp;
    }

    public function setDocTyp($docTyp) {
        $this->docTyp = $docTyp;
    }

    public function getDocParent() {
        return $this->docParent;
    }

    public function setDocParent($docParent) {
        $this->docParent = $docParent;
    }

    public function getDocTitel() {
        return $this->docTitel;
    }

    public function setDocTitel($docTitel) {
        $this->docTitel = $docTitel;
    }

    public function getDocUrl() {
        return $this->docUrl;
    }

    public function setDocUrl($docUrl) {
        $this->docUrl = $docUrl;
    }



}

?>