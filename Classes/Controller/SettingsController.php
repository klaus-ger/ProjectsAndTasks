<?php

namespace T3developer\ProjectsAndTasks\Controller;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2014  
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
 * The Settings controller - serves the setting pages
 *
 * @version 0.1
 * @copyright Copyright belongs to the respective authors
 * @package ProjectsAndTasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Klaus Heuer <klaus.heuer@t3-developer.com>
 */
class SettingsController extends \T3developer\ProjectsAndTasks\Controller\BaseController {

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\StatustypRepository   
     * @inject
     */
    protected $statustypRepository;

    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {

        $this->getUserRights();
    }

    //**************************************************************************
    // Project Categories actions
    //**************************************************************************

    /**
     * Shows the List of Project cats
     */
    public function settingsProjectCatAction() {

        $maincats = $this->projectcatsRepository->findByCatParent(0);

        foreach ($maincats as $main) {
            $catArray[$main->getUid()]['main'] = $main;
            $catArray[$main->getUid()]['subs'] = $this->projectcatsRepository->findByCatParent($main->getUid());
        }
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($catArray);

        $this->view->assign('categories', $catArray);
        $this->view->assign('mainmenu', '1');
    }

    /**
     * Shows a Form for a new Category
     */
    public function settingsProjectCatNewAction() {

        $maincats = $this->projectcatsRepository->findByCatParent(0);

        $this->view->assign('maincats', $maincats);
        $this->view->assign('mainmenu', '1');
    }

    /**
     * Shows a Form to edit a Category
     * 
     * 
     */
    public function settingsProjectCatEditAction() {
        if ($this->request->hasArgument('category')) {
            $catUid = $this->request->getArgument('category');
        }
        $cat = $this->projectcatsRepository->findByUid($catUid);

        $maincats = $this->projectcatsRepository->findByCatParent(0);

        $this->view->assign('maincats', $maincats);
        $this->view->assign('mainmenu', '1');
        $this->view->assign('category', $cat);
    }

