<?php
Router::connect('/blog/feed', array('plugin'=>'blogs', 'controller' => 'blogs', 
                                     'action' => 'index', 
                                     'url' => array('ext' => 'rss')
                                ) );
?>
