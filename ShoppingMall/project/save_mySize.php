<?
  include './dbconn.php';

  $id = $_POST['user_id'];
  $password = $_POST['user_password'];
  $name = $_POST['user_name'];
  $phNum = $_POST['user_phNum'];

  $user_height = $_POST['user_height'];
  $shoulder_len = $_POST['shoulder_len'];
  $chest_len = $_POST['chest_len'];
  $waist_len = $_POST['waist_len'];
  $arm_len = $_POST['arm_len'];
  $leg_len = $_POST['leg_len'];
  $foot_h = $_POST['foot_h'];
  $foot_w = $_POST['foot_w'];

  $find_id = "SELECT *FROM member WHERE id = '$id'";
  $find_id_result = mysqli_query($conn, $find_id);
  if($num = mysqli_num_rows($find_id_result)){
    echo "<script>alert('User id already exists!')</script>";
    echo"<script>location.href='./sign_up_page.php';</script>";
  }
  else{
    $save_info = "INSERT INTO member(id, pwd, name, phone_number) VALUES('$id', '$password', '$name', '$phNum')";
    mysqli_query($conn, $save_info);

    if($user_height == null){
      $user_height = 'null';
    }
    if($shoulder_len == null){
      $shoulder_len = 'null';
    }
    if($chest_len == null){
      $chest_len = 'null';
    }
    if($waist_len == null){
      $waist_len = 'null';
    }
    if($arm_len == null){
      $arm_len = 'null';
    }
    if($leg_len == null){
      $leg_len = 'null';
    }
    if($foot_h == null){
      $foot_h = 'null';
    }
    if($foot_w == null){
      $foot_w = 'null';
    }

    $save_mySize_query = "INSERT INTO size VALUES('$id', $user_height, $shoulder_len, $chest_len, $waist_len, $arm_len, $leg_len, $foot_h, $foot_w)";
    mysqli_query($conn, $save_mySize_query);

    echo"<script>location.href='./main_page.php'</script>";
  }
?>
