<?php
/**
  * File contains detail page of image
  * Page opens when picture is clicked from main page, browse page, or search page. Shows watermarked image with image details along with button to purchase
  *
  * @author Albert Yu
  *
  * 
  */
require_once 'login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);
if (isset($_GET['number'])) {
    $id = $_GET['number'];
} else {
    // Fallback behaviour goes here
    $id = 120;
}
if (isset($_GET['user'])) {
  $username = $_GET['user'];
} else {
  // Fallback behaviour goes here
  $username = "";
}
if (isset($_GET['cost'])) {
  $cost = $_GET['cost'];
} else {
  // Fallback behaviour goes here
  $cost = 0;
}

if (isset($_POST['buy'])) {

  $query = "INSERT into transactions (user, image_id)
                VALUES ('$username', '$id')";
  $result = $conn->query($query);

  $query = "UPDATE users SET credit = credit - '$cost' WHERE username = '$username' and credit > 0";
  $result = $conn->query($query);

  //increment purchases for image

  $query = "UPDATE image SET purchases = purchases + 1 WHERE id = '$id'";
  $result = $conn->query($query);
}

$query = "SELECT * FROM image WHERE id = '$id'";
$sth = $conn->query($query);

$images = array();
$authors = array();
$prices = array();
$number = array();
while($row = mysqli_fetch_array($sth)) {
//echo '<img src="data:picture/jpeg;base64,'.base64_encode( $row['picture'] ).'"/>';
    $images[] = '<img src="data:picture/jpeg;base64,'.base64_encode( $row['picture'] ).'"width="50%"/>';
    $authors[] = $row['author'];
    $prices[] = $row['price'];
    $number[] = $row['id'];
    $height = $row['height'];
    $width = $row['width'];
    $size = $row['size'];
    $type = $row['type'];
    $date = $row['date'];
}


echo<<<_END
<!DOCTYPE html>
<html>
<head>
<style>
body {
    font-family: "Comic Sans MS", cursive, sans-serif;
}

div.polaroid {
  position: relative;
  float: middle;
  width: 100%;
  height: 100%
  background-color: white;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  margin-bottom: 25px;
  display: inline-block;
}
html, body {
    height:100%;
} 
div.polaroid img {
    osition: relative;p
    float: middle;
    max-width: 100%
    max-height: 100%
    background-position: center;
    background-repeat:   no-repeat;
    background-size:     cover;
    display: block;
    margin-left: auto;
    margin-right: auto;
}
.over
{
  opacity: 0.5;
  position: relative;
  bottom: 300px;
  left: 500px;
  
}
div.container {
  text-align: center;
  padding: 10px 20px;
}

.topnav {
    overflow: hidden;
    background-color: #333;
  }
  
  .topnav a {
    float: left;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
    font-family: "Comic Sans MS", cursive, sans-serif;
  }
  
  .topnav a:hover {
    background-color: #ddd;
    color: black;
  }
  
  .topnav a.active {
    background-color: #4CAF50;
    color: white;
  }
  .topnav .search-container {
    float: right;
  }
  
  .topnav input[type=text] {
    padding: 6px;
    margin-top: 8px;
    font-size: 17px;
    border: none;
  }
  
  .topnav .search-container button {
    float: right;
    padding: 6px;
    margin-top: 8px;
    margin-right: 16px;
    background: #ddd;
    font-size: 17px;
    border: none;
    cursor: pointer;
  }
  
  .topnav .search-container button:hover {
    background: #ccc;
  }
  
  @media screen and (max-width: 600px) {
    .topnav .search-container {
      float: none;
    }
    .topnav a, .topnav input[type=text], .topnav .search-container button {
      float: none;
      display: block;
      text-align: left;
      width: 100%;
      margin: 0;
      padding: 14px;
    }
    .topnav input[type=text] {
      border: 1px solid #ccc;  
    }
  }
  .button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 25px;
    text-align: center;
    font-size: 16px;
    cursor: pointer;
  }
  .button:hover {
    background-color: green;
  }
</style>
</head>
<body>
<div class="topnav">
  <a href="main_page.php?user=$username">Home</a>
  <a href="browse.php?user=$username">Browse All</a>
  <a href="upload.php?user=$username">Upload</a>
  <a href="account.php?user=$username">Account</a>
  <div class="search-container">
  <form action="search.php?user=$username">
    <input type="text" placeholder="Search.." name="search">
    <button type="submit">Search</button>
  </form>
  </div>
</div>
<br>
<div class="polaroid">

  $images[0]
  
  <div class="container">
  <p>By: $authors[0]
  <br>
  Dimensions: $width pixels by $height pixels
  <br>
  Size: $size bytes
  <br>
  Type: $type
  <br>
  Uploaded on: $date
  </p>
  <form action="detail.php?number=$id&user=$username&cost=$prices[0]" method="POST">
    <button class="button" name="buy" type="submit">Purchase for $prices[0] Credits</button>
  </form>
  </div>
  
</div>
<img src="watermark.jpg" class="over">

</body>
</html>
_END;

?>