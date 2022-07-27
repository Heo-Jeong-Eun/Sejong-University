<!--login_page.php에서 입력 받은 아이디와 비밀번호 확인 및 로그인 진행-->
<?
  include './dbconn.php';
  session_start();

  $id = $_POST['user_id'];
  $password = $_POST['user_password'];

  $login_q = "SELECT *FROM member WHERE id = '$id'";
  $login_r = mysqli_query($conn, $login_q);

  if(mysqli_num_rows($login_r)){  //입력 받은 아이디와 아이디가 같은 투플 존재
    $result = mysqli_fetch_array($login_r);

    if($result['pwd'] == $password){  //아이디와 비밀번호 일치
      $_SESSION['user_id'] = $id;
      $_SESSION['mem_id'] = $result['mem_id'];
      echo"<script>alert('Login Successful!')</script>";
      echo"<script>location.href='./main_page.php'</script>";
    }
    else{ //비밀번호 틀림
      echo"<script>alert('Incorrect password')</script>";
      echo"<script>location.href='./login_page.php'</script>";
    }
  }
  else{ //존재하지 않는 아이디를 입력받음
    echo"<script>alert('Incorrect ID')</script>";
    echo"<script>location.href='./login_page.php'</script>";
  }
?>
