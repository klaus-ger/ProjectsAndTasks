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
 * @package wfp2_dmc_stammdaten
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author klaus heuer <norman.moeller@wfp2.com>
 */

class WorktimeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    /**
     * Tx_Fluid_Core_ViewHelper_AbstractViewHelper
     * View Helper to show the Status of a single Termin
     * Relation of Booked Customers to total seats of the Veranstaltungsort
     * 
     * Usage in fluid form: 
     * For the Icon class (green, orange or red)
     *    <vh:BuchungStatus termin='{termin.uid}' result='class' /> 
     *    output: 'label-success', 'label-warning', 'label-important', depending on the calculated booking level
     *
     * For the Text (Mobil View)
     *    <vh:BuchungStatus termin='{termin.uid}' result='text' /> 
     *    output: 'Noch Plätze frei', 'Nur noch wenige Plätze frei' .. etc
     * 
     *     
     * 
     * The limit for the orange Booking Level is defined in line 81 $bookingLine
     *  
     * @param int $start
     * @param int $end
     * 

     */


        
        
  
    /**
     * Main method of the View Helper
     * 
     * @param int $start
     * @param int $end
      */
    public function render($start, $end) {
        
        if($end != null) {
            $time = $end - $start;
            $plantime = $time / 60;
            $plantime = $plantime / 60 . ' h';
        } else {
            $plantime = '-';
        }
        
        return $plantime;
}

}
?>
