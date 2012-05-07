<?php
/**
 * Most Watched Projects Element 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.projects.views.elements
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */


# this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
# it allows a database driven way of configuring elements, and having multiple instances of that configuration.
if(!empty($instance) && defined('__ELEMENT_BLOGS_LATEST_'.$instance)) {
	extract(unserialize(constant('__ELEMENT_BLOGS_LATEST_'.$instance)));
} else if (defined('__ELEMENT_BLOGS_LATEST')) {
	extract(unserialize(__ELEMENT_BLOGS_LATEST));
}


// options
$moduleTitle = isset($moduleTitle) ? $moduleTitle : 'Latest Posts';
$numberOfPosts = !empty($numberOfPosts) ? $numberOfPosts : 5;
$blogID = !empty($blogID) ? $blogID : 1;

$latestPosts = $this->requestAction('/blogs/blog_posts/latest/blog_id:'.$blogID.'/limit:'.$numberOfPosts);
?>

<div id="ELEMENT_BLOGS_LATEST_<?php echo $instance ?>">
	<h3><?php echo $moduleTitle ?></h3>
	<ul>
    	<?php
		#debug($latestPosts);
        foreach ($latestPosts as $post) {
			#debug($post);
			echo '<li>'
			. '<a href="/blogs/blog_posts/view/' . $post['BlogPost']['id'] . '">'
			. $post['BlogPost']['title']
			. '</a>'
			. ' <small>' . $post['BlogPost']['text'] .'</small>'
			. '</li>';
		}

		?>
    </ul>
</div>
