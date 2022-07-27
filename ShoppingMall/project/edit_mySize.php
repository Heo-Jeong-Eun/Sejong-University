<a href = './my_page.php'><input type = 'button' value = '마이페이지'></a><br>
<!--로그인한 회원이 자신의 신체 사이즈 수정-->
<?
  include './dbconn.php';

  session_start();
  if(!$_SESSION['user_id']){ //로그인을 하지 않은 상태
    echo"<script>alert('Please login first')</script>"; //로그인을 하지 않은 상태이므로, 로그인을 먼저 하도록 알려줍니다
    echo"<script>location.href='./login_page.php'</script>";
  }
  else{
    $id = $_SESSION['user_id'];

    $query = "SELECT *FROM size WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $my_sizes = mysqli_fetch_array($result);
  }
?>
<html>
<body>
  <form name = "login_form" action = "update_mySize.php" method="post">
    <center>

    키:<input type = 'number' step = '1' min = '0' max = '999' value = '<?echo $my_sizes['user_height'];?>' name = 'user_height'>
    어깨 넓이:<input type = 'number' step = '1' min = '0' max = '999' value = '<?echo $my_sizes['shoulder_len'];?>' name = 'shoulder_len'>
    가슴 둘레:<input type = 'number' step = '1' min = '0' max = '999' value = '<?echo $my_sizes['chest_len'];?>' name = 'chest_len'>
    허리 둘레:<input type = 'number' step = '1' min = '0' max = '999' value = '<?echo $my_sizes['waist_len'];?>' name = 'waist_len'>
    팔 길이:<input type = 'number' step = '1' min = '0' max = '999' value = '<?echo $my_sizes['arm_len'];?>' name = 'arm_len'>
    다리 길이:<input type = 'number' step = '1' min = '0' max = '999' value = '<?echo $my_sizes['leg_len'];?>' name = 'leg_len'>
    발 길이:<input type = 'number' step = '1' min = '0' max = '999' value = '<?echo $my_sizes['foot_h'];?>' name = 'foot_h'>
    발 폭:<input type = 'number' step = '1' min = '0' max = '999' value = '<?echo $my_sizes['foot_w'];?>' name = 'foot_w'>

    <input type = "submit" value = "수정하기" onClick = "submitForm()">
    </center>
  </form>
</body>