    /**
     * Saves a Category
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Projectcats $category
     */
    public function settingsProjectCatSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Projectcats $category) {


        if ($category->getUid()) {
            $this->projectcatsRepository->update($category);
        } else {
            //find existing Cats for Order value
            if (!$category->getCatParent()) {
                $category->setCatParent(0);
            }
            $existcats = $this->projectcatsRepository->countByCatParent($category->getCatParent());
            $newOrderValue = $existcats + 1;
            $category->setCatOrder($newOrderValue);

            $this->projectcatsRepository->add($category);
            // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($category);
        }

        $this->redirect('settingsProjectCat');
    }

    /**
     * Move Category Up 
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Projectcats $category
     */
    public function settingsProjectCatUpAction(\T3developer\ProjectsAndTasks\Domain\Model\Projectcats $category) {
        $actualPosition = $category->getCatOrder();
        $newPosition = $actualPosition - 1;

        $catMoveDown = $this->projectcatsRepository->findByMaincatAndOrder($category->getCatParent(), $newPosition);
        $catMoveDown[0]->setCatOrder($actualPosition);
        $this->projectcatsRepository->update($catMoveDown[0]);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($catMoveDown);

        $category->setCatOrder($newPosition);
        $this->projectcatsRepository->update($category);

        $this->redirect('settingsProjectCat');
    }

    /**
     * Move Category Down
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Projectcats $category
     */
    public function settingsProjectCatDownAction(\T3developer\ProjectsAndTasks\Domain\Model\Projectcats $category) {
        $actualPosition = $category->getCatOrder();
        $newPosition = $actualPosition + 1;

        $catMoveDown = $this->projectcatsRepository->findByMaincatAndOrder($category->getCatParent(), $newPosition);
        $catMoveDown[0]->setCatOrder($actualPosition);
        $this->projectcatsRepository->update($catMoveDown[0]);


        $category->setCatOrder($newPosition);
        $this->projectcatsRepository->update($category);

        $this->redirect('settingsProjectCat');
    }

    //**************************************************************************
    // Status table actions
    //**************************************************************************

    /**
     * settingsStatusAction
     * Shows a List of all Status
     */
    public function settingsStatusAction() {


        $statustyp = $this->statustypRepository->findAll();
        if ($statustyp[0] == '') {
            $this->importBasicStatusValues();
            $statustyp = $this->statustypRepository->findAll();
        }
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($statustyp);
        $i = 0;
        foreach ($statustyp as $typ) {
            $statusAray[$i]['typ'] = $typ;
            $statusAray[$i]['status'] = $this->statusRepository->findByStatusTyp($typ->getUid());
            $i++;
        }
        $this->view->assign('mainmenu', '2');
        $this->view->assign('statuslist', $statusAray);
    }

    /**
     * settingsStatusNewAction
     * 
     * Shows a form for a new Status entry
     * 
     */
    public function settingsStatusNewAction() {

        if ($this->request->hasArgument('statustyp')) {
            $statustyp = $this->statustypRepository->findByUid($this->request->getArgument('statustyp'));
        }
        $status = new \T3developer\ProjectsAndTasks\Domain\Model\Status;
        $status->setStatusTyp($statustyp);

        $this->view->assign('mainmenu', '2');
        $this->view->assign('status', $status);
    }

    /**
     * settingsStatusEditAction
     * Shows a List of all Status
     */
    public function settingsStatusEditAction() {
        if ($this->request->hasArgument('uid')) {
            $statusUid = $this->request->getArgument('uid');
        }
        $status = $this->statusRepository->findByUid($statusUid);
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($status);
        $this->view->assign('mainmenu', '2');
        $this->view->assign('status', $status);
    }

    /**
     * settingsStatusSaveAction
     * Shows a List of all Status
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Status $status
     */
    public function settingsStatusSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Status $status) {

        if ($status->getUid()) {
            $this->statusRepository->update($status);
        } else {
            $this->statusRepository->add($status);
            // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($category);
        }

        $this->redirect('settingsStatus');
    }

    //**************************************************************************
    // User Rights functions
    //**************************************************************************

    /**
     * settingsRights  Function
     * 
     * Shows a List of all Userright Groups, is no Group exists, we create a blank one.
     */
    public function settingsRightsAction() {

        $rightsGroups = $this->userrightsRepository->findAll();

        if ($rightsGroups[0] == NULL) {
            $newGroup = new \T3developer\ProjectsAndTasks\Domain\Model\Userrights;
            $newGroup->setRightName('admin');
            $this->userrightsRepository->add($newGroup);
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            $rightsGroups = $this->userrightsRepository->findAll();
        }

        $this->view->assign('rightsGroups', $rightsGroups);
        $this->view->assign('mainmenu', '3');
    }

    /**
     * settingsRights  Function
     */
    public function settingsRightsNewAction() {
        $newGroup = new \T3developer\ProjectsAndTasks\Domain\Model\Userrights;
        
        $this->view->assign('mainmenu', '3');
        $this->view->assign('rightsGroup', $newGroup);
    }

    /**
     * settingsRightsEdit  Function
     * 
     * Shows a Form to edit an Right Group
     */
    public function settingsRightsEditAction() {

        if ($this->request->hasArgument('rightGroup')) {
            $rightsGroup = $this->request->getArgument('rightGroup');
            $rightsGroup = $this->userrightsRepository->findByUid($rightsGroup);
        }

        $this->view->assign('mainmenu', '3');
        $this->view->assign('rightsGroup', $rightsGroup);
    }

    /**
     * settingsRights Save  Function
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Userrights $rightsGroup
     */
    public function settingsRightsSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Userrights $rightsGroup) {
        
        if ($rightsGroup->getUid()) {
            $this->userrightsRepository->update($rightsGroup);
        } else {
            $this->userrightsRepository->add($rightsGroup);
            // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($category);
        }

        $this->redirect('settingsRights');
    }

    //**************************************************************************
    // Helper Functions
    //**************************************************************************

    /**
     * importBasicStatusValues
     * Imports a couple of Basic Status Values if statustable is empty
     */
    public function importBasicStatusValues() {
        //Stautustyps
        // 1 = Projectstatus
        // 2 = Ticket status
        // 3 = Ticket Typ (bug feature etc)
        // 4 = Milestonestatus
        // 5 = worktime Typ (customer, research, administrative)
        //status behaviour
        // 0 = open
        // 1 = closed
        // 2 = time can be invoiced
        // 3 = internal time
        // 9 = no behaviour
        //check if Status Typs exists
        //Statustyp Projects
        $type1 = $this->statustypRepository->findByUid(1);
        if (!$type1) {
            $type1 = new \T3developer\ProjectsAndTasks\Domain\Model\Statustyp;
            $type1->setStatustypText('Project Status');
            $this->statustypRepository->add($type1);

            $cat1 = new \T3developer\ProjectsAndTasks\Domain\Model\Status;
            $cat1->setStatusTyp(1);
            $cat1->setStatusText('open');
            $cat1->setStatusBehaviour(0);
            $this->statusRepository->add($cat1);

            $cat2 = new \T3developer\ProjectsAndTasks\Domain\Model\Status;
            $cat2->setStatusTyp(1);
            $cat2->setStatusText('closed');
            $cat2->setStatusBehaviour(1);
            $this->statusRepository->add($cat2);
        }

        //Statustyp Tickets
        $type2 = $this->statustypRepository->findByUid(2);
        if (!$type2) {
            $type2 = new \T3developer\ProjectsAndTasks\Domain\Model\Statustyp;
            $type2->setStatustypText('Ticket Status');
            $this->statustypRepository->add($type2);

            $cat1 = new \T3developer\ProjectsAndTasks\Domain\Model\Status;
            $cat1->setStatusTyp(2);
            $cat1->setStatusText('open');
            $cat1->setStatusBehaviour(0);
            $this->statusRepository->add($cat1);

            $cat2 = new \T3developer\ProjectsAndTasks\Domain\Model\Status;
            $cat2->setStatusTyp(2);
            $cat2->setStatusText('done');
            $cat2->setStatusBehaviour(1);
            $this->statusRepository->add($cat2);
        }

        //Statustyp Ticket TYP
        $type3 = $this->statustypRepository->findByUid(3);
        if (!$type3) {
            $type3 = new \T3developer\ProjectsAndTasks\Domain\Model\Statustyp;
            $type3->setStatustypText('Ticket Typ');
            $this->statustypRepository->add($type3);

            $cat1 = new \T3developer\ProjectsAndTasks\Domain\Model\Status;
            $cat1->setStatusTyp(3);
            $cat1->setStatusText('Bug');
            $cat1->setStatusBehaviour(9);
            $this->statusRepository->add($cat1);

            $cat2 = new \T3developer\ProjectsAndTasks\Domain\Model\Status;
            $cat2->setStatusTyp(3);
            $cat2->setStatusText('Feature');
            $cat2->setStatusBehaviour(9);
            $this->statusRepository->add($cat2);
        }

        //Statustyp Milestone
        $type4 = $this->statustypRepository->findByUid(4);
        if (!$type4) {
            $type4 = new \T3developer\ProjectsAndTasks\Domain\Model\Statustyp;
            $type4->setStatustypText('Milestone');
            $this->statustypRepository->add($type4);

            $cat1 = new \T3developer\ProjectsAndTasks\Domain\Model\Status;
            $cat1->setStatusTyp(4);
            $cat1->setStatusText('open');
            $cat1->setStatusBehaviour(0);
            $this->statusRepository->add($cat1);

            $cat2 = new \T3developer\ProjectsAndTasks\Domain\Model\Status;
            $cat2->setStatusTyp(4);
            $cat2->setStatusText('achived');
            $cat2->setStatusBehaviour(1);
            $this->statusRepository->add($cat2);
        }

        //Statustyp Worktime typ
        $type5 = $this->statustypRepository->findByUid(5);
        if (!$type5) {
            $type5 = new \T3developer\ProjectsAndTasks\Domain\Model\Statustyp;
            $type5->setStatustypText('Worktime Typ');
            $this->statustypRepository->add($type5);

            $cat1 = new \T3developer\ProjectsAndTasks\Domain\Model\Status;
            $cat1->setStatusTyp(5);
            $cat1->setStatusText('customer');
            $cat1->setStatusBehaviour(2);
            $this->statusRepository->add($cat1);

            $cat2 = new \T3developer\ProjectsAndTasks\Domain\Model\Status;
            $cat2->setStatusTyp(5);
            $cat2->setStatusText('research');
            $cat2->setStatusBehaviour(3);
            $this->statusRepository->add($cat2);

            $cat3 = new \T3developer\ProjectsAndTasks\Domain\Model\Status;
            $cat3->setStatusTyp(5);
            $cat3->setStatusText('administrative');
            $cat3->setStatusBehaviour(3);
            $this->statusRepository->add($cat3);
        }
    }

}

?>