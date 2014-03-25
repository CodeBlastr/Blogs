<?php
/**
 * BlogPost helper
 *
 * @package 	blogs
 * @subpackage 	blogs.views.helpers
 */
class BlogPostHelper extends AppHelper {

/**
 * helpers variable
 *
 * @var array
 */
	public $helpers = array ('Html', 'Form');

/**
 * Constructor method
 * 
 */
    public function __construct(View $View, $settings = array()) {
    	$this->View = $View;
    	//$this->defaults = array_merge($this->defaults, $settings);
		parent::__construct($View, $settings);
		App::uses('BlogPost', 'Blogs.Model');
		$this->BlogPost = new BlogPost();
    }

/**
 * Find method
 */
 	public function find($type = 'first', $params = array()) {
 		return $this->BlogPost->find($type, $params);
 	}

}