<script>
function showResults(str) {
  if (str.length == 0) {
    document.getElementById("search-result").innerHTML = "";
    document.getElementById("search-result").style.border = "0px";
    return;
  } 
  
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
      document.getElementById("search-result").innerHTML = xmlhttp.responseText;
    }
  };

  xmlhttp.open("GET", "art-module/search.php?q=" + str, true);
  xmlhttp.send();
}
</script>

<form>
    <div id="search-box">
        <input type="text" id="search" name="search" onkeyup="showResults(this.value)" 
        placeholder="Search Art Pieces..."> 
        <a href="index.php?page=art&subpage=art" id="clear-button">Clear</a> 
    </div>
</form>

<div id="search-result"></div>

<div id="artcontent">
    <?php
    $count = 1;
    if ($artPiece->list_art_pieces() != false) {
        foreach ($artPiece->list_art_pieces() as $value) {
            extract($value);
            ?>
                <div class="art-item">
                <a href="index.php?page=art&subpage=art&action=profile&id=<?php echo $artpiece_id; ?>">
                    <div class="art-image">
                        <img src="processes/art/<?php echo htmlspecialchars($artpiece_image); ?>" alt="<?php echo htmlspecialchars($artpiece_title); ?>">
                    </div>
                    <div class="art-details">
                        <h2><?php echo htmlspecialchars($artpiece_title); ?></h2>
                        <p><?php echo htmlspecialchars($artpiece_description); ?></p>
                    </div>
                </div>
            </a>
            <?php
        }
    } else {
        echo '<div class="no-galleries"><p>No art pieces found.</p></div>';
    }
    ?>
</div>
</div>
