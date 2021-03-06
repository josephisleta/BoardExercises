<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Discussion Forum</title>

    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px;
      }
    </style>
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
            <table style="width: 100%;">
                <td>
                    <a class="brand" style="color:black;" href="<?php encode(url('thread/index')) ?>">Discussion Forum</a>
                </td>
                <?php if(is_logged_in()): ?>
                    <td>
                      Welcome <?php encode($_SESSION['name']) ?>!
                    </td>
                    <td style="text-align:right;">
                        You are logged in as
                        <?php encode($_SESSION['type']) ?>: 
                        <?php encode($_SESSION['username']) ?>
                        <a class="btn btn-mini btn-primary" href="<?php encode(url('user/profile')) ?>">Profile</a>
                        <?php if(is_admin()): ?>
                          <a class="btn btn-mini btn-primary" href="<?php encode(url('user/admin')) ?>">Control Panel</a>
                        <?php endif ?>
                        <a class="btn btn-mini btn-danger" href="<?php encode(url('user/logout')) ?>">Logout</a>
                    </td>
                <?php endif?>
            </table>
        </div>
      </div>
    </div>

    <div class="container">

      <?php echo $_content_ ?>

    </div>

    <script>
    console.log(<?php encode(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>

  </body>
</html>
