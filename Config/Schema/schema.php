<?php 
class BlogsSchema extends CakeSchema {

	public $renames = array();

	public function before($event = array()) {
	    $db = ConnectionManager::getDataSource('default');
	    $db->cacheSources = false;
		App::uses('UpdateSchema', 'Model'); 
		$this->UpdateSchema = new UpdateSchema;
		$before = $this->UpdateSchema->before($event);
		return $before;
	}

	public function after($event = array()) {
		$this->_installData($event);
		$this->UpdateSchema->rename($event, $this->renames);
		$this->UpdateSchema->after($event);
	}

	public $blog_posts = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'blog_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'introduction' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'text' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tags' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'allow_comments' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'comments' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'comment' => 'counter cache'),
		'author_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'creator_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'modifier_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'published' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	public $blogs = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'start_page' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_public' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'owner_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'creator_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'modifier_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	
/**
 * Install Data Method
 * 
 * @param string $event
 */
	protected function _installData($event) {
		if (isset($event['create'])) {
			switch ($event['create']) {
	            case 'blogs':
	                $Model = ClassRegistry::init('Blogs.Blog');
					$Model->create();
					$Model->saveAll(array(
						'Blog' => array(
							'title' => __SYSTEM_SITE_NAME . ' Blog',
							'is_public' => 1,
							'owner_id' => CakeSession::read('Auth.User.id'),
						),
						'BlogPost' => array(
							array(
								'title' => 'First Blog Post',
								'text' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquam luctus est, eget vehicula augue blandit ut. Aenean ultrices sapien ac porta elementum. Morbi tempus elit leo, ac vehicula ante laoreet ac. Aenean tristique vulputate diam, quis faucibus tellus mattis in. Donec id ultricies sem, et porta dui. Curabitur suscipit, sem et tincidunt tincidunt, libero dolor dictum ligula, nec volutpat erat justo vel libero. Morbi commodo arcu eget lacus suscipit, eu sollicitudin felis lobortis. Fusce at vulputate mi. Sed vitae mi interdum, mollis neque sit amet, bibendum sem. Sed in dolor libero.</p><p>Proin auctor ipsum eget libero dignissim bibendum. Suspendisse potenti. Praesent dapibus dolor in sapien vulputate, eu congue urna faucibus. Sed at pulvinar enim, eu condimentum arcu. Maecenas at nisi a nulla ullamcorper placerat. Etiam eu elit tempor, porta erat eu, interdum dolor. Maecenas ultricies et quam sed feugiat. Aliquam quis metus eget elit posuere elementum. Nullam quis justo sed ligula laoreet convallis cursus semper ligula. Proin imperdiet nibh at dolor varius lobortis. Integer at consequat nunc, quis tincidunt mauris. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam porttitor diam non est blandit, vel aliquet nulla consectetur. Etiam vitae sem erat. Mauris scelerisque felis eu est bibendum, ut tincidunt ante molestie. In hac habitasse platea dictumst. Phasellus tincidunt, nisl quis adipiscing placerat, erat lacus sodales metus, mattis vehicula est mauris at diam. Aenean a elit sit amet dolor fringilla egestas in sit amet velit.</p><p>In molestie magna id lacinia fringilla. Ut sodales sapien in sem congue, aliquam posuere sapien laoreet. Nunc gravida mollis scelerisque. Vestibulum quis venenatis turpis, in vestibulum arcu. Mauris cursus pulvinar nisi, laoreet mattis nisi lacinia a. Vivamus euismod laoreet ante, ut sagittis justo sagittis non. Cras luctus hendrerit leo rhoncus pulvinar. Nulla sollicitudin nulla nec dui viverra volutpat vel id mauris. Morbi rhoncus non magna ut feugiat. Pellentesque adipiscing quam sollicitudin dui mollis, non dictum nulla pretium. In hac habitasse platea dictumst. Vivamus tincidunt sapien eget interdum feugiat.</p>',
								'status' => 'published',
								'author_id' => CakeSession::read('Auth.User.id'),
								'published' => date('Y-m-d h:i:s')
							)
						)
					));
				break;
			}
		}
	}

}
