<?php
App::uses('BlogsAppModel', 'Blogs.Model');

class BlogPost extends BlogsAppModel {

	public $name = "BlogPost";
	public $fullName = "Blogs.BlogPost"; //for the sake of comments plugin
        
 /**
  * Acts as
  * 
  * @var array
  */
    public $actsAs = array(
        'Alias'
		);
	
	public $validate = array(
		'title' => array(
			'rule' => array('between',8,128),
			'required' => true,
			'message' => 'Title must be between 8 and 128 characters.'
		),
		'text' => array(
			'rule' => array('minLength',8),
			'required' => true,
			'message' => 'Content must be longer then 8 characters.'
		)
	);

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
	
	public function __construct($id = false, $table = null, $ds = null) {
		if (in_array('Tags', CakePlugin::loaded())) {
			$this->actsAs['Tags.Taggable'] = array('automaticTagging' => true, 'taggedCounter' => true);
			$this->hasAndBelongsToMany['Tag'] = array(
            	'className' => 'Tags.Tag',
	       		'joinTable' => 'tagged',
	            'foreignKey' => 'foreign_key',
	            'associationForeignKey' => 'tag_id',
	    		'conditions' => 'Tagged.model = "BlogPost"',
	    		// 'unique' => true,
		        );
		}
		if (in_array('Categories', CakePlugin::loaded())) {
			$this->hasAndBelongsToMany['Category'] = array(
            	'className' => 'Categories.Category',
	       		'joinTable' => 'categorized',
	            'foreignKey' => 'foreign_key',
	            'with' => 'Categorized',
	            'associationForeignKey' => 'category_id',
    			'conditions' => 'Categorized.model = "BlogPost"',
	    		// 'unique' => true,
		        );
		}
    	parent::__construct($id, $table, $ds);		
    }
	
	
	
/**
 * Before save
 * 
 * @return bool
 */
	public function beforeSave($options = array()) {
		if (isset($this->data['BlogPost']['published']) && empty($this->data['BlogPost']['published'])) {
			$this->data['BlogPost']['published'] = date('Y-m-d');
		}
		return true;
	}
	
	
/**
 * After save
 * 
 * @return null
 * @todo		Not the best way to handle this.  Would be cool if it were a callback or something.
 */
	public function afterSave($created) {		
		// use twitter behavior to update status about new post
		if ($created && in_array('Twitter', CakePlugin::loaded())) {
			$body = $this->data['BlogPost']['title'] . ' http://'.$_SERVER['HTTP_HOST'].'/blogs/blog_posts/view/' . $this->id; 
			
			App::uses('UserConnect', 'Users.Model');
			$UserConnect = new UserConnect;
			$twitter = $UserConnect->find('first', array(
				'conditions' => array(
					'UserConnect.user_id' => CakeSession::read('Auth.User.id'),
					),
				));
			$connect = unserialize($twitter['UserConnect']['value']);
			
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
		$categoryData['Category'] =  $data['Category'];
		if ($this->save($data)) {
			// this is how the categories data should look when coming in.
			if (isset($categoryData['Category']['Category'][0])) {
				$categorized = array('BlogPost' => array('id' => array($this->id)));
				foreach ($categoryData['Category']['Category'] as $catId) {
					$categorized['Category']['id'][] = $catId;
				}
				if ($this->Category->categorized($categorized, 'BlogPost')) {
					// do nothing, the return is at the bottom of this if
				} else {
					throw new Exception(__d('blogs', 'Blog post category save failed.'));
				}
				return true;
			}
		} else {	
			throw new Exception(__d('blogs', 'Blog post save failed.'));
		}
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
}
