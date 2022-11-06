<?php

function displayYoutubeLinkForm(){
    
    echo '<section>
                <form method="POST">
                    <input type="hidden" value="1" name="checker"/>
                    <input type="text" value="LinusTechTips" name="youtubeLink"/>
                    <button type="submit"> Fetch Videos ...</button>
                </form>
            </section>';
}

if($step == 'youtubelink' || $step == 'default'){

    if(isset($error)){
        echo "Error " . $message;
    }

    displayYoutubeLinkForm();
}

if($step =='choose'){  ?>
        <section>
            <form method="POST">
            <input type="hidden" value="1" name="isVideoSelector"/>
                <table>
                    <tr>
                        <th>Select</th>
                    </tr>
                </table>
        
                <?php foreach ($data as $item) { ?>
                    <input type="checkbox" value="<?= $item['videoId']; ?>" name="yt_id[]"/>
        
        
            <?php   } ?>
        
                
                <button type="submit"> Import ...
                </button>
            </form>
        </section>
  

<?php } ?>
