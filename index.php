<?php

    include 'db_connection.php';
    //include 'functions.php';
        ini_set('display_errors', 1);  
        ini_set('display_startup_errors', 1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MapsWeather</title>
    <link rel = "stylesheet" href = "main.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <h1>MAPSWEATHER</h1>
    <br />
    <hr />
    <form action = "" method = "POST">
    <!-- <select id="razred" class = "form-control"  name="start">
			<?php
			/*	$sql = "SELECT * FROM mesta";
				$rezultat = mysqli_query($link, $sql);
                while ($row8 = mysqli_fetch_array($rezultat)) {
                    echo "<option value='" . $row8['city'] . "'>" . $row8['city'] . "</option>";
                   } */
		    ?>
		</select>
  <select id="razred" class = "form-control"  name="start">
			<?php
				/* $sql = "SELECT * FROM mesta";
				$rezultat = mysqli_query($link, $sql);
                while ($row8 = mysqli_fetch_array($rezultat)) {
                    echo "<option value='" . $row8['city'] . "'>" . $row8['city'] . "</option>";
                   } */
		    ?>
		</select> -->
        <input type = "text" class="form-control" name = "start" placeholder = "start" required><br />
        <input type = "text" class="form-control" name = "cilj" placeholder = "cilj" required>
        <button type = "submit" name = "submit" class="btn btn-primary" value = "submit">Start</button>
    </form>
    <br />
    <?php

        if(isset($_POST['submit'])){
            $sql = $pdo -> prepare("SELECT * FROM mesta WHERE city = ?;");
            $sql2 = $pdo -> prepare("SELECT * FROM mesta WHERE city = ?;");


            $start = $_POST['start'];
            $cilj = $_POST['cilj'];
      
            if($sql->execute([$start]) && $sql2->execute([$cilj])){
                foreach($sql as $row){
                    $lat = $row['lat'];
                    $lng = $row['lng'];
                }
                foreach($sql2 as $row2){
                    $lat2 = $row2['lat'];
                    $lng2 = $row2['lng'];
                }
                if($sql->rowcount()==1 && $sql2->rowcount()==1){

                    $R = 6371;  // earth's mean radius, km
                    $sql3 = "SELECT 
                            city,country,lat,lng,
                            (
                            $R *
                            acos(cos(radians($lat)) * 
                            cos(radians(lat)) * 
                            cos(radians(lng) - 
                            radians($lng)) + 
                            sin(radians($lat)) * 
                            sin(radians(lat)))
                            ) AS distance 
                            FROM mesta 
                            HAVING distance < 10 AND distance > 0 
                            ORDER BY distance LIMIT 0, 20";

                            $points = $pdo->prepare($sql3);
                            $points->execute();
                            
                            ?>
                            <table border ="1">
                            <tr>
                                <th>City</th>
                                <th>Country</th>
                                <th>Distance</th>
                                <th>lat</th>
                                <th>lng</th>
                            </tr>
                            <?php
                            $latracun = $lat - $lat2;
                            $lngracun = $lng - $lng2;
                            echo $latracun, ' ', $lngracun;
                            foreach ($points as $row){
                                echo '
                                        <tr>
                                            <td>
                                                '.$row['city'].',
                                            </td>
                                            <td>
                                                '.$row['country'].',
                                            </td>
                                            <td>
                                                '.$row['distance'].',
                                            </td>
                                            <td>
                                                '.$row['lat'].',
                                            </td>
                                            <td>
                                            '.$row['lng'].',
                                        </td>
                                        </tr>';
                            }
                            ?>
                            </table>
                            <?php
                }
                else{
                    echo "nestari";
                }
            }
        } else{
            echo "okej";
        }
            
        ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>