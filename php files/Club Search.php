<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Search Form</title>
    <style>
        body {
            font-family: Georgia, sans-serif;
            background-color: white;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .Search_Club {
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
            margin: auto;
            display: flex;
        }

        .Search_Club h3 {
            text-align: center;
            text-decoration: underline;
        }

        .Search_Club label {
            display: block;
            margin-top: 10px;
        }

        .Search_Club input[type="text"] {
            width: 98%;
            padding: 8px;
            margin-top: 7px;
            border: 2px solid #ccc;
            border-radius: 10px;
        }

        .Search_Club input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .Search_Club input[type="submit"]:hover {
            background-color: darkgreen;
        }

        button {
            width: 100%;
            padding: 5px;
            margin-top: 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: auto;}
    </style>
</head>

<body>
<div class="UTD_Header">
    <span>THE UNIVERSITY OF TEXAS AT DALLAS</span>
    <span>UTDCMS</span>
</div>
<div class="Search_Club">
    <h3>Search for a Club at UTD</h3>
    <form action="" method="get">
        <label for="search1">Search by Club Name or Club ID:</label><br>
        <input type="text" id="search1" name="search1" placeholder="Search for Clubs using Name or Club ID"><br>
        <input type="submit" value="Search"><br>
    </form>


    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search1'])) {
        $search1 = $_GET['search1'];

        $connection = mysqli_connect("localhost", "root", '', "clubdb");

        if (!$connection) {
            die("Could not connect: " . mysqli_connect_error());
        }

        $query = "SELECT * FROM club WHERE club_name LIKE '%$search1%' OR club_id LIKE '%$search1%'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<table><tr><th>Club ID</th><th>Club Name</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . $row["Club_ID"] . "</td><td>" . $row["Club_Name"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found</p>";
        }

        mysqli_close($connection);
    }
    ?>
    <button onclick= "document.location.href = 'LandingPage.php';" id="button" >Go back</button>
</div>


</body>
</html>
