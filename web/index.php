<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php
    session_start();
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
                <div class="col-md-5" id = "frame">
                    <h3 class="text-center">Đăng nhập</h3>
                     <form class="form-horizontal" role="form" method="POST" action="action.php">
                     <div class="form-group">
                        <label for="user" class="col-sm-3 control-label"> Tài Khoản</label>
                         <div class="col-sm-10">
                            <input type='text' class='form-control' id='user' name='username' value="<?php if (isset($_SESSION['username'])) {
                                    echo $_SESSION['username'];
                                }
                                
                            ?>" /> 
        
                         </div>
                    </div>
                     <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">Mật khẩu </label>
                         <div class="col-sm-10">
                            <span class="btn-show-pass">
                            <i class="fa fa-eye"></i>
                        </span>
                            <input type="password" class="form-control" id="inputPassword3" name="password" value="<?php if (isset($_SESSION['password'])) {
                                    echo $_SESSION['password'];
                                }
                                
                            ?>" /> 
                         </div>
                    </div>
                    <p class="notification">
                        <?php
                                if (isset($_SESSION['tb'])) {
                                    echo $_SESSION['tb'];
                                }
                                unset($_SESSION['tb']);
                     ?>
                    </p>
                    
                    
                     <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label><input type="checkbox" name="remember" id="checkbox" /> Ghi nhớ tài khoản và mật khẩu</label>
                            </div>
                         </div>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default" id="loginbutton" name='button-submit'>Đăng nhập </button>
                        </div>
                    </div>
                    </form> 
                </div>
        </div>
    </div>
    
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>