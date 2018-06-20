<?php
    session_start();
    require_once('db.php');
    $remember=false;
    $_SESSION['username'] = '';
    $_SESSION['password'] = '';
    if (isset($_POST['button-submit'])) {
        $user_name = $_POST['username'];
        $password = $_POST['password'];
        if ($user_name == '' && $password == '') {
           $_SESSION['tb'] = "Bạn chưa điền thông tin để đăng nhập";
           header('location: index.php');
        }
        else if ($user_name == '') {
           $_SESSION['tb'] =  "Bạn chưa nhập tên tài khoản ";
           header('location: index.php');
        }
        else if ($password == '') {
           $_SESSION['tb'] =  "Bạn chưa nhập mật khẩu ";
           header('location: index.php');
        }
        else {
            $password1 = $password;
            $password = md5($password);
            $sql = "select * from admin where username = '$user_name' and password = '$password' ";
            $query = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($query);
            if ($num_rows == 0) {
                $_SESSION['tb'] = "Tên đăng nhập hoặc mật khẩu không chính xác ";      
                header('location: index.php');
                echo 'aaaaaaaaa';
            }
            else { 
              if (isset($_POST['remember'])){
                $_SESSION['username'] = "admin";
                $_SESSION['password'] = $password1;
                header('location: https://www.facebook.com/ptquang97');  
              }
            else {
              header('location: https://www.facebook.com/'); 
            }
          }
        }
      }
?>
