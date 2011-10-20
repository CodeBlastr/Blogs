<?php
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
}
?>