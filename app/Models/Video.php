<?php
namespace App\Models;

use TypeRocket\Models\WPPost;

class Video extends WPPost
{
    public const POST_TYPE = 'video';

    protected $metaless = [
        'details'
    ];


    protected $fillable = [
        'title',
        'post_author',
        'post_title',
        'json',
        'version',
        'slug',
        // 'post_status',
        // 'post_content'
    ];


    public function details(){
        return $this->hasOne(PostDetails::class , 'post_id');
    }
}
