<?php foreach ($data as $item) { ?>
            <tr class="video-element">
                <th scope="row"><input type="checkbox" value="<?= $item['videoId']; ?>" name="yt_id[]"/></th>
                <td><img src="<?= $item['thumbnails']; ?>"></td>
                <td><?= $item['title']; ?></td>
                <td><?= $item['videoId']; ?></td>
            </tr>        
<?php   } ?>