<!-- Import Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">


<?php

function displayMessage($message , $type = 'danger'){
    echo '<div class="alert alert-'.$type.'" role="alert">
            '.$message.'
        </div>';
}


function displayYoutubeLinkForm(){
    
    echo '<section>
                <form method="POST">
                    <input type="hidden" value="1" name="checker"/>
                    <div class="mb-3">
                            <label for="youtubeChannel" class="form-label">Youtube Channel</label>
                            <input type="text"value="https://www.youtube.com/c/LinusTechTips/videos" name="youtubeLink"  class="form-control" id="youtubeChannel" placeholder="Youtube Channel">
                    </div>
                    <button type="submit" class="btn btn-primary"> Fetch Videos ...</button>
                </form>
            </section>';
}

if($step == 'youtubelink' || $step == 'default'){

    if(isset($error)){
        displayMessage($message);
    }

    if(isset($success)){
        displayMessage($message , 'success');
    }

    displayYoutubeLinkForm();
}

if($step =='choose'){  ?>
        <section>
            <form method="POST">
            <input type="hidden" value="1" name="isVideoSelector"/>

            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Select</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Title</th>
                    <th scope="col">VideoId</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($data as $item) { ?>
                        <tr>
                            <th scope="row"><input type="checkbox" value="<?= $item['videoId']; ?>" name="yt_id[]"/></th>
                            <td><img src="<?= $item['thumbnails']; ?>"></td>
                            <td><?= $item['title']; ?></td>
                            <td><?= $item['videoId']; ?></td>
                        </tr>        
                     <?php   } ?>
                </tbody>
                </table>
                
                <button type="submit" class="btn btn-primary"> Import ...</button>
            </form>
        </section>
<?php } ?>
