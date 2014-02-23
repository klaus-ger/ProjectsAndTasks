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
class LoginController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
//    /**
//     * @var \T3developer\T3gists\Domain\Repository\GistsRepository   
//     * @inject
//     */
//    protected $gistsRepository;

    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {
        
    }

    /**
     * Index Action: Checks the login Status
     */
    public function indexAction() {

    }

    /*
     * Show the login Form
     * 
     * @param \t3developer\ProjectsAndTasks\Domain\Model\User $user
     * @dontvalidate $user
     */

    public function logInAction() {
        $user = $GLOBALS['TSFE']->fe_user->user;

        if ($user != NULL) {
            $this->redirect('index', 'Index');
        }


        if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['loginFormOnSubmitFuncs'])) {
            $_params = array();
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['loginFormOnSubmitFuncs'] as $funcRef) {
                //list($onSub, $hid) = t3lib_div::callUserFunction($funcRef, $_params, $this);
                //   TYPO3\CMS\CoreUtility\GeneralUtility::callUserFunction
                list($onSub, $hid) = \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($funcRef, $_params, $this);
                $onSubmitAr[] = $onSub;
                $extraHiddenAr[] = $hid;
            }
        }

        if (count($onSubmitAr)) {
            $onSubmit = implode('; ', $onSubmitAr) . '; return true;';
        }

        if (count($extraHiddenAr)) {
            $extraHidden = implode(LF, $extraHiddenAr);
        }
        $this->view->assign('storagePid', $this->settings['storagePid']);
        $this->view->assign('onSubmit', $onSubmit);
        $this->view->assign('extraHidden', $extraHidden);
        $this->view->assign('currentPid', \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('id'));
    }

}

?>