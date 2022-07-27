<?
  session_start();
  $id = $_SESSION['user_id'];
  session_destroy();
  
  if($id){
    echo"<script>alert('Logged out')</script>";
  }
  echo"<script>location.href='./main_page.php'</script>";
?>
