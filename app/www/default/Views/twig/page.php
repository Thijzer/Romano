<?php

if ($data) {
    $error = 'Page Not Found';
    $info = "We couldn't find the page you requested on our servers.";
    $button = "return to the homepage";
    $butloc = '';
    $code = 404;
    switch ($data['code']) {
      case '404':
        header('HTTP/1.0 404 Not Found');
        $error = 'Page Not Found';
        $info = "We couldn't find the page you requested on our servers.";
        $button = "return to the homepage";
        $butloc = '';
        $code = 404;
        break;
      case '500':
        header('HTTP/1.1 500 Internal Server Error');
        $error = 'Internal Server Error';
        $info = "Nope that is not so good";
        $button = "return to the homepage";
        $butloc = '';
        $code = 500;
        break;
      case '1012':
        header('HTTP/1.1 1012 Access to restricted URI denied');
        $error = 'Access to Restricted URI Denied';
        $info = '';
        $button = '';
        $butloc = '';
        $code = 1012;
        break;
      case '401':
        header("HTTP/1.1 401 Unauthorized");
        $error = 'Unauthorized Access';
        $info = "We need you to sign in again, in order to access this page.";
        $button = "Please Log in";
        $butloc = 'login';
        $code = 401;
        break;
    }
}

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $error; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            * {
                line-height: 1.5;
                margin: 0;
            }

            html {
                color: #888;
                font-family: sans-serif;
                text-align: center;
            }

            body {
                background: #f0efe7 url(/img/body.png);
                left: 50%;
                margin: -43px 0 0 -150px;
                position: absolute;
                top: 50%;
                width: 300px;
            }

            h1 {
                color: #555;
                font-size: 2em;
                font-weight: 400;
            }

            p {
                line-height: 1.2;
            }

            @media only screen and (max-width: 270px) {

              body {
                  margin: 10px auto;
                  position: static;
                  padding-top: 100px;
                  padding-bottom: 40px;
                  color: #5a5a5a;
                  width: 95%;
              }

              h1 {
                  font-size: 1.5em;
              }

              div {
                width: 500px;
                text-align: center;
              }
            }
        </style>
    </head>
    <body>
    <div class="container">
        <h1><?php echo 'Error '. $code . ' : ' . $error; ?></h1>
        <hr>
        <p><?php echo $info; ?></p>
        <a class="" href="/<?php echo $butloc; ?>"><?php echo $button; ?></a>
    </div>
    </body>
</html>
<!-- IE needs 512+ bytes: http://blogs.msdn.com/b/ieinternals/archive/2010/08/19/http-error-pages-in-internet-explorer.aspx -->
