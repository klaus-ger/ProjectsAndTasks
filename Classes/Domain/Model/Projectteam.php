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
class Projectteam extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * Project ID
     * @var \T3developer\ProjectsAndTasks\Domain\Model\Projects
     * 
     */
    protected $PtProject;

    /**
     * The Ticket Titel
     * @var \T3developer\ProjectsAndTasks\Domain\Model\User
     * 
     */
    protected $PtUser;

    public function getPtProject() {
        return $this->PtProject;
    }

    public function setPtProject($PtProject) {
        $this->PtProject = $PtProject;
    }

    public function getPtUser() {
        return $this->PtUser;
    }

    public function setPtUser($PtUser) {
        $this->PtUser = $PtUser;
    }

}

?>