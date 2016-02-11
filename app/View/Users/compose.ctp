<?php echo $this->Html->css("token-input-facebook") ?>

<?php echo $this->Html->script("jquery.tokeninput") ?>

<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
        
        $('#send').click(function() {
            sendmail();
            return false;
        });
        
        $('#save').click(function() {
            savemail();
            return false;
        });
        
        function sendmail(e) {
            if ($('#to').val().length == 0) {
                $('#to').parent().addClass('error');
                $('#to').parent().append('<div class=\"error-message\">A valid recipient is required.</div>');
                return false;
            }
            $.ajax({
                url: '/users/send_mail/',
                type: 'POST',
                data: {
                    id: $('#id').val(),
                    to: $('#to').val(),
                    subject: $('#subject').val(),
                    parentmail: $('#parent').val(),
                    message: $('#message').val()
                }
            }).done(function() {
                location.href = '/users/inbox';
            }).fail(function() {
                location.reload();
            });
            return false;
        }
        
        function savemail(e) {
            $.ajax({
                url: '/users/save_mail/',
                type: 'POST',
                data: {
                    id: $('#id').val(),
                    to: $('#to').val(),
                    subject: $('#subject').val(),
                    parent: $('#parent').val(),
                    message: $('#message').val()
                }
            }).done(function(msg) {
                if (msg.length > 0) {
                    $('#id').val(msg);
                }
            }).fail(function() {
                location.reload();
            });
            return false;
        }
        
        function isValidEmailAddress(e) {
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (filter.test(e)) {
                return true;
            }
            else {
                return false;
            }
        };
        
        $('#to').tokenInput('/users/retrieve_friends/', {
            theme: 'facebook',
            preventDuplicates: 'true',
            minChars: 2
        });
        
        $('#token-input-to').keydown(function(e) {
            if (e.which == 188 || e.which == 32 && $(this).val().length > 2) {
                $('#to').tokenInput('add', {id: $(this).val(), name: $(this).val()});
                return false;
            }
        }).focusout(function() {
            if ($(this).val().length > 2) {
                if (isValidEmailAddress($(this).val())) {
                    $('#to').tokenInput('add', {id: $(this).val(), name: $(this).val()});
                }
            }
        });
        
    });
") ?>

<?php echo $this->element('mail_search') ?>

<form style="margin-right: 0; width: 100%">
    
<input type="hidden" name="mailid" id="id" value="" />
<input type="hidden" name="parent" id="parent" value="" />

<div id="messageForm" style="display:block; margin-top: 10px">
    <div class="messageActions actions" style="width: 100% !important; clear:both">
        <a href="/users/inbox" class="actions">< Back to Inbox</a> 
        <a href="#send" class="actions" id="send">Send</a>
        <a href="#save" class="actions" id="save">Save</a>
    </div>
    
    <div class="messageTo" style="margin-top: 50px">To <input type="text" id="to" autocomplete="off" name="to" placeholder="Name or Email Address" value="" /></div>
    <div class="messageSubject">Subject <input type="text" id="subject" name="subject" value="" /></div>
    <div class="messageAttachment"><a href="#"><sub>Attach a file</sub></a></div>
    <textarea name="message" id="message" rows="15"></textarea>
</div>

</form>

<br />