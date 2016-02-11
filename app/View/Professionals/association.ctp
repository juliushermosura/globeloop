<?php echo $this->Html->css("token-input-facebook") ?>

<?php echo $this->Html->script("jquery.tokeninput") ?>
<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
    
        $('#invitation').tokenInput('/users/retrieve_friends/', {
            theme: 'facebook',
            preventDuplicates: 'true',
            minChars: 2
        });
        
        $('#token-input-to').keydown(function(e) {
            if (e.which == 188 || e.which == 32 && $(this).val().length > 2) {
                $('#invitation').tokenInput('add', {id: $(this).val(), name: $(this).val()});
                return false;
            }
        });
        
        $('#show_hide_members').click(function() {
            $('.members_list').toggle()
            if ($('.members_list').is(':visible')) {
                $(this).text('Hide Members');
            } else {
                $(this).text('Show Members (" . count($data['AssociationMember']) . ")');
            }
            return false;
        });
        
        $('#friend_join_group').click(function() {
            $.ajax({
                url: '/users/friend_join_association',
                data: { user_id: $('#invitation').val(), association_id: '" . $data['Association']['id'] . "' },
                type: 'POST'
            }).done(function(msg) {
                $('#invitation').tokenInput('clear');
            }).fail(function() {
                alert('Oops! Something went wrong during adding friend to this association. You may try again later.');
            });
            return false;
        });
        
    });
                                    "); ?>

<style>
ul.token-input-list-facebook {
    height: 30px !important;
    min-width: 300px;
}
</style>

<h2><?php echo $data['Association']['title'] ?></h2>

<?php echo $this->Session->flash('auth'); ?>

<div style="margin-bottom: 10px">
    <div style="margin-bottom: 10px;">
        <?php echo $this->Html->link('Show Members (' . count($data['AssociationMember']) . ')', '#show_hide_members', array('escape' => false, 'id' => 'show_hide_members')) ?>
    </div>

    <div class="members_list">
        <?php foreach($data['AssociationMember'] as $member): ?>
            <span><?php echo ($member['User']['id'] == $this->Session->read('Auth.User.id')) ? 'You' : $this->Html->link($member['User']['full_name'], array('controller' => 'users', 'action' => 'view', $member['User']['id']), array('class' => 'show_details', 'id' => 'member-' . $member['User']['id'], 'escape' => false, 'rel' => '/users/quicklook/' . $member['User']['id'])) ?></span>
        <?php endforeach ?>
    </div>

    <div class="actions">
        <div style="display: inline-block; vertical-align: top;">Join your friends to this association </div>
        <div style="display: inline-block; height: 30px;"><input type="text" autocomplete="off" name="invitation" placeholder="Type in your friends name" id="invitation" style="height: 30px;" /></div>
        <div style="display: inline-block; vertical-align: top; line-height: 2.1"><a href="#friend_join_association" id="friend_join_association">Send</a></div>
    </div>
    
</div>

<br /><br />

<?php echo $this->element('association_posts',array('data'=>$data2, 'parent' => $data['Association']['id'], 'type'=>'Association')) ?> 

