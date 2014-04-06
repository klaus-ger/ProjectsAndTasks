<?php

namespace T3developer\ProjectsAndTasks\Controller;

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
 * @package ProjectsAndTasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AddressController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository   
     * @inject
     */
    protected $userRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\CompanyRepository   
     * @inject
     */
    protected $companyRepository;

    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {
        $user = $GLOBALS['TSFE']->fe_user->user;

        if ($user == NULL) {
            $this->redirect('logIn', 'Login');
        } else {
            $this->user = $this->userRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
            $this->settings['username'] = $this->user->getUsername();
        }
    }

    //**************************************************************************
    // Adress actions
    //**************************************************************************

    /**
     * Index Action: Shows a list of all Persons
     */
    public function personListAction() {
        $persons = $this->userRepository->findAll();
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($companies);
        $this->view->assign('mainmenu', '1');
        $this->view->assign('persons', $persons);
    }

    /**
     * Shows an Edit Form
     */
    public function personEditAction() {
        if ($this->request->hasArgument('person')) {
            $personID = $this->request->getArgument('person');
        }
        $person = $this->userRepository->findByUid($personID);
        $companies = $this->companyRepository->findAll();
        
        $this->view->assign('mainmenu', '1');
        $this->view->assign('person', $person);
        $this->view->assign('companies', $companies);
    }

        /**
     * Shows the PErson create Form
     */
    public function personNewAction() {
        $companies = $this->companyRepository->findAll();
        
        $this->view->assign('mainmenu', '1');
        $this->view->assign('companies', $companies);
    }
    
    /**
     * Save the person
     * @param \T3developer\ProjectsAndTasks\Domain\Model\User $person Description
     */
    public function personSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\User $person) {
        if ($person->getUid()) {
            $this->userRepository->update($person);
        } else {
            $person->setUsergroup($this->settings['adressusergroup']);
            $this->userRepository->add($person);
        }

        $this->redirect('personList');
    }

    //**************************************************************************
    // Company actions
    //**************************************************************************

    /**
     * Index Action: Shows a list of all Companys
     */
    public function companyListAction() {
        $companies = $this->companyRepository->findAll();
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($companies);
        $this->view->assign('mainmenu', '2');
        $this->view->assign('companies', $companies);
    }

    /**
     * Shows an Edit Form
     */
    public function companyEditAction() {
        if ($this->request->hasArgument('company')) {
            $companyID = $this->request->getArgument('company');
        }
        $company = $this->companyRepository->findByUid($companyID);

        $this->view->assign('mainmenu', '2');
        $this->view->assign('company', $company);
    }

    /**
     * Shows the Company create Form
     */
    public function companyNewAction() {

        $this->view->assign('mainmenu', '2');
    }

    /**
     * Save the company
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Company $company Description
     */
    public function companySaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Company $company) {
        if ($company->getUid()) {
            $this->companyRepository->update($company);
        } else {
            $this->companyRepository->add($company);
        }

        $this->redirect('companyList');
    }

}

?>