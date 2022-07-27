<!-- 회원가입 페이지-->
<a href = './main_page.php'><input type = 'button' value = 'MAIN PAGE'></a>

<?
  session_start();
  if($_SESSION['user_id']){ //로그인한 상태
    echo"<script>alert('Already logged in!')</script>"; //로그인한 상태이므로, 회원가입이 불가능
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
    else if(!document.login_form.user_name.value){
      alert("Input Name");
      document.login_form.user_name.focus();
      return;
    }
    else if(!document.login_form.user_phNum.value){
      alert("Input Phone Number");
      document.login_form.user_phNum.focus();
      return;
    }

    document.login_form.submit();
  }
</script>
</head>
<body>
  <form name = "login_form" action = "save_mySize.php" method="post">
    <center>
    <br>
<div>
    <br>
    <label>ID: </label> <input type = "text" name = "user_id"><br>
    <label>Password: </label> <input type = "text" name = "user_password"><br>
    <label>Name: </label> <input type = "text" name = "user_name"><br>
    <label>Phone Number: </label> <input type = "text" name = "user_phNum"><br>
    <br>
</div>
    <br><br><br>
<div>
    <br>
    키:<input type = 'number' step = '1' min = '0' max = '999' name = 'user_height'><br>
    어깨 넓이:<input type = 'number' step = '1' min = '0' max = '999' name = 'shoulder_len'><br>
    가슴 둘레:<input type = 'number' step = '1' min = '0' max = '999' name = 'chest_len'><br>
    허리 둘레:<input type = 'number' step = '1' min = '0' max = '999' name = 'waist_len'><br>
    팔 길이:<input type = 'number' step = '1' min = '0' max = '999' name = 'arm_len'><br>
    다리 길이:<input type = 'number' step = '1' min = '0' max = '999' name = 'leg_len'><br>
    발 길이:<input type = 'number' step = '1' min = '0' max = '999' name = 'foot_h'><br>
    발 폭:<input type = 'number' step = '1' min = '0' max = '999' name = 'foot_w'><br>
    <br>
</div>
    <br><br>
    <input type = "button" value = "SIGN UP" onClick = "submitForm()">
    </center>
  </form>
</body>
