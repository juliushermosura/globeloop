<?php echo $this->element('mail_js_functions') ?>

<?php echo $this->Session->flash(); ?>


<?php echo $this->element('mail_search') ?>

<div id="messageViewport">

    <div id="messagePage">
        
        <div class="messageslist">
            
            <?php if (!empty($data)): ?>

                <input type="hidden" name="mailid" id="id" value="" />
                <input type="hidden" name="parent" id="parent" value="" />
                
                <div class="pagesX">
                <?php foreach($data as $message): ?>
                    
            <div class="user_mail_details" id="mail-<?php echo $message['Inbox']['id'] ?>">
                <div class="user_thumb_pic">
                    <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $message['Recipient']['full_name'], 'border' => 0, 'width' => '80', 'height' => '63')), array('controller' => 'users', 'action' => 'view', !empty($message['Sender']['username']) ? $message['Sender']['username'] : $message['Sender']['id']), array('escape' => false, 'title' => !empty($message['Sender']['full_name']) ? $message['Sender']['full_name'] : htmlentities($message['Inbox']['sender_email']))) ?>
                </div>
                
                <div class="user_mail_info">
                    <div class="user_brief_details"><?php echo $this->Html->link(String::truncate(!empty($message['Sender']['full_name']) ? $message['Sender']['full_name'] : htmlentities($message['Inbox']['sender_email']), 38, array('ellipsis' => '...')), array('controller' => 'users', 'action' => 'view', !empty($message['Sender']['username']) ? $message['Sender']['username'] : $message['Sender']['id']), array('escape' => false, 'title' => !empty($message['Sender']['full_name']) ? $message['Sender']['full_name'] : htmlentities($message['Inbox']['sender_email']))) ?></div>
                    <div class="user_brief_details"><?php echo date('M d, Y', strtotime($message['Inbox']['received_on'])) ?></div>
                </div>
                
                <div class="subject_mail_info">
                    <a href="#read" class="readMail">
                        <div class="sender_info"><?php echo empty($message['Inbox']['sender_id']) ? htmlentities($message['Inbox']['sender_email']) : $message['Sender']['full_name'] ?></div>
                        <div class="subject_info <?php echo ($message['Inbox']['read'] == 0) ? 'subjectUnread' : '' ?>"><?php echo $message['Inbox']['subject'] ?></div>
                        <div class="mail_info"><?php echo String::truncate($message['Inbox']['body_plain'], 50, array('ellipsis' => '...')) ?></div>
                    </a>
                    <div class="mail_content"><?php echo !empty($message['Inbox']['body_html']) ? quoted_printable_decode($message['Inbox']['body_html']) : quoted_printable_decode($message['Inbox']['body_plain']) ?></div>
                </div>
                
            </div>
                
                <?php endforeach ?>
                </div>
                
                <div class="pageNav" style="display: none"><?php echo $this->Paginator->next(' >> ' . __('next'), array(), null, array('class' => 'next disabled')); ?></div>
                
            <?php else: ?>
                
            <p>No message.</p>
                
            <?php endif ?>
            
        </div>
        
        <div id="messageBodyContainer">
            
            <div class="actions" style="clear:both">
                <a href="#" class="actions" id="inbox">< Back to Inbox</a> 
                <a href="#reply" class="actions" id="reply">Reply</a> 
                <a href="#forward" id="forward">Forward</a>  
                <a href="#markunread" id="markasunread">Mark as Unread</a>  
                <a href="#delete" id="delete">Delete</a>
            </div>
            
            <div style="padding-top: 10px; clear: both;">
                <span>From: </span><span class="senderPlaceholder"></span>
                <br />
                <span>To: </span><span class="recipientPlaceholder"><?php echo $message['Inbox']['recipients'] ?></span>

            </div>
            
            <div class="subjectPlaceholder"></div>
            <hr />
            
            <div class="messagePlaceholder"></div>
            
            <div id="messageForm">
                <div class="messageActions actions" style="width: 100% !important; clear:both">
                    <a href="#send" class="actions" id="send">Send</a>
                    <a href="#save" class="actions" id="save">Save</a>
                    <a href="#cancel" class="actions" id="cancel">Cancel</a>
                </div>
                
                <div class="messageTo">To <input type="text" id="to" name="to" placeholder="Name or Email Address" /></div>
                <div class="messageSubject">Subject <input type="text" id="subject" name="subject" /></div>
                <div class="messageAttachment"><a href="#"><sub>Attach a file</sub></a></div>
                <textarea name="message" id="message" rows="15"></textarea>
            </div>
            
        </div>
        
    </div>
    
</div>