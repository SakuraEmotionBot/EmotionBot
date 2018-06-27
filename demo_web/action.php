<?php
    session_start();
   if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      $expensions= array("jpeg","jpg","png");
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="Không chấp nhận định dạng ảnh có đuôi này, mời bạn chọn JPEG hoặc PNG.";
      }
      if($file_size > 20971520){
         $errors[]='Kích cỡ file nên là 2 MB';
      }
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"images/".$file_name);
         $_SESSION['img_name']="images/".$file_name;
         //$_SESSION['img_name']=$file_name;
         echo $_SESSION["img_name"] ;
         header('Location: http://localhost/web/index.php');
      }
      else{
         print_r($errors);
      }
   }
?>