<?php
class BlogsController extends BlogsAppController {
	
	public $uses = 'Blogs.Blog';
	
	public function view($id=null) {
		if (!empty($this->request->params['named']['user'])) {
			$blog = $this->Blog->find('first',array(
				'conditions' => array(
					'Blog.owner_id' => $this->request->params['named']['user']
				)
			));
			$this->redirect(array($blog['Blog']['id']));
		}
		$blog = $this->Blog->find('first',array(
			'conditions' => array(
				'Blog.id' => $id,
			)
		));
		$this->set('page_title_for_layout', $blog['Blog']['title']);
		$this->set('blog',$blog);
		if(isset($blog['Blog'])) {
			$this->paginate['conditions']['BlogPost.blog_id'] = $id;
			$this->paginate['conditions']['BlogPost.status'] = 'published';
			$this->paginate['conditions']['BlogPost.published <'] = date('Y-m-d h:i:s');
			$this->paginate['limit'] = 15;
			$this->paginate['order']['BlogPost.created'] = 'DESC';
			$this->paginate['contain'][] = 'Author';
			$blogPosts = $this->paginate('BlogPost');
			$this->set('blogPosts', $blogPosts);
		} else {
			$this->Session->setFlash('Unable to find blog');
			$this->render(false);
		}
	}
	
	public function index() {
		$this->Blog->recursive = 0;
		$this->set('displayName', 'title');
		$this->set('displayDescription', '');
		$this->set('blogs', $this->paginate());
	}
	
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

	public function add() {
		if (!empty($this->request->data)) {
			if ($this->Blog->save($this->request->data)) {
				$this->redirect(array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'view', $this->Blog->id));
			}
		}
	}
	
	public function delete($id = null) {
		$this->__delete('Blog', $id);
	}
}
?>