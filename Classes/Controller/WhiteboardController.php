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
 * The Whiteboard controller - serves the whiteboard pages
 *
 * @version 0.1
 * @copyright Copyright belongs to the respective authors
 * @package ProjectsAndTasks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Klaus Heuer <klaus.heuer@t3-developer.com>
 */
class WhiteboardController extends \T3developer\ProjectsAndTasks\Controller\BaseController {

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\BoardcatRepository
     * @inject
     */
    protected $boardcatRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\BoardtopicRepository
     * @inject
     */
    protected $boardtopicRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\BoardmessageRepository
     * @inject
     */
    protected $boardmessageRepository;

    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {

        $this->getUserRights();

        // this configures the parsing
        if (isset($this->arguments['topic'])) {
            // $propertyMappingConfiguration->allowProperties('projectDate');
            $this->arguments['topic']
                    ->getPropertyMappingConfiguration()->allowProperties('btDate')
                    ->forProperty('btDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd-m-Y');
            ;
        }
    }

    //**************************************************************************
    // Index
    //**************************************************************************

    /**
     * Index Action: Shows the Whiteboard
     */
    public function whiteboardOverviewAction() {

        $categories = $this->boardcatRepository->findAll();
        if ($categories[0]) {
            foreach ($categories as $cat) {
                $board[$cat->getUid()]['cat'] = $cat;
                $topics = $this->boardtopicRepository->findByBtCat($cat->getUid());
                //append live data to topic model
                foreach ($topics as $topic) {
                    $topic->setBtMessages($this->boardmessageRepository->countByTopic($topic->getUid()));
                    $last = $this->boardmessageRepository->findLastMessageByTopic($topic->getUid());
                    $topic->setBtLastMessage($last[0]);
                }
                $board[$cat->getUid()]['topics'] = $topics;
            }
        }

        $this->view->assign('board', $board);
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($board);
    }

    /**
     * Shows a form to add an Whiteboarcategory
     */
    public function whiteboardCatAddAction() {

        $cat = $this->objectManager->get('T3developer\ProjectsAndTasks\Domain\Model\Boardcat');


        //show close link in header
        $this->view->assign('link', '1');

        $this->view->assign('cat', $cat);
    }

