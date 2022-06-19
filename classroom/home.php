<!-- Hàm này check phân quyền  -->
<?php
  session_start();
  require_once("connection.php");
  $regexResult = CheckPrivilege();
  if(!$regexResult){
    echo "Banj khoong cos quyeenf chi caapj chuwsc nawng nayf";
    exit();

  }
?>

<!-- Hàm này check xem người dùng đã đăng nhập hay chưa. Nếu chưa thì đi đến trang đăng nhập -->
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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./main.js">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <title>Your Class Room</title>
</head>

<body>
    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
          <div class="bg-light p-1">
            <div class="head">
              
              <!-- Check phân quyền. Nếu người dùng được phân quyền là admin thì mục này mới xuất hiện -->
              <!-- Khi click vào "Quản lý tài khoản" thì nó sẽ chuyển đến trang quản lý tài khoản của classroom" -->
              <?php if(CheckPrivilege('Manager-Account.php')){ ?>
              <a class="badge badge-light"  href="Manager-Account.php">Quản lý tài khoản <i class="fas fa-user-circle"></i></a>
              <?php } ?>

              <!-- Check phần quyền. Nếu người dùng được phân quyền là giáo viên thì mục này mới xuất hiện -->
              <!-- Khi click vào "Quản lý lớp học" thì nó sẽ chuyển đến trang quản lý lớp học của giáo viên -->
              <!-- Giáo viên sẽ quản lý lớp học của mình -->
              <!-- Admin sẽ quản lý lớp học của tất cả giáo viên -->
              <?php if(CheckPrivilege('Manager-Class.php')){ ?>
              <a class="badge badge-light"  href="Manager-Class.php">Quản lý lớp học <i class="fas fa-chalkboard-teacher"></i></a>
              <?php } ?>
            </div>
          </div>
        
        </div>
        <nav class="navbar navbar-light bg-light justify-content-between">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Tìm kiếm tên lớp học -->
          <div class="search">
              <form class="form-search" action="" method="POST">

                  <!-- Khi nhập tên lớp học bấm enter nó sẽ POST nội dung mình vừa nhập với tên biến là "keyword" -->
                  <input value="<?= isset($_POST['keyword']) ? $_POST['keyword'] : "" ?>" type="text" class="searchTerm" placeholder="Tìm khóa học" name="keyword">
                  <input class="btn-input" type="submit" value=" Tìm ">
              </form>
          </div>

          <!-- Nhập code để tham gia vào lớp học -->
          <div class="search">
              <form class="form-search" action="sendEmailTeacher.php?username=<?php echo $_SESSION['UserName'] ?>" method="POST">
                  <input type="text" class="searchTerm" placeholder="Nhập code lớp..." name = "code">
                  <input class="btn-input" type="submit" value="Tham gia">
              </form>
          </div>

          <!-- Đăng xuất -->
          <a class="badge badge-light"  href="logout.php">Đăng xuất <i class="fas fa-door-open"></i></a>           
        </nav>
      </div>
      <div class="container-fluid">
        <div class="row">

        <?php
            require "connect2.php";
            
            // Nếu không nhập nội dung vào search thì biến "keywword" sẽ là ""(rỗng)
            $search = isset($_POST['keyword']) ? $_POST['keyword'] : "" ;
            
            // Cho $username  = username của tài khoản mà mình đăng nhập
            $username = $_SESSION["UserName"];

            // Nếu tồn tại biến search thì thực hiện câu truy vấn bên dưới
            if($search){
              // %search% là tìm tên lớp học trong đó có chứa nội dụng mình tìm kiếm. Ví dụ tìm kiếm "cơ" thì nó sẽ tìm được lớp học có tên "Web cơ bản"
              // `username` = '$username' nó sẽ hiện lên các lớp học mà giáo viên đã tạo. Không hiện các lớp học của giáo viên khác.
              $sql = "SELECT * FROM class WHERE `classname` LIKE '%$search%' AND `username` = '$username'" ;
            }

            // Nếu không tồn tại biến seach thì thực hiện câu truy vấn bên dưới
            else{
              // `username` = '$username' nó sẽ hiện lên các lớp học mà giáo viên đã tạo. Không hiện các lớp học của giáo viên khác.
              $sql = "SELECT * FROM class WHERE `username` = '$username'";
            }

						
            $result = $con->query($sql);
            // Chạy vòng lặp để hiện lớp học
            while ($row=$result->fetch_assoc()) {
						?>
          <div class="col-lg-3 mt-5">
              <div class="card-class">
                  <div class="card-img">
                  <!-- Khi click vào lớp học sẽ chuyển đến trang của lớp học tương ứng(class-home) -->
                  <!-- onclick="parentNode.submit();" dùng để POST dữ liệu thông qua click vào lớp học. Không cần nút Submit -->
                  <form action="class-home.php?classcode=<?php echo $row["classcode"] ?>" method = "POST">
                      <a href="javascript:;" class="card-img-content" onclick="parentNode.submit();" >
                      <input type="hidden" name="mess" value="<?php echo $row["classcode"] ?>">
                      <!-- Tên lớp -->
                          <h1><?php echo $row["classname"] ?></h1>
                          
                          <!-- Môn học -->
                          <span><?php echo $row["subject"] ?></span> <br>
                          
                          <!-- Phòng học -->
                          <span><?php echo $row["classroom"] ?></span> <span> - </span> <span><?php echo $row["teachername"] ?></span>
                      </a>
                  
                  </form>
                  </div>
                  <div class="card-avatar">
                  <!-- Ảnh đại diện -->
                      <img src="<?php echo $row["avatar"] ?>">
                  </div>
                  <div class="card-content">
                    
                  </div>
                  <div class="card-icon">
                  </div>
              </div>
          </div>
          <?php 
						}
            ?>
            
