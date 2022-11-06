<?php
namespace App\Controllers;

use App\Models\Post;
use App\Models\Video;
use TypeRocket\Controllers\WPPostController;

class VideoController extends WPPostController
{
    
    protected $video = null;


    public function __construct(){
        $this->video = new Video();
    }

    public function add()
    {
        $fields = [
            'title' => 'Checker',
            'post_author' =>1,
            'post_title' => 'Setting Fillable Model Fields',
            'content' => 'When saviChecker.',
            // 'post_content' => 'When saving fields to a model use fillable to restrict mass/bulk saving.',
            // 'post_status' => 'publish',
        ];
        $this->video->save($fields);

        $this->video->content = $fields['content'];
        // $this->video->post_content = $fields['content'];
        // $this->video->post_title = $fields['title'];
        $this->video->save($fields);
    }

    
    
    // Only `title` from fields is saved
    
    
    // Only `title` from fields is saved, and the
    // explicitly set `content` is saved.  
    
}
