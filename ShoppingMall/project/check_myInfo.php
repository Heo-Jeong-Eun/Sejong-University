<html>
<head>
<script>
  function submitForm(){
    if(!document.login_form.user_password.value){
      alert("Input Password");
      document.login_form.user_password.focus();
      return;
    }
    document.login_form.submit();
  }
</script>
</head>
<body>
  <form name = "login_form" action = "delete_myInfo.php" method="post">
    <center>
    <label>Password: </label> <input type = "text" name = "user_password"><br>
    <input type = "button" value = "탈퇴하기" onClick = "submitForm()">
    </center>
  </form>
</body>
