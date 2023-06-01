<?php

class Template
{
    public static function header($title, $error = false)
    {
        $home_path = getHomePath();
        $user = getUser();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= $title ?> - Multitier Shop</title>


            <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
            <link rel="stylesheet" href="<?= $home_path ?>/assets/css/style.css">
            <script type="module" src="./assets/js/index.js"></script>

            <script src="<?= $home_path ?>/assets/js/script.js"></script>
        </head>

        <body>
            <header <?= $home_path ?>>
                <h1><?= $title; ?></h1>
            </header>

            <nav>
                <a href="<?= $home_path ?>">Start</a>
                <a href="<?= $home_path ?>/bookings">Bookings</a>

                <?php if ($user) : ?>
                    <a href="<?= $home_path ?>/auth/profile">Profile</a>
                <?php else : ?>
                    <a href="<?= $home_path ?>/auth/login">Log in</a>
                <?php endif; ?>
            </nav>

            <main>

                <?php if ($error) : ?>
                    <div class="error">
                        <p><?= $error ?></p>
                    </div>
                <?php endif; ?>

                
            <?php }

        public static function map() {
            ?>
            <div id="map">
                <script
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5FWuHa-QaWFDkbkBbhtiTqmAnHiDZIUI&callback=initMap&v=weekly"
                    defer
                >
                </script>
                </div>
            <?php
        }
        public static function footer()
        {
            ?>
            </main>
            <footer>
            </footer>
        </body>

        </html>
<?php }
    }