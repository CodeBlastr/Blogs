<?php

App::uses('BlogsAppController', 'Blogs.Controller');

/**
 * @property BlogPost BlogPost
 * @property Blog Blog
 */
class AppBlogPostsController extends BlogsAppController {

	public $allowedActions = array('latest');

/**
 * Uses
 *
 */
	public $uses = array('Blogs.BlogPost');
	
/**
 * Alias Format
 * 
 * @options %title%
 */
 	// public $aliasFormat = 'blog/%title%';

/**
 * Constructor
 *
 */
	public function __construct($request = null, $response = null) {		
		parent::__construct($request, $response);
		if (CakePlugin::loaded('Comments')) {
			$this->components['Comments.Comments'] = array('userModelClass' => 'User');
		}
		if (CakePlugin::loaded('Categories')) {
			$this->uses[] = 'Categories.Category';
		}
	}

/**
 * parse alias format
 * 
 * REALIZED THIS WON'T WORK, because I want the date to be date('F', strtotime('+ 1 month')).  How do you put that into something like %month%
 */
 	// protected function _aliasFormat($string = null) {
 		// if ($string === null) {
 			// return str_replace('%title%', '', $this->aliasFormat);
 		// }
		// __BLOGS_PREFIX 
		// 'companies/' . date('Y') . '/' . strtolower(date('F', strtotime('+ 1 month'))) . '/'
 	// }

/**
 * Before Filter
 *
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->passedArgs['comment_view_type'] = 'threaded';
		// $this->set('prefix', $this->aliasFormat());
	}

/**
 * View method
 *
 * @todo 		Need to find a better way more reusable way to use recaptcha
 */
	public function view($id = null) {
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
		$blogPost = $this->BlogPost->find('first', array(
			'conditions' => array(
				'BlogPost.id' => $id,
			),
			'contain' => array(
				'Blog',
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
			'conditions' => array('model' => 'Blogs.BlogPost')
		));

		$this->set('categories', $blogPost['Category']);
		$this->set('blogPost', $blogPost);
		$this->set('title_for_layout', __('%s', $blogPost['BlogPost']['title']));
		$this->set('page_title_for_layout', $blogPost['BlogPost']['title']);
		$this->set('description_for_layout', substr(strip_tags($blogPost['BlogPost']['text']), 0, 158));
	}

/**
 * Index method
 * 
 * @todo This needs to be updated to work with multi-blogs, by somehow grouping search results into blogs
 */
 	public function search($blogId = null) {
		$this->paginate['contain'][] = 'Owner';
		$this->paginate['contain'][] = 'Blog';
		$this->paginate['contain']['BlogPost']['order']['published'] = 'DESC';
		$this->BlogPost->bindModel(array('hasOne' => array('Alias' => array('foreignKey' => 'value'))));
		$this->paginate['contain'][] = 'Alias';
		if (!empty($blogId)) {
			$this->paginate['conditions']['BlogPost.blog_id'] = $blogId;
		}
		$this->set('blogPosts', $this->request->data = $this->paginate());
		$this->set(compact('blogId'));
		$this->set('page_title_for_layout', 'Posts Search');
		$this->set('title_for_layout', 'Posts Search');
 	}

/**
 * Add method
 */
	public function add($blogId = null) {

		if (strtolower($blogId) == 'my') {
			$myBlogId = $this->BlogPost->Blog->findBlogIdByOwnerId($this->userId);
			$this->redirect(array('action' => 'add', $myBlogId));
			return;
		}
		$this->BlogPost->Blog->id = $blogId;
		if (!$this->BlogPost->Blog->exists()) {
			throw new NotFoundException(__('Invalid blog.'));
		}
		if (!empty($this->request->data)) {
			try {
				unset($this->request->data['BlogPost']['id']);
				$this->BlogPost->save($this->request->data);
				$this->Session->setFlash('Blog Post Saved');
				$this->redirect(array('action' => 'view', $this->BlogPost->id));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		$authors = $this->BlogPost->Author->find('list');
		if (CakePlugin::loaded('Categories')) {
			$categories = $this->BlogPost->Category->find('list', array('conditions' => array('Category.model' => 'BlogPost')));
		} else {
			$categories = null;
		}
		$statuses = $this->BlogPost->statusTypes();
		$blog = $this->BlogPost->Blog->find('first', array('conditions' => array('Blog.id' => $blogId)));
		$page_title_for_layout = __('Add Blog Post to %s', $blog['Blog']['title']);

		$userGroups = Set::combine($this->BlogPost->Author->UserGroup->UsersUserGroup->getUserGroups(), '{n}.UserGroup.id', '{n}.UserGroup.title');

		$this->set(compact('authors', 'blogId', 'categories', 'statuses', 'page_title_for_layout', 'userGroups'));
	}

	public function getMetaDescripton($url = '') {
		$metaData = get_meta_tags(((strpos($url, 'http://') === 0 || (strpos($url, 'https://') === 0 ) ? '' : 'http://')) . $url);
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

		if ($this->request->is('put')) {
			try {
				$this->BlogPost->save($this->request->data);
				$this->Session->setFlash('Blog Post Saved');
				$this->redirect(array('action' => 'view', $this->BlogPost->id));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}

		$contain[] = 'Author';
		$contain[] = 'Blog';
		if (CakePlugin::loaded('Categories')) {
			$categories = $this->BlogPost->Category->generateTreeList(array('Category.model' => 'BlogPost'));
			$this->set(compact('categories'));
			$contain[] = 'Category';
		}
		if (CakePlugin::loaded('Tags')) {
			$contain[] = 'Tag';
			$tags = $this->BlogPost->Tag->Tagged->find('cloud', array('conditions' => array('Tagged.foreign_key' => $id)));
			$this->request->data['BlogPost']['tags'] = implode(', ', Set::extract('/Tag/name', $tags));
		}

		$blogPost = $this->BlogPost->find('first', array(
			'conditions' => array(
				'BlogPost.id' => $id
			),
			'contain' => $contain,
		));

		$this->request->data = $blogPost;
		$this->set('selectedCategories', Set::extract('/id', $this->request->data['Category']));
		$authors = $this->BlogPost->Author->find('list');
		$statuses = $this->BlogPost->statusTypes();
		$title_for_layout = __('Edit %s Post', $blogPost['BlogPost']['title']);
		$page_title_for_layout = __('Edit %s Post', $blogPost['BlogPost']['title']);
		$this->set(compact('authors', 'statuses', 'title_for_layout', 'page_title_for_layout'));
	}

/**
 * Latest method (should be removed in favor of the helper / element combo)
 */
	public function latest() {
		if (isset($this->request->params['named']['blog_id']) && isset($this->request->params['named']['limit'])) {
			$options = array(
				'conditions' => array(
					'BlogPost.blog_id' => $this->request->params['named']['blog_id'],
					'BlogPost.published <' => date('Y-m-d h:i:s'),
					'BlogPost.status' => 'published'
				),
				'contain' => array('Author'),
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
		$this->BlogPost->id = $id;
		if (!$this->BlogPost->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->BlogPost->delete()) {
			$this->Session->setFlash(__('Post deleted'));
			$this->redirect(array('controller' => 'blogs', 'action' => 'dashboard'));
		}
		$this->Session->setFlash(__('Post was not deleted'));
		$this->redirect(array('controller' => 'blogs', 'action' => 'dashboard'));
	}

}

if (!isset($refuseInit)) {

	class BlogPostsController extends AppBlogPostsController {

	}

}