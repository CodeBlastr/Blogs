<?php
App::uses('BlogsAppModel', 'Blogs.Model');

class Blog extends BlogsAppModel {
	public $hasMany = array(
		'BlogPost' => array(
			'className' => 'Blogs.BlogPost'
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
}
?>