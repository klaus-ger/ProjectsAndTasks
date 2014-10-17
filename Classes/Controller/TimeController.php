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
 * The Time controller - serves the kalender pages
 *
 * @version 0.1
 * @copyright Copyright belongs to the respective authors
 * @package ProjectsAndTasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Klaus Heuer <klaus.heuer@t3-developer.com>
 */
class TimeController extends \T3developer\ProjectsAndTasks\Controller\BaseController {

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
    //Booked time
    //**************************************************************************

    /**
     * Shows the List of Project cats
     */
    public function timeMonthAction() {
        //search worktime only for loged in user
        //
        //This gets today's date
        $date = time();

        $arrayMonth = $this->getMonthArray($date);

        foreach ($arrayMonth as $key => $week) {

            foreach ($week as $day) {
                if ($day['date']) {

                    $arrayMonth[$key][$day['count']]['bookedtime'] = $this->searchWorktime($day['date']);
                    //$arrayMonth[$key][$day['count']]['bookedtime'] = 'test';
                }
            }
        }

        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($arrayMonth);
        $this->view->assign('arrayMonth', $arrayMonth);
        $this->view->assign('mainmenu', 1);
    }

    /**
     * Shows the booked time for a day
     */
    public function timeDayAction() {
        // TODO:
        //search worktime only for loged in user
        if ($this->request->hasArgument('date')) {
            $date = $this->request->getArgument('date');
        } else {
            $date = date("d.m.Y");
        }
        $headlineDate = $date;
        //set the start/end timestamps for the day
        $date = explode('.', $date);
        $start = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
        $end = mktime(23, 59, 59, $date[1], $date[0], $date[2]);

        //loged in user
        $userID = $GLOBALS['TSFE']->fe_user->user['uid'];

        $workNotesCustom = $this->ticketresponseRepository->findPerDate($start, $end, 2);
        $workNotesInternal = $this->ticketresponseRepository->findPerDate($start, $end, 3);

        $time['custom'] = 0;
        $time['internal'] = 0;
        if ($workNotesCustom[0]) {
            foreach ($workNotesCustom as $noteCustom) {

                $time['custom'] = $time['custom'] + $noteCustom->getTrTime();
            }
        }
        if ($workNotesInternal[0]) {
            foreach ($workNotesInternal as $noteInternal) {

                $time['internal'] = $time['internal'] + $noteInternal->getTrTime();
            }
        }
        $time['total'] = $time['custom'] + $time['internal'];


        //This gets today's date
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($workNotesInternal);
        $this->view->assign('date', $headlineDate);
        $this->view->assign('workNotesInternal', $workNotesInternal);
        $this->view->assign('workNotesCustom', $workNotesCustom);
        $this->view->assign('mainmenu', 2);
    }

    /**
     * Search the notes and worktime for a date
     */
    public function searchWorktime($date) {

        //expolde the date string format D.M.Y
        $date = explode('.', $date);

        //set the start/end timestamps for the day
        $start = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
        $end = mktime(23, 59, 59, $date[1], $date[0], $date[2]);

        $workNotesCustom = $this->ticketresponseRepository->findPerDate($start, $end, 2);
        $workNotesInternal = $this->ticketresponseRepository->findPerDate($start, $end, 3);

        $time['custom'] = 0;
        $time['internal'] = 0;
        if ($workNotesCustom[0]) {
            foreach ($workNotesCustom as $noteCustom) {

                $time['custom'] = $time['custom'] + $noteCustom->getTrTime();
            }
        }
        if ($workNotesInternal[0]) {
            foreach ($workNotesInternal as $noteInternal) {

                $time['internal'] = $time['internal'] + $noteInternal->getTrTime();
            }
        }
        $time['total'] = $time['custom'] + $time['internal'];
        return $time;
    }

    /**
     * Returns a motn array with blank week entrys on start
     * 
     * 
     */
    public function getMonthArray($date) {
        //This puts the day, month, and year in seperate variables
        $day = date('d', $date);
        $month = date('m', $date);
        $year = date('Y', $date);

        //Here we generate the first day of the month
        $first_day = mktime(0, 0, 0, $month, 1, $year);

        //This gets us the month name
        $title = date('F', $first_day);

        //Here we find out what day of the week the first day of the month falls on 
        $day_of_week = date('D', $first_day);



        //Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero

        switch ($day_of_week) {

            case "Sun": $blank = 6;
                break;

            case "Mon": $blank = 0;
                break;

            case "Tue": $blank = 1;
                break;

            case "Wed": $blank = 2;
                break;

            case "Thu": $blank = 3;
                break;

            case "Fri": $blank = 4;
                break;

            case "Sat": $blank = 5;
                break;
        }



        //We then determine how many days are in the current month

        $days_in_month = cal_days_in_month(0, $month, $year);

        //Here we start building the table heads 
        //This counts the days in the week, up to 7

        $day_count = 1;


        //first we take care of those blank days
        $week = 1;
        $weekdays = 1;
        while ($blank > 0) {

            $arrayMonth[1][$day_count]['count'] = $day_count;

            $blank = $blank - 1;

            $day_count++;
            $weekdays++;
        }

        //sets the first day of the month to 1 

        $day_num = 1;



        //count up the days, untill we've done all of them in the month


        while ($day_num <= $days_in_month) {

            $arrayMonth[$week][$day_count]['count'] = $day_count;
            $arrayMonth[$week][$day_count]['date'] = $day_num . '.' . $month . '.' . $year;

            $day_num++;
            $day_count++;
            $weekdays++;
            if ($weekdays == 8) {
                $week++;
                $weekdays = 1;
            }
        }

        //we add dummy days for a whole week
        while ($weekdays < 8) {

            $arrayMonth[$week][$day_count]['count'] = $day_count;



            $day_count++;
            $weekdays++;
        }

        return $arrayMonth;
    }

}

?>