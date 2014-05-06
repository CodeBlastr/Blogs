<?php
/**
 * Class BlogsController
 * @property Blog Blog
 */
class BlogsController extends BlogsAppController {
	
	public $uses = 'Blogs.Blog';
	public $components = array('RequestHandler');
	public $helpers = array('Text');
	
/**
 * view method
 * 
 * @todo make this rss function available to all views and indexes automatically by just using the .rss or .xml extension
 */
	public function view($id = null) {
		if ($this->RequestHandler->isRss() ) {
			$this->RequestHandler->respondAs('xml');
			$blogPosts = $this->Blog->BlogPost->find('all', array(
				'limit' => 20,
				'order' => 'BlogPost.created DESC',
				'conditions' => array(
					'BlogPost.status' => 'published',
					'BlogPost.blog_id' => $id
				),
			));
			return $this->set(compact('blogPosts'));
		}
		if (!empty($this->request->params['named']['user'])) {
			$blog = $this->Blog->find('first',array(
				'conditions' => array(
					'Blog.owner_id' => $this->request->params['named']['user']
				)
			));
			$this->redirect(array($blog['Blog']['id']));
		}
		//$this->Blog->recursive = 1;
		$blog = $this->Blog->find('first',array(
			'conditions' => array(
				'Blog.id' => $id,
			)
		));
		
		$this->set('page_title_for_layout', $blog['Blog']['title']);
		$this->set(compact('blog'));

		if(isset($blog['Blog'])) {
			$this->paginate['conditions']['BlogPost.blog_id'] = $id;
			$this->paginate['conditions']['BlogPost.status'] = 'published';
			$this->paginate['conditions']['BlogPost.published <'] = !empty($this->request->query['preview']) ? $this->request->query['preview'] : date('Y-m-d h:i:s');
			$this->paginate['limit'] = 5;
			$this->paginate['order']['BlogPost.created'] = 'DESC';
			$this->paginate['contain'][] = 'Author';
			$this->paginate['contain'][] = 'Alias';
			$this->set('blogPosts', $this->paginate('BlogPost'));
		} else {
			$this->Session->setFlash('Unable to find blog');
			$this->render(false);
		}
	}
	
/**
 * Index method
 * 
 */
	public function index() {
		$this->paginate['contain'][] = 'Owner';
		$this->paginate['contain'][] = 'BlogPost';
		$this->set('blogs', $blogs = $this->paginate());
        if (count($blogs)) {
            $this->redirect(array('action' => 'view', $blogs[0]['Blog']['id']));
        }
	}

/**
 * Dashboard method
 */
 	public function dashboard($blogId = null) {
		$this->paginate['contain'][] = 'Owner';
		$this->paginate['contain']['BlogPost']['order']['published'] = 'DESC';
		$this->Blog->BlogPost->bindModel(array('hasOne' => array('Alias' => array('foreignKey' => 'value'))));
		$this->paginate['contain']['BlogPost'][] = 'Alias';
		if (!empty($blogId)) {
			$this->paginate['conditions']['Blog.id'] = $blogId;
		} else {
			$this->paginate['contain']['BlogPost']['limit'] = '5';
		}
		$this->set('blogs', $this->request->data = $this->paginate());
		$this->set(compact('blogId'));
		$this->set('page_title_for_layout', 'Blogs Dashboard');
		$this->set('title_for_layout', 'Blogs Dashboard');
 	}

/**
 * Categories method
 */
	public function categories() {
		$this->Blog->recursive = 0;
		$this->paginate['contain'][] = 'Category';
		if(isset($this->request->query['categories'])) {
			$categoriesParam = explode(';', rawurldecode($this->request->query['categories']));
			$this->set('selected_categories', json_encode($categoriesParam));
			$joins = array(
		           array('table'=>'categorized', 
		                 'alias' => 'Categorized',
		                 'type'=>'left',
		                 'conditions'=> array(
		                 	'Categorized.foreign_key = BlogPost.id'
		           )),
		           array('table'=>'categories', 
		                 'alias' => 'Category',
		                 'type'=>'left',
		                 'conditions'=> array(
		                 	'Category.id = Categorized.category_id'
				   ))
		         );
			$this->paginate['joins'] = $joins;
			$this->paginate['conditions']['Category.name'] = $categoriesParam;
		}
		$this->set('blogPosts', $blogPosts = $this->paginate('BlogPost'));
		$this->view = 'view';
	}

/**
 * add method
 * 
 * @return void
 */
	public function add() {
		if (!empty($this->request->data)) {
			if ($this->Blog->save($this->request->data)) {
				$this->redirect(array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'view', $this->Blog->id));
			}
		}
	}
	
/**
 * edit method
 * 
 * @todo make this rss function available to all views and indexes automatically by just using the .rss or .xml extension
 */
	public function edit($id = null) {
		$this->Blog->id = $id;
		if (!$this->Blog->exists()) {
			throw new NotFoundException(__('Invalid blog'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Blog->save($this->request->data)) {
				$this->Session->setFlash('Blog updated');
            	$this->redirect(array('action' => 'view', $this->request->data['Blog']['id']));	
			}
		}
		$this->request->data = $this->Blog->find('first',array(
			'conditions' => array(
				'Blog.id' => $id,
			)
		));
	}
	
/**
 * delete method
 * 
 */
	public function delete($id = null) {
		$this->__delete('Blog', $id);
	}

/**
 * my method
 * 
 * @return void
 */
	public function my() {
		$blog = $this->Blog->find('first',array(
			'conditions' => array(
				'Blog.owner_id' => $this->Session->read('Auth.User.id')
			)
		));
		if(isset($blog['Blog'])) {
			$this->redirect(array('action' => 'view', $blog['Blog']['id']));
		}
		else {
			$this->Session->setFlash('You do not have a blog.');
			$this->render(false);
		}
	}
}