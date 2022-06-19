

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm lớp học</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="py-5 text-center">
          <img class="d-block mx-auto mb-4" src="./img/img-class.png" alt="" width="72" height="72">
          <h2>Thêm lớp học</h2>
        </div>
  
        <div class="row">
          <div class="col-md order-md-1">
            <?php
            include("connect2.php");
            $id = "";
            $classname = "";
            $subject = "";
            $classroom = "";
            $username = $_GET["username"];
            $sql1 = "SELECT `fullname` FROM `account` WHERE `username` = '$username'";
            $result = $con->query($sql1);
            $row1 = $result->fetch_assoc();
            $teachername = $row1["fullname"];
            
            
            if (isset($_GET["id"])) {
                require "connect2.php";
                $id = $_GET["id"];
                $sql = "SELECT * FROM class WHERE id=$id";
                $result = $con->query($sql);
                $row = $result->fetch_assoc();
                $id = $row["id"];
                $classname = $row["classname"];
                $subject = $row["subject"];
                $classroom = $row["classroom"];
                $username = $row["username"];
                $teachername = $row["teachername"];
            }

            ?>
            <form action="processformclass.php" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo $id ?>" >
                <div class="mb-3">
                    <label for="classname">Tên Lớp Học</label>
                    <div class="input-group">
                        <input value="<?php echo $classname ?>" type="text" class="form-control" id="classname" name="classname" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="subject">Môn Học</label>
                    <div class="input-group">
                        <input value="<?php echo $subject ?>" type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="classroom">Phòng Học</label>
                    <div class="input-group">
                        <input value="<?php echo $classroom ?>" type="text" class="form-control" id="classroom" name="classroom" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="classroom"></label>
                    <div class="input-group">
                        <input type="hidden" value="<?php echo $teachername ?>" type="text" class="form-control" id="teachername" name="teachername" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="imgToUpload">Ảnh Đại Diện</label>
                    <div class="input-group">
                      <input type="file" id="imgToUpload" name="imgToUpload" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="username"></label>
                    <div class="input-group">
                        <input type="hidden" value="<?php echo $username ?>" type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
            
                <hr class="mb-2">
                <button class="btn btn-info btn-lg btn-block" type="submit">Add</button>
      </div>
</body>
</html>