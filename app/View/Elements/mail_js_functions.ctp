<?php echo $this->Html->css("token-input-facebook") ?>

<?php echo $this->Html->script("jquery.tokeninput") ?>
<?php echo $this->Html->script("jquery.infinitescroll.min") ?>

<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
        var options = {};
        var selectedMail;

        $('#contentarea').on('click', '.readMail', function(event) {
            $('#messagePage').animate({ right: '715' });
            $('.senderPlaceholder').text($(this).children('.sender_info').text());
            $('.subjectPlaceholder').text($(this).children('.subject_info').text());
            $('.messagePlaceholder').html($(this).next('.mail_content').html());
            selectedMail = $(this).parents('.user_mail_details').prop('id');
            $('#id').val(selectedMail.replace('mail-', ''));
            $('#parent').val($(this).next('.parent').text());
            markasread(selectedMail);
            return false;
        });
        
        $('#inbox').click(function() {
            back2inbox();
            return false;
        });
        
        $('#send').click(function() {
            sendmail(selectedMail);
            return false;
        });
        
        $('#save').click(function() {
            savemail(selectedMail);
            return false;
        });
        
        $('#reply').click(function() {
            $('#messageForm').show('slide', {direction:'up'}, 1000);
            $('html, body').animate({ scrollTop: $('#message').offset().top }, 500);
            $('#to').val($('.senderPlaceholder').text());
            $('#subject').val('Re: ' + $('.subjectPlaceholder').text());
            return false;
        });
        
        $('#forward').click(function() {
            $('#messageForm').show('slide', {direction:'up'}, 1000);
            $('html, body').animate({ scrollTop: $('#message').offset().top }, 500);
            $('#to').val('');
            $('#subject').val('Fwd: ' + $('.subjectPlaceholder').text());
            return false;
        });
        
        $('#markasunread').click(function() {
            markasunread(selectedMail);
            back2inbox();
            return false;
        });
        
        $('#delete').click(function() {
            deletemail(selectedMail);
            back2inbox();
            return false;
        });
        
        $('#cancel').click(function() {
            $('#to').val('');
            $('#subject').val('');
            $('#message').val('');
            $('#messageForm').hide();
            $('html, body').animate({ scrollTop: $('#container').offset().top }, 500);
            return false;
        });
        
        function markasread(e) {
            if ($('#'+e).has('.subjectUnread')) {
                $.ajax({
                    url: '/users/mark_as_read/' + e.replace('mail-', ''),
                    type: 'GET'
                }).done(function() {
                    if (parseInt($('.unreadCount').text()) > 1) {
                        if ($('#' + e).find('.subject_info').hasClass('subjectUnread'))
                            $('.unreadCount').text(parseInt($('.unreadCount').text()) - 1);
                    } else {
                        $('.encloser').remove();
                    }
                    $('#' + e).find('.subject_info').removeClass('subjectUnread');
                }).fail(function() {
                    location.reload();
                });
            }
            return false;
        }
        
        function markasunread(e) {
            $.ajax({
                url: '/users/mark_as_unread/' + e.replace('mail-', ''),
                type: 'GET'
            }).done(function() {
                $('#' + e).find('.subject_info').addClass('subjectUnread');
            }).fail(function() {
                location.reload();
            });
            return false;
        }
        
        function back2inbox() {
            $('#messagePage').animate({ right: '0' });
            $('.subjectPlaceholder').text('');
            $('.messagePlaceholder').html('');
            $('#messageForm').hide();
            $('html, body').animate({ scrollTop: $('#container').offset().top }, 500);
        }

        function sendmail(e) {
            var parentMail;
            if ($('#parent').val().length == 0) {
                parentMail = selectedMail.replace('mail-', '');
            } else {
                parentMail = $('#parent').val();
            }
            $.ajax({
                url: '/users/send_mail/',
                type: 'POST',
                data: {
                    id: $('#id').val(),
                    to: $('#to').val(),
                    subject: $('#subject').val(),
                    parentmail: parentMail,
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
            var parentMail;
            if ($('#parent').val().length == 0) {
                parentMail = selectedMail.replace('mail-', '');
            } else {
                parentMail = $('#parent').val();
            }
            $.ajax({
                url: '/users/save_mail/',
                type: 'POST',
                data: {
                    id: $('#id').val(),
                    to: $('#to').val(),
                    subject: $('#subject').val(),
                    parent: parentMail,
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
        
        function deletemail(e) {
            $.ajax({
                url: '/users/delete_mail/' + e.replace('mail-', ''),
                type: 'GET'
            }).done(function() {
                $('#'+e).remove();
                if ($('.user_mail_details').size() == 0) {
                    $('.messageslist').html('<p>No message.</p>');
                }
            }).fail(function() {
                location.reload();
            });
            return false;
        }
        
        $('.pagesX').infinitescroll({
            navSelector  : 'div.pageNav',            
            nextSelector : 'div.pageNav .next a',    
            itemSelector : '.pagesX',
            loading: {
                finishedMsg: '<em>That\'s all your mail.</em>',
                msgText: '<em>Retrieving more mails...</em>',
            }
        });
        
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
        //@TODO: get email address highlighted with token-input & get user id be converted to token-input & get name to be converted to token-input
    });
") ?>