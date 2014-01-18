<?php
App::uses('BlogsAppModel', 'Blogs.Model');

class Blog extends BlogsAppModel {
	
	public $name = "Blog";	
		
	public $hasMany = array(
		'BlogPost' => array(
			'className' => 'Blogs.BlogPost',
			'foreignKey' => 'blog_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
	); 
	
	public $belongsTo = array(
		'Owner' => array(
			'className' => 'Users.User',
			'foreignKey' => 'owner_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);





	public function findBlogIdByOwnerId($ownerId){
		$result = $this->find('first',array('conditions'=>
		array('Blog.owner_id'=>$ownerId)));
		return isset($result['Blog']['id']) ? $result['Blog']['id']  : '';
	}
}