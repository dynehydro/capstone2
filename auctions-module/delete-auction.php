    <form method="POST" action="processes/process.art.php?action=delete">
        <div id="form-block-half">
            <input type="hidden" id="gallery_id" class="input" name="gallery_id" value="<?php echo $id;?>">
        </div>
        <div id="button-block">
            <input type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this art piece?');">
        </div>
  </form>