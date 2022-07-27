<a href = './main_page.php'><input type = 'button' value = 'MAIN PAGE'></a>
<br><br><br><br><br><br><br>
<!--로그인 하기 위해 아이디와 비밀번호 저장 -->
<?
  session_start();
  if($_SESSION['user_id']){ //이미 로그인을 한 상태
    echo"<script>alert('Already logged in!')</script>"; //이미 로그인을 한 상태 이므로, 또 로그인 할 필요가 없음
    echo"<script>location.href='./main_page.php'</script>";
  }
?>
<html>

<style>
div {
  border: 3px solid black;
  margin-top: 70px;
  margin-bottom: 10px;
  margin-right: 100px;
  margin-left: 100px;
}
</style>

<head>
<script>
  function submitForm(){
    if(!document.login_form.user_id.value){
      alert("Input ID");
      document.Login_form.user_id.focus();
      return;
    }
    else if(!document.login_form.user_password.value){
      alert("Input Password");
      document.login_form.user_password.focus();
      return;
    }

    document.login_form.submit();
  }
</script>
</head>

<body>
  <div>
  <br><br>
  <form name = "login_form" action = "verify_login.php" method="post"> <!--아이디와 비밀번호를 입력 받고, verify_login.php에서 정보가 맞는지 확인 및 로그인 진행 -->
    <center>
    <label>ID: </label> <input type = "text" name = "user_id"><br>
    <label>Password: </label> <input type = "password" name = "user_password"><br><br>
    <input type = "button" value = "LOGIN" onClick = "submitForm()">
    </center>
  </form>
</div>
</body>
