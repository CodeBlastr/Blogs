<?php
$this->set('channelData', array(
    'title' => __("Most Recent Posts"),
    'link' => $this->Html->url('/', true),
    'description' => __("Most recent posts."),
    'language' => 'en-us'
));

// You should import Sanitize
App::uses('Sanitize', 'Utility');

foreach ($blogPosts as $post) {
    $postTime = strtotime($post['BlogPost']['created']);

    $postLink = array(
        'plugin' => 'blogs',
        'controller' => 'blog_posts',
        'action' => 'view',
//        'year' => date('Y', $postTime),
//        'month' => date('m', $postTime),
//        'day' => date('d', $postTime),
        $post['BlogPost']['id']
    );

    // This is the part where we clean the body text for output as the description
    // of the rss item, this needs to have only text to make sure the feed validates
    $bodyText = preg_replace('=\(.*?\)=is', '', $post['BlogPost']['text']);
    $bodyText = $this->Text->stripLinks($bodyText);
    $bodyText = Sanitize::stripAll($bodyText);
    $bodyText = $this->Text->truncate($bodyText, 400, array(
        'ending' => '...',
        'exact'  => true,
        'html'   => true,
    ));

    echo  $this->Rss->item(array(), array(
        'title' => $post['BlogPost']['title'],
        'link' => $postLink,
        'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
        'description' => $bodyText,
        'pubDate' => $post['BlogPost']['created']
    ));
}