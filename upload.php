
<?php
/**
  * File contains upload page of Pixel Share
  * Allows users to upload images to the website
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
$query = "SELECT * FROM image";
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);

if (isset($_POST["submit"])) {
    $author =  $_POST["name"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $imagename=$_FILES["image"]["name"];
    $imagesize=$_FILES["image"]["size"] / 1000;
    $image_info = getimagesize($_FILES["image"]["tmp_name"]);
    $image_width = $image_info[0];
    $image_height = $image_info[1];

    $imageData = $_FILES["image"]["tmp_name"];
    $imageType = $_FILES["image"]["type"];
    $imgContent = addslashes(file_get_contents($imageData));
    $imgTypeDetail = substr($imageType, 6);
    if (substr($imageType, 0, 5) == "image") {
        $query = "INSERT into image (name, category, height, width, size, picture, type, author, price)
                VALUES ('$imagename', '$category', '$image_height', '$image_width', '$imagesize', '$imgContent', '$imgTypeDetail', '$author', '$price')";
        $result = $conn->query($query);
        if (!$result) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";

    }
    else {
        echo "Only images are allowed";
    }
    
    
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
    background-position: 50% 50%;
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
  h2 {
    font-family: "Comic Sans MS", cursive, sans-serif;
  }
  p {
    font-family: "Comic Sans MS", cursive, sans-serif;
  }
  body {
    font-family: "Comic Sans MS", cursive, sans-serif;
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
  .in {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  
  .s {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .s:hover {
    background-color: #45a049;
  }
  
  .d {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
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
  <a href="browse.php?user=$username">Browse All</a>
  <a class="active" href="upload.php?user=$username">Upload</a>
  <a href="account.php?user=$username">Account</a>
  <div class="search-container">
  <form action="search.php?user=$username" method="post">
    <input type="text" placeholder="Search.." name="search">
    <button type="submit" name="submit">Search</button>
  </form>
  </div>
</div>
<h2 style="padding-left:16px">Upload Image</h2>

<div class ="d">
  <form action="upload.php" method="POST" enctype="multipart/form-data">
    <label for="name">Name</label>
    <input class="in" type="text" name="name" placeholder="Your name..">

    <label for="price">Price</label>
    <input class="in" type="text" name="price" placeholder="Number of Credits...">

    <label for="category">Category</label>
    <select class="in" id="category" name="category">
      <option value="Food">Food</option>
      <option value="Nature">Nature</option>
      <option value="Animals">Animals</option>
      <option value="Buildings">Buildings</option>
      <option value="Art">Art</option>
      <option value="Everyday">Everyday</option>
    </select>
    <br>
    <br>
    <input type="hidden" name="id">
    <input type="file" name="image" id="image">
    <br>
    <br>
    <input class ="s" type="submit" value="Upload" name="submit">
  </form>
</div>

</body>
</html>


_END;



?>

