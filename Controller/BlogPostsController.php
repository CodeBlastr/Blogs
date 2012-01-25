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
	
/**
 * Add method
 */
	public function add($blogId = null) {
		$this->BlogPost->Blog->id = $blogId;
		if (!$this->BlogPost->Blog->exists()) {
			throw new NotFoundException(__('Invalid blog.'));
		}
  		
		if(!empty($this->request->data)) {
			try {
				$this->BlogPost->add($this->request->data);
				$this->Session->setFlash('Blog Post Saved');
				$this->redirect(array('action' => 'view', $this->BlogPost->id));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		$categories = $this->BlogPost->Category->generateTreeList(array('Category.model' => 'BlogPost'));
		$this->set(compact('blogId', 'categories'));
	}
	
	
/**
 * Edit method
 */
	public function edit($id = null) {
		$this->BlogPost->id = $id;
		if (!$this->BlogPost->exists()) {
			throw new NotFoundException(__('Invalid post.'));
		}

		if(!empty($this->request->data)) {
			try {
				$this->BlogPost->add($this->request->data);
				$this->Session->setFlash('Blog Post Saved');
				$this->redirect(array('action' => 'view', $this->BlogPost->id));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		
		$this->request->data = $this->BlogPost->find('first',array(
			'conditions' => array(
				'BlogPost.id' => $id
				),
			'contain' => array(
				'Category',
				),
			));
			
		$categories = $this->BlogPost->Category->generateTreeList(array('Category.model' => 'BlogPost'));
		$this->set(compact('categories'));

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