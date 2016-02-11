<?php

class UsersController extends AppController {

    public $helpers = array('Js' => array('Jquery'));
    public $paginate;

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

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Session->write('userid', $this->Auth->user('id'), $encrypt = false);
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Invalid username/email address or password, try again.'));
            }
        }
    }
    
    public function logout() {
        $this->Session->destroy();
        $this->redirect($this->Auth->logout());
    }
    
    public function index() {
        $this->layout = 'users';
        $this->set('title', 'Horizon');
        $this->redirect(array('action' => 'horizon'));
    }
    
    public function horizon() {
        //pr($this->Session);
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
    
    public function selections() {
        $this->layout = 'users';
        $this->set('title', 'Selections');
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
        $id = $this->User->FriendFrom->find('all', array('conditions' => array('FriendFrom.user_from' => $this->Auth->user('id'), 'FriendFrom.status' => 1, 'FriendFrom.selection' => 1), 'recursive' => 1, 'fields' => array('UserTo.id')));
        
        $ids = Set::extract($id, '{n}.UserTo.id');
        array_push($ids, $this->Auth->user('id'));
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
    
    public function forgot_password() {
        
    }
    
    public function signup() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Welcome to Globeloop'), 'default', array('class' => 'success'));
                $this->Auth->login($this->request->data['User']);
                $userId = $this->User->getLastInsertId();
                $data['PhotoAlbum'] = array('title' => 'Random Photos', 'user_id' => $userId, 'primary' => 0);
                $this->User->PhotoAlbum->create();
                $this->User->PhotoAlbum->save($data);
                unset($data);
                $data['PhotoAlbum'] = array('title' => 'Primary Photos', 'user_id' => $userId, 'primary' => 1);
                $this->User->PhotoAlbum->create();
                $this->User->PhotoAlbum->save($data);
                unset($data);
                $data['VideoAlbum'] = array('title' => 'Videos', 'user_id' => $userId);
                $this->User->VideoAlbum->save($data);
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
    }
    
    /*
    public function fix_default_albums() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $users = $this->User->find('all', array('fields' => array('id'), 'recursive' => -1));
        foreach($users as $user) {
            unset($primary_exists);
            $primary_exists = $this->User->PhotoAlbum->find('all', array('conditions' => array('PhotoAlbum.user_id' => $user['User']['id'], 'PhotoAlbum.primary' => 1, 'PhotoAlbum.deleted' => 0)));
            if (empty($primary_exists)) {
                unset($data);
                $data = array('PhotoAlbum' => array('user_id' => $user['User']['id'], 'primary' => 1, 'title' => 'Primary Photos'));
                $this->User->PhotoAlbum->create();
                $this->User->PhotoAlbum->save($data);
            }
            unset($random_exists);
            $random_exists = $this->User->PhotoAlbum->find('all', array('conditions' => array('PhotoAlbum.user_id' => $user['User']['id'], 'PhotoAlbum.title' => 'Random Photos', 'PhotoAlbum.deleted' => 0)));
            if (empty($random_exists)) {
                unset($data);
                $data = array('PhotoAlbum' => array('user_id' => $user['User']['id'], 'title' => 'Random Photos', 'primary' => 0));
                $this->User->PhotoAlbum->create();
                $this->User->PhotoAlbum->save($data);
            }
            unset($primary_exists);
            $video_exists = $this->User->VideoAlbum->find('all', array('conditions' => array('VideoAlbum.user_id' => $user['User']['id'], 'VideoAlbum.title' => 'Random Photos', 'VideoAlbum.deleted' => 0)));
            if (empty($video_exists)) {
                unset($data);
                $data = array('VideoAlbum' => array('user_id' => $user['User']['id'], 'title' => 'Videos'));
                $this->User->VideoAlbum->create();
                $this->User->VideoAlbum->save($data);
            }
            echo ' oh yeah';
        }
    } */
        
    public function view($user = null) {
        $this->layout = 'public';
        
        if ($this->User->exists($user)) {
            $this->User->FriendFrom->unbindModel(array('belongsTo' => array('UserFrom')));
            $this->User->FriendFrom->UserTo->unbindModel(array('hasMany' => array('FriendTo', 'FriendFrom', 'GroupMember', 'Inbox', 'Sent', 'Draft', 'VideoAlbum', 'Comment', 'Like', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
            $this->User->unbindModel(array('hasAndBelongsToMany' => array('UserFriendship'), 'hasMany' => array('NewsFeed', 'Inbox', 'Sent', 'Draft', 'FriendTo')));
            $data = $this->User->find('first', array('conditions' => array('User.id' => $user), 'recursive' => 2));
            $id = $user;
        } else {
            $this->User->FriendFrom->unbindModel(array('belongsTo' => array('UserFrom')));
            $this->User->FriendFrom->UserTo->unbindModel(array('hasMany' => array('FriendTo', 'FriendFrom', 'GroupMember', 'Inbox', 'Sent', 'Draft', 'VideoAlbum', 'Comment', 'Like', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
            $this->User->unbindModel(array('hasAndBelongsToMany' => array('UserFriendship'), 'hasMany' => array('NewsFeed', 'Inbox', 'Sent', 'Draft', 'FriendTo')));
            $data = $this->User->find('first', array('conditions' => array('User.username' => $user), 'recursive' => 2));
            $id = $data['User']['id'];
        }
        $this->loadModel('NewsFeed');
        $this->NewsFeed->bindModel(array('belongsTo' => array(
                                                              'OtherPhoto' => array('className' => 'Photo', 'foreignKey' => 'parent_id', 'conditions' => array('NewsFeed.parent_model_name' => 'OtherPhoto'), 'order' => array('NewsFeed.created' => 'desc')),
                                                              'HorizonPost' => array('className' => 'Post', 'foreignKey' => 'parent_id', 'conditions' => array('NewsFeed.parent_model_name' => 'HorizonPost'), 'order' => array('NewsFeed.created' => 'desc'))
                                                              )
                                         )
                                   );

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

        //cleanups for recursive 4
        $this->NewsFeed->User->PhotoAlbum->Photo->unbindModel(array('belongsTo' => array('PhotoAlbum'), 'hasMany' => array('Like')));
        $this->NewsFeed->User->PhotoAlbum->unbindModel(array('hasMany' => array('Like')));

        $this->NewsFeed->User->unbindModel(array('hasAndBelongsToMany' => array('UserFriendship'), 'hasMany' => array('GroupMember', 'VideoAlbum', 'NewsFeed', 'Inbox', 'Sent', 'Draft', 'FriendFrom', 'FriendTo')));
        $feeds = $this->NewsFeed->find('all', array('conditions' => array('NewsFeed.user_id' => $id, 'NewsFeed.parent_model_name' => array('HorizonPost', 'OtherPhoto')), 'recursive' => 5));
        $this->set(compact('data', 'feeds'));
    }
    
    public function profile($id = null) {
        $this->layout = 'users';
        $data = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'fields' => array('User.username_updated', 'User.password'), 'recursive' => -1));
        $username_updated = $data['User']['username_updated'];
        if (!empty($this->data['User']['username'])) {
            if (isset($id)) {
                $this->request->data['User']['id'] = $id;
                if ($username_updated == 0) {
                    $this->request->data['User']['username_updated'] = 1;
                } else {
                    $this->request->data['User']['username_updated'] = 2;
                }
            }
            if ($username_updated < 2) {
                if ($this->User->save($this->data)) {
                    $this->Session->setFlash('You have successfully saved your username.', 'default', array('class' => 'success'), 'user');
                }
                unset($this->data);
            } else {
                $this->Session->setFlash('The username could not be save.', 'default', array(), 'user');
                unset($this->data);
            }
        }

        if (!empty($this->data['User']['current_password'])) {
            $this->request->data['User']['id'] = $id;
            if ($this->User->validates($this->data)) {
                $this->request->data['User']['password'] = $this->data['User']['new_password'];
                if ($this->User->save($this->data)) {
                    $this->Session->setFlash('Your have successfully change your password.', 'default', array('class' => 'success'), 'password');
                }
            }
            unset($this->data);
        }
        
        if (!empty($this->data['User']['first_name']) || !empty($this->data['User']['last_name'])) {
            $this->request->data['User']['id'] = $id;
            if ($this->User->save($this->data)) {
                $this->Session->setFlash('Your have successfully updated your name.', 'default', array('class' => 'success'), 'name');
            }
            unset($this->data);
        }
        
        if (!empty($this->data['User']['email_address'])) {
            $this->request->data['User']['id'] = $id;
            if ($this->User->save($this->data)) {
                $this->Session->setFlash('Your have successfully updated your email.', 'default', array('class' => 'success'), 'email');
            }
            unset($this->data);
        }
        
        $this->data = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'recursive' => -1));
        $this->set('title', 'Profile');
    }
    
    public function friends() {
        $this->layout = "users";
        $this->set('title', 'Friends');
        $this->User->FriendFrom->unbindModel(array('belongsTo' => array('UserFrom')));
        $this->User->FriendFrom->UserTo->unbindModel(array('hasMany' => array('FriendTo', 'FriendFrom', 'GroupMember', 'Inbox', 'Sent', 'Draft', 'VideoAlbum', 'Comment', 'Like', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
        $data = $this->User->FriendFrom->find('all', array('conditions'=>array('FriendFrom.status' => 1,'FriendFrom.user_from' => $this->Auth->user('id')), 'contain' => array('UserTo', 'PhotoAlbum'), 'recursive' => 3,
                                                           //'fields' => array('UserTo.*')
                                                           ));

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
        $data2 = $this->paginate('NewsFeed');
        $this->set(compact('data', 'data2'));
    }
    
    public function send_friend_request($id = null) {
        $this->autoRender = false;
        $user = $this->User->find('first', array('conditions' => array('id' => $id), 'recursive' => -1));
        if (!empty($user)) {
            $data = array('FriendFrom' => array('user_to' => $id, 'user_from' => $this->Auth->user('id'), 'status' => 0));
            if ($this->User->FriendFrom->save($data)) {
                $this->Session->setFlash('Friend request was sent to ' . $user['User']['full_name'], 'default', array('class' => 'success'), 'user');
            }
        }
    }
    
    public function accept_friend_request($id = null) {
        $this->autoRender = false;
        if (!empty($id)) {
            $my_id = $this->Auth->user('id');
            $this->User->unbindModel(array('hasMany' => array('Message', 'Sent', 'Draft', 'GroupMember', 'PhotoAlbum', 'VideoAlbum', 'Comment', 'Like', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
            $new_friend = $this->User->FriendTo->find('first', array('conditions' => array('FriendTo.user_to' => $my_id, 'FriendTo.user_from' => $id, 'FriendTo.status' => 0)));
            if (!empty($new_friend)) {
                $data = array('FriendTo' => array('id' => $new_friend['FriendTo']['id'], 'status' => 1));
                if ($this->User->FriendTo->save($data)) {
                    $reversal = array('FriendFrom' => array('user_to' => $id, 'user_from' => $my_id, 'status' => 1));
                    unset($data);
                    $data[] = array('NewsFeed' => array('user_id' => $id, 'parent_id' => $new_friend['FriendTo']['id'], 'parent_model_name' => 'Friendship'));
                    if ($this->User->FriendFrom->save($reversal)) {
                        //@TODO: broadcast to newsfeed
                        $this->loadModel('NewsFeed');
                        $parent_id = $this->User->FriendFrom->getLastInsertId();
                        $data[] = array('NewsFeed' => array('user_id' => $this->Auth->user('id'), 'parent_id' => $parent_id, 'parent_model_name' => 'Friendship'));
                        $this->NewsFeed->saveAll($data);
                        $notifications = $this->Session->read('Notifications');
                        foreach ($notifications['FriendRequests'] as $notify) {
                            if ($notify['User']['id'] == $id) {
                                $this->Session->delete('Notifications.FriendRequests.' . key($notifications['FriendRequests']));
                            }
                            next($notifications['FriendRequests']);
                        }
                        $this->Session->setFlash('You are now friend with ' . $new_friend['UserTo']['full_name'], 'default', array('class' => 'success'), 'user');
                    }
                }
            }
        }
        $this->redirect(array('controller' => 'users', 'action' => 'friends'));
    }
    
    public function decline_friend_request($id = null) {
        $this->autoRender = false;
        if (!empty($id)) {
            $my_id = $this->Auth->user('id');
            $this->User->unbindModel(array('hasMany' => array('Message', 'Sent', 'Draft', 'FriendFrom', 'GroupMember', 'PhotoAlbum', 'VideoAlbum', 'Comment', 'Like', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
            $new_friend = $this->User->FriendTo->find('first', array('conditions' => array('FriendTo.user_to' => $my_id, 'FriendTo.user_from' => $id, 'FriendTo.status' => 0)));
            if (!empty($new_friend)) {
                $notifications = $this->Session->read('Notifications');
                if ($this->User->FriendFrom->delete($new_friend['FriendTo']['id'])) {
                    $notifications = $this->Session->read('Notifications');
                    foreach ($notifications['FriendRequests'] as $notify) {
                        if ($notify['User']['id'] == $id) {
                            $this->Session->delete('Notifications.FriendRequests.' . key($notifications['FriendRequests']));
                        }
                        next($notifications['FriendRequests']);
                    }
                    $this->Session->setFlash('You have successfully rejected a friend request', 'default', array('class' => 'success'), 'user');
                }
            }
        }
        $this->redirect(array('controller' => 'users', 'action' => 'friends'));
    }
    
    public function remove_friend($id = null) {
        $this->autoRender = false;
        if (!empty($id)) {
            $my_id = $this->Auth->user('id');
            $this->User->unbindModel(array('hasMany' => array('Message', 'Sent', 'Draft', 'GroupMember', 'PhotoAlbum', 'VideoAlbum', 'Comment', 'Like', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
            $valid_id = $this->User->FriendFrom->find('first', array('conditions' => array('FriendFrom.user_from' => $id, 'FriendFrom.user_from' => $my_id, 'FriendFrom.status' => 1)));
            if (!empty($valid_id)) {
                if ($this->User->FriendFrom->delete($valid_id['FriendFrom']['id'])) {
                    unset($valid_id);
                    $valid_id = $this->User->FriendTo->find('first', array('conditions' => array('FriendTo.user_to' => $my_id, 'FriendTo.user_from' => $id, 'FriendTo.status' => 1)));
                    $this->User->FriendTo->delete($valid_id['FriendTo']['id']);
                } 
            }
        }
        $this->redirect(array('controller' => 'users', 'action' => 'friends'));
    }
    
    public function search() {
        $this->layout = 'users';
        $this->set('title', 'Search');
        if ($this->request->is('post')) {
            $this->User->unbindModel(array('hasMany' => array('Inbox', 'Sent', 'Draft', 'FriendFrom', 'GroupMember', 'VideoAlbum' , 'Comment', 'Like', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
            $data = $this->User->find('all', array('conditions'=>array('OR' => array(
                'User.first_name LIKE' => "%" . $this->request->data['User']['globalsearch'] . "%",
                'User.last_name LIKE' => "%" . $this->request->data['User']['globalsearch'] . "%",
                'User.full_name LIKE' => "%" . $this->request->data['User']['globalsearch'] . "%",
            )), 'recursive' => 2));
        } else {
            $data = null;
        }
        $this->set('data', $data);
    }
    
    public function groups() {
        $this->layout = 'users';
        $this->set('title', 'Groups');
        $data = $this->User->GroupMember->find('all', array('conditions' => array('GroupMember.deleted' => 0, 'GroupMember.user_id' => $this->Auth->user('id'))));
        $this->set('data', $data);
    }
    
    public function group($id = null) {
        $this->layout = 'users';
        $this->set('title', 'Groups');
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
    
    public function settings() {
        $this->layout = 'users';
    }
    
    public function compose($user = null) {
        $this->layout = 'users';
        $this->set('title', 'Compose');
    }
    
    public function inbox() {
        $this->components[] = 'Paginator';
        $this->helpers[] = 'Paginator';
        $this->paginate = array(
            'limit' => 5,
            'conditions' => array('Inbox.recipient_id' => $this->Auth->user('id'), 'Inbox.deleted' => 0),
            'recursive' => 1,
            'order' => array('Inbox.created' => 'desc')
        );
        $this->layout = 'users';
        $this->set('title', 'Inbox');
        $data = $this->paginate('User.Inbox');
        $this->set('data', $data);
    }
    
    public function sent() {
        $this->components[] = 'Paginator';
        $this->helpers[] = 'Paginator';
        $this->paginate = array(
            'limit' => 5,
            'conditions' => array('Sent.sender_id' => $this->Auth->user('id'), 'Sent.sent' => 1, 'Sent.deleted' => 0),
            'recursive' => 1,
            'group' => 'Sent.batch_id',
            'order' => array('Sent.created' => 'desc')
        );
        $this->layout = 'users';
        $this->set('title', 'Sent');
        $data = $this->paginate('User.Sent');
        $this->set('data', $data);
    }
    
    public function drafts() {
        $this->components[] = 'Paginator';
        $this->helpers[] = 'Paginator';
        $this->paginate = array(
            'limit' => 5,
            'conditions' => array('Draft.sender_id' => $this->Auth->user('id'), 'Draft.draft' => 1, 'Draft.deleted' => 0),
            'recursive' => 1,
            'order' => array('Draft.modified' => 'desc')
        );
        $this->layout = 'users';
        $this->set('title', 'Drafts');
        $data = $this->paginate('User.Draft');
        $this->set('data', $data);
    }
    
    public function archive() {
        $this->layout = 'users';
        $this->set('title', 'Archive');
    }
    
    public function mark_as_read($id = null) {
        $this->autoRender = false;
        if ($this->request->is('get')) {
            if (!empty($id)) {
                $exist = $this->User->Inbox->find('first', array('conditions' => array('Inbox.id' => $id)));
                $read = ($exist['Inbox']['read'] == 0) ? true : false;
                if (!empty($exist)) {
                    $this->User->Inbox->id = $id;
                    if ($this->User->Inbox->saveField('read', 1)) {
                        if ($read) {
                            if ($this->Session->check('Notifications.UnreadMails')) {
                                if ($this->Session->read('Notifications.UnreadMails') > 0) {
                                    $this->Session->write('Notifications.UnreadMails', $this->Session->read('Notifications.UnreadMails') - 1);
                                }
                            }
                        }
                        echo 'success';
                    } else {
                        echo 'failed';
                    }
                } else {
                    echo 'not exist';
                }
            } else {
                echo 'no id';
            }
        } else {
            
        }
    }
    
    public function mark_as_unread($id = null) {
        $this->autoRender = false;
        if ($this->request->is('get')) {
            if (!empty($id)) {
                $exist = $this->User->Inbox->find('first', array('conditions' => array('Inbox.id' => $id)));
                if (!empty($exist)) {
                    $this->User->Inbox->id = $id;
                    if ($this->User->Inbox->saveField('read', 0)) {
                        echo 'success';
                    } else {
                        echo 'failed';
                    }
                } else {
                    echo 'not exist';
                }
            } else {
                echo 'no id';
            }
        } else {
            
        }
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
    
    public function send_mail() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            //@TODO: check if email is for gl users or for others
            $recipients = explode(',', $this->request->data['to']);
            $batch_id = String::uuid();
            foreach($recipients as $recipient) {
                unset($emails);
                $emails = $this->__extract_email_address($recipient);
                if ($emails != false) {
                    foreach($emails as $email) {
                        $e = explode('@', $email);
                        // check if recipient's email address is GL user
                        if ($e['1'] == 'globeloop.com' || $e['1'] == 'globeloop.com.ph') {
                            unset($data);
                            $data = array(
                                'Inbox' => array(
                                    'batch_id' => $batch_id,
                                    'parent_id' => $id,
                                    'subject' => $this->request->data['subject'],
                                    'body_plain' => $this->request->data['message'],
                                    'body_html' => nl2br($this->request->data['message']),
                                    'sender_email' => $this->Auth->user('gl_email'),
                                    'sender_id' => $this->Auth->user('id'),
                                    'reply_to' => $this->Auth->user('id'),
                                    'recipients' => $this->request->data['to'],
                                    'recipient_id' => trim($recipient),
                                    'sent' => 1,
                                    'sent_on' => date('Y-m-d H:i:s')
                                )
                            );
                            $this->User->Inbox->create();
                            if ($this->User->Inbox->save($data)) {
                                if (isset($this->request->data['id'])) {
                                    if (!empty($this->request->data['id'])) {
                                        $this->User->Inbox->save(array('Inbox' => array('id' => $this->request->data['id'], 'deleted' => 1, 'deleted_on' => date('Y-m-d H:i:s'))));
                                    }
                                }
                                $this->Session->setFlash('Message sent.', 'default', array('class' => 'success'));
                                echo 'success';
                            } else {
                                echo 'failed';
                            }
                        } else {
                            // recipient's email address is external email
                            unset($data);
                            $data = array(
                                'Inbox' => array(
                                    'batch_id' => $batch_id,
                                    'parent_id' => !empty($this->request->data['parent']) ? $this->request->data['parent'] : '',
                                    'subject' => $this->request->data['subject'],
                                    'body_plain' => $this->request->data['message'],
                                    'body_html' => nl2br($this->request->data['message']),
                                    'sender_email' => $this->Auth->user('full_name') . ' <' . $this->Auth->user('gl_email') . '>',
                                    'sender_id' => $this->Auth->user('id'),
                                    'reply_to' => $this->Auth->user('id'),
                                    'recipients' => $this->request->data['to'],
                                    'recipient_email' => trim($recipient),
                                    'sent' => 1,
                                    'sent_on' => date('Y-m-d H:i:s')
                                )
                            );
                            $this->User->Inbox->create();
                            if ($this->User->Inbox->save($data)) {
                                if (isset($this->request->data['id'])) {
                                    if (!empty($this->request->data['id'])) {
                                        $this->User->Inbox->save(array('Inbox' => array('id' => $this->request->data['id'], 'deleted' => 1, 'deleted_on' => date('Y-m-d H:i:s'))));
                                    }
                                }
                                $this->Session->setFlash('Message sent.', 'default', array('class' => 'success'));
                                echo 'success';
                            } else {
                                echo 'failed';
                            }
                        }
                    }
                } else {
                    //check if valid users
                    unset($valid_user);
                    $valid_user = $this->User->find('first', array('conditions' => array('User.id' => trim($recipient)), 'recursive' => -1, 'fields' => array('User.id')));
                    if (!empty($valid_user)) {
                        unset($data);
                        $data = array(
                            'Inbox' => array(
                                'batch_id' => $batch_id,
                                'parent_id' => !empty($this->request->data['parent']) ? $this->request->data['parent'] : '',
                                'subject' => $this->request->data['subject'],
                                'body_plain' => $this->request->data['message'],
                                'body_html' => nl2br($this->request->data['message']),
                                'sender_email' => $this->Auth->user('full_name') . ' <' . $this->Auth->user('gl_email') . '>',
                                'sender_id' => $this->Auth->user('id'),
                                'recipients' => $this->request->data['to'],
                                'reply_to' => $this->Auth->user('id'),
                                'recipient_id' => trim($recipient),
                                'sent' => 1,
                                'sent_on' => date('Y-m-d H:i:s'),
                                'received_on' => date('Y-m-d H:i:s')
                            )
                        );
                        $this->User->Inbox->create();
                        if ($this->User->Inbox->save($data)) {
                            if (isset($this->request->data['id'])) {
                                if (!empty($this->request->data['id'])) {
                                    $this->User->Inbox->save(array('Inbox' => array('id' => $this->request->data['id'], 'deleted' => 1, 'deleted_on' => date('Y-m-d H:i:s'))));
                                }
                            }
                            $this->Session->setFlash('Message sent.', 'default', array('class' => 'success'));
                            echo 'success';
                        } else {
                            echo 'failed';
                        }
                    } else {
                        //skip saving and mail sending
                    }
                }
            }
        } else {
            $data = null;
        }
    }
    
    public function save_mail() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $data = array(
                'Inbox' => array(
                    'id' => isset($this->request->data['id']) ? $this->request->data['id'] : '',
                    'recipient_email' => $this->request->data['to'],
                    'subject' => !empty($this->request->data['subject']) ? $this->request->data['subject'] : 'No Subject',
                    'body_plain' => $this->request->data['message'],
                    'body_html' => nl2br($this->request->data['message']),
                    'sender_email' => $this->Auth->user('full_name') . ' <' . $this->Auth->user('gl_email') . '>',
                    'sender_id' => $this->Auth->user('id'),
                    'reply_to' => $this->Auth->user('id'),
                    'draft' => 1,
                    'parent_id' => !empty($this->request->data['parent']) ? $this->request->data['parent'] : ''
                )
            );
            if (isset($this->request->data['id'])) {
                $this->User->Inbox->create();
            }
            if ($this->User->Inbox->save($data)) {
                $this->Session->setFlash('Message saved.', 'default', array('class' => 'success'));
                echo $this->User->Inbox->getLastInsertId();
            } else {
                echo 'failed';
            }
        } else {
            $data = null;
        }
    }
    
    public function delete_mail($id = null) {
        $this->autoRender = false;
        if ($this->request->is('get')) {
            if (!empty($id)) {
                $exist = $this->User->Inbox->find('first', array('conditions' => array('Inbox.id' => $id), 'recursive' => -1));
                if (!empty($exist)) {
                    $data = array(
                        'Inbox' => array(
                            'id' => $id,
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d H:i:s')
                        )
                    );
                    if ($this->User->Inbox->save($data)) {
                        //$this->Session->setFlash('Message deleted. To undo click <a href="/users/undelete_mail/' .$id. '">here</a>', 'default', array('class' => 'success'));
                        echo 'success';
                    } else {
                        echo 'failed';
                    }
                }
            }
        } else {
            $data = null;
        }
    }
    
    public function undelete_mail($id = null) {
        $this->autoRender = false;
        if ($this->request->is('get')) {
            if (!empty($id)) {
                $exist = $this->User->Inbox->find('first', array('conditions' => array('Inbox.id' => $id, 'Inbox.deleted' => 1), 'recursive' => -1));
                if (!empty($exist)) {
                    $this->User->Inbox->id = $id;
                    if ($this->User->Inbox->saveField('deleted', 0)) {
                        echo 'success';
                    } else {
                        echo 'failed';
                    }
                }
            }
        } else {
            $data = null;
        }
    }
    
    public function retrieve_friends() {
        $this->autoRender = false;
        $this->User->FriendFrom->UserTo->virtualFields['name'] = 'CONCAT(UserTo.first_name, " ", UserTo.last_name)';
        $this->User->FriendFrom->unbindModel(array('belongsTo' => array('UserFrom', 'UserTo')));
        $this->User->FriendFrom->bindModel(array('belongsTo' => array('UserTo' => array('className' => 'User', 'foreignKey' => 'user_to', 'conditions' => array('OR' => array('UserTo.first_name LIKE ' => $this->params->query['q'] . '%', 'UserTo.last_name LIKE ' => $this->params->query['q'] . '%', 'UserTo.username LIKE ' => $this->params->query['q'] . '%'))))));
        $fullnames = $this->User->FriendFrom->find('all', array('conditions' => array('FriendFrom.user_from' => $this->Auth->user('id')), 'recursive' => 1)); 
        $fn = Set::extract($fullnames, '{n}.UserTo');
        $fn = array_filter(array_map('array_filter', $fn));
        $count = count($fn);
        $counter = 0;
        echo '[';
        foreach($fn as $f) {
            echo json_encode($f);
            $counter++;
            if ($count != $counter) {
                echo ',';
            }
        }
        echo ']';
    }
    
    public function calendar() {
        $this->layout = 'users';
        $this->set('title', 'Calendar');
    }
    
    public function photos() {
        $this->layout = 'users';
        $this->set('title', 'Photo Albums');
        $data = $this->User->PhotoAlbum->find('all', array('conditions' => array('PhotoAlbum.user_id' => $this->Auth->user('id'), 'PhotoAlbum.deleted' => 0), 'order' => array('PhotoAlbum.primary DESC', 'PhotoAlbum.modified DESC')));
        $this->set('data', $data);
    }
    
    public function add_photo_album() {
        $this->layout = 'users';
        $this->set('title', 'Photos');
        if ($this->request->is('post')) {
            $this->request->data['PhotoAlbum']['user_id'] = $this->Auth->user('id');
            if ($this->User->PhotoAlbum->save($this->data)) {
                $this->Session->setFlash(__('You have successfully added a new photo album.'), 'default', array('class' => 'success'));
                $this->redirect(array('controller' => 'users', 'action' => 'photo_album', $this->User->PhotoAlbum->getLastInsertId()));
            }
        }
    }

    public function edit_photo_album() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            pr($this->data);
            if ($this->data['name'] == 'albumTitle') {
                $data['PhotoAlbum'] = array('title' => $this->data['value'], 'id' => $this->data['pk']);
            }
            if ($this->data['name'] == 'albumDescription') {
                $data['PhotoAlbum'] = array('description' => $this->data['value'], 'id' => $this->data['pk']);
            }
            if ($this->User->PhotoAlbum->save($data)) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }
    
    public function delete_photo_album($id = null) {
        $this->autoRender = true;
        if (!empty($id)) {
            $data['PhotoAlbum'] = array(
                'id' => $id,
                'deleted' => 1,
                'deleted_on' => date('Y-m-d H:i:s')
            );
            if ($this->User->PhotoAlbum->save($data)) {
                $this->Session->setFlash(__('The album was deleted successfully.'), 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash('Oops! Something went wrong during deletion. You may try deleting it again later.');
            }
        }
        $this->redirect(array('controller' => 'users', 'action' => 'photos'));
    }
    
    public function photo_album($id = null) {
        $this->layout = 'users';
        $this->set('title', 'Photos');
        if (!empty($id)) {
            $data = $this->User->PhotoAlbum->find('first', array('conditions' => array('PhotoAlbum.id' => $id)));
            if (!empty($data)) {
                $this->set('data', $data);
                if ($data['User']['id'] != $this->Auth->user('id')) {
                    $this->render('public_photo_album');
                }
            } else {
                $this->Session->setFlash(__('The album was not found.'));
                $this->redirect(array('controller' => 'users', 'action' => 'photos'));
            }
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'photos'));
        }
    }
    
    public function add_photo($id = null) {
        $this->layout = 'users';
        $this->set('title', 'Add Photo');
        if ($this->request->is('post')) {
            if (!empty($id)) {
                $this->User->unbindModel(array('hasMany' => array('FriendFrom', 'FriendTo', 'Inbox', 'Sent', 'Draft', 'GroupMember', 'VideoAlbum', 'PhotoAlbum', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
                $this->User->PhotoAlbum->unbindModel(array('belongsTo' => array('User')));
                $this->User->PhotoAlbum->hasMany['Photo']['limit'] = 1;
                $this->User->bindModel(array('hasMany' => array('PhotoAlbum' => array('conditions' => array('PhotoAlbum.deleted' => 0)))));
                $photoAlbumExist = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'recursive' => 2));
                if (!empty($photoAlbumExist)) {
                    $this->request->data['Photo']['photo_album_id'] = $id;
                    if (count($photoAlbumExist['PhotoAlbum']['0']['Photo']) == 0) {
                        $this->request->data['Photo']['primary'] = 1;
                    }
                    if ($this->User->PhotoAlbum->Photo->save($this->data)) {
                        $this->loadModel('NewsFeed');
                        $lastInsertId = $this->User->PhotoAlbum->Photo->getLastInsertId();
                        unset($photoAlbumExist);
                        $photoAlbumExist = $this->User->PhotoAlbum->Photo->find('first', array('conditions' => array('Photo.id' => $lastInsertId), 'recursive' => 1));
                        if ($photoAlbumExist['PhotoAlbum']['primary'] == 1) {
                            unset($data);
                            $data = array('NewsFeed' => array('user_id' => $this->Auth->user('id'), 'parent_id' => $lastInsertId, 'parent_model_name' => 'PrimaryPhoto'));
                            $this->NewsFeed->save($data);
                            unset($photoAlbumExist);
                            $photoAlbumExist = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'recursive' => 2));
                            $this->Session->delete('Essentials.Photo');
                            $this->Session->write('Essentials', array('Photo' => $photoAlbumExist['PhotoAlbum']['0']));
                        } else {
                            unset($data);
                            //@TODO: check first if record exist in newsfeed and dated today then skip adding record, else continue adding
                            $existInNewsFeed = $this->NewsFeed->find('first', array('conditions' => array('NewsFeed.user_id' => $this->Auth->user('id'), 'NewsFeed.parent_model_name' => 'Photo', 'DATE(NewsFeed.created)' => 'CURDATE()')));
                            if (empty($existInNewsFeed)) {
                                $data = array('NewsFeed' => array('user_id' => $this->Auth->user('id'), 'parent_id' => $lastInsertId, 'parent_model_name' => 'OtherPhoto'));
                                $this->NewsFeed->save($data);
                            }
                        }
                        $this->Session->setFlash(__('You have successfully added a new photo.'), 'default', array('class' => 'success'));
                        $this->redirect(array('controller' => 'users', 'action' => 'photo_album', $id));
                    }
                }
                $this->redirect(array('controller' => 'users', 'action' => 'photos'));
            } else {
                $this->redirect(array('controller' => 'users', 'action' => 'photos'));
            }
        }
    }
    
    public function delete_photos() {
        $this->autoRender = false;
        $params = array();
        $photos = array();
        parse_str($this->data['selected_photos'], $params);
        $this->User->unbindModel(array('hasMany' => array('FriendFrom', 'FriendTo', 'Inbox', 'Sent', 'Draft', 'GroupMember', 'VideoAlbum', 'PhotoAlbum'), 'hasAndBelongsToMany' => array('UserFriendship')));
        $this->User->PhotoAlbum->unbindModel(array('belongsTo' => array('User')));
        $this->User->PhotoAlbum->hasMany['Photo']['limit'] = 1;
        $this->User->bindModel(array('hasMany' => array('PhotoAlbum' => array('conditions' => array('PhotoAlbum.deleted' => 0, 'PhotoAlbum.primary' => 1)))));
        $photoAlbumExist = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'recursive' => 2));
        if (!empty($photoAlbumExist)) {
            foreach ($params['selectedPhoto'] as $photoID) {
                $photos[] = array('Photo' => array('deleted' => 1, 'deleted_on' => date('Y-m-d H:i:s'), 'id' => $photoID));
            }
            if (!empty($photos)) {
                if ($this->User->PhotoAlbum->Photo->saveAll($photos)) {
                    if ($photoAlbumExist['PhotoAlbum']['0']['primary'] == 1) {
                        $this->Session->delete('Essentials.Photo');
                        $this->Session->write('Essentials', array('Photo' => $photoAlbumExist['PhotoAlbum']['0']));
                    }
                    echo 'success';
                } else {
                    echo 'failed';
                    $this->Session->setFlash('Oops! Something went wrong during deletion of photo. You may try deleting it again later.');
                }
            } else {
                echo 'no id';
                $this->Session->setFlash('Oops! Something went wrong during deletion of photo. You may try deleting it again later.');
            }
        } else {
            $this->Session->setFlash('Oops! Something went wrong during deletion of photo. You may try deleting it again later.');
        }
    }
    
    public function update_photo_order($id = null) {
        $this->autoRender = false;
        if (!empty($id)) {
            if (!empty($this->data['photos_order'])) {
                foreach($this->data['photos_order'] as $value) {
                    unset($id);
                    $orders = explode('=', $value);
                    $id = trim(str_replace(array('photo-'), '', $orders['0']));
                    $order = trim($orders['1']);
                    if ($order == 0) {
                        $data[] = array('Photo' => array('id' => $id, 'primary' => 1, 'primary_on' => date('Y-m-d H:i:s')));
                        $primaryId = $id;
                    } else {
                        $data[] = array('Photo' => array('id' => $id, 'primary' => 0));
                    }
                }
                if ($this->User->PhotoAlbum->Photo->saveAll($data)) {
                    $this->User->PhotoAlbum->unbindModel(array('belongsTo' => array('User')));
                    $this->User->PhotoAlbum->hasMany['Photo']['limit'] = 1;
                    $primary = $this->User->PhotoAlbum->Photo->find('first', array('conditions' => array('Photo.id' => $primaryId), 'recursive' => 2));
                    if ($primary['PhotoAlbum']['primary'] == 1) {
                        $this->Session->delete('Essentials.Photo');
                        $this->Session->write('Essentials', array('Photo' => $primary['PhotoAlbum']));
                        $this->loadModel('NewsFeed');
                        unset($data);
                        $data = array('NewsFeed' => array('user_id' => $this->Auth->user('id'), 'parent_id' => $primaryId, 'parent_model_name' => 'PrimaryPhoto'));
                        $this->NewsFeed->save($data);
                        echo 'reload';
                    } else {
                        echo 'success';
                    }
                } else {
                    echo 'failed';
                }
            } else {
                $this->Session->delete('Essentials.Photo');
                echo 'reload2';
            }
            
        } else {
            echo 'no id';
        }
    }
    
    public function videos() {
        $this->layout = 'users';
        $this->set('title', 'Video Albums');
        $data = $this->User->VideoAlbum->find('all', array('conditions' => array('VideoAlbum.user_id' => $this->Auth->user('id'), 'VideoAlbum.deleted' => 0), 'order' => array('VideoAlbum.modified DESC')));
        $this->set('data', $data);
    }
    
    public function add_video_album() {
        $this->layout = 'users';
        $this->set('title', 'Videos');
        if ($this->request->is('post')) {
            $this->request->data['VideoAlbum']['user_id'] = $this->Auth->user('id');
            if ($this->User->VideoAlbum->save($this->data)) {
                $this->Session->setFlash(__('You have successfully added a new video album.'), 'default', array('class' => 'success'));
                $this->redirect(array('controller' => 'users', 'action' => 'video_album', $this->User->VideoAlbum->getLastInsertId()));
            }
        }
    }
    
    public function video_album($id = null) {
        $this->layout = 'users';
        $this->set('title', 'Videos');
        if (!empty($id)) {
            $data = $this->User->VideoAlbum->find('first', array('conditions' => array('VideoAlbum.id' => $id)));
            if (!empty($data)) {
                $this->set('data', $data);
            } else {
                $this->Session->setFlash(__('The album was not found.'));
                $this->redirect(array('controller' => 'users', 'action' => 'videos'));
            }
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'videos'));
        }
    }
    
    public function add_video($id = null) {
        $this->layout = 'users';
        $this->set('title', 'Add Video');
        if ($this->request->is('post')) {
            if (!empty($id)) {
                $this->request->data['Video']['video_album_id'] = $id;
                if ($this->User->VideoAlbum->Video->save($this->data)) {
                    $this->Session->setFlash(__('You have successfully added a new video.'), 'default', array('class' => 'success'));
                    $this->redirect(array('controller' => 'users', 'action' => 'video_album', $id));
                }
            }
        }
    }
    
    public function delete_videos() {
        $this->autoRender = false;
        $params = array();
        $videos = array();
        parse_str($this->data['selected_videos'], $params);
        foreach ($params['selectedVideo'] as $videoID) {
            $videos[] = array('Video' => array('deleted' => 1, 'deleted_on' => date('Y-m-d H:i:s'), 'id' => $videoID));
        }
        
        if (!empty($videos)) {
            if ($this->User->VideoAlbum->Video->saveAll($videos)) {
                echo 'success';
            } else {
                echo 'failed';
                $this->Session->setFlash('Oops! Something went wrong during deletion of video. You may try deleting it again later.');
            }
        } else {
            echo 'no id';
            $this->Session->setFlash('Oops! Something went wrong during deletion of video. You may try deleting it again later.');
        }
    }
    
    public function delete_video_album($id = null) {
        $this->autoRender = true;
        if (!empty($id)) {
            $data['VideoAlbum'] = array(
                'id' => $id,
                'deleted' => 1,
                'deleted_on' => date('Y-m-d H:i:s')
            );
            if ($this->User->VideoAlbum->save($data)) {
                $this->Session->setFlash(__('The album was deleted successfully.'), 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash('Oops! Something went wrong during deletion. You may try deleting it again later.');
            }
        }
        $this->redirect(array('controller' => 'users', 'action' => 'photos'));
    }
    
    public function video_player($id = null) {
        $this->layout = 'ajax';
        $data = array();
        if (!empty($id)) {
            $data = $this->User->VideoAlbum->Video->find('first', array('conditions' => array('Video.id' => $id)));
        }
        $this->set('data', $data);
    }
    
    public function add_remove_selections() {
        if ($this->request->is('post')) {
            $user_exists = $this->User->FriendTo->find('first', array('conditions' => array('FriendTo.user_to' => $this->Auth->user('id'), 'FriendTo.user_from' => $this->data['id'], 'FriendTo.status' => 1), 'recursive' => -1));
            if (!empty($user_exists)) {
                $data['FriendTo'] = array('id' => $user_exists['FriendTo']['id'], 'selection' => $this->data['action']);
                if ($this->User->FriendTo->save($data)) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                echo 'reload';
            }
        } else {
            echo 'reload';
        }
        $this->autoRender = false;
    }
    
    public function add_comment() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $this->loadModel('Comment');
            if (!empty($this->data['comment_content']) && !empty($this->data['comment_parent_id']) && !empty($this->data['comment_parent_name'])) {
                $data = array('Comment' => array('content' => $this->data['comment_content'], 'parent_id' => $this->data['comment_parent_id'], 'user_id' => $this->Auth->user('id'), 'parent_model_name' => $this->data['comment_parent_name']));
                if ($this->Comment->save($data)) {
                    echo $this->Comment->getLastInsertId();
                } else {
                    echo 'failed';
                }
            }
        }
    }
    
    public function remove_comment() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $this->loadModel('Comment');
            if (!empty($this->data['id'])) {
                $data = array('Comment' => array('deleted' => 1, 'deleted_on' => date('Y-m-d H:i:s'), 'id' => $this->data['id']));
                if ($this->Comment->save($data)) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }
    
    public function like_unlike() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $this->loadModel('Like');
            if (!empty($this->data['id'])) {
                $exists = $this->Like->find('first', array('conditions' => array('Like.user_id' => $this->Auth->user('id'), 'Like.parent_model_name' => $this->data['model'], 'Like.parent_id' => $this->data['id'])));
                $data['Like'] = array('user_id' => $this->Auth->user('id'), 'parent_id' => $this->data['id'], 'parent_model_name' => $this->data['model'], 'like' => ($this->data['like'] == 'true') ? 1 : 0);
                if (empty($exists)) {                    
                    $this->Like->create();
                } else {
                    $data['Like']['id'] = $exists['Like']['id'];
                }
                if ($this->Like->save($data)) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

    public function horizon_post() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if (!empty($this->data['content'])) {
                $this->loadModel('Post');
                $data['Post'] = array('content' => $this->data['content'], 'user_id' => $this->Auth->user('id'), 'parent_id' => $this->data['parent_id'], 'parent_model_name' => 'Horizon');
                if ($this->Post->save($data)) {
                    $lastInsertId = $this->Post->getLastInsertId();
                    unset($data);
                    $this->loadModel('NewsFeed');
                    $data = array('NewsFeed' => array('user_id' => $this->Auth->user('id'), 'parent_id' => $lastInsertId, 'parent_model_name' => 'HorizonPost'));
                    $this->NewsFeed->save($data);
                    echo $lastInsertId;
                } else {
                    echo 'failed';
                }
            }
        }
    }
    
    public function horizon_share() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $this->loadModel('Share');
            $data['Share'] = array('content' => $this->data['content'], 'user_id' => $this->Auth->user('id'), 'parent_id' => $this->data['parent_id'], 'parent_model_name' => 'Horizon');
            if ($this->Share->save($data)) {
                $lastInsertId = $this->Share->getLastInsertId();
                unset($data);
                $this->loadModel('NewsFeed');
                $data = array('NewsFeed' => array('user_id' => $this->Auth->user('id'), 'parent_id' => $lastInsertId, 'parent_model_name' => 'HorizonShare'));
                $this->NewsFeed->save($data);
                echo $lastInsertId;
            } else {
                echo 'failed';
            }
        }
    }
    
    public function quicklook($user = null) {
        $this->layout = 'ajax';
        $this->autoRender = false;
        if ($this->User->exists($user)) {
            $this->User->FriendFrom->unbindModel(array('belongsTo' => array('UserFrom')));
            $this->User->FriendFrom->UserTo->unbindModel(array('hasMany' => array('FriendFrom', 'GroupMember', 'Inbox', 'Sent', 'Draft', 'VideoAlbum', 'Comment', 'Like', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
            $this->User->unbindModel(array('hasAndBelongsToMany' => array('UserFriendship'), 'hasMany' => array('NewsFeed', 'Inbox', 'Sent', 'Draft', 'VideoAlbum', 'Comment', 'GroupMember')));
            $this->User->hasMany['PhotoAlbum']['fields'] = array('id');
            $this->User->PhotoAlbum->unbindModel(array('belongsTo' => array('User'), 'hasMany' => array('Like')));
            $this->User->PhotoAlbum->hasMany['Photo']['fields'] = array('photo', 'photo_dir');
            $this->User->hasMany['FriendTo']['fields'] = array('user_from', 'status', 'selection');
            $this->User->FriendTo->unbindModel(array('belongsTo' => array('UserFrom', 'UserTo')));
            $this->User->hasMany['FriendFrom']['fields'] = array('user_from', 'status', 'selection', 'user_to');
            $this->User->FriendFrom->unbindModel(array('belongsTo' => array('UserTo')));
            $user = $this->User->find('first', array('conditions' => array('User.id' => $user), 'fields' => array('User.id', 'User.username', 'User.full_name'), 'recursive' => 2));
        } else {
            $this->User->FriendFrom->unbindModel(array('belongsTo' => array('UserFrom')));
            $this->User->FriendFrom->UserTo->unbindModel(array('hasMany' => array('FriendFrom', 'GroupMember', 'Inbox', 'Sent', 'Draft', 'VideoAlbum', 'Comment', 'Like', 'NewsFeed'), 'hasAndBelongsToMany' => array('UserFriendship')));
            $this->User->unbindModel(array('hasAndBelongsToMany' => array('UserFriendship'), 'hasMany' => array('NewsFeed', 'Inbox', 'Sent', 'Draft', 'VideoAlbum', 'Comment', 'GroupMember')));
            $this->User->hasMany['PhotoAlbum']['fields'] = array('id');
            $this->User->PhotoAlbum->unbindModel(array('belongsTo' => array('User'), 'hasMany' => array('Like')));
            $this->User->PhotoAlbum->hasMany['Photo']['fields'] = array('photo', 'photo_dir');
            $this->User->hasMany['FriendTo']['fields'] = array('user_from', 'status', 'selection');
            $this->User->FriendTo->unbindModel(array('belongsTo' => array('UserFrom', 'UserTo')));
            $this->User->hasMany['FriendFrom']['fields'] = array('user_from', 'status', 'selection', 'id', 'user_to');
            $this->User->FriendFrom->unbindModel(array('belongsTo' => array('UserTo')));
            $user = $this->User->find('first', array('conditions' => array('User.username' => $user), 'fields' => array('User.id', 'User.username', 'User.full_name'), 'recursive' => 2));
        }
        $this->set('user', $user);
        $this->viewPath = 'Elements';
        $this->render('quicklook');
    }
    
    public function photoviewer($id = null) {
        $this->layout = 'ajax';
        $this->autoRender = false;
        if (!$id) die();
        if ($this->User->PhotoAlbum->Photo->exists($id)) {
            $this->User->PhotoAlbum->unbindModel(array('hasMany' => array('Like', 'Comment')));
            $this->User->PhotoAlbum->User->unbindModel(array('hasMany' => array('Comment')));
            $this->User->PhotoAlbum->belongsTo['User']['fields'] = array('id', 'full_name', 'username');
            $this->User->PhotoAlbum->User->unbindModel(array('hasMany' => array('Inbox', 'Draft', 'Sent', 'FriendFrom', 'FriendTo', 'GroupMember', 'NewsFeed', 'VideoAlbum'), 'hasAndBelongsToMany' => array('UserFriendship')));
            $this->User->PhotoAlbum->bindModel(array('hasMany' => array('Photo' => array('foreignKey' => 'photo_album_id', 'conditions' => array('primary' => 1, 'deleted' => 0), 'fields' => array('photo', 'photo_dir', 'deleted', 'primary'), 'limit' => 1))));
            $this->User->PhotoAlbum->Photo->belongsTo['PhotoAlbum']['fields'] = array('title', 'user_id');
            $this->User->PhotoAlbum->User->hasMany['PhotoAlbum']['fields'] = array('title', 'user_id', 'id');
            $this->User->PhotoAlbum->Like->belongsTo['User']['fields'] = array('id', 'username', 'full_name');
            $photo = $this->User->PhotoAlbum->Photo->find('first', array('conditions' => array('Photo.id' => $id, 'Photo.deleted' => 0), 'recursive' => 4));
            $this->set('data', $photo);
        }
        $this->viewPath = 'Elements';
        $this->render('photoviewer');
    }
    
    public function edit_photo_description() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            pr($this->data);
            if ($this->data['name'] == 'photoDescription') {
                $data['Photo'] = array('description' => $this->data['value'], 'id' => $this->data['pk']);
            }
            if ($this->User->PhotoAlbum->Photo->save($data)) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }
    
}

?>