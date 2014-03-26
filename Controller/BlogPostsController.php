<?php

App::uses('BlogsAppController','Blogs.Controller');
/**
 *@property BlogPost BlogPost
 *@property Blog Blog
 */
class AppBlogPostsController extends BlogsAppController {

	public $allowedActions = array('latest');

/**
 * Uses
 *
 */

	public $uses = array('Blogs.BlogPost');

/**
 * Constructor
 *
 */
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		if (in_array('Recaptcha', CakePlugin::loaded())) {
			$this->components[] = 'Recaptcha.Recaptcha';
		}
		if (in_array('Comments', CakePlugin::loaded())) {
			$this->components['Comments.Comments'] = array('userModelClass' => 'User');
		}
		if (in_array('Categories', CakePlugin::loaded())) {
			$this->uses[] = 'Categories.Category';
		}
	}

/**
 * Before Filter
 *
 */
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
		// temporary recaptcha placement
		if (!empty($this->request->data)) {
			if ($this->Recaptcha->verify()) {
		        // do something, save you data, login, whatever
		    } else {
		        // display the raw API error
		        $this->Session->setFlash($this->Recaptcha->error);
				$this->redirect($this->referer());
		    }
		}
		$blogPost = $this->BlogPost->find('first',array(
			'conditions' => array(
				'BlogPost.id' => $id,
				),
			'contain' => array(
				'Author',
				'Category.name',
				'Category.id'
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

		$this->set('categories', $blogPost['Category']);
		$this->set('blogPost',$blogPost);
		$this->set('title_for_layout', __('%s | %s', $blogPost['BlogPost']['title'], __SYSTEM_SITE_NAME));
		$this->set('page_title_for_layout', $blogPost['BlogPost']['title']);
	}

/**
 * Add method
 */
	public function add($blogId = null) {

		if(strtolower($blogId) == 'my'){
			$myBlogId = $this->BlogPost->Blog->findBlogIdByOwnerId($this->userId);
			$this->redirect(array('action'=>'add',$myBlogId));
			return;
		}
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
		$authors = $this->BlogPost->Author->find('list');
		if (in_array('Categories', CakePlugin::loaded())) {
			$categories = $this->BlogPost->Category->find('list', array('conditions' => array('Category.model' => 'BlogPost')));
		} else {
			$categories = null;
		}
		$statuses = $this->BlogPost->statusTypes();
		$blog = $this->BlogPost->Blog->find('first', array('conditions' => array('Blog.id' => $blogId)));
		$page_title_for_layout = __('Add Blog Post to %s', $blog['Blog']['title']);

		$userGroups = Set::combine($this->BlogPost->Author->UserGroup->UsersUserGroup->getUserGroups(),
			'{n}.UserGroup.id','{n}.UserGroup.title');

		$this->set(compact('authors', 'blogId', 'categories', 'statuses', 'page_title_for_layout','userGroups'));

	}

	public function getMetaDescripton($url=''){
		$metaData = get_meta_tags(((strpos($url,'http://') === 0 || (strpos($url,'https://') ===0 ) ?  '' : 'http://')) . $url);
		$desc = isset($metaData['description']) ? $metaData['description'] : '';
		print_r($desc);
		$this->autoRender = false;
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

		$blogPost = $this->BlogPost->find('first',array(
			'conditions' => array(
				'BlogPost.id' => $id
				),
			'contain' => array(
				'Author',
				),
			));
		$this->request->data = $blogPost;

		if (in_array('Categories', CakePlugin::loaded())) {
			$categories = $this->BlogPost->Category->generateTreeList(array('Category.model' => 'BlogPost'));
			$this->set(compact('categories'));
		}
		if (in_array('Tags', CakePlugin::loaded())) {
			$tags = $this->BlogPost->Tag->Tagged->find('cloud', array('conditions' => array('Tagged.foreign_key' => $id)));
			$this->request->data['BlogPost']['tags'] = implode(', ', Set::extract('/Tag/name', $tags));
		}
		$authors = $this->BlogPost->Author->find('list');
		$statuses = $this->BlogPost->statusTypes();
		$page_title_for_layout = __('Edit %s', $blogPost['BlogPost']['title']);
		$this->set(compact('authors', 'statuses', 'page_title_for_layout'));
	}

	public function latest() {
		if(isset($this->request->params['named']['blog_id']) && isset($this->request->params['named']['limit'])) {
			  $options = array(
			  	'conditions' => array(
					'BlogPost.blog_id' => $this->request->params['named']['blog_id']
				),
				'order' => 'published DESC',
				'limit' => $this->request->params['named']['limit']
			  );
			  return $this->BlogPost->find('all', $options);
		}
	}

/**
 * delete post
 * @param integer $id
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->BlogPost->id = $id;
		if (!$this->BlogPost->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->BlogPost->delete()) {
			$this->Session->setFlash(__('Post deleted'));
			$this->redirect(array('controller' => 'blogs', 'action' => 'index'));
		}
		$this->Session->setFlash(__('Post was not deleted'));
		$this->redirect(array('controller' => 'blogs', 'action' => 'index'));
	}

}

if (!isset($refuseInit)) {
	class BlogPostsController extends AppBlogPostsController {}
}