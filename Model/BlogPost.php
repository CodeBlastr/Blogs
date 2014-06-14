<?php
App::uses('BlogsAppModel', 'Blogs.Model');
/**
 *@property Blog Blog
 *@property AppUser Author
 *@property Category Category
 *@property Tag Tag
 */
class BlogPost extends BlogsAppModel {

	public $name = "BlogPost";

	public $fullName = "Blogs.BlogPost"; //for the sake of comments plugin

 /**
  * Acts as
  *
  * @var array
  */
    public $actsAs = array(
        'Optimizable',
        'Galleries.Mediable',
		'Users.Usable'
		);

	public $validate = array();

	public $belongsTo = array(
		'Author' => array(
			'className' => 'Users.User',
			'foreignKey' => 'author_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			),
		'Blog' => array(
			'className' => 'Blogs.Blog',
			'foreignKey' => 'blog_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			),
		);

/**
 * Constructor
 *
 */
	public function __construct($id = false, $table = null, $ds = null) {
		if(CakePlugin::loaded('Media')) {
			$this->actsAs[] = 'Media.MediaAttachable';
		}
		if (CakePlugin::loaded('Tags')) {
			$this->actsAs['Tags.Taggable'] = array('automaticTagging' => true, 'taggedCounter' => true);
		}
		if (CakePlugin::loaded('Categories')) {
			$this->actsAs[] = 'Categories.Categorizable';
			$this->hasAndBelongsToMany['Category'] = array(
            	'className' => 'Categories.Category',
	       		'joinTable' => 'categorized',
	            'foreignKey' => 'foreign_key',
	            'with' => 'Categories.Categorized',
	            'associationForeignKey' => 'category_id',
    			'conditions' => 'Categorized.model = "BlogPost"',
	    		// 'unique' => true,
		        );
		}
    	parent::__construct($id, $table, $ds);
    }

/**
 * The publish status of a post
 *
 * @param null
 * @return array
 */
	public function statusTypes() {
		return array(
			'published' => 'Published',
			'draft' => 'Draft',
			'pending' => 'Pending Approval',
			);
	}

/**
 * Before save
 *
 * @return bool
 */
	public function beforeSave($options = array()) {
		if (!isset($this->data['BlogPost']['published']) || empty($this->data['BlogPost']['published'])) {
			$this->data['BlogPost']['published'] = date('Y-m-d h:i:s');
		}
		return parent::beforeSave($options);
	}


/**
 * After save
 *
 * @return null
 * @todo		Not the best way to handle this.  Would be cool if it were a callback or something.
 */
	public function afterSave($created) {
		// use twitter behavior to update status about new post
		if ($created && in_array('Twitter', CakePlugin::loaded()) && in_array('Connections', CakePlugin::loaded())) {
			$body = $this->data['BlogPost']['title'] . ' http://'.$_SERVER['HTTP_HOST'].'/blogs/blog_posts/view/' . $this->id;

			App::uses('Connect', 'Connections.Model');
			$Connect = new Connect;
			$twitter = $Connect->find('first', array(
				'conditions' => array(
					'Connect.user_id' => CakeSession::read('Auth.User.id'),
					),
				));
			$connect = unserialize($twitter['Connect']['value']);

			if (!empty($connect['oauth_token']) && !empty($connect['oauth_token_secret'])) {
				$this->Behaviors->load('Twitter.Twitter', array(
					'oauthToken' => $connect['oauth_token'],
					'oauthTokenSecret' => $connect['oauth_token_secret'],
					));
				$this->updateStatus($body);
			}
		}
	}


/**
 * Add method
 *
 * @param array
 * @return bool
 */
	public function add($data) {
		return $this->save($data);
	}

/**
 *
 * @param int $groupId
 * @return array
 */
	public function getGroupsPosts($groupId) {
		// find posts that belong to this group
		App::uses('Used','Users.Model');
		$Used = new Used();
		$groupsPosts = $Used->find('all', array(
			'conditions' => array(
				'Used.model' => 'BlogPost',
				'Used.user_group_id' => $groupId
			)
		));
		$postIds = Hash::extract($groupsPosts, "{n}.Used.foreign_key");
		$posts = $this->find('all', array(
			'conditions' => array('BlogPost.id' => $postIds),
			'contain' => array('Author'),
			'order' => array('BlogPost.published' => 'DESC'),
			'nocheck' => true // disable Usable::beforeFind, for this call
		));
		return $posts;
	}
	
/**
 * Sitemap method
 * Called to from the main sitemap controller
 * 
 * @return array
 */
	public function sitemap() {
		$pages = $this->find('all', array('conditions' => array('BlogPost.published <' => date('Y-m-d')), 'order' => array('BlogPost.published' => 'DESC')));
		for ($i=0; $i < count($pages); $i++) {
			$sitemap[$i]['url']['loc'] = 'http://' . $_SERVER['HTTP_HOST'] . $pages[$i]['BlogPost']['_alias'];
			$sitemap[$i]['url']['lastmod'] = $pages[$i]['BlogPost']['modified'] > $pages[$i]['BlogPost']['published'] ? date('Y-m-d', strtotime($pages[$i]['BlogPost']['published'])) : date('Y-m-d', strtotime($pages[$i]['BlogPost']['modified']));
			$sitemap[$i]['url']['changefreq'] = 'monthly';
			$sitemap[$i]['url']['priority'] = '0.5';
		}
		return array_values($sitemap);
	}

}
