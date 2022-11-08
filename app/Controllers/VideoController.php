<?php
namespace App\Controllers;

use App\Models\Post;
use App\Models\Video;
use TypeRocket\Controllers\WPPostController;
use App\Controllers\YoutubeController;

class VideoController extends WPPostController
{
    
    protected $video = null;
    protected $tablePrefix = null;
    protected $youtubeController = null;

    /**
     * Constructor
     */

    public function __construct(){
        $this->video = new Video();
        $this->youtubeController = new YoutubeController();

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

    /**
     * Render Page : Render Videos or Single Video to Front-end
     * @param string|null $slug
     */
    
    public function renderPage(string $slug = null)
    {
        $frontTitle = 'Video Imported List';
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

        if($slug && !$my_posts){
            header('Location: /404');
        }

        if($slug && $my_posts){
            $frontTitle = $my_posts[0]->post_title;
        }
        return tr_view($view , ['posts' => $my_posts])->setTitle($frontTitle);
    }


    /**
     * FetMore Action : Function to generate new video frm Pagination
     * @return string
     */

    public function fetchMore()
    {

       
       $checkIsAdmin = true; // Check if user is admin

       if($checkIsAdmin){

        $request = tr_request();

        $channelId = $request->getInput('channelId');
        $token = $request->getInput('token');

        if(!$channelId || !$token){
            header('Location: /404');
        }


        $resultData = $this->youtubeController->getDataFromYoutube($channelId , $token);

        echo tr_view('my.viewAjaxResponse' , $resultData);
       }
    }


    /**
     * Check or Prepare Config API
     * Return GOOGLE API KEY And Results Number
     * @return array
     */

    public function checkAndPrepareAPI()
    {
        $result = false;
        $sqlArray = [];
        $query = tr_query()->table($this->tablePrefix.'options');
        $apiKeyOption = $query->select('option_value')->where('option_name' , 'easy_video_google_api_key')->first();
        $query = tr_query()->table($this->tablePrefix.'options');
        $resultNumberOption = $query->select('option_value')->where('option_name' , 'easy_video_google_result_number')->first();

        // If value not exist Create a new One
        if(!$apiKeyOption){
            $query = tr_query()->table($this->tablePrefix.'options');
            $query->setIdColumn('option_id')->create([
                'option_name' => 'easy_video_google_api_key',
                'option_value' => ''
            ]);
        }

        // If value not exist Create a new One
        if(!$resultNumberOption){
            $query = tr_query()->table($this->tablePrefix.'options');
            $query->setIdColumn('option_id')->create([
                'option_name' => 'easy_video_google_result_number',
                'option_value' => ''
            ]);
        }


        if(!$apiKeyOption || !$resultNumberOption){
            return false;
        }

        if($apiKeyOption['option_value'] == null || $apiKeyOption['option_value'] == '' || !$apiKeyOption['option_value'] ||
        $resultNumberOption['option_value'] == null || $resultNumberOption['option_value'] == '' || !$resultNumberOption['option_value']){
            return false;
        }

        // If All tests Passed return values
        return ['easy_video_google_api_key' => $apiKeyOption['option_value'] , 'easy_video_google_result_number' => $resultNumberOption['option_value']];
    }


    /**
     * updateSettingsKeyValue Action
     * Update into database Each API Settings Option
     */
    public function updateSettingsKeyValue($key,$value)
    {
        $query = tr_query()->table($this->tablePrefix.'options');
        $query->select('*')->where('option_name' ,$key)->first();
        $query->update([
            'option_value' => $value
        ]);
    }

}
