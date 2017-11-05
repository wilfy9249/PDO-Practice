<?php

  //db connection class using singleton pattern
  class dbConn{

       //variable to hold html
       protected $html;

       //variable to hold connection object.
       protected static $db;
  
       //private construct - class cannot be instatiated externally.
       private function __construct() {
   
         try {
              // assign PDO object to db variable
              self::$db = new PDO( 'mysql:host=sql1.njit.edu; dbname=wc335', 'wc335', 'ZxBEThIc' );
              self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
              echo "<h1> WEEK 7 : PDO-PRACTICE</h1>";
              echo "1. Connection to the Database was successful";
         }
         
         catch (PDOException $e) {
               //Output error - would normally log this to error file rather than output to user.
               echo "Connection Error: " . $e->getMessage();
         }
    
      }
     
         // get connection function. Static method - accessible without instantiation
         public static function getConnection() {
      
            //Guarantees single instance, if no connection object exists then create one.
            if (!self::$db) {
              //new connection object.
              new dbConn();
           }
       
            //return connection.
            return self::$db;
       }
}

    $db = dbConn::getConnection();
    //print_r($db);
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $db->prepare('SELECT * from accounts WHERE id < 6');
    $statement->execute();

    // 2. Count the number of records from the Query that is fetched
    $count = $statement->rowCount();
    print("2. The number of records in the result is : "  .$count);

    // 3. Display the Records in HTML Table
    while($result = $statement->fetch(PDO::FETCH_ASSOC)) {
          $results[] = $result;
    }

    if ($count > 0) {

        echo "<table border=\"1\">
          <tr>
               <th>ID</th>
               <th>Email</th>
               <th>First Name</th>
               <th>Last Name</th>
               <th>Phone</th>
               <th>Birthdate</th>
               <th>Gender</th>
               <th>Password</th>
          </tr>";

        foreach ($results as $row) {

            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>
				  <td>" . $row["email"] . "</td>
                  <td>" . $row["fname"] . "</td>
                  <td>" . $row["lname"] . "</td>
                  <td>" . $row["phone"] . "</td>
                  <td>" . $row["birthday"] . "</td>
                  <td>" . $row["gender"] . "</td>
                  <td>" . $row["password"] . "</td>";
            echo "</tr>";
        }

    } else {
        echo 'No records found';
    }

?>
