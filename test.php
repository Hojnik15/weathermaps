<?php

include 'db_connection.php';

$lat = 46.05; // latitude of centre of bounding circle in degrees
$lng = 14.5167; // longitude of centre of bounding circle in degrees
$R = 6371;  // earth's mean radius, km


$sql = "SELECT 
        city,country, 
        (
        6371 *
        acos(cos(radians($lat)) * 
        cos(radians(lat)) * 
        cos(radians(lng) - 
        radians($lng)) + 
        sin(radians($lat)) * 
        sin(radians(lat)))
        ) AS distance 
        FROM mesta 
        HAVING distance < 10 
        ORDER BY distance LIMIT 0, 20";

        $points = $pdo->prepare($sql);
        $points->execute();


        foreach ($points as $row){
            echo $row['city'].', '.$row['distance'].'</br>';
        }
?>