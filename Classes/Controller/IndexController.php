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
 * The Index controller - serves the in-box page
 *
 * @version 0.1
 * @copyright Copyright belongs to the respective authors
 * @package ProjectsAndTasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Klaus Heuer <klaus.heuer@t3-developer.com>
 */
class IndexController extends \T3developer\ProjectsAndTasks\Controller\BaseController {

    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {

        $this->getUserRights();
    }

    /**
     * Index Action: Shows a list of all User
     */
    public function indexAction() {

        //Open Tickets of the logged in user
        $openTickets = $this->ticketsRepository->findOpenTicketsByUser($this->user->getUid());

        //Block overall trend

        $statArray = $this->loadStatisticData();
        $this->checkStatsitikData();

        //Block My Summary
        $mySummary = $this->findMySummary($openTickets);

        //Block my Projekts
        $myProjects = $this->projectsRepository->findByProjectByStatusAndOwnser(0, $this->user->getUid());
        $meberships = $this->projectteamRepository->findByPtUser($this->user->getUid());


        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($meberships, 'dokument');
        $this->view->assign('openTickets', $openTickets);
        $this->view->assign('myProjects', $myProjects);
        $this->view->assign('projectMemberships', $meberships);
        $this->view->assign('mySummary', $mySummary);
        $this->view->assign('statArray', $statArray);
    }

    /**
     * find global Trend
     * 
     * Find the global statistic Data for all user - if the data for the actual date
     * is not create, we do so.
     */
    private function checkStatsitikData() {

        $lastStatistikData = $this->statisticRepository->findLast();

        if ($lastStatistikData[0]) {

            $acutalDate = date('d-m-Y');
            $lastStatiststicDate = date('d-m-Y', $lastStatistikData[0]->getStatsDate()->getTimestamp());

            if ($acutalDate != $lastStatiststicDate) {
                $this->createActualStatisticData();
            }
        } else {
            //We have a blank system and never stored statistic data before
            $this->createActualStatisticData();
        }
    }

    /**
     * find My Summary
     * 
     * returns an array of a summary for the loged in user
     */
    private function findMySummary($openTickets) {

        $openTime = 0;
        $actualTime = time();
        $ticketAgeTotal = 0;
        $countOpenTickets = count($openTickets);

        foreach ($openTickets as $openTi) {
            $openTime = $openTime + $openTi->getTicketScheduleTime();
            $ticketdate = $openTi->getTicketDate()->getTimestamp();
            $ticketage = $actualTime - $ticketdate;
            $ticketAgeTotal = $ticketAgeTotal + $ticketage;
        }
        if ($countOpenTickets > 0) {
            $averageTicketAge = $ticketAgeTotal / $countOpenTickets;
            $averageAge = $averageTicketAge / 3600 / 24;
        }

        $mySummary['openTickets'] = $countOpenTickets;
        $mySummary['openTime'] = $openTime;
        $mySummary['averageAge'] = round($averageAge, 2);

        return($mySummary);
    }

    /**
     * create Global Actual Statistic Data
     * 
     * This action is done only once per day.
     */
    private function createActualStatisticData() {

        $openTickets = $this->ticketsRepository->findOpenTickets();

        $openTime = 0;
        $actualTime = time();
        $ticketAgeTotal = 0;
        $countOpenTickets = count($openTickets);

        foreach ($openTickets as $openTi) {
            $openTime = $openTime + $openTi->getTicketScheduleTime();
            $ticketdate = $openTi->getTicketDate()->getTimestamp();
            $ticketage = $actualTime - $ticketdate;
            $ticketAgeTotal = $ticketAgeTotal + $ticketage;
        }
        if ($countOpenTickets > 0) {
            $averageTicketAge = $ticketAgeTotal / $countOpenTickets;
            $averageAge = $averageTicketAge / 3600 / 24;

            $newStat = new \T3developer\ProjectsAndTasks\Domain\Model\Statistic;
            $newStat->setStatsDate(time());
            $newStat->setStatsTickets($countOpenTickets);
            $newStat->setStatsOpentime($openTime);
            $newStat->setStatsAge($averageAge);

            $this->statisticRepository->add($newStat);
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        }
    }

    /**
     * 
     * load statistic data
     * 
     */
    private function loadStatisticData() {

        $stats = $this->statisticRepository->findLastStatForGraph();

        //find max value
        $max = 1;
        foreach ($stats as $stat) {
            if ($stat->getStatsTickets() > $max) {
                $max = $stat->getStatsTickets();
            }
            if ($stat->getStatsOpentime() / 3600 > $max) {
                $max = $stat->getStatsOpentime() / 3600;
            }
            if ($stat->getStatsAge() > $max) {
                $max = $stat->getStatsAge();
            }
        }
        //reorder result
        $li = 10;
        foreach ($stats as $orderedstat) {
            $orderdStat[$li] = $orderedstat;
            $li = $li - 1;
        }
        sort($orderdStat);

        //write % stst array
        $li = 10;
        $statArray['date'] = '';
        $statArray['ticket'] = '';
        $statArray['time'] = '';
        $statArray['age'] = '';
        foreach ($orderdStat as $stat) {
            $time = $stat->getStatsOpentime() / 3600;
            $statArray['date'][] = date('d.m.', $stat->getStatsDate()->getTimestamp());
            $statArray['ticket'][] = round($stat->getStatsTickets() * 100 / $max);
            $statArray['time'][] = round($time * 100 / $max);
            $statArray['age'][] = round($stat->getStatsAge() * 100 / $max);

            $li = $li - 1;
        }


        $statArray['date'] = implode(',', $statArray['date']);
        $statArray['ticket'] = implode(',', $statArray['ticket']);
        $statArray['time'] = implode(',', $statArray['time']);
        $statArray['age'] = implode(',', $statArray['age']);
        ;

        return $statArray;
    }

}

?>