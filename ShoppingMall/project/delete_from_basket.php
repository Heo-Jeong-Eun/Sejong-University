<?
  include './dbconn.php';
  session_start();

  $mem_id = $_SESSION['mem_id'];
  $product_no = $_GET['product_no'];

  $query = "DELETE FROM basket
            WHERE mem_id = '$mem_id' AND product_no = '$product_no'";
  mysqli_query($conn, $query);

  echo"<script>alert('Item deleted from basket')</script>";
  echo"<script>location.href='show_basket.php'</script>";
?>
