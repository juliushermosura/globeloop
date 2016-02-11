<div class="like_canvas">
    <?php
    unset($likes);
    $likes = array();
    $likeunlike = 'Like';
    //pr($data);
    if (isset($data['Like'])) {
        foreach ($data['Like'] as $like) {
            if ($like['like'] == '1') {
                if ($like['User']['id'] == $this->Session->read('Auth.User.id')) {
                    if (!empty($likes)) {
                        array_unshift($likes, 'You');
                    } else {
                        array_push($likes, 'You');
                    }
                    $likeunlike = 'Unlike';
                } else {
                    unset($user);
                    $user = !empty($like['User']['username']) ? $like['User']['username'] : $like['User']['id'];
                    array_push($likes, '<a href="/users/view/' .$user. '" rel="/users/quicklook/' .$user. '">' . $like['User']['full_name'] . '</a>');
                }
            }
        }
    }
    ?>
    <sub><a href="#like" title="<?php echo $likeunlike ?>" class="like <?php echo $type ?>" rel="like-<?php echo isset($data[$type]['id']) ? $data[$type]['id'] : $data['id'] ?>"><?php echo $likeunlike ?></a></sub>
    <div class="likers"><sub><?php echo !empty($likes) ? implode(', ', $likes) . ' likes this.' : '' ?></sub></div>
</div>