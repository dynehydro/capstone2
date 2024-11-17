<?php
include 'config.php';  // Include your DB connection

// SQL query to fetch all galleries from the correct table (tbl_gallery)
$query = "SELECT * FROM tbl_gallery";
$result = mysqli_query($con, $query);

$galleries = array();
while ($row = mysqli_fetch_assoc($result)) {
    $galleries[] = $row; // Add each gallery to the array
}

// Return the galleries as a JSON response
echo json_encode($galleries);
?>
