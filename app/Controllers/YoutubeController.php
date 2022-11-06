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
        $this->client->setDeveloperKey("xxxxxxxxxxxxxxx");
        $this->service = new Youtube($this->client);
    }


    /**
     * Constrcut Data from search list to array
     * @param  Google\Service\YouTube\VideoListResponse $searchResult
     * @return array
     */

    private function constructData($searchResult){

        if(!$searchResult){
            return [];
        }

        $resultList = [];

        foreach ($searchResult->getItems() as $item) {
            $itemId = $item->id; // Get Item ID
            $itemSnippet = $item->snippet; // Get Item Snippet
            if($itemId && $itemId->kind == 'youtube#video'){ // Be sure that this result is Video
                $resultList[] = ['videoId' => $itemId->videoId , 'description' => $itemSnippet->description , 'publishedAt' => $itemSnippet->publishedAt,
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

        $resultList = [];


        return $this->constructData($searchResult);
    }
}
