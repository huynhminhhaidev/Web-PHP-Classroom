<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./main.js">
    <link rel="stylesheet" href="./fontawesome-free-5.14.0-web/css/all.min.css">
    <title>Login your class room</title>
</head>
<body>
    <section>
        <div class="container-form">
            <div class="form signin-form">
                <!-- <div class="img-signin"><img src="./img/6.jpg"></div> -->
                <div class="form-">
                    <form method="post">
                        <h2>Sign In</h2>
                        <input type="text" name="UserName" required="required" placeholder="UserName">
                        <input type="password" name="Password" required="required" placeholder="Password">
                        <?php
                            include('connect.php');

                            if(isset($_POST['signin-btn'])){
                                $username = $_POST['UserName'];
                                $password = $_POST['Password'];
                                
                                $s = "select * from  usersignup where username = '$username' && password = '$password'";
                                
                                $result = mysqli_query($con,$s);
                                
                                $num = mysqli_num_rows($result);
                                
                                if($num == 1){
                                    header('location:home.php');
                                }else{
                                    echo '<p style="color:red; font-weight:bold">Sai tên đăng nhập</p>';
                                }                                
                            }

                        ?>
                        <input type="submit" name="signin-btn" value="Login">
                        <p class="signup">Don't have an account ? <a href="#" onclick="change();">Sign Up</a></p>
                    </form>
                </div>
                <div class="form-">
                    <form method="post">
                        <h2>Sign Up</h2>
                        <input type="text" name="UserName1" required="required" placeholder="User Name">
                        <input type="email" name="EmailAddress1" required="required" placeholder="Email Address">
                        <input type="text" name="FullName1" required="required" placeholder="Full Name">
                        <div class="s">
                            <input type="date" name="BirthDay1" required="required" placeholder="Birth Day">
                            <input type="number" name="Phone1" required="required" placeholder="Phone">
                        </div>
                        <input type="password" name="CreatePassword1" required="required" placeholder="Create Password">
                        <!-- <input type="password" name="ConfirmPassWord" required="required" placeholder="Confirm Password"> -->
                        <?php
                            include('connect.php');

                            if(isset($_POST['signup-btn'])){
                                $username = $_POST['UserName1'];
                                $emailaddress = $_POST['EmailAddress1'];
                                $fullname = $_POST['FullName1'];
                                $birtday = $_POST['BirthDay1'];
                                $phone = $_POST['Phone1'];
                                $password = $_POST['CreatePassword1'];

                                $s = "select * from  usersignup where username = '$username'";

                                $result = mysqli_query($con,$s);
                                
                                $num = mysqli_num_rows($result);
                                
                                if($num == 1){
                                    echo '<p style="color:red; font-weight:bold">Tên đăng nhập đã tồn tại</p>';
                                    // echo '<script language="javascript">';
                                    // echo 'alert("Tên đăng nhập đã tồn tại. Vui lòng điền lại form.")';
                                    // echo '</script>';
                                }else{
                                    $reg = "INSERT INTO usersignup(username, email, fullname, birthday, phone,password) VALUES ('$username','$emailaddress','$fullname','$birtday','$phone','$password')";
                                    mysqli_query($con,$reg);
                                    echo '<p style="color:green; font-weight:bold">Đã đăng ký thành công</p>';
                                    // echo '<script language="javascript">';
                                    // echo 'alert("Đăng ký thành công")';
                                    // echo '</script>';
                                }                            
                            }

                        ?>
                        <div class="gr">
                            <input type="submit" name="signup-btn" value="Sign Up">
                            <!-- <span class="mess" name="mess""></span> -->
                        </div>
                        <p class="signup">Already have an account ? <a href="#" onclick="change();">Sign In</a></p>
                        
                    </form>
                </div>
            </div>
            <!-- <div class="form signup-form"> -->
                
                <!-- <div class="img-signin"><img src="./img/5.jpg"></div> -->
            <!-- </div> -->
        </div>
    </section>

    <script>
        function change(){
            var containerForm = document.querySelector('.container-form');
            containerForm.classList.toggle('active');
        }
    </script>
</body>
</html>