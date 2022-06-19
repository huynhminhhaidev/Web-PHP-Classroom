
<!-- Kiểm tra phân quyền -->
<?php
  session_start();
  require_once("connection.php");
  $regexResult = CheckPrivilege();
  if(!$regexResult){
    echo "Banj khoong cos quyeenf chi caapj chuwsc nawng nayf";
    exit();
  }
?>

<!-- Kiểm tra người dùng đã đăng nhập hay chưa -->
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
            <!-- Chuyển về trang chủ của classroom -->
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
                     <!-- Lấy tên người dùng để xinh chào -->
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
              
              <tr class="header">
                  <td>Tên đăng nhập</td>
                  <td>Email</td>
                  <td>Học tên</td>
                  <td>Ngày sinh</td>
                  <td>Số điện thoại</td>
                  <td>Xóa</td>
                  <td>Phân quyền</td>
              </tr>
            
            <!-- Truy vấn tất cả các tài khoản trong database -->
            <?php
            require "connect2.php";
            $sql = "SELECT * FROM account";
            $result = $con->query($sql);
            // Chạy vòng lặp hiện dữ liệu
            while ($row=$result->fetch_assoc()) {
            ?>
              <tr class="item">
                  <td><?php echo $row["username"] ?></td>
                  <td><?php echo $row["email"] ?></td>
                  <td><?php echo $row["fullname"] ?></td>
                  <td><?php echo $row["birthday"] ?></td>
                  <td><?php echo $row["phone"] ?></td>
                  <td><a href="delete-account.php?username=<?php echo $row["username"] ?>" class="delete btn btn-secondary px-1">Xóa</a> </td>
                  <td>
                  <!-- Phân quyền cho tài khoản -->
                  <?php
                      include("connect2.php");
                      $user = $row["username"];
                      $current_Privilege = mysqli_query($con,"SELECT * FROM `user_privileges` WHERE `user`= '$user'");
                      $current_Privilege = mysqli_fetch_all($current_Privilege,MYSQLI_ASSOC);
                      $current_Privilege_Array = array();
                      if(!empty($current_Privilege)){
                        foreach($current_Privilege as $cp){
                          $current_Privilege_Array[] = $cp["privileges"];
                        }
                      }
                  ?>
                      <form action="Manager-Privileges.php?username=<?php echo $row["username"] ?>" method="POST">
                        <input type="checkbox"
                         <?php if(in_array("1",$current_Privilege_Array)){   ?>
                         checked
                         <?php } ?>
                         value="1" id="1" name="privilege1">
                        <label for="1">Admin</label> <br/>
                        <input type="checkbox"
                        <?php if(in_array("2",$current_Privilege_Array)){   ?>
                         checked
                         <?php } ?>
                         value="2" id="2" name="privilege2">
                        <label for="2">Giáo viên</label>
                        <br/>
                        <input class="btn btn-secondary px-1" type="submit" name="" value="Lưu" >
                      </form>

                  </td>
              </tr>
              <?php 
            }
            ?>
              <tr class="sum control">
                  <td colspan="5">
                      <!-- Hiển thị số lượng tài khoản -->
                      <p>Số lượng tài khoản: <?php echo $result->num_rows ?></p>
                  </td>
              </tr>
          </table>

          </div>
      </div>
      
    </div>
    <script>
<?php include './main.js'?>
</script>
</body>
</html>