
<?php

/**
  * File contains browse page of Pixel Share
  * Queries database for most all pictures
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
    float: middle;
    width:  200px;
    height: 200px;
   
    display: block;
    margin-left: auto;
    margin-right: auto;
}
.over
	{
		position:absolute;
		top: 10px;
		left: 10px;
		z-index: 1;
	}
	.under
	{
		position:absolute;
		top: 25px;
		left: 25px;
		z-index: 2;
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
  h2 {
    font-family: "Comic Sans MS", cursive, sans-serif;
  }
  p {
    font-family: "Comic Sans MS", cursive, sans-serif;
  }
  body {
    padding-bottom: 50px;

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
</style>
</head>
<body>

<div class="topnav">
  <a href="main_page.php?user=$username">Home</a>
  <a class="active" href="browse.php?user=$username">Browse All</a>
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
  <p>All Images</p>
</div>

<div style="padding-left:16px">
  <p></p>
</div>
_END;
$query = "SELECT * FROM image";
$sth = $conn->query($query);

$images = array();
$authors = array();
$prices = array();
$number = array();
while($row = mysqli_fetch_array($sth)) {
//echo '<img src="data:picture/jpeg;base64,'.base64_encode( $row['picture'] ).'"/>';
    $images[] = '<img src="data:picture/jpeg;base64,'.base64_encode( $row['picture'] ).'"width="600" height="350""/>';
    $authors[] = $row['author'];
    $prices[] = $row['price'];
    $number[] = $row['id'];
}
for ($j = 0; $j < sizeof($images); ++$j ) {


echo<<<_END
<div class="gallery">
  <a href="detail.php?number=$number[$j]&user=$username">
    $images[$j]
  </a>
  <div class="desc">By: $authors[$j] <br>
  Price: $prices[$j] credits</div>
</div>
_END;
}
echo<<<_END
<p><br></p>
</body>
</html>
_END;



?>


