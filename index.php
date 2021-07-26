<?php

  $error = "";
  $weather = "";
  if(array_key_exists("city", $_POST)){
    $url = "http://api.openweathermap.org/data/2.5/weather?q=".urlencode($_POST['city'])."&appid=40c6ade356fd610395faeaf138bae884";
    $headers = @get_headers($url);
    if($headers[0] == "HTTP/1.1 200 OK"){
      $urlContents = file_get_contents($url);
      $weatherArray = json_decode($urlContents, true);
      if($weatherArray['cod'] == 200){
        $weather = "<p>Weather description: '".$weatherArray['weather'][0]['description']."'</p>";
        $tempInCelcius = intval($weatherArray['main']['temp'] - 273.15);
        $weather.="<p>Current Temperature: ".$tempInCelcius."&deg;C</p>";
        $weather.="<p>Wind Speed: ".$weatherArray['wind']['speed']." m/s</p>";
      }else{
        $error = "Could not find city - Please try again..";
      }
    }else{
      $error = "Could not find city - Please try again..";
    }
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Weather Scraper</title>

    <link rel="stylesheet" type="text/css" href="styles.css">

  </head>
  <body>
    <div class="container">
      
      <h1>What's the Weather ?</h1>

      <form method="post">
        <div class="form-group">
          <label for="city"><strong>Enter the name of a city</strong></label>
          <input type="text" class="form-control" id="city" name="city" aria-describedby="emailHelp" placeholder="Eg. New Delhi, Kolkata" autocomplete="off" value="<?php 
                                      if (array_key_exists('city', $_POST)) {

                                        echo $_POST['city']; 

                                      }

                                    ?>"> 
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <div id="weather">
          <?php 
            if ($weather) {

              echo '<div class="alert alert-primary" role="alert">'.$weather.'</div>';

            } else if ($error) {

              echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';

            }
          ?>
        </div>
      </form>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>