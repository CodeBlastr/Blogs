<?php
App::uses('BlogsAppModel', 'Blogs.Model');

class BlogPost extends BlogsAppModel {

	var $name = "BlogPost";
	var $fullName = "Blogs.BlogPost"; //for the sake of comments plugin
	
	var $validate = array(
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

	var $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			), 
		'Blog' => array(
			'className' => 'Blogs.Blog'
			),
		);

    public $hasAndBelongsToMany = array(
        'Category' => array(
            'className' => 'Categories.Category',
       		'joinTable' => 'categorizeds',
            'foreignKey' => 'foreign_key',
            'associationForeignKey' => 'category_id',
    		'conditions' => 'Categorized.model = "BlogPost"',
    		// 'unique' => true,
	        ),
		);
	
	public function add($data) {
		if ($this->save($data)) {
			# this is how the categories data should look when coming in.
			if (isset($data['Category']['Category'][0])) {
				$categorized = array('BlogPost' => array('id' => array($this->id)));
				foreach ($data['Category']['Category'] as $catId) {
					$categorized['Category']['id'][] = $catId;
				}
				if ($this->Category->categorized($categorized, 'BlogPost')) {
					return true;
				} else {
					throw new Exception(__d('blogs', 'Blog post category save failed.'));
				}
				return true;
			}
		} else {	
			throw new Exception(__d('blogs', 'Blog post save failed.'));
		}
	}
}
?>