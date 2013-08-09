<?php
namespace T3developer\ProjectsAndTasks\Utility;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Klaus Heuer <klaus.heuer@t3-developer.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


class StaticValues {

    /**
     * Returns an array with all available status
     *
     * @return array available status
     */
    public static function getAvailableStatus() {
        return array(
            '1' => 'offen',
            '3' => 'zu klären',
            '5' => 'zur Prüfung',
            '6' => 'erledigt',

        );
    }
    
            /**
     * Returns an array with all available Projectstatus
     *
     * @return array available projectstatus
     */
    public static function getAvailableProjectStatus() {
        return array(
            '1' => 'Planung',
            '3' => 'in Bearbeitung',
            '5' => 'abrechnen',
            '6' => 'Archiv',

        );
    }
    

        /**
     * Returns an array with all available Todo Typ
     *
     * @return array available status
     */
    public static function getAvailableTodoTyp() {
        return array(
            '1' => 'DIV',
            '5' => 'FEAT',
            '6' => 'BUG',
        );
    }
    
            /**
     * Returns an array with all available WorkStatus
     *
     * @return array available status
     */
    public static function getAvailableWorkStatus() {
        return array(
            '1' => 'nicht verechenbar',
            '5' => 'offen',
            '6' => 'abgerechnet',
        );
    }
    
                /**
     * Returns an array with all available UserRights
     *
     * @return array available status
     */
    public static function getAvailableUserRights() {
        return array(
            '1' => 'owner',
            '2' => 'read',
            '3' => 'edit',
        );
    }
    
        /**
     * Returns an array with all available status
     *
     * @return array available status
     */
    public static function getAvailableTime() {
        return array(
            '25200' => '7:00',
            '27000' => '7:30',
            '28800' => '8:00',
            '30600' => '8:30',
            '32400' => '9:00',
            '34200' => '9:30',
            '36000' => '10:00',
            '37800' => '10:30',
            '39600' => '11:00',
            '41400' => '11:30',
            '43200' => '12:00',
            '45000' => '12:30',
            '46800' => '13:00',
            '48600' => '13:30',
            '50400' => '14:00',
            '52200' => '14:30',
            '54000' => '15:00',
            '55800' => '15:30',
            '57600' => '16:00',
            '59400' => '16:30',
            '61200' => '17:00',
            '63000' => '17:30',
            '64800' => '18:00',
            '66600' => '18:30',
            '68400' => '19:00',
            '70200' => '19:30',
            '72000' => '20:00',
            '73800' => '20:30',
            '75600' => '21:00',
            '77400' => '21:30',
            '79200' => '22:00'
            

        );
    }

    /**
     * Returns an array with all available Worktime
     *
     * @return array available status
     */
    public static function getAvailableWorkTime() {
        return array(
            '0'    => ' --',
            '900'  => '0,25 h',
            '1800' => '0,5 h',
            '3600' => '1 h',
            '5400' => '1,5 h',
            '7200' => '2 h',
            '9000' => '2,5 h',
            '10800'=> '3 h',
            '14400'=> '4 h',
            '18000'=> '5 h',
            '21600'=> '6 h',
            '25200'=> '7 h',
            '28800'=> '8 h',
            '54000'=> '15 h',
            '72000'=> '20 h',
            '90000'=> '25 h'
        );
    }
    
}

?>
