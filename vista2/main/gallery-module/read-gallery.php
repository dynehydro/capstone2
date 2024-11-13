<?php

$user_id = $_SESSION['user_id'];

if ($user->get_user_access($user_id) == "user") {
    // Redirect to index.php?page=users if the condition is true
    header("index.php?page=gallery&subpage=gallery");
} else if ($user->get_user_access($user_id) == "admin") {
    // Display the button if the condition is false
    ?>
    <a href="index.php?page=gallery&subpage=gallery&action=create">
        <button class="button">
            <i class="fas fa-plus"></i>
        </button>
    </a>    
    <?php

}
?>

<script>
function showResults(str) {
    if (str.length === 0) {
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

    xmlhttp.open("GET", "gallery-module/search.php?q=" + str, true);
    xmlhttp.send();
}
</script>

<form>
    <div id="search-box">
        <input type="text" id="search" name="search" onkeyup="showResults(this.value)"
        placeholder="Search Galleries..."> 
        <a href="index.php?page=gallery&subpage=gallery" id="clear-button">Clear</a> 
    </div>
</form>

<div id="search-result"></div>

<div id="subcontent">

    <?php
    $count = 1;
    if ($gallery->list_galleries() != false) 
    {
        foreach ($gallery->list_galleries() as $value) 
        {
            extract($value);
    ?>
    
            <div class="gallery-item">
                <div class="gallery-image">
                    <img src="processes/uploads/<?php echo htmlspecialchars($gallery_image); ?>" alt="<?php echo htmlspecialchars($gallery_name); ?>" />
                </div>
                <br>
                <div class="gallery-details">
                    <h2><?php echo htmlspecialchars($gallery_name); ?></h2>
                    <a href="index.php?page=gallery&subpage=gallery&action=profile&id=<?php echo $gallery_id; ?>" class="gallery-item-link">Begin touring</a>
                </div>
            </div>
    <?php
        }
    } 
    
    else 
    {
        echo '<div class="no-galleries"><p>No galleries found.</p></div>';
        
    }
    ?>

</div>