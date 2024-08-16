<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Clubs at UTD</title>
    <style>
        body {
            font-family: Georgia, sans-serif;
        }
        .header {
            padding: 60px;
            text-align: center;
            background: darkorange;
            color: white;
            font-size: 18px;
        }
        .club-list {
            width: 80%;
            margin: auto;
            padding: 30px;
            border: 10px solid #ccc;
            border-radius: 50px;
        }
        .club-list h3 {
            text-align: center;
            text-decoration: underline;
        }
        .club {
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
        }
        .club label {
            display: block;
            font-weight: bold;
        }

        button {
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
    </style>
</head>
<body>
    <div class="header">
        <h1>The University of Texas at Dallas</h1>
        <h3>Active Clubs at UTD</h3>
    </div>
    <br><br>
    <div class="club-list">
        <h3>Current Clubs</h3>
        

        <?php
$connction = mysqli_connect("localhost", "root", '', "clubdb");
if(!$connction)
    die("could not connect".mysqli_connect_error());
else
$query = "select * from club";
$stmt = mysqli_query($connction,$query);
while($row = mysqli_fetch_Array($stmt, MYSQLI_ASSOC))
{

    echo '<div class="club">';
    echo '<label>Club ID:</label>';
    echo $row ['Club_ID'].'</br>';
    echo '<label>Club Name:</label>';
    echo $row ['Club_Name'].'</br>';
    echo '<label>Club Description:</label>';
    echo $row ['ClubDescription'].'</br>';
    echo '<label>Club Type:</label>';
    echo $row ['ClubType'].'</br>';
    echo '</div>';
}
?>
    <button onclick= "document.location.href = 'LandingPage.php';" id="button" >Go back</button>
    </div>
    
</body>
</html>
