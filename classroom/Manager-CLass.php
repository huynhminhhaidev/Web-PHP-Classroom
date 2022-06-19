<?php
  session_start();
  require_once("connection.php");
  $regexResult = CheckPrivilege();
  if(!$regexResult){
    echo "Banj khoong cos quyeenf chi caapj chuwsc nawng nayf";
    exit();
  }
?>
<?php
    if (!isset($_SESSION['UserName'])) {
        header('Location: login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    
</head>
<?php
  require_once("connection.php");
?>
<body>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

    <div class="wrapper">
      <div class="top_navbar">
        <div class="hamburger">
           <div class="hamburger__inner">
             <div class="one"></div>
             <div class="two"></div>
             <div class="three"></div>
           </div>
        </div>
        <div class="menu">
          <div class="logo">
            Classroom
          </div>
          <div class="right_menu">
            <ul>
              <li> <a class="badge badge-light" href="./home.php">Trang chủ <i class="fas fa-chalkboard"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
        
      <div class="main_container">
          <div class="sidebar">
              <div class="sidebar__inner">
                <div class="profile">
                  <div class="img">
                    <img src="./img/avatar.png" alt="profile_pic">
                  </div>
                  <div class="profile_info">
                     <span>Xin chào</span>
                     <span class="profile_name"><?= $_SESSION['UserName'] ?></span>
                  </div>
                </div>
                <ul>
                <!-- Kiểm tra phần quyền. Nếu người dùng được phân quyền là admin thì Phần quản  lý tài khoản sẽ hiện ra -->
                <?php if(CheckPrivilege('Manager-Account.php')){ ?>
                  <li>
                    <a href="./Manager-Account.php" class="active">
                      <span class="icon"><i class="fas fa-user-circle"></i></span>
                      <span class="title">Tài Khoản</span>
                    </a>
                  </li>
                  <?php } ?>

                  <!-- Kiểm tra phân quyền. Nếu người dùng là giáo viên và admin thì Phần quản lý lớp học sẽ hiện ra -->
                  <?php if(CheckPrivilege('Manager-Class.php')){ ?>
                  <li>
                    <a href="./Manager-Class.php">
                      <span class="icon"><i class="fas fa-chalkboard-teacher"></i></span>
                      <span class="title">Lớp học</span>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
          </div>
          <div class="container">
          <table class ="body-listclass" cellpadding="10" cellspacing="10" border="0" >
              <tr class="control">
                  <td colspan="5">
                    <?php $username = $_SESSION['UserName'];
                    ?>
                      <a href="addclass.php?username=<?php echo $username ?>"  class="btn btn-secondary px-5" >Thêm lớp học mới</a>
                  </td>
              </tr>
              
              <tr class="header">
                  <td>Ảnh Đại Diện</td>
                  <td>Mã Lớp</td>
                  <td>Tên Lớp</td>
                  <td>Môn Học</td>
                  <td>Phòng Học</td>
                  <td>Tên Giáo Viên</td>
                  <td>Tùy Chỉnh</td>
              </tr>
              
            <?php
            require "connect2.php";
            if($username = "admin"){
              $sql = "SELECT * FROM `class` ";
            }else{
              $sql = "SELECT * FROM `class` WHERE `username` = '$username'";
            }
            $result = $con->query($sql);

            // chạy vòng lặp hiển thị dữ liệu
            while ($row=$result->fetch_assoc()) {
            ?>
              <tr class="item">
                  <td><img src="<?php echo $row["avatar"] ?>" ></td>
                  <td><?php echo $row["classcode"] ?></td>
                  <td><?php echo $row["classname"] ?></td>
                  <td><?php echo $row["subject"] ?></td>
                  <td><?php echo $row["classroom"] ?></td>
                  <td><?php echo $row["teachername"] ?></td>
                  <td><a class="btn btn-secondary px-1" href="addclass.php?id=<?php echo $row["id"] ?>">Edit</a> | <a href="delete-class.php?id=<?php echo $row["id"] ?>" class="delete btn btn-secondary px-1">Delete</a> </td>
              </tr>
              <?php 
            }
            ?>
              <tr class="sum control">
                  <td colspan="5">
                      <p>Số lượng lớp học: <?php echo $result->num_rows ?></p>
                  </td>
              </tr>
          </table>
</body>
<script>
<?php include './main.js'?>
</script>
          </div>
      </div>
      
    </div>    
</body>
</html>