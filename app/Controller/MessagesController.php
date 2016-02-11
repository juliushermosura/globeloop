<?php

class MessagesController extends AppController {

    public $layout = 'users';
    
    /* connect to gmail */
    private $hostname = 'imap.gmail.com';
    private $username = 'shadows@citizenshare.com';
    private $password = '!1ws6Y6sw1!';
    private $port = '993';
    private $ssl = true;
    private $mail;
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function index() {
        $this->__connect();
        $this->__fetch();
        $this->autoRender = false;
    }
    
    public function __connect() {
        set_include_path(implode(PATH_SEPARATOR, array(
            WWW_ROOT . '/zend/library/',
             get_include_path(),
        )));
        
        require_once 'Zend/Loader/Autoloader.php';
        
        Zend_Loader_Autoloader::getInstance();
        
        $this->mail = new Zend_Mail_Storage_Imap(
            array(
                'host'     => $this->hostname,
                'port'     => $this->port,
                'ssl'      => $this->ssl,
                'user'     => $this->username,
                'password' => $this->password,
            )
        );
    }
    
    public function __extract_email_address ($string) {
        foreach(preg_split('/ /', $string) as $token) {
            $email = filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
            if ($email !== false) {
                $emails[] = $email;
            } else {
                return false;
            }
        }
        return $emails;
    }

    private function __fetch() {
        $this->loadModel('User');
        $this->log('==================================================');
        $this->log('Start Fetching Emails');
        $this->mail->noop();
        foreach ($this->mail as $messageNum => $message) {
            unset($emails);
            $emails = $this->__extract_email_address($message->to);
            if ($emails != false) {
                foreach ($emails as $email) {
                    unset($valid_recipient);
                    $e = explode('@', $email);
                    $valid_recipient = $this->User->find('first', array('conditions' => array('User.username' => $e['0'], 'User.domain_name' => $e['1']), 'recursive' => -1));
                    if (!empty($valid_recipient)) {
                        $plain = array();
                        $html = array();
                        foreach (new RecursiveIteratorIterator($message) as $part) {
                            try {
                                if (strtok($part->contentType, ';') == 'text/plain') {
                                    $plain[] = $part->getContent();
                                }
                                if (strtok($part->contentType, ';') == 'text/html') {
                                    $html[] = $part->getContent();
                                }
                            } catch (Zend_Mail_Exception $e) {
                                // ignore
                            }
                        }
                        unset($data);
                        $data = array(
                            'Message' => array(
                                'recipient_id' => $valid_recipient['User']['id'],
                                'recipient_email' => $message->to,
                                'sender_email' => $message->from,
                                'subject' => $message->subject,
                                'received_on' => date('Y-m-d H:i:s', strtotime($message->date)),
                                'body_plain' => implode(' ', $plain),
                                'body_html' => implode(' ', $html)
                            )
                        );
                        $this->mail->noop();
                        $this->Message->create();
                        if (!$this->Message->save($data)) {
                            $this->log('==================================================');
                            $this->log('Email Failed to Save to DB.');
                            $this->log('Message ID: ' . $message->messageId);
                            $this->log('Sender: ' . $message->from);
                            $this->log('Recipient: ' . $message->to);
                            $this->log('Subject: ' . $message->subject);
                            $this->log('Email Date Received: ' . $message->date);
                        } else {
                            //Zend_Debug::dump($message->getHeaders());
                            //Zend_Debug::dump($message->getContent());
                            $this->mail->removeMessage($messageNum);
                        }
                    } else {
                        $this->log('==================================================');
                        $this->log('No Valid Recipient.');
                        $this->log('Message ID: ' . $message->messageId);
                        $this->log('Sender: ' . $message->from);
                        $this->log('Recipient: ' . $message->to);
                        $this->log('Subject: ' . $message->subject);
                        $this->log('Email Date Received: ' . $message->date);
                        $this->mail->removeMessage($messageNum);
                    }
                }
            } else {
                $this->log('==================================================');
                $this->log('No Valid Recipient.');
                $this->log('Message ID: ' . $message->messageId);
                $this->log('Sender: ' . $message->from);
                $this->log('Recipient: ' . $message->to);
                $this->log('Subject: ' . $message->subject);
                $this->log('Email Date Received: ' . $message->date);
                $this->mail->removeMessage($messageNum);
            }
        }
        $this->log('==================================================');
        $this->log('Done Fetching Emails');
        // output subject of message
        //$message = $this->mail->getMessage(1);
        //$email = $this->__extract_email_address($message->to);
        //echo $message->subject . "<br>";
        //echo '<pre>' . $message->getContent() . '</pre>';

        // dump message headers
        //Zend_Debug::dump($message->getHeaders());
    }

}

?>