<?php 
    /*  
        The config folder MUST ABSOLUTELY be placed in the directory where the public_html folder is located.
        NOT INSIDE THE public_html DIRECTORY
          ________________________________________
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\\
        //----------------------------------------\\
        || ! WARNING: DO NOT PUT THIS FILE       !||
        || ! IN YOUR PUBLIC HTML DIRECTORY       !|| 
        || ! WHERE IT CAN BE DOWNLOADED          !|| 
        || ! BY ANY USER                         !||
        ||!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!||
        \\________________________________________//
    */

    //DB identifiers
    $dbHost = "localhost";
    $dbUser = "admin";    
    $dbPass = 'sae23';       //Enter user password, if no password for user leave blank
    $dbName = "sae23";      //Name of the database to be used

    //Rooms in the iut buildings
    $building_rooms = [

      'Batiment R&T' =>  [ 'E001', 'E002', 'E003', 'E004', 'E005', 'E006', 'E007',
       'E100', 'E101', 'E102', 'E103', 'E104', 'E105', 'E106', 'E201', 'E206', 'E207', 'E208', 'E209', 'E210'
      ],

      'Batiment INFO' => [ 'B001', 'B002', 'B003', 'B101', 'B102', 'B103', 'B104', 'B105', 'B106', 'B107', 'B108', 'B109', 'B110', 'B111',
       'B112', 'B113', 'B201', 'B202', 'B203', 'B212','B217','B219'
      ],

      'Batiment C' => [ 'C004', 'C006'],
      
      'Batiment A' => ['A007']
      
    ];


    //Function to make data retrieval in tables less repetitive
    function fetchResults($result) {
      $rows = array();
  
      while ($row = mysqli_fetch_array($result)) {
        $rows[] = $row;
      }
  
      return $rows;
    }
  
    //Function to use strtotime with French date format
    function fr_strtotime($date){

      $date = explode('/', $date);
      $date = strtotime($date[2] . '-' . $date[1] . '-' . $date[0]);

      return $date;
    }
    


?>