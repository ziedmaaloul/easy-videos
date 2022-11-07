# Easy Videos Wordpress Plugin

## Framework : 
[![N|Solid](https://raw.githubusercontent.com/TypeRocket/art/main/wordmark/typerocket.svg)](https://typerocket.com/)


## Estimation Tasks:

| Hours | TASK |
| ------ | ------ |
| 5H | Wordpress Installation + Initialize Plugin + import videos from the Linus Tech Tips youtube channel to a custom post type video using youtube API  |
| 3H | Upon importing, the following information from the YouTube API should be saved as a meta field: title, description, medium thumbnail url, publish time. |
| 1H | I should also be able to select which videos I want to import and also have its preview before importing them. |
| TBI | If any channel or user has a lot of videos, there will be pagination for them as well. |
| 2H | Make the videos playable on frontend via an iframe. |

## Tasks Done

- Initialize Plugin
- Extend MVC file to Plugin
- Create Video Post Type
- Fetch Videos
- Save Each video as post type
- Add Admin Page for Youtube video Importing
- Add Style
- Support Link in Search Box
- Fetch Youtube Search from channel / User
- Display Video on table by Title , picture and description +  Style
- Display Post on Frontend
- Use Dynamic Prefix
- Check If Framework is installed
- Save API key in safe place
- Add paginations

## Enhancement

- Try to Save Post Type using Model
- Add Control if UI is Active Or Activate UI Automatic
- Set the number of result page in Configuration place

## Waiting
- Docker Image
- Watch Video and vidoe List only for connected user

## Notice

- I've exceeded  my quota in Google API
- Save Post Type Using Model return Framework Bug => I Think Bug in Framework
- UI is used on Pagination to set CRFS Token on Ajax Call
- Default Result per page is 15

## How to use

- Install TypeRocket Plugin : [Download Here](https://typerocket.com/downloads/v5.zip) , And check [Documentation](https://typerocket.com/docs/v5/install-via-plugin/)
- run composer install in this directory in server or run it and upload vendor folder
- Add Your Google API Key to wp_settings.php file (replace xxx by your API KEY)
- Result Per page of pagination is in YoutubeController
```sh
define( 'GOOGLE_API_KEY', 'xxxxxxxxxxxx' );
```
- Enjoy :) 

## Routes

- [List of video On Front-End](http://wordpress.local/video/)
- [Import Video](http://wordpress.local/wp-admin/admin.php?page=video_importer_view)
- [Video Post Type](http://wordpress.local/wp-admin/edit.php?post_type=video)