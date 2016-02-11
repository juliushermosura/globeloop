<?php

class ProfessionalsController extends AppController {
    
    public $layout = 'professionals';
    public $uses = array('User');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('signup', 'forgot_password', 'view');
        $online = $this->Auth->loggedIn();
        if ($online) {
            $this->User->FriendFrom->unbindModel(array('belongsTo' => array('UserFrom')));
            $this->User->FriendFrom->UserTo->unbindModel(array('hasMany' => array('FriendTo', 'FriendFrom', 'GroupMember', 'Inbox', 'Sent', 'Draft', 'VideoAlbum', 'Comment', 'Like', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
            $this->User->FriendFrom->belongsTo['UserTo']['fields'] = array('id', 'full_name', 'username');
            $friends = $this->User->FriendFrom->find('all', array('conditions'=>array('FriendFrom.status' => 1,'FriendFrom.user_from' => $this->Auth->user('id')), 'contain' => array('UserTo', 'PhotoAlbum'), 'recursive' => 3
                                                   //'fields' => array('UserTo.*')
            ));
            $this->set('onlinebuddies', $friends);
        }
    }
    
    public function index() {
        //$this->redirect(array('action' => 'newsfeeds'));
    }
    
    public function forums() {
        
    }
    
    public function references() {
        
    }
    
    public function professional_help() {
        
    }
    
    public function newsfeeds() {
        $this->layout = 'users';
        $this->set('title', 'Horizon');
        $this->components[] = 'Paginator';
        $this->helpers[] = 'Paginator';
        
        /*
        $this->User->FriendFrom->unbindModel(array('belongsTo' => array('UserFrom')));
        $this->User->FriendFrom->belongsTo['UserTo']['fields'] = array('id', 'username', 'full_name');
        $this->User->FriendFrom->UserTo->unbindModel(array('hasAndBelongsToMany' => array('UserFriendship'), 'hasMany' => array('FriendFrom', 'FriendTo', 'PhotoAlbum', 'Comment', 'GroupMember', 'Inbox', 'Sent', 'Draft', 'VideoAlbum')));
        $this->paginate = array(
            'limit' => 5,
            'conditions' => array('FriendFrom.user_from' => $this->Auth->user('id'), 'FriendFrom.status' => 1),
            'recursive' => 2,
            'order' => array('NewsFeed.created' => 'desc')
        );
        $data = $this->paginate('FriendFrom');*/
        
        //$this->User->FriendFrom->unbindModel(array('belongsTo' => array('UserFrom')));
        $this->User->unbindModel(array('hasAndBelongsToMany' => array('UserFriendship'), 'hasMany' => array('NewsFeed', 'FriendFrom', 'FriendTo', 'Comment', 'GroupMember', 'Inbox', 'Sent', 'Draft', 'VideoAlbum')));
        $this->User->PhotoAlbum->unbindModel(array('belongsTo' => array('User')));
        //$this->User->PhotoAlbum->bindModel(array('hasMany' => array('Photo' => array('conditions' => array('Photo.primary' => 1, 'Photo.deleted' => 0)))));
        $this->User->hasMany['PhotoAlbum']['fields'] = array('deleted', 'id', 'primary');
        $this->User->NewsFeed->belongsTo['User']['fields'] = array('id', 'username', 'full_name', 'gender');
        //$this->User->PhotoAlbum->hasMany['Photo']['fields'] = array('photo_dir', 'photo', 'deleted', 'id', 'primary');
        //$this->User->PhotoAlbum->Photo->unbindModel(array('belongsTo' => array('PhotoAlbum')));
        $id = $this->User->FriendFrom->find('all', array('conditions' => array('FriendFrom.user_from' => $this->Auth->user('id'), 'FriendFrom.status' => 1), 'recursive' => 1, 'fields' => array('UserTo.id')));
        
        $ids = Set::extract($id, '{n}.UserTo.id');
        if (empty($ids)) {
            $ids[] =  $this->Auth->user('id');
        } else {
            array_push($ids, $this->Auth->user('id'));
        }
        $this->loadModel('NewsFeed');
        $this->NewsFeed->bindModel(array('belongsTo' => array(
                                                              'Friendship' => array('className' => 'Friendship', 'foreignKey' => 'parent_id', 'conditions' => array('NewsFeed.parent_model_name' => 'Friendship')),
                                                              'PrimaryPhoto' => array('className' => 'Photo', 'foreignKey' => 'parent_id', 'conditions' => array('NewsFeed.parent_model_name' => 'PrimaryPhoto'), 'limit' => 1, 'order' => array('NewsFeed.created' => 'desc')),
                                                              'OtherPhoto' => array('className' => 'Photo', 'foreignKey' => 'parent_id', 'conditions' => array('NewsFeed.parent_model_name' => 'OtherPhoto'), 'order' => array('NewsFeed.created' => 'desc')),
                                                              'HorizonPost' => array('className' => 'Post', 'foreignKey' => 'parent_id', 'conditions' => array('NewsFeed.parent_model_name' => 'HorizonPost'), 'order' => array('NewsFeed.created' => 'desc')),
                                                              'HorizonShare' => array('className' => 'Share', 'foreignKey' => 'parent_id', 'conditions' => array('NewsFeed.parent_model_name' => 'HorizonShare'), 'order' => array('NewsFeed.created' => 'desc'))                                                              
                                                              )
                                         )
                                   );
        $this->NewsFeed->Friendship->unbindModel(array('hasMany' => array('Inbox', 'Sent', 'Draft'), 'belongsTo' => array('UserFrom')));
        $this->NewsFeed->Friendship->UserTo->unbindModel(array('hasMany' => array('Comment', 'FriendFrom', 'FriendTo', 'GroupMember', 'Inbox', 'Sent', 'Draft', 'NewsFeed', 'VideoAlbum'), 'hasAndBelongsToMany' => array('UserFriendship')));
        $this->NewsFeed->Friendship->UserTo->hasMany['PhotoAlbum']['fields'] = array('deleted', 'id', 'primary');
        $this->NewsFeed->Friendship->UserTo->PhotoAlbum->hasMany['Photo']['conditions'] = array('Photo.primary' => 1, 'Photo.deleted' => 0);
        $this->NewsFeed->Friendship->UserTo->PhotoAlbum->hasMany['Photo']['fields'] = array('photo_dir', 'photo', 'deleted', 'id', 'primary');
        
        $this->NewsFeed->belongsTo['PrimaryPhoto']['fields'] = array('id', 'deleted', 'primary', 'photo_dir', 'photo', 'photo_album_id');
        $this->NewsFeed->PrimaryPhoto->bindModel(array('belongsTo' => array('PhotoAlbum' => array('foreignKey' => 'photo_album_id'))));
        $this->NewsFeed->PrimaryPhoto->hasMany['Like']['fields'] = array('id', 'user_id', 'like');
        $this->NewsFeed->PrimaryPhoto->belongsTo['PhotoAlbum']['fields'] = array('title');
        $this->NewsFeed->PrimaryPhoto->Like->belongsTo['User']['fields'] = array('id', 'username', 'full_name');
        
        $this->NewsFeed->belongsTo['OtherPhoto']['fields'] = array('id', 'deleted', 'primary', 'photo_dir', 'photo', 'photo_album_id');
        $this->NewsFeed->OtherPhoto->bindModel(array('belongsTo' => array('PhotoAlbum2' => array('className' => 'PhotoAlbum', 'foreignKey' => 'photo_album_id'))));
        $this->NewsFeed->OtherPhoto->unbindModel(array('belongsTo' => array('PhotoAlbum')));
        $this->NewsFeed->OtherPhoto->hasMany['Like']['fields'] = array('id', 'user_id', 'like');
        $this->NewsFeed->OtherPhoto->PhotoAlbum2->unbindModel(array('belongsTo' => array('User')));
        $this->NewsFeed->OtherPhoto->PhotoAlbum2->hasMany['Photo']['conditions'] = array('Photo.deleted' => 0);
        $this->NewsFeed->OtherPhoto->PhotoAlbum2->hasMany['Like']['fields'] = array('id', 'user_id', 'like');
        $this->NewsFeed->OtherPhoto->belongsTo['PhotoAlbum2']['fields'] = array('title', 'id');
        $this->NewsFeed->OtherPhoto->PhotoAlbum2->hasMany['Photo']['fields'] = array('photo', 'photo_dir', 'id');
        $this->NewsFeed->OtherPhoto->Like->belongsTo['User']['fields'] = array('id', 'username', 'full_name');
        $this->NewsFeed->OtherPhoto->PhotoAlbum2->Like->belongsTo['User']['fields'] = array('id', 'username', 'full_name');
        
        $this->NewsFeed->belongsTo['HorizonPost']['fields'] = array('id', 'content');
        $this->NewsFeed->HorizonPost->unbindModel(array('belongsTo' => array('User')));
        $this->NewsFeed->HorizonPost->hasMany['Like']['fields'] = array('id', 'user_id', 'like');
        $this->NewsFeed->HorizonPost->Like->belongsTo['User']['fields'] = array('id', 'username', 'full_name');
        //$this->NewsFeed->HorizonPost->hasMany['Comment']['fields'] = array('id', 'user_id',);
        $this->NewsFeed->HorizonPost->Comment->belongsTo['User']['fields'] = array('id', 'username', 'full_name');
        
        $this->NewsFeed->belongsTo['HorizonShare']['fields'] = array('id', 'content');
        $this->NewsFeed->HorizonShare->unbindModel(array('belongsTo' => array('User')));
        $this->NewsFeed->HorizonShare->hasMany['Like']['fields'] = array('id', 'user_id', 'like');
        $this->NewsFeed->HorizonShare->Like->belongsTo['User']['fields'] = array('id', 'username', 'full_name');
        //$this->NewsFeed->HorizonPost->hasMany['Comment']['fields'] = array('id', 'user_id',);
        $this->NewsFeed->HorizonShare->Comment->belongsTo['User']['fields'] = array('id', 'username', 'full_name');
        
        //cleanups for recursive 4
        $this->NewsFeed->User->PhotoAlbum->Photo->unbindModel(array('belongsTo' => array('PhotoAlbum'), 'hasMany' => array('Like')));
        $this->NewsFeed->User->PhotoAlbum->unbindModel(array('hasMany' => array('Like')));
        
        //$this->NewsFeed->OtherPhoto->Like->User->unbindModel(array('hasMany' => array('PhotoAlbum')));
        
        //$this->NewsFeed->Friendship->UserTo->unbindModel(array('hasMany' => array('PhotoAlbum')));
        
        $this->NewsFeed->Friendship->belongsTo['UserTo']['fields'] = array('id', 'username', 'full_name');
        //pr($ids);
        $this->paginate = array(
            'limit' => 15,
            'conditions' => array('NewsFeed.user_id' => $ids, 'NewsFeed.deleted' => 0),
            'recursive' => 5,
            'order' => array('NewsFeed.created' => 'desc')
        );
        $data = $this->paginate('NewsFeed');
        $this->set('data', $data);
    }
    
    public function groups() {
        $this->layout = 'professionals';
        $this->set('title', 'Professional Groups');
        $data = $this->User->GroupMember->find('all', array('conditions' => array('GroupMember.deleted' => 0, 'GroupMember.user_id' => $this->Auth->user('id'))));
        $this->set('data', $data);
    }
    
    public function group($id = null) {
        $this->layout = 'professionals';
        $this->set('title', 'Professional Groups');
        if (!empty($id)) {
            $this->User->unbindModel(array('hasMany' => array('Inbox', 'Sent', 'Draft', 'FriendFrom', 'FriendTo', 'GroupMember', 'VideoAlbum', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
            $this->User->GroupMember->Group->GroupMember->unbindModel(array('belongsTo' => array('Group')));
            $this->User->GroupMember->Group->GroupMember->User->unbindModel(array('hasMany' => array('Comment', 'PhotoAlbum')));
            $this->User->GroupMember->Group->unbindModel(array('hasMany' => array('Post')));
            $this->User->GroupMember->Group->GroupMember->User->PhotoAlbum->Photo->unbindModel(array('belongsTo' => array('PhotoAlbum')));
            $this->User->GroupMember->Group->Post->belongsTo['User']['fields'] = array('User.username', 'User.full_name', 'User.id');
            //$this->User->GroupMember->Group->Post->Comment->belongsTo['User']['fields'] = array('User.username', 'User.full_name', 'User.id');
            $this->User->GroupMember->Group->hasMany['GroupMember']['fields'] = array('GroupMember.id', 'GroupMember.user_id');
            $this->User->GroupMember->Group->GroupMember->belongsTo['User']['fields'] = array('User.username', 'User.full_name', 'User.id');
            //$this->User->GroupMember->Group->GroupMember->User->hasMany['PhotoAlbum']['fields'] = array('PhotoAlbum.id');
            //$this->User->GroupMember->Group->GroupMember->User->PhotoAlbum->hasMany['Photo']['conditions'] = array('Photo.primary' => 1, 'Photo.deleted' => 0);
            //$this->User->GroupMember->Group->GroupMember->User->PhotoAlbum->hasMany['Photo']['fields'] = array('Photo.photo_dir', 'Photo.photo');
            $this->User->PhotoAlbum->unbindModel(array('belongsTo' => array('User')));
            $data = $this->User->GroupMember->Group->find('first', array('conditions' => array('Group.id' => $id), 'recursive' => 5));
            if (!$this->__isMemberOfGroup($data)) {
                $this->render('not_allowed');
            }
            $this->components[] = 'Paginator';
            $this->helpers[] = 'Paginator';
            $this->loadModel('Post');
            $this->Post->User->unbindModel(array('hasAndBelongsToMany' => array('UserFriendship'), 'hasMany' => array('Comment', 'FriendFrom', 'FriendTo', 'Inbox', 'Sent', 'Draft', 'GroupMember', 'VideoAlbum', 'NewsFeed')));
            $this->Post->User->PhotoAlbum->unbindModel(array('belongsTo' => array('User')));
            $this->Post->User->unbindModel(array('hasMany' => array('Like')));
            $this->Post->Comment->Like->belongsTo['User']['fields'] = array('id', 'username', 'full_name');
            $this->Post->User->PhotoAlbum->Photo->unbindModel(array('belongsTo' => array('PhotoAlbum')));
            $this->Post->User->hasMany['PhotoAlbum']['fields'] = array('PhotoAlbum.id', 'PhotoAlbum.primary', 'PhotoAlbum.deleted');
            $this->Post->Comment->belongsTo['User']['fields'] = array('User.full_name', 'User.id', 'User.username');
            $this->Post->User->PhotoAlbum->hasMany['Photo']['conditions'] = array('Photo.primary' => 1, 'Photo.deleted' => 0);
            $this->Post->User->PhotoAlbum->hasMany['Photo']['fields'] = array('Photo.photo_dir', 'Photo.photo', 'Photo.primary', 'Photo.deleted');
            $this->paginate = array(
                'limit' => 2,
                'conditions' => array('Post.parent_id' => $id, 'Post.parent_model_name' => 'Group', 'Post.deleted' => 0),
                'recursive' => 4,
                'order' => array('Post.created' => 'desc')
            );
            $data2 = $this->paginate('Post');
            //pr($data2);
            $this->set(compact('data', 'data2'));
        }
    }
    
    private function __isMemberOfGroup($data = null) {
        $ids = array();
        foreach($data['GroupMember'] as $d) {
            array_push($ids, $d['user_id']);
        }
        return in_array($this->Auth->user('id'), $ids);
    }
    
    public function friend_join_group() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $user_ids = explode(',', $this->data['user_id']);
            foreach($user_ids as $id) {
                if ($this->User->exists($id) && $this->User->GroupMember->Group->exists($this->data['group_id'])) {
                    unset($already_member);
                    $already_member = $this->User->GroupMember->find('first', array('conditions' => array('GroupMember.user_id' => $id, 'GroupMember.group_id' => $this->data['group_id'])));
                    if (empty($already_member)) {
                        $data[] = array('GroupMember' => array('user_id' => $id, 'group_id' => $this->data['group_id']));
                    }
                }
            }
            if (!empty($data)) {
                $this->User->GroupMember->create();
                if ($this->User->GroupMember->saveAll($data)) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                echo 'not exist';
            }
        }
    }
    
    public function group_post() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if (!empty($this->data['content'])) {
                if ($this->User->GroupMember->Group->exists($this->data['parent_id'])) {
                    $this->loadModel('Post');
                    $data['Post'] = array('content' => $this->data['content'], 'user_id' => $this->Auth->user('id'), 'parent_id' => $this->data['parent_id'], 'parent_model_name' => 'Group');
                    if ($this->Post->save($data)) {
                        echo $this->Post->getLastInsertId();
                    } else {
                        echo 'failed';
                    }
                } else {
                    echo 'not exist';
                }
            }
        }
    }
    
    public function remove_post() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if (!empty($this->data['id'])) {
                $this->loadModel('Post');
                if ($this->Post->exists($this->data['id'])) {
                    $data['Post'] = array('deleted' => 1, 'user_id' => $this->Auth->user('id'), 'id' => $this->data['id'], 'deleted_on' => date('Y-m-d H:i:s'));
                    if ($this->Post->save($data)) {
                        echo 'success';
                    } else {
                        echo 'failed';
                    }
                }
            }
        }
    }
    
    public function remove_newsfeed() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if (!empty($this->data['id'])) {
                $this->loadModel('NewsFeed');
                if ($this->NewsFeed->exists($this->data['id'])) {
                    $data['NewsFeed'] = array('deleted' => 1, 'id' => $this->data['id'], 'deleted_on' => date('Y-m-d H:i:s'));
                    if ($this->NewsFeed->save($data)) {
                        echo 'success';
                    } else {
                        echo 'failed';
                    }
                }
            }
        }
    }
    
    public function add_group() {
        $this->set('title', 'Groups');
        $this->layout = 'users';
        $this->User->FriendFrom->unbindModel(array('hasMany' => array('Inbox', 'Sent', 'Draft', 'FriendFrom', 'FriendTo', 'VideoAlbum', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
        $data = $this->User->FriendFrom->find('all', array('conditions'=>array('FriendFrom.user_from' => $this->Auth->user('id')), 'contain' => array('UserTo')));
        
        $this->set('friends', $data);
        if ($this->request->is('post')) {
            //check for existing title
            //if title exists, add (n) on the title before saving
            $this->request->data['Group']['title'] = $this->__existing_group_title($this->data['Group']['title']);
            $params = array();
            parse_str($this->data['Group']['selected_friends'], $params);
            if ($this->User->GroupMember->Group->save($this->data)) {
                $group_id = $this->User->GroupMember->Group->getLastInsertId();
                $members[] = array('GroupMember' => array('group_id' => $group_id, 'user_id' => $this->Auth->user('id')));
                foreach ($params['selectedFriend'] as $friendID) {
                    $members[] = array('GroupMember' => array('group_id' => $group_id, 'user_id' => $friendID));
                }
                $this->User->GroupMember->saveAll($members);
                $this->Session->setFlash('You have successfully created a group.', 'default', array('class' => 'success'), 'user');
                $this->redirect(array('controller' => 'users', 'action' => 'group', $group_id));
            }
        }
    }
    
    private function __existing_group_title($title = null) {
        $loop = true;
        $i = 0;
        $orig_title = $title;
        while ($loop == true) {
            $groups = $this->User->GroupMember->Group->find('all', array('conditions' => array('Group.title' => $title, 'Group.deleted' => 0), 'recursive' => -1));
            if (!empty($groups)) {
                foreach ($groups as $group) {
                    $is_member = $this->User->GroupMember->find('count', array('conditions' => array('GroupMember.user_id' => $this->Auth->user('id'), 'GroupMember.group_id' => $group['Group']['id'], 'GroupMember.deleted' => 0)));
                    if (!empty($is_member)) {
                        $i++;
                        $title = $orig_title . ' (' . $i . ')';
                        continue;
                    }
                }
            } else {
                $loop = false;
            }
        }
        return $title;
    }
    
    public function leave_group($id = null) {
        $this->layout = 'users';
        if (!empty($id)) {
            //find out if user is the last member then delete this group
            $group_members = $this->User->GroupMember->find('count', array('conditions' => array('GroupMember.deleted' => 0, 'GroupMember.group_id' => $id)));
            if ($group_members <= 1) {
                //if last member, then delete the group as well
                $data = array('Group' => array('id' => $id, 'deleted' => 1, 'deleted_on' => date('Y-m-d H:i:s')));
                $this->User->GroupMember->Group->save($data);
            }
            unset($data);
            $group_member_id = $this->User->GroupMember->find('first', array('conditions' => array('GroupMember.deleted' => 0, 'GroupMember.group_id' => $id, 'GroupMember.user_id' => $this->Auth->user('id'))));
            $data = array('GroupMember' => array('id' => $group_member_id['GroupMember']['id'], 'deleted' => 1, 'deleted_on' => date('Y-m-d H:i:s')));
            $this->User->GroupMember->save($data);
        }
        $this->redirect(array('controller' => 'users', 'action' => 'groups'));
    }
    
    public function associations() {
        $this->layout = 'professionals';
        $this->set('title', 'Industry Related Associations');
        $data = $this->User->AssociationMember->find('all', array('conditions' => array('AssociationMember.deleted' => 0, 'AssociationMember.user_id' => $this->Auth->user('id'))));
        $this->set('data', $data);
    }
    
    public function association($id = null) {
        $this->layout = 'professionals';
        $this->set('title', 'Industry Related Association: ');
        if (!empty($id)) {
            $this->User->unbindModel(array('hasMany' => array('Inbox', 'Sent', 'Draft', 'FriendFrom', 'FriendTo', 'AssociationMember', 'VideoAlbum', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
            $this->User->AssociationMember->Association->AssociationMember->unbindModel(array('belongsTo' => array('Association')));
            $this->User->AssociationMember->Association->AssociationMember->User->unbindModel(array('hasMany' => array('Comment', 'PhotoAlbum')));
            $this->User->AssociationMember->Association->unbindModel(array('hasMany' => array('Post')));
            $this->User->AssociationMember->Association->AssociationMember->User->PhotoAlbum->Photo->unbindModel(array('belongsTo' => array('PhotoAlbum')));
            $this->User->AssociationMember->Association->Post->belongsTo['User']['fields'] = array('User.username', 'User.full_name', 'User.id');
            //$this->User->GroupMember->Group->Post->Comment->belongsTo['User']['fields'] = array('User.username', 'User.full_name', 'User.id');
            $this->User->AssociationMember->Association->hasMany['GroupMember']['fields'] = array('AssociationMember.id', 'AssociationMember.user_id');
            $this->User->AssociationMember->Association->AssociationMember->belongsTo['User']['fields'] = array('User.username', 'User.full_name', 'User.id');
            //$this->User->GroupMember->Group->GroupMember->User->hasMany['PhotoAlbum']['fields'] = array('PhotoAlbum.id');
            //$this->User->GroupMember->Group->GroupMember->User->PhotoAlbum->hasMany['Photo']['conditions'] = array('Photo.primary' => 1, 'Photo.deleted' => 0);
            //$this->User->GroupMember->Group->GroupMember->User->PhotoAlbum->hasMany['Photo']['fields'] = array('Photo.photo_dir', 'Photo.photo');
            $this->User->PhotoAlbum->unbindModel(array('belongsTo' => array('User')));
            $data = $this->User->AssociationMember->Group->find('first', array('conditions' => array('Group.id' => $id), 'recursive' => 5));
            if (!$this->__isMemberOfAssociation($data)) {
                $this->render('not_allowed');
            }
            $this->components[] = 'Paginator';
            $this->helpers[] = 'Paginator';
            $this->loadModel('Post');
            $this->Post->User->unbindModel(array('hasAndBelongsToMany' => array('UserFriendship'), 'hasMany' => array('Comment', 'FriendFrom', 'FriendTo', 'Inbox', 'Sent', 'Draft', 'AssociationMember', 'VideoAlbum', 'NewsFeed')));
            $this->Post->User->PhotoAlbum->unbindModel(array('belongsTo' => array('User')));
            $this->Post->User->unbindModel(array('hasMany' => array('Like')));
            $this->Post->Comment->Like->belongsTo['User']['fields'] = array('id', 'username', 'full_name');
            $this->Post->User->PhotoAlbum->Photo->unbindModel(array('belongsTo' => array('PhotoAlbum')));
            $this->Post->User->hasMany['PhotoAlbum']['fields'] = array('PhotoAlbum.id', 'PhotoAlbum.primary', 'PhotoAlbum.deleted');
            $this->Post->Comment->belongsTo['User']['fields'] = array('User.full_name', 'User.id', 'User.username');
            $this->Post->User->PhotoAlbum->hasMany['Photo']['conditions'] = array('Photo.primary' => 1, 'Photo.deleted' => 0);
            $this->Post->User->PhotoAlbum->hasMany['Photo']['fields'] = array('Photo.photo_dir', 'Photo.photo', 'Photo.primary', 'Photo.deleted');
            $this->paginate = array(
                'limit' => 2,
                'conditions' => array('Post.parent_id' => $id, 'Post.parent_model_name' => 'Group', 'Post.deleted' => 0),
                'recursive' => 4,
                'order' => array('Post.created' => 'desc')
            );
            $data2 = $this->paginate('Post');
            //pr($data2);
            $this->set(compact('data', 'data2'));
        }
    }
    
    private function __isMemberOfAssociation($data = null) {
        $ids = array();
        foreach($data['AssociationMember'] as $d) {
            array_push($ids, $d['user_id']);
        }
        return in_array($this->Auth->user('id'), $ids);
    }
    
    public function friend_join_association() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $user_ids = explode(',', $this->data['user_id']);
            foreach($user_ids as $id) {
                if ($this->User->exists($id) && $this->User->AssociationMember->Association->exists($this->data['association_id'])) {
                    unset($already_member);
                    $already_member = $this->User->AssociationMember->find('first', array('conditions' => array('AssociationMember.user_id' => $id, 'AssociationMember.association_id' => $this->data['association_id'])));
                    if (empty($already_member)) {
                        $data[] = array('AssociationMember' => array('user_id' => $id, 'group_id' => $this->data['association_id']));
                    }
                }
            }
            if (!empty($data)) {
                $this->User->AssociationMember->create();
                if ($this->User->AssociationMember->saveAll($data)) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                echo 'not exist';
            }
        }
    }
    
    public function association_post() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if (!empty($this->data['content'])) {
                if ($this->User->AssociationMember->Association->exists($this->data['parent_id'])) {
                    $this->loadModel('Post');
                    $data['Post'] = array('content' => $this->data['content'], 'user_id' => $this->Auth->user('id'), 'parent_id' => $this->data['parent_id'], 'parent_model_name' => 'Association');
                    if ($this->Post->save($data)) {
                        echo $this->Post->getLastInsertId();
                    } else {
                        echo 'failed';
                    }
                } else {
                    echo 'not exist';
                }
            }
        }
    }
    
    public function add_association() {
        $this->set('title', 'Industry Related Associations');
        $this->layout = 'users';
        $this->User->FriendFrom->unbindModel(array('hasMany' => array('Inbox', 'Sent', 'Draft', 'FriendFrom', 'FriendTo', 'VideoAlbum', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
        $data = $this->User->FriendFrom->find('all', array('conditions'=>array('FriendFrom.user_from' => $this->Auth->user('id')), 'contain' => array('UserTo')));
        
        $this->set('friends', $data);
        if ($this->request->is('post')) {
            //check for existing title
            //if title exists, add (n) on the title before saving
            $this->request->data['Association']['title'] = $this->__existing_association_title($this->data['Association']['title']);
            $params = array();
            parse_str($this->data['Association']['selected_friends'], $params);
            if ($this->User->AssociationMember->Association->save($this->data)) {
                $group_id = $this->User->AssociationMember->Association->getLastInsertId();
                $members[] = array('AssociationMember' => array('association_id' => $association_id, 'user_id' => $this->Auth->user('id')));
                foreach ($params['selectedFriend'] as $friendID) {
                    $members[] = array('AssociationMember' => array('association_id' => $association_id, 'user_id' => $friendID));
                }
                $this->User->AssociationMember->saveAll($members);
                $this->Session->setFlash('You have successfully created a association.', 'default', array('class' => 'success'), 'user');
                $this->redirect(array('controller' => 'users', 'action' => 'group', $association_id));
            }
        }
    }
    
    private function __existing_association_title($title = null) {
        $loop = true;
        $i = 0;
        $orig_title = $title;
        while ($loop == true) {
            $associations = $this->User->AssociationMember->Association->find('all', array('conditions' => array('Association.title' => $title, 'Association.deleted' => 0), 'recursive' => -1));
            if (!empty($associations)) {
                foreach ($associations as $association) {
                    $is_member = $this->User->AssociationMember->find('count', array('conditions' => array('AssociationMember.user_id' => $this->Auth->user('id'), 'AssociationMember.association_id' => $association['Association']['id'], 'AssociationMember.deleted' => 0)));
                    if (!empty($is_member)) {
                        $i++;
                        $title = $orig_title . ' (' . $i . ')';
                        continue;
                    }
                }
            } else {
                $loop = false;
            }
        }
        return $title;
    }
    
    public function leave_association($id = null) {
        $this->layout = 'users';
        if (!empty($id)) {
            //find out if user is the last member then delete this group
            $association_members = $this->User->AssociationMember->find('count', array('conditions' => array('AssociationMember.deleted' => 0, 'AssociationMember.association_id' => $id)));
            if ($association_members <= 1) {
                //if last member, then delete the group as well
                $data = array('Association' => array('id' => $id, 'deleted' => 1, 'deleted_on' => date('Y-m-d H:i:s')));
                $this->User->AssociationMember->Association->save($data);
            }
            unset($data);
            $association_member_id = $this->User->AssociationMember->find('first', array('conditions' => array('AssociationMember.deleted' => 0, 'AssociationMember.group_id' => $id, 'AssociationMember.user_id' => $this->Auth->user('id'))));
            $data = array('AssociationMember' => array('id' => $association_member_id['AssociationMember']['id'], 'deleted' => 1, 'deleted_on' => date('Y-m-d H:i:s')));
            $this->User->AssociationMember->save($data);
        }
        $this->redirect(array('controller' => 'users', 'action' => 'associations'));
    }
    
}

?>