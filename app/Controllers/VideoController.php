<?php
namespace App\Controllers;

use App\Models\Post;
use App\Models\Video;
use TypeRocket\Controllers\WPPostController;

class VideoController extends WPPostController
{
    
    protected $video = null;
    protected $tablePrefix = null;

    /**
     * Constructor
     */

    public function __construct(){
        $this->video = new Video();

        // Get Database table Prefix
        global $wpdb;
        $this->tablePrefix = $wpdb->prefix;
    }

    /**
     * Save to Video WP POST ACtion
     * @param array $video
     * @return bool
     */
    public function save($video)
    {
        $currentDate = date('Y-m-d h:i:s');
        $query = tr_query()->table($this->tablePrefix.'posts');
        $post_ID = $query->setIdColumn('ID')->create([
            'post_content' => $video['description'],
            'post_title' => $video['title'],
            'post_status' => 'publish',
            'comment_status' => 'close',
            'post_name' =>  sanitize_title($video['title']),
            'post_type' => 'video',
            'post_date' => $currentDate,
            'post_date_gmt' => $currentDate,
            'post_modified_gmt' => $currentDate,
            'post_modified' => $currentDate,
            'ping_status' => 'open',
            'menu_order' => 0,
            'post_excerpt' => '',
            'to_ping' => '',
            'pinged' => '',
            'post_content_filtered' => ''
        ]);

        $video_picture = $video['thumbnails'];
        $video_id = $video["videoId"];
        $publishedAt = $video['publishedAt'];
        $channelName ='nom de channel';

        $metaObject = 'a:4:{s:13:"video_picture";s:'.strlen($video_picture).':"'.$video_picture.'";s:8:"video_id";s:'.strlen($video_id).':"'.$video_id.'";s:12:"published_at";s:'.strlen($publishedAt).':"'.$publishedAt.'";s:12:"channel_name";s:'.strlen($publishedAt).':"'.$publishedAt.'";}';

        $query = tr_query()->table($this->tablePrefix.'postmeta');
        $meta_ID = $query->setIdColumn('meta_id')->create([
            'post_id' => $post_ID,
            'meta_key' => 'details',
            'meta_value' => $metaObject
        ]);

        return true;

    }

    
    public function renderPage(string $slug = null)
    {
        $view = 'single.videos';
        $args = array(
        'post_type'   => 'video',
        'post_status' => 'publish',
        );

        if($slug){
            $args['name'] = $slug;
            $args['numberposts'] = 1;
            $view = 'single.video';
        }

        $my_posts = get_posts($args);

        return tr_view($view , ['posts' => $my_posts]);
    }
}
