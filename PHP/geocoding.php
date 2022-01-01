<?php

if (!empty($_POST)) {
    $lati_pizzeria = 45.406972;
    $longi_pizzeria = 11.885583;

    $geocodingAPI = "https://nominatim.openstreetmap.org/search?q=";

    $_POST = array_map('clean', $_POST);
    $address = $_POST['address'];
    $number = $_POST['number'];
    $city = $_POST['city'];
    $county = $_POST['county'];
    $country = "Italy";

    $qs = $number."+".$address.",".$city.",".$county.",".$country;
    $qs .= "&format=json&limit=1&polygon=0&addressdetails=0";

    $rs = json_decode(file_get_contents_curl($geocodingAPI.$qs));

    if (!empty((array) $rs)) {
        $lati = $rs[0]->lat;
        $longi = $rs[0]->lon;

        $earthRadiusKm = 6371;

        $lat = deg2rad($lati_pizzeria - $lati);
        $lon = deg2rad($longi_pizzeria - $longi);

        $lati_pizzeria = deg2rad($lati_pizzeria);
        $lati = deg2rad($lati);

        $a = sin($lat/2) * sin($lat/2) + sin($lon/2) * sin($lon/2) * cos($lati_pizzeria) * cos($lati);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadiusKm * $c;

        if ($distance > 50) {
            echo "<p>Troppo distante.</p>";
        } else {
            echo "<p>Va bene!</p>";
        }
    } else {
        echo "<p>Nessuna corrispondenza trovata.</p>";
    }
}

function file_get_contents_curl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER ['HTTP_USER_AGENT']);
  curl_setopt($ch, CURLOPT_URL, $url);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

function clean($value) {
  $value = trim($value);
  $value = strip_tags($value);
  return urlencode($value);
}

?>
