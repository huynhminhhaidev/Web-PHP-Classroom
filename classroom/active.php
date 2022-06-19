<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Xác minh mật khẩu</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
      integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
      crossorigin="anonymous"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </head>
  <body>

    <?php
        require_once 'connection.php';

        $error = '';
        $message = '';

        if (isset($_GET['email']) && isset($_GET['token'])) {
          $email = $_GET['email'];
          $token = $_GET['token'];

          if (filter_var($email, FILTER_VALIDATE_EMAIL) == false ) {
            $error = 'Email không hợp lệ';
          }

          else if (strlen($token) != 32) {
            $error = 'Định dạng mã thông báo không hợp lệ';
          }
          else {
              $result = activeAccount($email, $token);
              if ($result['code'] == 0) {
                $message = 'Tài khoản của bạn đã được kích hoạt. Đăng nhập ngay bây giờ';
              }else {
                $error = $result['error'];
              }
          }

        }
        else {
          $error = 'Kích hoạt không hợp lệ';
        }

    ?>

    <?php

        if (!empty($error)) {
          ?>
          
            <div class="row">
                <div class="col-md-6 mt-5 mx-auto p-3 border rounded">
                    <h4>Kích hoạt tài khoản</h4>
                    <p class="text-danger"><?= $error?></p>
                    <p>Click <a href="login.php">tại đây</a> để đăng nhập.</p>
                    <a class="btn btn-info px-5" href="login.php">Login</a>
                </div>
            </div>            
          
          <?php
        }else {
          ?>
          
          <div class="container">
            <div class="row">
              <div class="col-md-6 mt-5 mx-auto p-3 border rounded">
                  <h4>Kích hoạt tài khoản</h4>
                  <p class="text-success">Xin chúc mừng! tài khoản của bạn đã được kích hoạt.</p>
                  <p>Click <a href="login.php">tại đây</a> để đăng nhập và quản lý thông tin tài khoản của bạn.</p>
                  <a class="btn btn-info px-5" href="login.php">Đăng nhập</a>
              </div>
            </div>

          <?php
        }

    ?>

    

    
    </div>
  </body>
</html>
