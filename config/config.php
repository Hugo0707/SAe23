<?php 
    /*  
        PLACER LE DOSSIER config DANS LE REPERTOIRE OU SE TROUVE LE DOSSIER PUBLIC_HTML (htdocs pour xampp en local)
          ________________________________________
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\\
        //----------------------------------------\\
        || ! ATTENTION NE PAS METTRE CE FICHIER ! ||
        || ! DANS VOTRE REPERTOIRE PUBLIC HTML  ! || 
        || ! OU CELUI CI POURRA ETRE TELECHARGÉ ! || 
        || ! PAR N'IMPORTE QUEL UTILISATEUR     ! ||
        ||!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!||
        \\________________________________________//
    */

    //Identifiants BD
    $dbHost = "localhost";
    $dbUser = "admin";    
    $dbPass = 'SndRshfoK6g&t4FqXAfK6rgKr@N#KE6iRQ?YsE$n';          //Entrer mdp de l'utilisateur, si aucun mdp pour l'utilisateur laisser vide
    $dbName = "sae23";      //Nom de la base de données à utiliser

    //Salles Présentes dans les Batiments de l'iut
    $building_rooms = [

      'Batiment R&T' =>  [ 'E001', 'E002', 'E003', 'E004', 'E005', 'E006', 'E007',
       'E100', 'E101', 'E102', 'E103', 'E104', 'E105', 'E106', 'E201', 'E206', 'E207', 'E208', 'E209', 'E210'
      ],

      'Batiment INFO' => [ 'B001', 'B002', 'B003', 'B101', 'B102', 'B103', 'B104', 'B105', 'B106', 'B107', 'B108', 'B109', 'B110', 'B111',
       'B112', 'B113', 'B201', 'B202', 'B203', 'B212','B217','B219'
      ]
      
    ]


?>