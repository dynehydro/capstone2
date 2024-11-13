<div>
    <form method="POST" action="processes/processes.gallery.php?action=delete">
            <input type="hidden" id="gallery_id" class="input" name="gallery_id" value="<?php echo $id;?>">

            <input type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this gallery?');">
  </form>
</div>