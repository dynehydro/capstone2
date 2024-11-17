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
                    <a href="index.php?page=auctions&subpage=auctions&action=profile&id=<?php echo $auction_id; ?>">

                        <div class="auction-image">
                            <img src="processes/art/<?php echo htmlspecialchars($artpiece_image); ?>" alt="<?php echo htmlspecialchars($artpiece_title); ?>">
                        </div>
                        <div class="gallery-details">
                            <h2><?php echo htmlspecialchars($artpiece_title); ?></h2>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($auction_description); ?></p>

                            <p><strong>Time Remaining:</strong> <span id="countdown"></span></p>

                            <script>
                            // Set the end date in JavaScript
                            const endDate = new Date("<?php echo date('Y-m-d H:i:s', strtotime($end_date)); ?>").getTime();

                            function updateCountdown() {
                                const now = new Date().getTime();
                                const timeRemaining = endDate - now;

                                if (timeRemaining < 0) {
                                    document.getElementById("countdown").innerHTML = "Auction Ended";
                                    return;
                                }

                                // Calculate days, hours, minutes, and seconds remaining
                                const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                                const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                                const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                                // Display the result in the element with id="countdown"
                                document.getElementById("countdown").innerHTML = days + "d " + hours + "h " +
                                minutes + "m " + seconds + "s ";
                            }

                            // Update the countdown every 1 second
                            setInterval(updateCountdown, 1000);
                            </script>

                            <p><strong>Starting Bid:</strong> $<?php echo number_format($starting_bid, 2); ?></p>
                            <p><strong>Current Bid:</strong> $<?php echo number_format($current_bid, 2); ?></p>
                        </div>
                    </a>
                </div>
            <?php
        }
    } else {
        echo '<div class="no-auctions"><p>No auctions found.</p></div>';
    }
    ?>
</div>
