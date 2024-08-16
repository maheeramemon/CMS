<?php
session_start();
$user_id = $_SESSION['utd_id']; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Landing Page</title>
    <style>
        body {
            font-family: Georgia, sans-serif;
            background-color: white;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .Landing {
            width: 1000px;
            margin: auto;
            margin-top: 40px;
            padding: 30px;
            border: 10px solid #ccc;
            border-radius: 60px;
        }
        .UTD_Header {
            width: 960px;
            height: 1vh;
            background-color: #df5d00;
            justify-content: space-between;
            color: white;
            padding: 40px;
            font-size: 18px;
            font-weight: bold;
            text-align: left;
            margin:auto;
            display: flex;
        }

        .Landing h3 {
            text-align: center;
            text-decoration: underline;
        }
        .Landing label {
            display: block;
            margin-top: 10px;
            
        }
        .Landing button {
            width: 100%;
            padding: 20px;
            margin-top: 40px;
            margin-bottom: 40px;
            background-color: green;
            font-size: 20px;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: auto;}

        .Landing input[type="text"], .Landing input[type="password"] {
            width: 98%;
            padding: 8px;
            margin-top: 7px;
            border: 2px solid #ccc;
            border-radius: 10px;
        }
        .Landing input[type="submit"] {
            width: 100%;
            padding: 5px;
            margin-top: 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: auto;
        }

    </style>
</head>

<body>
<div class="UTD_Header">
    <span>THE UNIVERSITY OF TEXAS AT DALLAS</span>
    <span>UTDCMS </span>
</div>
<div class="Landing">
    <button onclick= "document.location.href = 'MyClubs.php';" id="button" >My Clubs</button>
    <button onclick= "document.location.href = 'Club Join Request.php';" id="button" >Join a Club</button>
    <button onclick= "document.location.href = 'ClubCreation.php';" id="button" >Create a Club</button>
    <button onclick= "document.location.href = 'ClubManagement.php';" id="button" >Club Management</button>
    <button onclick= "document.location.href = 'ClubNameChange.php';" id="button" >Club Name Change</button>
    <button onclick= "document.location.href = 'Logout.php';" id="button" >Log out</button>
   

</div>

</body>
</html>