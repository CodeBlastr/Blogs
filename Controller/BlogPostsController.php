<?php
class BlogPostsController extends BlogsAppController {

	public $components = array('Comments.Comments' => array('userModelClass' => 'User'));
	public $allowedActions = array('latest');
	public $uses = 'Blogs.BlogPost';
	
	
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		if (in_array('Recaptcha', CakePlugin::loaded())) { 
			$this->components[] = 'Recaptcha.Recaptcha'; 
		}
	}

	public function beforeFilter() {
		parent::beforeFilter();
		$this->passedArgs['comment_view_type'] = 'threaded';
	}
	
/**
 * View method
 *
 * @todo 		Need to find a better way more reusable way to use recaptcha
 */
	public function view($id=null) {
		# temporary recaptcha placement
		if (!empty($this->request->data)) {
			if ($this->Recaptcha->verify()) {
		        // do something, save you data, login, whatever
		    } else {
		        // display the raw API error
		        $this->Session->setFlash($this->Recaptcha->error);
				$this->redirect($this->referer());
		    }
		}
		Inflector::variable("BlogPost");

		$blogPost = $this->BlogPost->find('first',array(
			'conditions' => array(
				'BlogPost.id' => $id
				),
			'contain' => array(
				'User'
				),
			));
		
		$this->paginate = array(
			'limit' => 5,
			'order' => array(
			),
		);


		$this->paginate = array('Comment' => array(
			'order' => array('Comment.created' => 'desc'),
			'recursive' => 0,
			'limit' => 5,
			'conditions'=>array('model' => 'Blogs.BlogPost')
		));
		
		$this->set('blogPost',$blogPost);
	}
	
	public function add() {
		if(isset($this->request->params['named']['blog_id'])) {
			$blogId = $this->request->params['named']['blog_id'];
		} else if(isset($this->request->data['BlogPost']['blog_id'])) {
			$blogId = $this->request->data['BlogPost']['blog_id'];
		}
  			
		if(isset($blogId)) {
			$blog = $this->BlogPost->Blog->find('first',array(
				'conditions' => array(
					'Blog.id' => $blogId
				)
		   	));
			if(isset($blog['Blog'])) {
				if($this->Session->read('Auth.User.id') == $blog['Blog']['creator_id']) {
					if(!empty($this->request->data)) {
						if($this->BlogPost->save($this->request->data)) {
			   				$this->Session->setFlash('Blog Post Saved');
							$this->redirect('/blogs/blog_posts/view/' . $this->BlogPost->id);
						} else {
 						 	$this->Session->setFlash('Save error');
							$this->render(false);
						}
					} 
				} else {
					$this->Session->setFlash('You do not own this blog');
					$this->render(false);
				}
			} else {
			    $this->Session->setFlash('Invalid blog');
				$this->render(false);
			}
		} else {
			$this->Session->setFlash('Must specify blog');
			$this->render(false);
		}
	}//add()
	
	public function edit($id = null) {
		
		if(isset($this->request->data['BlogPost']['id'])) $id = $this->request->data['BlogPost']['id'];

		if(isset($id)) {
			if(!empty($this->request->data)) {
				if($this->BlogPost->save($this->request->data)) {
					$this->Session->setFlash('Blog Post Saved');
					$this->redirect('/blogs/blog_posts/view/' . $this->BlogPost->id);
				} else {
					$this->Session->setFlash('Save error');
					$this->render(false);
				}
			} else {
				$blogPost = $this->BlogPost->find('first',array(
					'conditions' => array(
						'BlogPost.id' => $id
						)
					));
				if($blogPost) {
					$this->set('blogPost',$blogPost);
				} else {
					$this->Session->setFlash('Blog Post not found');
					$this->render(false);
				}
			}
		} else {
			$this->Session->setFlash('You must specify a blog post');
			$this->render(false);
		}

	}//edit()
	
	public function latest() {
		#$this->Project = ClassRegistry::init('Projects.Project'); #TODO: why is this necessary here?
		
		if(isset($this->request->params['named']['blog_id']) && isset($this->request->params['named']['limit'])) {

			  $options = array(
			  	'conditions' => array(
					'BlogPost.blog_id' => $this->request->params['named']['blog_id']
				),
				'order' => 'created DESC',
				'limit' => $this->request->params['named']['limit']
			  );

			  return $this->BlogPost->find('all', $options);

		}
	}//most_watched()

}//controller 