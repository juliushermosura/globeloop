<?php echo $this->element('mail_js_functions') ?>

<?php echo $this->Session->flash(); ?>

<?php echo $this->element('mail_search') ?>

<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
        $('#messageForm').show();
        $('.readMail').bind('click', function() {
            $('html, body').animate({ scrollTop: $('#messageForm').offset().top - 80 }, 500);
        });
        
        $('#inbox').bind('click', function() {
            $('#messageForm').show();
        });
        
    });"); ?>

<div id="messageViewport">

    <div id="messagePage">
        
        <div class="messageslist">
            
            <?php if (!empty($data)): ?>

                <input type="hidden" name="mailid" id="id" value="" />
                <input type="hidden" name="parent" id="parent" value="" />
                
                <div class="pagesX">
                <?php foreach($data as $message): ?>
                    
            <div class="user_mail_details" id="mail-<?php echo $message['Draft']['id'] ?>">
                <div class="user_thumb_pic">
                    <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => !empty($message['Recipient']['full_name']) ? $message['Recipient']['full_name'] : $message['Draft']['recipient_email'], 'border' => 0, 'width' => '80', 'height' => '63')), array('controller' => 'users', 'action' => 'view', !empty($message['Recipient']['username']) ? $message['Recipient']['username'] : !empty($message['Recipient']['id']) ? $message['Recipient']['id'] : $message['Draft']['recipient_email']), array('escape' => false, 'title' => !empty($message['Recipient']['full_name']) ? $message['Recipient']['full_name'] : htmlentities($message['Draft']['recipient_email']))) ?>
                </div>
                
                <div class="user_mail_info">
                    <div class="user_brief_details"><?php echo $this->Html->link(String::truncate(!empty($message['Recipient']['full_name']) ? $message['Recipient']['full_name'] : htmlentities($message['Draft']['recipient_email']), 38, array('ellipsis' => '...')), array('controller' => 'users', 'action' => 'view', !empty($message['Recipient']['username']) ? $message['Recipient']['username'] : !empty($message['Recipient']['id']) ? $message['Recipient']['id'] : $message['Draft']['recipient_email']), array('escape' => false, 'title' => !empty($message['Recipient']['full_name']) ? $message['Recipient']['full_name'] : htmlentities($message['Draft']['recipient_email']))) ?></div>
                    <div class="user_brief_details"><?php echo date('M d, Y', strtotime($message['Draft']['modified'])) ?></div>
                </div>
                
                <div class="subject_mail_info">
                    <a href="#read" class="readMail">
                        <div class="parent" style="display:none"><?php echo $message['Draft']['parent_id'] ?></div>
                        <?php if (!empty($message['Parent']['id'])): ?>
                        <div class="sender_info"><?php echo empty($message['Parent']['sender_id']) ? htmlentities($message['Parent']['sender_email']) : $message['Sender']['full_name'] ?></div>
                        <div class="subject_info <?php echo ($message['Draft']['read'] == 0) ? 'subjectUnread' : '' ?>"><?php echo $message['Parent']['subject'] ?></div>
                        <div class="mail_info"><?php echo String::truncate($message['Parent']['body_plain'], 50, array('ellipsis' => '...')) ?></div>
                        <?php else: ?>
                        <div class="sender_info"><?php echo empty($message['Draft']['sender_id']) ? htmlentities($message['Draft']['sender_email']) : $message['Sender']['full_name'] ?></div>
                        <div class="subject_info"><?php echo $message['Draft']['subject'] ?></div>
                        <div class="mail_info"><?php echo String::truncate($message['Draft']['body_plain'], 50, array('ellipsis' => '...')) ?></div>                        
                        <?php endif ?>
                    </a>
                    <div class="mail_content"><?php echo !empty($message['Parent']['body_html']) ? quoted_printable_decode($message['Parent']['body_html']) : quoted_printable_decode($message['Parent']['body_plain']) ?></div>
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
            <?php if (!empty($message['Parent']['id'])): ?>
            <div style="padding-top: 10px; clear: both;"><span>From: </span><span class="senderPlaceholder"></span></div>
            <div class="subjectPlaceholder"></div>
            <hr />
            
            <div class="messagePlaceholder"></div>
            <?php endif ?>
            
            <div id="messageForm">
                <div class="messageActions actions" style="width: 100% !important; clear:both">
                    <a href="#" class="actions" id="inbox">< Back to Inbox</a> 
                    <a href="#send" class="actions" id="send">Send</a>
                    <a href="#save" class="actions" id="save">Save</a>
                    <a href="#delete" id="delete">Delete</a>
                </div>
                
                <div class="messageTo">To <input type="text" id="to" name="to" placeholder="Name or Email Address" value="<?php echo !empty($message['Draft']['recipient_id']) ? $message['Draft']['recipient_id'] : $message['Draft']['recipient_email']?>" /></div>
                <div class="messageSubject">Subject <input type="text" id="subject" name="subject" value="<?php echo $message['Draft']['subject'] ?>" /></div>
                <div class="messageAttachment"><a href="#"><sub>Attach a file</sub></a></div>
                <textarea name="message" id="message" rows="15"><?php echo $message['Draft']['body_plain'] ?></textarea>
            </div>
            
        </div>
        
    </div>
    
</div>