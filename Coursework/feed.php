<?php
  $config = simplexml_load_file("config.xml") or die("error");

  $rssfeed = "";
  $host=$config->MySQL->host;
  $servername = $config->MySQL->database;
  $username = $config->MySQL->username;
  $password = $config->MySQL->password;
  $conn = new mysqli($host, $username, $password, $servername);

  header("Content-Type: application/rss+xml; charset=ISO-8859-1");
  $rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
  $rssfeed .= '<rss version="2.0">';
  $rssfeed .= '<channel>';
  $rssfeed .= '<title>Twin Cities RSS</title>';
  $rssfeed .= '<link>http://cems.uwe.ac.uk/~a2-matuzeviciu/</link>';
  $rssfeed .= '<description>RSS feed showing city and point of interest data currently in the database.</description>';
  $rssfeed .= '<language>en-us</language>';
  $rssfeed .= '<copyright>Copyright (C) 2009 mywebsite.com</copyright>';

  function add_post($title, $desc, $link){
    global $rssfeed;
    $rssfeed .= '<item>';
    $rssfeed .= '<title>' . $title . '</title>';
    $rssfeed .= '<description>' . $desc . '</description>';
    $rssfeed .= '<link>' . $link . '</link>';
    $rssfeed .= '</item>';
  }

//CITY's
  $sql = "SELECT * FROM City";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      while($row = $result->fetch_object()) {
        $post = "";
        $title = $row["Name"];
        foreach($row as $key=>$value){
          $post.= $key . ":" . $value. " | ";
        }
          add_post($title,$post,"http://cems.uwe.ac.uk/~a2-matuzeviciu/");
      }
  }

  $sql = "SELECT * FROM PlaceOfInterest";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      while($row = $result->fetch_object()) {
        $post = "";
        $title = $row["Name"];
        foreach($row as $key=>$value){
          $post.= $key . ":" . $value. " | ";
        }
        add_post($title,$post,"http://cems.uwe.ac.uk/~a2-matuzeviciu/");
      }
  }


  $rssfeed .= '</channel>';
  $rssfeed .= '</rss>';
  echo $rssfeed;

 ?>
