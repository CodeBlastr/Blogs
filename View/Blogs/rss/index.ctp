<?php
/** 
* Callback used by RssHelper::items()
*/
function rss_transform($item) {
    return array('title' => $item['Post']['title'],
                'link' => '/posts/view/'.$item['Post']['slug'],
                'guid' => '/posts/view/'.$item['Post']['slug'],
                'description' => strip_tags($item['Post']['abstract']),
                'pubDate' => $item['Post']['created'],              
                );
}
 
 $this->set('items',  $rss->items($posts, 'rss_transform'));
?>