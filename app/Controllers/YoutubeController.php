<?php

namespace App\Controllers;
use \Google\Client;
use \Google\Service\Youtube;
class YoutubeController
{
    protected $client = null;
    protected $service = null;

    /**
     * Constructor
     */

    public function __construct(){
        $this->client = new Client();
        $this->client->setApplicationName("Youtube_Importer");
        $this->client->setDeveloperKey("AIzaSyBAQu9nDuLhgPdmxTmtpZzyrLqil5OxfkI");
        $this->service = new Youtube($this->client);
    }


    /**
     * Constrcut Data from search list to array
     * @param  Google\Service\YouTube\VideoListResponse $searchResult
     * @return array
     */

    private function constructData($searchResult , $searchList = 0){

        if(!$searchResult){
            return [];
        }

        $resultList = [];

        $kindOperator = null;


        foreach ($searchResult->getItems() as $item) {
            $itemId = $item->id; // Get Item ID
            $itemSnippet = $item->snippet; // Get Item Snippet

            if ($searchList) {
                $kindOperator = $item->kind;
            } else {
                $kindOperator = $itemId->kind;
            }

    
            if($itemId && $kindOperator == 'youtube#video'){ // Be sure that this result is Video
                $resultList[] = ['videoId' => $searchList ? $itemId : $itemId->videoId , 'description' => $itemSnippet->description , 'publishedAt' => $itemSnippet->publishedAt,
                                'title' => $itemSnippet->title , 'thumbnails' => $itemSnippet->thumbnails->medium->url
                ];
            }
        }

        return $resultList;
    }

    /**
     * Fetch Data Function return Result List
     * @param string $channelName
     * @return array
     */
   public function fetchData($channelName)
   {
        
        $optParams = [
        'part' => 'snippet',
        //   'channelId'=> $query
        ];

        $searchResult =  $this->service->search->listSearch($channelName, $optParams);


        return $this->constructData($searchResult);
    }

    /**
     * Return Videos details array from Ids array
     * @param array $youtubeIds
     * @return array
     */
    public function getVideoChoosedList(array $youtubeIds)
    {
        if (!$youtubeIds){
            return [];
        }

        $query = '';
        $optParams = [
            'part' => 'snippet',
            'id' => implode(',',$youtubeIds)
            //   'channelId'=> $query
        ];

        $searchResult =  $this->service->videos->listVideos('', $optParams);

        return $this->constructData($searchResult  , 1);
    }
}
