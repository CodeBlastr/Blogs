<?php
App::uses('AppModel', 'Model');

class BlogsAppModel extends AppModel {
	
/**
 * Menu Init method
 * Used by WebpageMenuItem to initialize when someone creates a new menu item for the users plugin.
 * 
 */
 	public function menuInit($data = null) {
 		App::uses('Blog', 'Blogs.Model');
		$Blog = new Blog;
		$blog = $Blog->find('first', array('contain' => array('BlogPost')));
		if (!empty($blog)) {
	 		// link to users index, login, register, and my
			$data['WebpageMenuItem']['item_url'] = '/blogs/blogs/view/'.$blog['Blog']['id'];
			$data['WebpageMenuItem']['item_text'] = $blog['Blog']['title'];
			$data['WebpageMenuItem']['name'] = $blog['Blog']['title'];
			$data['ChildMenuItem'] = array(
				array(
					'name' => $blog['BlogPost'][0]['title'],
					'item_text' => $blog['BlogPost'][0]['title'],
					'item_url' => '/blogs/blog_posts/view/'.$blog['BlogPost'][0]['id']
				)
			);
		}
 		return $data;
 	}

}