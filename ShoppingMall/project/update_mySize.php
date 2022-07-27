<!--수정할 사이즈를 edit_mySize.php에서 입력 받은 후 size 테이블을 업데이트 시키기 -->
<?
  include './dbconn.php';
  session_start();

  $id = $_SESSION['user_id'];

  $user_height = $_POST['user_height'];
  $shoulder_len = $_POST['shoulder_len'];
  $chest_len = $_POST['chest_len'];
  $waist_len = $_POST['waist_len'];
  $arm_len = $_POST['arm_len'];
  $leg_len = $_POST['leg_len'];
  $foot_h = $_POST['foot_h'];
  $foot_w = $_POST['foot_w'];


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
  }//신체 사이즈 수정 할때, 공백으로 둔 수치들은 null값으로 저장

  $update_mySize_query = "UPDATE size
                            SET user_height = $user_height,
                                shoulder_len = $shoulder_len,
                                chest_len = $chest_len,
                                waist_len = $waist_len,
                                arm_len = $arm_len,
                                leg_len = $leg_len,
                                foot_h = $foot_h,
                                foot_w = $foot_w
                            WHERE id = '$id'";

  mysqli_query($conn, $update_mySize_query);

  echo"<script>alert('Size updated')</script>";
  echo"<script>location.href='./main_page.php'</script>";
?>
