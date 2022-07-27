<?
  include './dbconn.php';
  session_start();

  $id = $_SESSION['user_id'];
  $pwd = $_POST['user_password'];

  $get_pwd_q = "SELECT pwd FROM member WHERE id = '$id'";
  $get_pwd_r = mysqli_query($conn, $get_pwd_q);
  $correct_pwd = mysqli_fetch_array($get_pwd_r);

  if($pwd == $correct_pwd['pwd']){
    $delA_q = "DELETE b, s, o
                FROM (((member m LEFT JOIN basket b ON m.mem_id = b.mem_id)
                                    LEFT JOIN simple_orders s ON s.mem_id = m.mem_id)
                                          LEFT JOIN orders o ON s.order_id = o.order_id)
                WHERE m.id = '$id'";

    $delB_q = "DELETE m, s
                FROM member m LEFT JOIN size s
                ON m.id = s.id
                WHERE m.id = '$id'";

    mysqli_query($conn, $delA_q);
    mysqli_query($conn, $delB_q);


    echo"<script>location.href='./logout.php'</script>";
  }
  else{
    echo"<script>alert('Incorrect Password')</script>";
    echo"<script>location.href='./check_myInfo.php'</script>";
  }


?>
