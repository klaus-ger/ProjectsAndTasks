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
class IndexController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository   
     * @inject
     */
    protected $userRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\TicketsRepository   
     * @inject
     */
    protected $ticketsRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\StatisticRepository   
     * @inject
     */
    protected $statisticRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ProjectteamRepository   
     * @inject
     */
    protected $projectteamRepository;

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

    /**
     * Index Action: Shows a list of all User
     */
    public function indexAction() {
        //if loged in User is admin -> redirect to admin panel
        if ($this->user->getUsername() == 'admin') {
            $this->redirect('adminIndex', 'Admin');
        }

        $openTickets = $this->ticketsRepository->findOpenTicketsByUser($this->user->getUid());

        //Block My Summary
        $countOpenTickets = count($openTickets);

        $openTime = 0;
        $actualTime = time();
        $ticketAgeTotal = 0;
        foreach ($openTickets as $openTi) {
            $openTime = $openTime + $openTi->getTicketScheduleTime();
            $ticketdate = $openTi->getTicketDate()->getTimestamp();
            $ticketage = $actualTime - $ticketdate;
            $ticketAgeTotal = $ticketAgeTotal + $ticketage;
        }
        if ($countOpenTickets > 0) {
            $averageTicketAge = $ticketAgeTotal / $countOpenTickets;
            $averageAge = $averageTicketAge / 3600 / 24;

            //Stat Data
            $this->writeStats($countOpenTickets, $openTime, $averageAge);
            $statArray = $this->loadStatData();
        }


        //Block my Projekts
        $meberships = $this->projectteamRepository->findByPtUser($this->user->getUid());


        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($meberships, 'dokument');

        $this->view->assign('projectMemberships', $meberships);
        $this->view->assign('countOpenTickets', $countOpenTickets);
        $this->view->assign('openTickets', $openTickets);
        $this->view->assign('openTime', $openTime);
        $this->view->assign('openAge', round($averageAge, 2));
        $this->view->assign('statArray', $statArray);
    }

    /**
     * 
     * load statistic data
     * 
     */
    public function loadStatData() {
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

    /**
     * write statistic Data (one per day)
     * 
     * will be later removed to scheduler script
     */
    public function writeStats($countOpenTickets, $openTime, $averageAge) {
        $stats = $this->statisticRepository->findLast();
        if ($stats[0]) {
            //aktual date 
            $acutalString = date('d-m-Y');
            $lastString = date('d-m-Y', $stats[0]->getStatsDate()->getTimestamp());


            if ($acutalString == $lastString) {
                
            } else {
                $newStat = new \T3developer\ProjectsAndTasks\Domain\Model\Statistic;
                $newStat->setStatsDate(time());
                $newStat->setStatsTickets($countOpenTickets);
                $newStat->setStatsOpentime($openTime);
                $newStat->setStatsAge($averageAge);

                $this->statisticRepository->add($newStat);
            }
        } else {
            $newStat = new \T3developer\ProjectsAndTasks\Domain\Model\Statistic;
            $newStat->setStatsDate(time());
            $newStat->setStatsTickets($countOpenTickets);
            $newStat->setStatsOpentime($openTime);
            $newStat->setStatsAge($averageAge);

            $this->statisticRepository->add($newStat);
        }
    }

}

?>