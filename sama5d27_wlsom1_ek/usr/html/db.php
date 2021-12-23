<?php
   class MyDB extends SQLite3 {
      function __construct() {
         $this->open('access.sqlite');
      }
   }
   $db = new MyDB();
   if(!$db) {
      echo $db->lastErrorMsg();
   } else {
      echo "DB aperto correttamente<br /><br />";

      $sql =<<<EOF
         SELECT * from users;
   EOF;

      $ret = $db->query($sql);
      while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
        //header('Content-type: text/plain');
        echo "ID = ". $row['id'] . "<br />";
        echo "USERNAME = ". $row['username'] ."<br />";
        echo "PASSWORD = ". $row['password'] ."<br />";
        echo "AUTH = ".$row['auth'] ."<br /><br />";
      }
      echo "operazione andata a buon fine";
      $db->close();

   }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>DKC wallbox login</title>
    <meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
  </head>
  <body class="text-center">
  </body>
</html>
