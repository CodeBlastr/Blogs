<?php
class BlogsController extends BlogsAppController {
	
	function view($id=null) {
		if (!empty($this->request->params['named']['user'])) {
			$blog = $this->Blog->find('first',array(
				'conditions' => array(
					'Blog.user_id' => $this->request->params['named']['user']
				)
			));
			$this->redirect(array($blog['Blog']['id']));
		}
		$blog = $this->Blog->find('first',array(
			'conditions' => array(
				'Blog.id' => $id
			)
		));
		$this->set('blog',$blog);
		if(isset($blog['Blog'])) {
			$this->paginate = array(
				'limit' => 15,
				'order' => array(
					'BlogPost.created' => 'DESC',
				),
				'contain' => array(
					'User',
					),
			);
			$blogPosts = $this->paginate($this->Blog->BlogPost,array(
				'BlogPost.blog_id' => $id,
			));
			$this->set('blogPosts',$blogPosts);
		}
		else {
			$this->Session->setFlash('Unable to find blog');
			$this->render(false);
		}
	}
	
	function index() {
		$this->Blog->recursive = 0;
		$this->set('blogs', $this->paginate());
	}
	
	function my() {
		$blog = $this->Blog->find('first',array(
			'conditions' => array(
				'Blog.user_id' => $this->Session->read('Auth.User.id')
			)
		));
		if(isset($blog['Blog'])) {
			$this->redirect('/blogs/view/' . $blog['Blog']['id']);
		}
		else {
			$this->Session->setFlash('You do not have a blog.');
			$this->render(false);
		}
	}

	function add() {
		if (!empty($this->data)) {
			if ($this->Blog->save($this->data)) {
				$this->redirect(array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'view', $this->Blog->id));
			}
		}
	}
	
	function delete($id = null) {
		$this->__delete('Blog', $id);
	}
}
?>