<!-- ----------------------------------------------------------------------------------------------------- -->

            <?php
            require "connect2.php";
            // Giống trên
            $search = isset($_POST['keyword']) ? $_POST['keyword'] : "" ;

            //Tồn tại biến search thì thực hiện truy vấn bên dưới
            if($search){
              // Câu lệnh truy vấn database. Nó sẽ hiện lên các lớp học mà sinh viên đã tham gia
              // %search% là giống trên
              $sql = "SELECT * FROM `class`,`sv_class` WHERE class.classcode = sv_class.classcode AND sv_class.username = '$username' AND `classname` LIKE '%$search%'  ";
              // $sql = "SELECT * FROM `class`  INNER JOIN `sv_class` ON class.classcode = sv_class.classcode WHERE `classname` LIKE '%$search%' " ;
            }else{
              // Câu lệnh truy vấn database. Nó sẽ hiện lên các lớp học mà sinh viên đã tham gia
              $sql = "SELECT * FROM `class`,`sv_class` WHERE class.classcode = sv_class.classcode AND sv_class.username = '$username' ";
              // $sql = "SELECT * FROM `class`  INNER JOIN sv_class ON class.classcode = sv_class.classcode WHERE `classname` LIKE '%$search%'" ;
            }
            $result = $con->query($sql);
            // var_dump($result->fetch_assoc());exit;

            // Thực hiện vòng lặp để hiện lên thông tin lớp học mà sinh viên đã tham gia
						while ($row1=$result->fetch_assoc()) {
						?>
          <div class="col-lg-3 mt-5">
              <div class="card-class">
                  <div class="card-img">
                    <!-- Khi click vào lớp học sẽ chuyển đến trang của lớp học tương ứng(class-home) -->
                  <!-- onclick="parentNode.submit();" dùng để POST dữ liệu thông qua click vào lớp học. Không cần nút Submit -->
                    <form action="class-home.php?classcode=<?php echo $row1["classcode"] ?>" method = "POST">
                        <a href="javascript:;" class="card-img-content" onclick="parentNode.submit();" >
                            <input type="hidden" name="mess" value="<?php echo $row1["classcode"] ?>">
                            
                            <!-- Tên lớp -->
                            <h1><?php echo $row1["classname"] ?></h1>
                            
                            <!-- Môn học -->
                            <span><?php echo $row1["subject"] ?></span> <br>
                            
                            <!-- Phòng học -->
                            <span><?php echo $row1["classroom"] ?></span> <span> - </span> <span><?php echo $row1["teachername"] ?></span>
                        </a>
                    </form>
                  </div>
                  <div class="card-avatar">
                      <!-- Ảnh đại diện -->
                      <img src="<?php echo $row1["avatar"] ?>">
                  </div>
                  <div class="card-content">
                    
                  </div>
                  <div class="card-icon">
                  </div>
              </div>
          </div>
          <?php 
						}
						?>
        </div>
      </div>
</body>
</html>