<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS for the page-->
    <link rel="stylesheet" href="./Style/style.css">
    <link rel="icon" href="./Images/IOT_Logo.png" type="image/gif">
    <title>Legal Notice</title>
</head>
<body>
    <header>
        <nav class="nav">
            <span class="title">SAE 23</span>
            <ul class="pages">
                <li><a class="effect-underline" href="./index.php">Home</a></li>
                <li><a class="effect-underline" href="./sensors.php">Sensors</a></li>
                <li><a class="effect-underline" href="./contact.php">Contact</a></li>
                <li><a class="effect-underline" href="./legal_Information.php">Legal Notice</a></li>
                <li><a class="effect-underline" href="./ourwork.php">Our work</a></li>
            </ul>
            <?php 
            if (isset($_SESSION['grade'])) {
                if ($_SESSION['grade'] === 'Admin' ) {
                    echo "<span class='main_btn'><a href='./connection.php'>Admin</a></span>";
                }
                elseif ($_SESSION['grade'] === 'Manager') {
                    echo "<span class='main_btn'><a href='./connection.php'>Manager</a></span>";
                }
            }
            else {
                echo "<span class='main_btn'><a href='./connection.php'>Log In</a></span>";
            }
            
            ?>
        </nav>  
    </header>
    <section class="background">
        <div class="circle one"></div>
        <div class="circle two"></div>
        <div class="circle three"></div>
        <div class="circle four"></div>
        <div class="circle five"></div>
        <div class="circle sixe"></div>
    </section>
    <section class="main">
        <!-- If No JS -->    
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('js-message').style.display = 'none';
        });
        </script>

        <div id="js-message" style="display: block;">
            <center> <h1> Please enable JavaScript to allow the site to function properly. </h1> </center>
        </div>
        </script>
                <ul class="notice">
                    <li>
                        <h1>Our work: </h1>
                    </li>
                    <li>
                        <h2>
                        &bull;Division of time and tasks :
                        </h2>
                        <p>
                        To assign tasks and organize ourselves over time, we set up a GANTT. <br>
                        During the project, we had to adapt the GANTT forecast slightly, as we had misjudged the time it would take to complete certain tasks.
                        </p>
                        <p>Forecast Gantt :</p>
                        <img src="./Images/Gantt_forecast.png" alt="Forecast Gantt">
                        </p>
                        <p>Final Gantt :</p>
                        <img src="./Images/Gantt_final.png" alt="Final Gantt">
                        <h2>
                        &bull;Hugo's part :
                        </h2>
                        <p>
                        I took care of the two gantts, the database design with Yassir and the creation of the data recuperation script.<br>

                        The provisional gantt was not complicated to create, as we had already divided up our tasks, so all we had to do was to put this division of tasks on the gantt. <br>

                        Yassir and I gave a great deal of thought to the design of the database, as this was the most important stage of the project. It's thanks to this database that the project will be able to function. <br>

                        When I wanted to start the data retrieval script, I didn't know where to begin. So I started with a basic script that retrieves mqtt data. The second step of this script was to process the received data. The third step was to send the received data to the database we had created. The fourth step was to create a dynamic script that would process all the data requested from the database. The fifth step was to execute parts of my script in parallel to make it run faster. The final step was to indent and format the script. <br>

                        When the actual gantt was completed, I realized that we had met the critical dates we had set ourselves, and that the project had therefore been successfully completed. <br>

                        One difficulty I encountered was optimizing the bash script. In fact, in step 4, if there were 4 pieces of data to retrieve, the script would take 40 minutes to run. So I racked my brains to find the right solution to minimize the script execution time to 10 min maximum.
                        </p>
                        <p>
                        Relational diagram of our database :
                        </p>
                        <img src="./Images/Shema_BD_Final.PNG" alt="Relational diagram of our database">
                        <h2>
                        &bull;Gabin's part :
                        </h2>
                        <p>
                        I took care of making node-red and grafana, on node-red, I set up the mqtt in to retrieve the mqtt messages we needed from the topic. Then on node-red I downloaded the dashboard to be able to add gauges that I configured according to the building and the room. <br>
                        Then I had to create a sensor database in influxdb to put the values collected from node-red directly into the database. To do this, I had to install a tool on node-red to add the required node. This allowed me to set up the graphs on grafana.
                        </p>
                        <p>
                        Result of Grafana :
                        </p>
                        <img src="./Images/Grafana_Dashboard_R&T.png" alt="Result of Grafana">
                        <p>
                        Result of Node-Red :
                        </p>
                        <img src="./Images/Jauge_Building_GIM.png" alt="Result of Node-Red">
                        <h2>
                        &bull;Yassir's part :
                        </h2>
                        <p>
                            During this SAE, I worked with Hugo on the database design, so that we could agree from the outset on the types of data we were going to use, and so that our two scripts could work together. Secondly, and this was my main task, I took care of the back-end of the dynamic website, I essentially produced PHP code, but also JavaScript and HTML, in order to retrieve measurements from the database and display them, add/remove sensors and buildings and filter functionalities for displaying measurements. <br>
                        </p>
                        <br>
                        <p>

                            Problem encountered: <br>

                            Database hash truncation: When we designed the database we gave 255 characters in VARCHAR for our password fields, and this caused a problem because when I added a building with a manager who had a password that was a bit long, the password hash that was longer than 255 characters was truncated in the database which prevented password verification when logging in. <br>

                            <br>
                            Solution : <br>

                            To solve this problem, I changed the number of characters in the VARCHAR of the two password fields in the database to 2500 characters. <br>
                        </p>
                        
                        <p>

                         Problem encountered: <br>

                            I realized that when submitting a form, GET or POST, the data entered in the previous form is not saved in the new one. I needed to do this, as I wanted to display only the rooms that were linked to the building chosen in the previous form, the one that retrieves the room and sends the request to add a sensor. <br>

                        Solution : <br>

                            To overcome this problem, I saved the choices made in previous forms in the input tags of the next form, and set these tags to type="hidden", which hides them from users. This solved the problem and produced the result I wanted. <br>
                        </p>

                        <h2>
                        &bull;Baptiste's part :
                        </h2>
                        <p>
                        During this SAE, my main mission was to create the site, focusing on the front-end. <br>

                        Initially, I spent time rethinking the site's tree structure, as it was not optimal for managing the back-end. I made adjustments during the site creation phase to optimize it. <br>

                        I then divided the site into different parts/pages to make it easier to understand. This segmentation allowed me to better structure the content. <br>

                        Once this stage was complete, I began work on creating the HTML/CSS code. This was the most time-consuming part, as it was essential that the code be fully PHP-compatible. Therefore I produced a first version without taking PHP into account, then I adapted the parts of the site requiring the use of PHP. <br>

                        Once this task had been completed, I set about writing and translating the various parts of the site, with the exception of the "Our work" section, which was written by all of us.
                        </p>
                        <p>
                        Here's a model I made to help me preview the site's final design :
                        </p>
                        <img src="./Images/Design.png" alt="preview the site's final design">
                        <p>
                        To be able to continue improving my work without losing my old versions, I made great use of a GitHub repository. <br> Here's an example :
                        </p>
                        <img src="./Images/GitHub.png" alt="GitHub repository">
                    </li>
                </ul>
    </section>
    <footer>
        <ul>
            <li><a href="https://www.iut-blagnac.fr/fr/departement-rt" target="_blank" class="footer_text">IUT of Blagnac R&T Department</a></li>
            <li><a href="./legal_Information.php" class="footer_text" >© Copyright 2023 All rights reserved</a></li>
            <li><a href="https://www.linkedin.com/in/gabin-lopez-168bb525b" target="_blank" class="footer_text" >Lopez</a></li>
            <li><a href="#" target="_blank" class="footer_text" >Calmels</a></li>
            <li><a href="#" target="_blank" class="footer_text" >Boulouiha</a></li>
            <li><a href="https://www.linkedin.com/in/baptiste-alteirac" target="_blank" class="footer_text" >Alteirac</a></li>
        </ul>
    </footer>
</body>
</html>