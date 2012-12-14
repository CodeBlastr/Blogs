<?php
$channel = array('title' => 'Recent Writing | Mark Story',
                'link' => '/posts/rss',
                'url' => '/posts/rss',
                'description' => 'Recent writing and musings of Mark Story',
                'language' => 'en-us',
                'managing-editor' => 'no-spam@my-domain.com',
            );
echo $rss->header(); ?>
<?xml-stylesheet type="text/xsl" href="<?php echo $rss->webroot('css/feed.xsl') ?>" ?>
<?php 
$channelEl = $rss->channel(array(), $channel, $items);
 
echo $rss->document(array(), $channelEl);
?>