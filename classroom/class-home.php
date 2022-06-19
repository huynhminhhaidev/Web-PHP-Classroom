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

<!-- Dùng để Post mã lớp học qua lại giữa class-home và class-classmate -->
<?php
  // var_dump($_GET);exit;
  if(isset($_GET['classcode'])){
    $code = $_GET['classcode']; 
  }else{
    $code = "";
  }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./main.js">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <title>Lớp Học</title>
</head>
<body>
    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
          <div class="bg-light p-1">
          </div>
        </div>
        <nav class="navbar navbar-light bg-light justify-content-between">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
              <!-- Khi click vào lớp học sẽ chuyển đến trang của lớp học tương ứng(class-home) -->
                  <!-- onclick="parentNode.submit();" dùng để POST dữ liệu thông qua click vào lớp học. Không cần nút Submit -->
              <form action="class-home.php?classcode=<?php echo $code?>" method = "POST">
                <a class="badge badge-light" href="javascript:;" onclick="parentNode.submit();">Lớp học</a>
                <input type="hidden" name="mess" value="<?php echo $code ?>">
              </form>
              <!-- Khi click vào lớp học sẽ chuyển đến trang của lớp học tương ứng(class-classmate) -->
                  <!-- onclick="parentNode.submit();" dùng để POST dữ liệu thông qua click vào lớp học. Không cần nút Submit -->
              <form action="class-classmate.php?classcode=<?php echo $code?>" method = "POST">
                <a class="badge badge-light" href="javascript:;" onclick="parentNode.submit();">Mọi người</a>
                <input type="hidden" name="mess" value="<?php echo $code ?>">
              </form>
            <a class="badge badge-light"  href="home.php">Trang chủ <i class="fas fa-arrow-circle-left"></i></a>
        </nav>
      </div>
      <!-- Check Phân quyền -->
      <!-- Nếu là giáo viên thì chỗ đăng thông báo sẽ được hiển thị -->
      <?php if(CheckPrivilege('Manager-Class.php')){ ?>
      <form <?php if(!isset($_GET["id"])){?> action="add-share.php" <?php } ?> <?php if(isset($_GET["id"])){?> action="add-share.php?id=<?php echo $_GET["id"]?>" <?php } ?> method="POST" enctype="multipart/form-data">
      <?php

      // Nếu tồn tại biến id được POST khi giáo viên thực hiện chỉnh sửa thông báo thì thực hiện các lệnh bên dưới
      // Dùng để chỉnh sửa thông báo
      // Truy vấn database share_something(thông báo) và gán nội dụng cần sửa bằng biến $content
      if(isset($_GET["id"])){
        // var_dump($_POST);exit;
        $id = $_GET["id"];
        var_dump($_GET["id"]);
        require_once("connect2.php");
        $sql = "SELECT * FROM `share_something` WHERE id = $id" ;
        $result = $con->query($sql);
        $result = $result->fetch_assoc();
        var_dump($result);
        $content = $result["content"];
      }
      // Nếu không tồn tại biến id thì nội dụng thông báo sẽ là rỗng(Thêm thông báo mới)
      // Dùng để thêm thông báo
      else{
        $content = "";
      }
      ?>
        <div class="container mt-5">
          <div class="card">
                <input type="text" placeholder="Đăng thông báo, file,..." value="<?php echo $content ?>" name="content" class="input-share">
                <div class="mb-3">
                  <input type="file" name="fileToUpload" id="fileToUpload">
                </div>
                <input type="hidden" name="classcode" value="<?php echo $code ?>" >
                <input type="submit" value="Đăng" class="btn-share">
            </div>
        </div>
      </form>
      <?php } ?>

      <!-- Truy vấn database class(Lớp học) -->
      <!-- Lấy ảnh đại diện của giáo viên, tên giáo viên -->
      <?php
          require_once("connect2.php");
          $sql = "SELECT * FROM `class` WHERE classcode = '$code'" ;
          $result1 = $con->query($sql);
          $result1 = $result1->fetch_assoc();
          // var_dump();exit;
      ?>

      <div class="container mt-5">

      <!-- Truy vấn database share_something(Thông báo) -->
      <?php
          require_once("connect2.php");
          $sql = "SELECT * FROM `share_something` WHERE classcode = '$code'" ;
          $result = $con->query($sql);

          // chạy vòng lặp
          while ($row=$result->fetch_assoc()) {
      ?>
        <div class="card mt-5">

            
            <div class="card-body">

            <div class="card-headcontent">
              <!-- Ảnh đại diện của giáo viên -->
              <img class="avatar-content" src="<?php echo $result1["avatar"]  ?>" >
              <div class="teacher-content">
                <div class="name-teacher">
                    <!-- Tên giáo viên -->
                    <?php echo $result1["teachername"];?>
                    <div class="time-content">
                      <span>
                      <!-- Ngày đăng thông báo -->
                        <?php echo $row["time"] ?>
                      </span>
                    </div>
                </div>
                
              </div>

                <!-- Check phân quyền. Nếu là giáo viên thì xóa và chỉnh sửa sẽ hiện ra -->
                <?php if(CheckPrivilege('Manager-Class.php')){ ?>
                <div class="setting">
                  <a href="delete-share.php?id=<?php echo $row["id"] ?>" class="delete btn-setting ">Xóa</a>
                  <a href="class-home.php?id=<?php echo $row["id"] ?>" class="btn-setting">Chỉnh sửa</a>
                </div>
                <?php } ?>
            </div>

            </div>
            <div class="card-body">
            <!-- Nội dung thông báo -->
                <?php echo $row["content"] ?>
            </div>
            <div class="card-body">
            <!-- File đính kèm -->
              <a href="<?php echo $row["file"] ?>"><?php echo $row["file"] ?></a>
            </div>

            <?php
              require_once("connect2.php");
              // Gán id của share_something(thông báo) cho biến $id3
              $id3 = $row["id"];
              // Câu lệnh truy vấn comment(bình luận) điều kiện là có id bằng $id3
              // Mỗi $id3 của share_something(thông báo) sẽ có nhiều commnent(bình luận)
              // Lọc bình luận theo từng thông báo
              $sql3 = "SELECT * FROM comment WHERE share_id = $id3";
              $result3 = $con->query($sql3);

              // Thực hiện vòng lặp để hiện thị bình luận theo từng thông báo
              while ($row3 = $result3->fetch_assoc()) {

                $username3 = $row3["username"];
                //Truy vấn tên người comment
                $sql4 = "SELECT fullname FROM account WHERE username = '$username3'";
                $result4 = $con->query($sql4);
                // Thực hiện vòng lặp hiển thị thông tin người bình luận
                while ($row4 = $result4->fetch_assoc()) {
            ?>

            <div class="card-footer">
              <div class="comment">
              <!-- Họ tên người bình luận -->
                <?php echo $row4["fullname"] ?>: <?php echo $row3["comment"] ?>
                  <!-- Kiểm tra phân quyền. Nếu là giáo viên thì hiển thị xóa comment -->
                <?php if(CheckPrivilege('Manager-Class.php')){ ?>
                <a href="delete-comment.php?id=<?php echo $row3["id"] ?>" class="delete btn-setting">Xóa</a> 
                <?php } ?>

                <!-- Dùng để xuống dòng -->
                <?php echo  nl2br("\n",false);?>

                <!-- Thời gian bình luận -->
                <span class="time-comment"><?php echo $row3["time"] ?></span>
              </div>
              
            </div>
              <?php } ?>

            <?php } ?>

                  <!-- Thêm bình luận -->
            <form action="add-comment.php?id=<?php echo $row["id"] ?>" method="POST">
              <input type="text" placeholder="Thêm bình luận..." class="input-comment" name="comment" value="">
              <input type="hidden" value="<?php echo $_SESSION['UserName'] ?>" name = "username">
            </form>


          </div>
          <?php 
						}
						?>
      </div>

      <!-- Xuống dòng -->
      <?php echo  nl2br("\n",false);?>
      <?php echo  nl2br("\n",false);?>
</body>
<script>
<?php include './main.js'?>
</script>
</html>