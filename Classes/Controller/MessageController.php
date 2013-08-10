<?php

namespace T3developer\Projectsandtasks\Controller;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Klaus Heuer <klaus.heuer@t3-developer.com>
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
 *
 */
class MessageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository   
     */
    protected $userRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\MessageRepository   
     */
    protected $messageRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\ProjectRepository   
     */
    protected $projectRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\TodolistRepository    
     */
    protected $todolistRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Domain\Repository\TodoRepository   
     */
    protected $todoRepository;

    /**
     * @var \T3developer\ProjectsAndTasks\Utility\Pdf  
     */
    protected $pdfUtility;

    /**
     * @var T3developer\ProjectsAndTasks\Controller\ProjectController  
     */
    protected $project;

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\MessageRepository $messageRepository
     * @return void
     */
    public function injectMessageRepository(\T3developer\ProjectsAndTasks\Domain\Repository\MessageRepository $messageRepository) {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\TodolistRepository $todolistRepository
     * @return void
     */
    public function injectTodolistRepository(\T3developer\ProjectsAndTasks\Domain\Repository\TodolistRepository $todolistRepository) {
        $this->todolistRepository = $todolistRepository;
    }

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\TodoRepository $todoRepository
     * @return void
     */
    public function injectTodoRepository(\T3developer\ProjectsAndTasks\Domain\Repository\TodoRepository $todoRepository) {
        $this->todoRepository = $todoRepository;
    }

    /**
     * @param \T3developer\ProjectsAndTasks\Domain\Repository\UserRepository $userRepository
     * @return void
     */
    public function injectUserRepository(\T3developer\ProjectsAndTasks\Domain\Repository\UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     *       
     * @param \t3developer\ProjectsAndTasks\Domain\Repository\ProjectRepository $projectRepository     
     */
    public function injectProjectRepository(\t3developer\ProjectsAndTasks\Domain\Repository\ProjectRepository $projectRepository) {
        $this->projectRepository = $projectRepository;
    }

    /**
     *       
     * @param \T3developer\ProjectsAndTasks\Utility\Pdf $pdfUtility    
     */
    public function injectPdf(\T3developer\ProjectsAndTasks\Utility\Pdf $pdfUtility) {
        $this->pdfUtility = $pdfUtility;
    }

    /**
     *       
     * @param \T3developer\ProjectsAndTasks\Controller\ProjectController $project
     */
    public function injectProject(\T3developer\ProjectsAndTasks\Controller\ProjectController $project) {
        $this->project = $project;
    }

    /**
     * Initializes the current action 
     * @return void 
     */
    public function initializeAction() {
        // this configures the parsing
        if (isset($this->arguments['message'])) {
            $this->arguments['message']
                    ->getPropertyMappingConfiguration()
                    ->forProperty('messageDate')
                    ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
        }
    }

    /**
     * Shows the Message Page with a form to create Messages
     * 
     * @param int $project The projectUid of the actual project
     */
    public function messageNewAction() {
        $project = $this->request->getArgument('project');

        $newMessage = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Message');

        $newMessage->setMessageProject($project);


        $this->view->assign('projectHeader', $this->project->findProjectHeader($project));
        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('user', $this->userRepository->findAll());
        $this->view->assign('message', $newMessage);
        $this->view->assign('messageList', $this->messageRepository->findByMessageProject($project));
        $this->view->assign('menu', '3');
    }

    /**
     * Create a new Message from Form
     *
     *  @param \T3developer\ProjectsAndTasks\Domain\Model\Message $message
     * @dontvalidate $message
     * @return void
     */
    public function messageCreateAction(\T3developer\ProjectsAndTasks\Domain\Model\Message $message) {
        //  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($message);
        $this->messageRepository->add($message);

        $this->redirect('messageNew', 'Message', NULL, Array('project' => $message->getMessageProject()));
    }

    /**
     * Shows the Message Page with a form to edit Messages
     * 
     * @param int $messageUid The messageUid of the actual project
     */
    public function messageEditAction($messageUid) {

        $message = $this->messageRepository->findByUid($messageUid);
        //$project = $this->projectRepository->findByUid($message->getMessageProject());

        //$this->view->assign('inboxHeader', $this->inbox->searchHeaderData());
        $this->view->assign('status', \T3developer\ProjectsAndTasks\Utility\StaticValues::getAvailableStatus());
        $this->view->assign('user', $this->userRepository->findAll());
        $this->view->assign('message', $message);
        $this->view->assign('menu', '3');
    }

    /**
     * Updates a new Message from Form
     *
     *  @param \T3developer\ProjectsAndTasks\Domain\Model\Message $message
     * @dontvalidate $message
     * @return void
     */
    public function messageUpdateAction(\T3developer\ProjectsAndTasks\Domain\Model\Message $message) {
        //  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($message);
        $this->messageRepository->update($message);

        $this->redirect('messageNew', 'Message', NULL, Array('project' => $message->getMessageProject()));
    }

    public function checkMailserverAction() {

        $server = "{xxx/pop3/notls}INBOX";
        $user = "xxx";
        $passwd = "xxx";

        $imap = imap_open($server, $user, $passwd) or die("Could not open Mailbox - try again later!");

        $check = imap_mailboxmsginfo($imap);
        $newmails = $check->Recent;

        for ($count = 1; $count <= $newmails; $count++) {
            $mbox = $imap;
            $mid = $count;
            $struct = imap_fetchstructure($mbox, $mid);
            

    $parts = $struct->parts;
    $i = 0;
    if (!$parts) { /* Simple message, only 1 piece */
        $attachment = array(); /* No attachments */
        $content = imap_body($mbox, $mid);
    } else { /* Complicated message, multiple parts */

        $endwhile = false;

        $stack = array(); /* Stack while parsing message */
        $content = "";    /* Content of message */
        $attachment = array(); /* Attachments */

        while (!$endwhile) {
            if (!$parts[$i]) {
                if (count($stack) > 0) {
                    $parts = $stack[count($stack)-1]["p"];
                    $i     = $stack[count($stack)-1]["i"] + 1;
                    array_pop($stack);
                } else {
                    $endwhile = true;
                }
            }

            if (!$endwhile) {
                /* Create message part first (example '1.2.3') */
                $partstring = "";
                foreach ($stack as $s) {
                    $partstring .= ($s["i"]+1) . ".";
                }
                $partstring .= ($i+1);

                if (strtoupper($parts[$i]->disposition) == "ATTACHMENT" || strtoupper($parts[$i]->disposition) == "INLINE") { /* Attachment or inline images */
                    $filedata = imap_fetchbody($mbox, $mid, $partstring);
                    if ( $filedata != '' ) {
                        // handles base64 encoding or plain text
                        $decoded_data = base64_decode($filedata);
                        if ( $decoded_data == false ) {
                            $attachment[] = array("filename" => $parts[$i]->parameters[0]->value,
                                "filedata" => $filedata);
                        } else {
                            $attachment[] = array("filename" => $parts[$i]->parameters[0]->value,
                                "filedata" => $decoded_data);
                        }
                    }
                } elseif (strtoupper($parts[$i]->subtype) == "PLAIN" && strtoupper($parts[$i+1]->subtype) != "HTML") { /* plain text message */
                    $content .= imap_fetchbody($mbox, $mid, $partstring);
                } elseif ( strtoupper($parts[$i]->subtype) == "HTML" ) {
                    /* HTML message takes priority */
                    $content .= imap_fetchbody($mbox, $mid, $partstring);
                }
            }

            if ($parts[$i]->parts) {
                if ( $parts[$i]->subtype != 'RELATED' ) {
                    // a glitch: embedded email message have one additional stack in the structure with subtype 'RELATED', but this stack is not present when using imap_fetchbody() to fetch parts.
                    $stack[] = array("p" => $parts, "i" => $i);
                }
                $parts = $parts[$i]->parts;
                $i = 0;
            } else {
                $i++;
            }
        } /* while */
    } /* complicated message */

    $ret = array();
    //$ret['body'] = quoted_printable_decode($content);
    $neu = htmlspecialchars($content, ENT_QUOTES);
    $ret['body'] = $content ;
    $ret['attachment'] = $attachment;
    //return $ret;
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($neu);
            ///////////////////////////////////////////
            $info = imap_header($imap, $count);
            //$message = imap_qprint(imap_body($imap, $count));
            $message = imap_body($imap, $count);
            //$message = htmlentities($message, ENT_QUOTES);
            $newmessage = $this->objectManager->create('t3developer\ProjectsAndTasks\Domain\Model\Message');

            $newmessage->setMessageTitle($info->subject);
            //$newmessage->setMessageText($message);
            $newmessage->setMessageText($message);
            $newmessage->setMessageDate($info->date);
            $newmessage->setMessageSender($info->fromaddress);
            $newmessage->setMessageReceiver($GLOBALS['TSFE']->fe_user->user['uid']);
            
            $this->messageRepository->add($newmessage);

            
           
        }
        //delete all Messages:
        imap_delete($imap,'1:*');
        imap_expunge($imap);
        
        imap_close($imap);




//        
//        $server = "{pop.1und1.com:110/pop3/notls}INBOX";
//        $user = "test@t3-developer.com";
//        $passwd = "ivonne1";
// 
//    $mbox = imap_open($server,$user,$passwd) or die("Could not open Mailbox - try again later!");
//
//     
//     
//    $message_count = imap_num_msg($mbox);
//    \Tx_Extbase_Utility_Debugger::var_dump($message_count);
// 
//    $headers = imap_headers($mbox);
//    
//    if ($headers == false) {
//    echo "Abruf fehlgeschlagen<br />\n";
//} else {
//    foreach ($headers as $val) {
//         \Tx_Extbase_Utility_Debugger::var_dump($val);
//    }
//}
//
//
//
//
//
//
//imap_close($mbox);
//       
//   
        //$connection = $this->pop3_login($host, $port, $user, $pass);
//        $newmails = $check->Recent;
//
//        for ($count = 1; $count <= $newmails; $count++) {
//
//            $info = imap_fetch_overview($imap, $count);
//            foreach ($info as $msg) {
//                
//            }
//            $message = imap_body($imap, $count);
//            $text = $msg->to;
//            $needle = strpos($text, '@');
//            $newnumber = substr($text, 0, $needle);
//            echo $message;
//            echo $newnumber;
//            echo $newmails;
//        }

        imap_close($imap);
    }



       /*
     * Shows the log-in Form
     */

    public function checkLogIn() {

        $user = $GLOBALS['TSFE']->fe_user->user;

        if ($user == null) {
            $this->redirect('logIn', 'User');
        } else {

            $this->user = $this->userRepository->findByUid($user['uid']);
        }
    }
    
}

?>