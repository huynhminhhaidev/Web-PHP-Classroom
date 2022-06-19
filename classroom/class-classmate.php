<!-- Kiểm tra phần quyền -->

<?php
  session_start();
  require_once("connection.php");
  $regexResult = CheckPrivilege();
  if(!$regexResult){
    echo "Banj khoong cos quyeenf chi caapj chuwsc nawng nayf";
    exit();

  }
?>

<!-- Kiểm tra đăng nhập -->
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
              <form action="class-home.php?classcode=<?php echo $code?>" method = "POST">
                <a class="badge badge-light" href="javascript:;" onclick="parentNode.submit();">Lớp học</a>
                <input type="hidden" name="mess" value="<?php echo $code ?>">
              </form>
              <form action="class-classmate.php?classcode=<?php echo $code?>" method = "POST">
                <a class="badge badge-light" href="javascript:;" onclick="parentNode.submit();">Mọi người</a>
                <input type="hidden" name="mess" value="<?php echo $code ?>">
              </form>
            <a class="badge badge-light"  href="home.php">Trang chủ <i class="fas fa-arrow-circle-left"></i></a>
        </nav>
      </div>
      
      <div class="container mt-5">
        <div class="card">

        <!-- Kiểm tra phần quyền. Nếu là giáo viên và admin sẽ được thêm học sinh mới thông qua việc gửi mail cho sinh viên -->
            <?php if(CheckPrivilege('Manager-Class.php')){ ?>

            <!-- Khi nhấn "Thêm" mã lớp sẽ được truyền đến trang sendEmailStudent.php thông qua phương thức POST -->
            <form action="sendEmailStudent.php?classcode=<?php echo $code ?>" method="POST">
              Thêm sinh viên: <input class="input-student" type="text" placeholder="Nhập email sinh viên cần thêm" name="inputstudent" value="">
              <input type="submit" value="Thêm">
            </form>
            
            <?php } ?>

            <?php echo  nl2br("\n",false);?>
            Giáo viên: 
            <?php
              require_once("connect2.php");

              // Câu lệnh truy vấn tên giáo viên khi có mã lớp học
              $sql1 = "SELECT teachername FROM `class` WHERE classcode = $code";
              $result1 = $con->query($sql1);
              $result1 = $result1->fetch_assoc();
            ?>
            <div class="card-header">
            <!-- Tên giáo viên -->
              <?php echo $result1["teachername"] ?>
            </div>
            <?php echo  nl2br("\n",false);?>
            Sinh viên: 
            <?php
                //Câu lện sql truy vấn học sinh đã tham gia lớp học tương ứng theo mã lớp học
                require_once("connect2.php");
                $sql = "SELECT * FROM `account`,`sv_class` WHERE account.username = sv_class.username AND sv_class.classcode = '$code'" ;
                $result = $con->query($sql);

                // Thực hiện vòng lặp
                while ($row=$result->fetch_assoc()) {
            ?>
            <div class="card-header">
                <div class="flex-card-header">
                  <?php echo $row["fullname"] ?>

                  <!-- Kiểm tra phân quyền. Nếu là giáo viên và admin thì xóa sinh viên trong lớp học sẽ hiển thị -->
                  <?php if(CheckPrivilege('Manager-Class.php')){ ?>
                  <a href="delete-student.php?username=<?php echo $row["username"] ?>" class="delete btn btn-secondary px-1">Xóa</a>
                  <?php } ?>
                </div>
            </div>
            <?php } ?>
          </div>
      </div>
</body>
<script>
<?php include './main.js'?>
</script>

</html>