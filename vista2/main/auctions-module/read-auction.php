<script>
        // JavaScript function to fetch search results for auctions
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

            xmlhttp.open("GET", "auction-module/search.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>

<!-- Search form for auctions -->
<form>
    <div id="search-box">
        <input type="text" id="search" name="search" onkeyup="showResults(this.value)" 
        placeholder="Search Auctions..."> 
        <a href="index.php?page=auctions&subpage=list" id="clear-button">Clear</a> 
    </div>
</form>

<!-- Search results container -->
<div id="search-result"></div>

<div id="subcontent">
    <?php
    $count = 1;    
    if ($auction->list_auctions() != false) {
        foreach ($auction->list_auctions() as $value) {
            extract($value);
            ?>
                <div class="gallery-item">
                        <div class="auction-image">
                            <img src="processes/art/<?php echo htmlspecialchars($artpiece_image); ?>" alt="<?php echo htmlspecialchars($artpiece_title); ?>">
                        </div>
                        <div class="gallery-details">
                            <h2><?php echo htmlspecialchars($artpiece_title); ?></h2>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($auction_description); ?></p>
                            <p><strong>Starting Date:</strong> <?php echo date("F j, Y", strtotime($start_date)); ?></p>
                            <p><strong>Ending Date:</strong> <?php echo date("F j, Y", strtotime($end_date)); ?></p>
                            <p><strong>Starting Bid:</strong> $<?php echo number_format($starting_bid, 2); ?></p>
                            <p><strong>Current Bid:</strong> $<?php echo number_format($current_bid, 2); ?></p>
                        </div>
                </div>
            <?php
        }
    } else {
        echo '<div class="no-auctions"><p>No auctions found.</p></div>';
    }
    ?>
</div>
