
<?php
/**
  * File contains main page of Pixel Share
  * Queries database for most recently added pictures and most popular pictures by purchases
  *
  * @author Albert Yu
  *
  * 
  */
require_once 'login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);
if (isset($_GET['user'])) {
  $username = $_GET['user'];
} else {
  // Fallback behaviour goes here
  $username = "";
}
    
$query = "SELECT * FROM image order by id desc limit 7";
$sth = $conn->query($query);

$images = array();
$authors = array();
$prices = array();
$number = array();

while($row = mysqli_fetch_array($sth)) {
    $images[] = '<img src="data:picture/jpeg;base64,'.base64_encode( $row['picture'] ).'"width="600" height="350""/>';
    $authors[] = $row['author'];
    $prices[] = $row['price'];
    $number[] = $row['id'];
}

$query = "SELECT * FROM image order by purchases desc limit 7";
$sth = $conn->query($query);

$images2 = array();
$authors2 = array();
$prices2 = array();
$number2 = array();
while($row = mysqli_fetch_array($sth)) {
//echo '<img src="data:picture/jpeg;base64,'.base64_encode( $row['picture'] ).'"/>';
    $images2[] = '<img src="data:picture/jpeg;base64,'.base64_encode( $row['picture'] ).'"width="600" height="350""/>';
    $authors2[] = $row['author'];
    $prices2[] = $row['price'];
    $number2[] = $row['id'];
}
echo<<<_END

<!DOCTYPE html>
<html>
<head>
<style>
div.gallery {
  margin: 5px;
  float: left;
  width: 250px;
  background-color:#333;
  color: white;
  box-shadow: 1px 1px #333;
}

div.clear {
    clear: left;
}
div.gallery:hover {
  box-shadow: inset 0 0 100px 100px rgba(255, 255, 255, 0.1);
}

div.gallery img {
    position: relative;
    float: middle;
    width:  200px;
    height: 200px;
    background-position: center;
    background-repeat:   no-repeat;
    background-size:     cover;
    display: block;
    margin-left: auto;
    margin-right: auto;
}
div.desc {
  padding: 15px;
  text-align: center;
  font-family: "Comic Sans MS", cursive, sans-serif;
  font-size: 10px;
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
  h2 {
    font-family: "Comic Sans MS", cursive, sans-serif;
  }
  p {
    font-family: "Comic Sans MS", cursive, sans-serif;
  }
  body {
    padding-bottom: 50px;
  }
</style>
</head>
<body>

<div class="topnav">
  <a class="active" href="main_page.php?user=$username">Home</a>
  <a href="browse.php?user=$username">Browse All</a>
  <a href="upload.php?user=$username">Upload</a>
  <a href="account.php?user=$username">Account</a>
  <div class="search-container">
  <form action="search.php?user=$username" method="post">
    <input type="text" placeholder="Search.." name="search">
    <button type="submit" name="submit">Search</button>
  </form>
  </div>
</div>

<div style="padding-left:16px">
  <h2>Welcome $username</h2>
  <p>Recently Added</p>
</div>

<div class="gallery">
<a href="detail.php?number=$number[0]&user=$username">
  $images[0]
  </a>
  <div class="desc">By: $authors[0]<br>
  Price: $prices[0] credits</div></div>
</div>

<div class="gallery">
<a href="detail.php?number=$number[1]&user=$username">
  $images[1]
  </a>
  <div class="desc">By: $authors[1]<br>
  Price: $prices[1] credits</div></div>
</div>

<div class="gallery">
  <a href="detail.php?number=$number[2]&user=$username">
  $images[2]
  </a>
  <div class="desc">By: $authors[2]<br>
  Price: $prices[2] credits</div></div>
</div>

<div class="gallery">
  <a href="detail.php?number=$number[3]&user=$username">
  $images[3]
  </a>
  <div class="desc">By: $authors[3] <br>
  Price: $prices[3] credits</div></div>
</div>

<div class="gallery">
  <a href="detail.php?number=$number[4]&user=$username">
  $images[4]
  </a>
  <div class="desc">By: $authors[4]<br>
  Price: $prices[4] credits</div></div>
</div>

<div class="gallery">
  <a href="detail.php?number=$number[5]&user=$username">
  $images[5]
  </a>
  <div class="desc">By: $authors[5]<br>
  Price: $prices[5] credits</div></div>
</div>

<div class="gallery">
  <a href="detail.php?number=$number[6]&user=$username">
  $images[6]
  </a>
  <div class="desc">By: $authors[6]<br>
  Price: $prices[6] credits</div></div>
</div>


<div class="clear" style="padding-left:16px">
<br>
<p>Most Popular</p>
</div>
<div class="gallery">
  <a href="detail.php?number=$number2[0]&user=$username">
    $images2[0]
  </a>
  <div class="desc">By: $authors2[0] <br>
  Price: $prices2[0] credits</div></div>
</div>

<div class="gallery">
  <a href="detail.php?number=$number2[1]&user=$username">
  $images2[1]
  </a>
  <div class="desc">By: $authors2[1] <br>
  Price: $prices2[1] credits</div></div>
</div>

<div class="gallery">
  <a href="detail.php?number=$number2[2]&user=$username">
  $images2[2]
  </a>
  <div class="desc">By: $authors2[2] <br>
  Price: $prices2[2] credits</div></div>
</div>

<div class="gallery">
  <a href="detail.php?number=$number2[3]&user=$username">
  $images2[3]
  </a>
  <div class="desc">By: $authors2[3] <br>
  Price: $prices2[3] credits</div></div>
</div>
<div class="gallery">
  <a href="detail.php?number=$number2[4]&user=$username">
    $images2[4]
  </a>
  <div class="desc">By: $authors2[4] <br>
  Price: $prices2[4] credits</div></div>
</div>
<div class="gallery">
  <a href="detail.php?number=$number2[5]&user=$username">
    $images2[5]
  </a>
  <div class="desc">By: $authors2[5] <br>
  Price: $prices2[5] credits</div></div>
</div>
<div class="gallery">
  <a href="detail.php?number=$number2[6]&user=$username">
    $images2[6]
  </a>
  <div class="desc">By: $authors2[6] <br>
  Price: $prices2[6] credits</div></div>
</div>
<p><br></p>
</body>
</html>
_END;
?>


