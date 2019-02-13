<?php
    require_once "config.php";

    $query = "SELECT (SELECT title FROM activities ORDER BY RAND() LIMIT 1), (SELECT COUNT(title) as amount FROM activities)";
    $stmt = $mysqli->prepare($query);

    $stmt->execute();
    $stmt->store_result();

    $stmt->bind_result($title, $amount);
    $stmt->fetch();

    $stmt->close();
    $mysqli->close();

?>

<!DOCTYPE html>
<html>
  <head>
      <title>AxiFiteiten generator</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css" />
      <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <section class="hero is-medium is-primary is-bold">
        <div class="hero-body">
        <a class="button is-primary is-inverted is-outlined is-small" href="/suggestie.php">Laat self een suggestie achter</a><br/>
        <p style="margin-bottom: 20px;">al <?= $amount ?> AxiFiteiten opgeslagen</p>
          <div class="container has-text-centered">
            <h1 class="title is-spaced">
              Willekeurige AxiFiteiten generator
            </h1>
            <div class="output-container">
              <h2 id="output" class="animated bounceIn has-text-weight-bold is-size-5 has-text-black">
                <?= $title ?>
              </h2>
            </div>
            <a href="/" class="subtitle generate-button is-large is-fullwidth has-text-weight-bold">inspiratie!</a>
          </div>
        </div>
      </section>
  </body>
</html>