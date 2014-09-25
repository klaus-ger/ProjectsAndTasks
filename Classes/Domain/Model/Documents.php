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
     * project
     * @var \int
     */
    protected $docProject;

    /**
     * title
     *
     * @var \string
     */
    protected $docDescription;

    /**
     * File reference for FAL
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3developer\ProjectsAndTasks\Domain\Model\FileReference>
     * @lazy
     */
    protected $files;

    /**
     * Construct
     */
    public function __construct() {
        $this->initStorageObjects();
    }

    /**
     * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects() {
        $this->files = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    public function getDocProject() {
        return $this->docProject;
    }

    public function setDocProject($docProject) {
        $this->docProject = $docProject;
    }

    public function getDocDescription() {
        return $this->docDescription;
    }

    public function setDocDescription($docDescription) {
        $this->docDescription = $docDescription;
    }

    /**
     * Returns the files
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getFiles() {
        return $this->files;
    }

    /**
     * Sets the files
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $files
     * @return void
     */
    public function setFiles($files) {
        $this->files = $files;
    }

    /**
     * Adds a file
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     *
     * @return void
     */
    public function addFile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $file) {
        $this->files->attach($file);
    }

}

?>