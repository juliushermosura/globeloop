<?php

class ShopsController extends AppController {
    
    public $uses = 'Deal';
    public $layout = 'shops';
    
    public function index() {
        $this->redirect(array('action' => 'featured_deals'));
    }
    
    public function featured_deals() {
        $deals = $this->Deal->find('all', array('conditions' => array('Deal.featured' => 1, 'Deal.deleted' => 0, 'Deal.publish_until >' => date('Y-m-d H:i:s'))));
        $title = 'Featured Deals';
        $subcats = array();
        $this->set(compact('subcats', 'title', 'deals'));
    }
    
    public function todays_deals($subcat = null) {
        $this->set('title', 'Today\'s Deals');
        switch ($subcat) {
            case "activities_and_events":
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.id' => 5)));
                break;
            case "health_and_beauty":
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.id' => 6)));
                break;
            case "dining":
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.id' => 4)));
                break;
            case "all":
            default:
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.parent_id' => 1)));
                break;
        }
        $title = 'Today\'s Deals';
        $subcats = $this->Deal->Category->find('all', array('conditions' => array('Category.parent_id' => 1), 'recursive' => -1));
        $this->set(compact('subcats', 'title', 'deals'));
        $this->render('deals');
    }
    
    public function products($subcat = null) {
        switch ($subcat) {
            case "home_and_kitchen":
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.id' => 11)));
                break;
            case "health_and_beauty":
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.id' => 10)));
                break;
            case "food_and_beverage":
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.id' => 9)));
                break;
            case "fashion":
                $data = $this->Deal->Category->find('all', array('conditions' => array('Category.id' => 8)));
                break;
            case "electronics":
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.id' => 7)));
                break;
            case "all":
            default:
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.parent_id' => 2)));
                break;
        }
        $title = 'Products';
        $subcats = $this->Deal->Category->find('all', array('conditions' => array('Category.parent_id' => 2), 'recursive' => -1));
        $this->set(compact('subcats', 'title', 'deals'));
        $this->render('deals');
    }
    
    public function travel($subcat = null) {
        switch ($subcat) {
            case "activities":
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.id' => 12)));
                break;
            case "abroad":
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.id' => 13)));
                break;
            case "local":
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.id' => 14)));
                break;
            case "domestic":
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.id' => 15)));
                break;
            case "all":
            default:
                $deals = $this->Deal->Category->find('all', array('conditions' => array('Category.parent_id' => 3)));
                break;
        }
        $title = 'Travel';
        $subcats = $this->Deal->Category->find('all', array('conditions' => array('Category.parent_id' => 3), 'recursive' => -1));
        $this->set(compact('subcats', 'title', 'deals'));
        $this->render('deals');
    }
    
    public function preview($id = null) {
        if (!empty($id)) {
            $data = $this->Deal->findById($id);
            $this->set('data', $data);
        }
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $this->request->data['Deal']['user_id'] = $this->Auth->user('id');
            if ($this->Deal->save($this->data)) {
                $this->Session->setFlash('This is a preview of your ad.', 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'preview', $this->Deal->getLastInsertId()));
            }
        }
        $places = $this->Deal->Place->find('list', array('conditions' => array('Place.publish' => 1)));
        $categories = $this->Deal->Category->find('threaded');
        foreach ($categories as $category) {
            unset($c);
            foreach($category['children'] as $cat) {
                $c[$cat['Category']['id']] = $cat['Category']['name'];
            }
            $data[$category['Category']['name']] = $c;
        }
        unset($categories);
        $categories = $data;
        $this->set(compact('places', 'categories'));
    }
    
    /*public function place() {
        $this->autoRender = false;
        $data['Place'] = array('title' => 'Davao', 'publish' => 1);
        $this->Deal->Place->save($data);
    }
    
    public function category() {
        $this->autoRender = false;
        $data['Category']['parent_id'] = '3';
        $data['Category']['name'] = 'Domestic';
        $this->Deal->Category->save($data);
    }*/

}

?>