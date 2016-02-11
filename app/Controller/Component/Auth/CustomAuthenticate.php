<?php

App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class CustomAuthenticate extends BaseAuthenticate {
/**
 * Settings for this object.
 *
 * - `fields` The fields to use to identify a user by.
 * - fields['username'] can be an array
 * - `userModel` The model name of the User, defaults to User.
 * - `scope` Additional conditions to use when looking up and authenticating users,
 *    i.e. `array('User.is_active' => 1).`
 *
 * @var array
 */
    public $settings = array(
        'fields' => array(
            'username' => array('username', 'email_address', 'gl_email'),
            'password' => 'password'
        ),
        'userModel' => 'User',
        //'scope' => array(
        //    'deleted' => false,
        //    'enabled' => true,
        //),
    );
    
    
/**
 * Authenticates the identity contained in a request.  Will use the `settings.userModel`, and `settings.fields`
 * to find POST data that is used to find a matching record in the `settings.userModel`.  Will return false if
 * there is no post data, either username or password is missing, of if the scope conditions have not been met.
 *
 * @param CakeRequest $request The request that contains login information.
 * @param CakeResponse $response Unused response object.
 * @return mixed.  False on login failure.  An array of User data on success.
 */
    public function authenticate(CakeRequest $request, CakeResponse $response)
    {
        $userModel = $this->settings['userModel'];
        list($plugin, $model) = pluginSplit($userModel);

        $fields = $this->settings['fields'];
        if (empty($request->data[$model])) {
            return false;
        }

        if (!is_array($fields['username']))
        {
            $fields['username'] = array($fields['username']);
        }
        
        if (empty($request->data[$model][$fields['password']]))
        {
            return false;
        }
        
        foreach ($fields['username'] as $usernameField)
        {
            if (!empty($request->data[$model][$usernameField]))
            {
                return $this->_findUser(
                    $request->data[$model][$usernameField],
                    $request->data[$model][$fields['password']]
                );
            }            
        }
        
        return false;
    }
    
/**
 * Find a user record using the standard options.
 *
 * @param string $username The username/identifier.
 * @param string $password The unhashed password.
 * @return Mixed Either false on failure, or an array of user data.
 */
    protected function _findUser($username, $password) {
        $userModel = $this->settings['userModel'];
        list($plugin, $model) = pluginSplit($userModel);
        $fields = $this->settings['fields'];

        if (!is_array($fields['username']))
        {
            $fields['username'] = array($fields['username']);
        }
        
        $conditions = array();
        
        foreach ($fields['username'] as $usernameField)
        {
            $conditions['OR'][] = array(
                $model . '.' . $usernameField => $username,
                $model . '.' . $fields['password'] => $this->_password($password),
            );
            
        }
        
        if (!empty($this->settings['scope'])) {
            $conditions = array_merge($conditions, $this->settings['scope']);
        }
        
        ClassRegistry::init($userModel)->unbindModel(array('hasMany' => array('NewsFeed', 'FriendFrom', 'FriendTo', 'Inbox', 'Sent', 'Draft', 'GroupMember', 'VideoAlbum', 'PhotoAlbum', 'Comment', 'Like'), 'hasAndBelongsToMany' => array('UserFriendship')));
        ClassRegistry::init($userModel)->PhotoAlbum->unbindModel(array('belongsTo' => array('User')));
        ClassRegistry::init($userModel)->PhotoAlbum->hasMany['Photo']['limit'] = 1;
        ClassRegistry::init($userModel)->FriendTo->unbindModel(array('belongsTo' => array('UserFrom', 'UserTo')));
        ClassRegistry::init($userModel)->bindModel(array('hasMany' => array('Inbox' => array('className' => 'Message', 'foreignKey' => 'recipient_id', 'conditions' => array('Inbox.draft' => 0, 'Inbox.deleted' => 0, 'Inbox.read' => 0), 'recursive' => -1, 'fields' => 'COUNT(Inbox.id) AS unread'),'FriendTo' => array('className' => 'Friendship', 'foreignKey' => 'user_to', 'fields' => array('FriendTo.status', 'FriendTo.user_from')), 'PhotoAlbum' => array('conditions' => array('PhotoAlbum.deleted' => 0, 'PhotoAlbum.primary' => 1)))));
        $result = ClassRegistry::init($userModel)->find('first', array(
            'conditions' => $conditions,
            'recursive' => 2
        ));
            
        if (!empty($result)) {
            $ids = array();
            foreach($result['FriendTo'] as $friend) {
                if (empty($friend['status']))
                    $ids[] = $friend['user_from'];
            }
            
            ClassRegistry::init($userModel)->unbindModel(array('hasMany' => array('NewsFeed', 'FriendFrom', 'FriendTo', 'Inbox', 'Sent', 'Draft', 'GroupMember', 'VideoAlbum', 'Comment', 'Like'), 'hasAndBelongsToMany' => array('UserFriendship')));
            ClassRegistry::init($userModel)->PhotoAlbum->unbindModel(array('belongsTo' => array('User')));
            ClassRegistry::init($userModel)->hasMany['PhotoAlbum']['fields'] = array('id', 'primary', 'deleted');
            ClassRegistry::init($userModel)->PhotoAlbum->hasMany['Photo']['fields'] = array('photo_dir', 'primary', 'photo', 'deleted');
            
            $friends = ClassRegistry::init($userModel)->find('all', array(
                'conditions' => array('id' => $ids),
                'recursive' => 2,
                'fields' => array('id', 'username', 'full_name')
            ));
        }

        if (empty($result) || empty($result[$model])) {
            return false;
        }
        unset($result[$model][$fields['password']]);
        
        if (!empty($result)) {
            if (!empty($result['PhotoAlbum']['0'])) {
                SessionComponent::write('Essentials', array('Photo' => $result['PhotoAlbum']['0']));
            }
            if (!empty($result['Inbox'])) {
                SessionComponent::write('Notifications', array('FriendRequests' => $friends, 'UnreadMails' => $result['Inbox']['0']['Inbox']['0']['unread']));
            } else {
                SessionComponent::write('Notifications', array('FriendRequests' => $friends));
            }
        }
        
        return $result[$model];
    }
}