# Easy Videos Wordpress Plugin

## Framework : 
[![N|Solid](https://raw.githubusercontent.com/TypeRocket/art/main/wordmark/typerocket.svg)](https://typerocket.com/)

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
- Run Wordpress by Docker
- Set the number of result page in Configuration place
- Set Api key and page number in other place (add new coinfiguration page)
- Watch Video and vidoe List only for connected user

## How to use

- Install TypeRocket Plugin : [Download Here](https://typerocket.com/downloads/v5.zip) , And check [Documentation](https://typerocket.com/docs/v5/install-via-plugin/)
- run composer install in this directory in server or run it and upload vendor folder
- Enjoy :-) 

## Run Using Docker

- [Download](https://typerocket.com/downloads/v5.zip) TypeRocket Plugin and extract zip file
- Set the path of Typerocket Extension in docker-compose.yml in the section of wordpress->volumes Volume 2 (# TypeRocket Extension)
- You can Update the physical path of wordpress installation in docker-compose.yml of wordpress->volumes Volume 3
- You can add also Your theme and other custom extension by adding new volumes
- Run docker-compose up
- Wordpress Link will be => [http://localhost:8080](http://localhost:8080)
- PhpMyAdmin Link will be => [http://localhost:8081](http://localhost:8081)
- Enjoy :-)

## Routes

- [List of video On Front-End](http://wordpress.local/video/)
- [Import Video](http://wordpress.local/wp-admin/admin.php?page=video_importer_view)
- [Video Post Type](http://wordpress.local/wp-admin/edit.php?post_type=video)
