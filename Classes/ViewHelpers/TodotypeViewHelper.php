<?php

namespace T3developer\ProjectsAndTasks\ViewHelpers;
/***************************************************************
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
 ***************************************************************/

/**
 *
 *
 * @package projects_and_tasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author klaus heuer <klaus.heuer@t3-developer.com>
 */

class TodotypeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    /**
     * Tx_Fluid_Core_ViewHelper_AbstractViewHelper
     * View Helper to show the Status of a Todo 
     * 
     *  
     * @param int $termin
     * @param string $result
     * 

     */


        
        
  
    /**
     * Main method of the View Helper
     * 
     * @param int $typ
     * @param int $status
      */
    public function render($typ, $status) {
        $imagelink1 = '<img src="typo3conf/ext/projects_and_tasks/Resources/Public/Icons/';
        $imagelink2 = '" alt="My Image" height="16px" width="16px">';
          
        if($typ == '1' && $status < '6')  $image = 'div_open.png';
        if($typ == '1' && $status == '6') $image = 'div_close.png';
        
        if($typ == '5' && $status < '6')  $image = 'feauture_open.png';
        if($typ == '5' && $status == '6') $image = 'feauture_close.png';
        
        if($typ == '6' && $status < '6')  $image = 'bug_open.png';
        if($typ == '6' && $status == '6') $image = 'bug_close.png';
        
        return $imagelink1 . $image . $imagelink2;
      

}
}

?>
