<?php

namespace T3developer\ProjectsAndTasks\ViewHelpers;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Klaus Heuer 
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
 * @author klaus heuer klaus.heuer@t3-developer.com
 */
class ProjectSelectViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    /**
     * Tx_Fluid_Core_ViewHelper_AbstractViewHelper
     * View Helper to show the Select Fields with Projects
     * 
     * @param array $projects
     * @param array $selected
     */

    /**
     * Main method of the View Helper
     * 
     * @param array $projects
     * @param int $selected
     */
    public function render($projects, $selected) {
       
     $html = '<select name="tx_projectsandtasks_patsystem[project][projectParent]">';   
     $html.= '<option value="0"> --- </option>' ;
     foreach ($projects as $project){
         if($project['node']->getUid() == $selected){
             $html.= '<option selected="selected"';
         }else {
             $html.= '<option'; 
         }
        
         $html.= ' value="'. $project['node']->getUid() . '">';
         $html.= '<b>' . $project['node']->getProjectTitle() . '</b>'; 
         $html. '</option>';
         
         foreach ($project['subnodes'] as $level2){
            if($level2['node']->getUid() == $selected){
                $html.= '<option selected="selected"';
            }else {
                $html.= '<option'; 
            }
            $html.= ' value="'. $level2['node']->getUid() . '">';
            $html.= '--' . $level2['node']->getProjectTitle(); 
            $html. '</option>';
            
            foreach ($level2['subnodes'] as $level3){
            if($level3->getUid() == $selected){
                $html.= '<option selected="selected"';
            }else {
                $html.= '<option'; 
            }    
            $html.= ' value="'. $level3->getUid() . '">';
            $html.= '----' . $level3->getProjectTitle(); 
            $html. '</option>';
            }
         }
     }
     $html.= '</select>';


        return $html;
    }

}

?>