    /**
     * Save a category (add or edit Form)
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Boardcat $cat
     */
    public function whiteboardCatSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Boardcat $cat) {

        if ($cat->getUid() > 0) {
            $this->boardcatRepository->update($cat);
        } else {
            $this->boardcatRepository->add($cat);
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        $this->redirect('whiteboardOverview');
    }

    /**
     * Shows a form to add an Topic
     */
    public function whiteboardTopicAddAction() {
        if ($this->request->hasArgument('catUid')) {
            $catUid = $this->request->getArgument('catUid');
        }

        $topic = $this->objectManager->get('T3developer\ProjectsAndTasks\Domain\Model\Boardtopic');

        $topic->setBtCat($catUid);
        $topic->setBtUser($this->user->getUid());

        //show close link in header
        $this->view->assign('link', '1');

        $this->view->assign('topic', $topic);
        $this->view->assign('cat', $this->boardcatRepository->findByUid($catUid));
    }

    /**
     * Save a topic (add or edit Form)
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Boardtopic $topic
     */
    public function whiteboardTopicSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Boardtopic $topic) {
        if ($topic->getUid() > 0) {
            $this->boardtopicRepository->update($topic);
        } else {
            $this->boardtopicRepository->add($topic);
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        $this->redirect('whiteboardOverview');
    }

    /**
     * Deletes a Topic
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Boardtopic $topic
     */
    public function whiteboardTopicDeleteAction(\T3developer\ProjectsAndTasks\Domain\Model\Boardtopic $topic) {

        //Delete all messages of the topic
        $messages = $this->boardmessageRepository->findByBmTopic($topic->getuid());
        foreach ($messages as $message) {
            $this->boardmessageRepository->remove($message);
        }

        //remove topic
        $this->boardtopicRepository->remove($topic);

        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        $this->redirect('whiteboardOverview');
    }

    //**************************************************************************
    // Topic Page
    //**************************************************************************

    /**
     * Shows the Whiteboard Topic Page
     */
    public function whiteboardShowTopicAction() {
        if ($this->request->hasArgument('topicUid')) {
            $topicUid = $this->request->getArgument('topicUid');
        }

        $topic = $this->boardtopicRepository->findByUid($topicUid);
        $messages = $this->boardmessageRepository->findByBmTopic($topicUid);
        $newmessage = $this->objectManager->get('T3developer\ProjectsAndTasks\Domain\Model\Boardmessage');
        $newmessage->setBmTopic($topicUid);

        $this->view->assign('topic', $topic);
        $this->view->assign('messages', $messages);
        $this->view->assign('newmessage', $newmessage);
        $this->view->assign('loggedInUser', $this->user);
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($companies);
    }

    /**
     * Save a message (Edit and new)
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Boardmessage $newmessage
     */
    public function whiteboardMessageSaveAction(\T3developer\ProjectsAndTasks\Domain\Model\Boardmessage $newmessage) {

        if ($newmessage->getUid() > 0) {
            $this->boardmessageRepository->update($newmessage);
        } else {
            $newmessage->setBmUser($this->user);
            $newmessage->setBmDate(time());
            $this->boardmessageRepository->add($newmessage);
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

        //image handling
        if (!empty($_FILES['tx_projectsandtasks_pat'])) {

            /** @var \TYPO3\CMS\Core\Resource\StorageRepository $storageRepository */
            $storageRepository = $this->objectManager->get('TYPO3\CMS\Core\Resource\StorageRepository');
            /** @var \TYPO3\CMS\Core\Resource\ResourceStorage $storage */
            $storage = $storageRepository->findByUid('1');

            for ($index = 0; $index < count($_FILES['tx_projectsandtasks_pat']['name']['file']); $index++) {
                // setting up file data
                $fileData = array();
                $fileData['name'] = $_FILES['tx_projectsandtasks_pat']['name']['file'][$index];
                $fileData['type'] = $_FILES['tx_projectsandtasks_pat']['type']['file'][$index];
                $fileData['tmp_name'] = $_FILES['tx_projectsandtasks_pat']['tmp_name']['file'][$index];
                $fileData['size'] = $_FILES['tx_projectsandtasks_pat']['size']['file'][$index];

                if ($fileData['name']) {
                    // this will already handle the moving of the file to the storage:
                    $newFileObject = $storage->addFile(
                            $fileData['tmp_name'], $storage->getRootLevelFolder(), $fileData['name']
                    );
                    $newFileObject = $storage->getFile($newFileObject->getIdentifier());
                    $newFile = $this->fileRepository->findByUid($newFileObject->getProperty('uid'));

                    /** @var \T3developer\ProjectsAndTasks\Domain\Model\FileReference $newFileReference */
                    $newFileReference = $this->objectManager->get('T3developer\ProjectsAndTasks\Domain\Model\FileReference');
                    $newFileReference->setFile($newFile);

                    $newmessage->addBmImage($newFileReference);
                    $this->boardmessageRepository->update($newmessage);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                }
            }
        }
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($newmessage);

        // image delete
        if ($newmessage->getBmDeleteImage() == 1) {
            $files = $newmessage->getBmImage();

            foreach ($files as $singlefile) {

                //remove the file reference
                $reference =
                        $this->fileReferenceRepository->findByUid($singlefile->getUid());
                $this->fileReferenceRepository->remove($reference);
            }
            $newmessage->setBmImage(null);
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        }

         $this->redirect('whiteboardShowTopic', NULL, NULL, array('topicUid' => $newmessage->getBmTopic()));
    }

    /**
     * Shows a Form to edit a Message
     * 
     * @param \T3developer\ProjectsAndTasks\Domain\Model\Boardmessage $message
     */
    public function whiteboardMessageEditAction(\T3developer\ProjectsAndTasks\Domain\Model\Boardmessage $message) {

        $this->view->assign('newmessage', $message);
    }

}

?>