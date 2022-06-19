<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh sách lớp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- <style>
    body{
        padding-top: 50px;
    }
    table{

        text-align: center;
    }
    td{
        padding: 10px;
    }
    tr.item{
        border-top: 1px solid #5e5e5e;
        border-bottom: 1px solid #5e5e5e;
    }

    tr.item:hover{
        background-color: #d9edf7;
    }

    tr.item td{
        min-width: 150px;
    }

    tr.header{
        font-weight: bold;
    }

    a{
        text-decoration: none;
    }
    a:hover{
        color: deeppink;
        font-weight: bold;
    }
</style> -->


<table class ="body-listclass" cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto">
    <tr class="control" style="text-align: left; font-weight: bold; font-size: 20px">
        <td colspan="5">
            <a href="addclass.php" class="btn btn-primary px-5" >Thêm lớp học mới</a>
        </td>
    </tr>
    
    <tr class="header">
        <td>Ảnh đại diện</td>
        <td>Mã lớp</td>
        <td>Tên lớp</td>
        <td>Môn học</td>
        <td>Phòng học</td>
        <td>Tùy chỉnh</td>
    </tr>
    
	<?php
	require "connect2.php";
	$sql = "SELECT * FROM class";
	$result = $con->query($sql);
	while ($row=$result->fetch_assoc()) {
	?>
    <tr class="item">
        <td><img src="<?php echo $row["avatar"] ?>" style="max-height: 80px"></td>
        <td><?php echo $row["classcode"] ?></td>
        <td><?php echo $row["classname"] ?></td>
        <td><?php echo $row["subject"] ?></td>
        <td><?php echo $row["classroom"] ?></td>
        <td><a href="addclass.php?id=<?php echo $row["id"] ?>">Edit</a> |<button class="b" > <a href="delete-class.php?id=<?php echo $row["id"] ?>" class="delete">Delete</a> </button> </td>
    </tr>
    <?php 
	}
	?>
    <tr class="control" style="text-align: right; font-weight: bold; font-size: 17px">
        <td colspan="5">
            <p>Số lượng lớp học: <?php echo $result->num_rows ?></p>
        </td>
    </tr>
</table>
</body>
<script>
<?php include './main.js'?>
</script>
</html>