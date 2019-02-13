<?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = RECAPTCHA_SECRET;
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    if (!$recaptcha->success) {
        $msg = "Er gaat iets mis, je probeert me toch niet te hacken?";
        goto page;
    }

    if(!isset($_POST["title"]) || trim($_POST["title"] == "")){
        $msg = "je moet wel wat toevoegen hè";
        goto page;
    }

    if(strlen(trim($_POST["title"])) > 255){
        $msg = "doe eens niet zo'n lange tekst toevoegen met je hoofd";
        goto page;
    }

    require_once "config.php";

    $query = "INSERT INTO activities (title) VALUES (?)";
    $stmt = $mysqli->prepare($query);    
    $stmt->bind_param("s", $param_title);
 
    $param_title = trim($_POST["title"]);
    
    if($stmt->execute()){
        $msg = "staat er nu in!";
    } else {
        $msg = "er is iets mis gegaan. MEEEEEES!!";
    }

    $stmt->close();
    $mysqli->close();

}

page:
?>

<!DOCTYPE html>
<html>
  <head>
    <title>AxiFiteiten generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css" />

    <?php if(!isset($msg)){ ?>
    <script src="https://www.google.com/recaptcha/api.js?render=".RECAPTCHA_SITE></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute(RECAPTCHA_SITE, { action: 'validate_captcha' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script>
    <?php } ?>

  </head>
  <body>

    <section class="hero is-medium is-primary is-bold">
        <div class="hero-body">
        <a class="button is-primary is-inverted is-outlined is-small" style="margin-bottom: 20px;" href="/">vergaar inspiratie</a>
          <div class="container has-text-centered">
            <h1 class="title is-spaced">
              Willekeurige AxiFiteiten generator
            </h1>

            <?php if(!isset($msg)){ ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" id="recaptchaResponse" name="g-recaptcha-response">
                <input type="hidden" name="action" value="validate_captcha">
                <div class="output-container">
                    <input type="text" name="title" class="form-control has-text-weight-bold is-size-5 has-text-black" placeholder="ik wil doen..." style="border: none; width: 100%; height: 100%;">
                </div> 
                <div>
                    <input type="submit" class="subtitle generate-button is-large is-fullwidth has-text-weight-bold" value="voeg toe!" style="border: none; cursor: pointer;">
                </div>
            </form>

            <?php } else { ?>
            <div class="output-container">
                <h2 id="output" class="animated bounceIn has-text-weight-bold is-size-5 has-text-black">
                    <?= $msg ?>
                </h2>
            </div>
            <a href="/suggestie.php" class="subtitle generate-button is-large is-fullwidth has-text-weight-bold">nog een!</a>
            <?php } ?>
            
          </div>
        </div>
      </section>
  </body>

  <style>
    .hero{
      height: 100vh;
    }

    .hero .output-container{
      padding: 20px;
      background-color: white;
      border-radius: 10px;
      color: black;
      margin: 20px 0;
    }

    .generate-button{
      background-color: rgba(255, 255, 255,0.2);
      border-radius: 10px;
      padding: 20px;
      width: 100%;
      display: block;
    }

  </style>
</html>