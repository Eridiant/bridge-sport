<?php

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select URLs from the database
$sql = "SELECT url, allow FROM robots_data";
$result = $conn->query($sql);

// Start generating robots.txt content
$robotsTxt = "User-agent: *\n";

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        if($row["allow"]) {
            $robotsTxt .= "Allow: " . $row["url"] . "\n";
        } else {
            $robotsTxt .= "Disallow: " . $row["url"] . "\n";
        }
    }
} else {
    echo "0 results";
}
$conn->close();

// Output the robots.txt content
header('Content-Type: text/plain');
echo $robotsTxt;

?>


<?php
// Assuming you have the $posts variable defined as shown in the question

// Set the content type to plain text
header('Content-Type: text/plain');

// Start generating the robots.txt content
$robotsTxt = "User-agent: *\n\n";

foreach ($posts as $post) {
    $url = $post->url;
    $priority = $post->priority;
    $changefreq = $post->changefreq;
    $updatedAt = $post->updated_at;

    $robotsTxt .= "Sitemap: " . $url . "\n";
    $robotsTxt .= "Priority: " . $priority . "\n";
    $robotsTxt .= "Changefreq: " . $changefreq . "\n";
    $robotsTxt .= "Last modified: " . $updatedAt . "\n\n";
}

// Output the generated robots.txt content
echo $robotsTxt;
?>
