<a href = './my_page.php'><input type = 'button' value = '마이페이지로'></a><br>
<!--주문내역을 상세히 보여줌-->
<?
  include './dbconn.php';

  $order_id = $_GET['order_id'];

  $get_orders_q = "SELECT *FROM orders WHERE order_id = '$order_id'";
  $get_orders_r = mysqli_query($conn, $get_orders_q);

  echo"<br>주문내역:<br>";
  echo "
    <table width='500' border='1'>
    <tr>
      <td>주문 번호</td>
      <td>주문 제품</td>
    </tr>";
  while($cur = mysqli_fetch_array($get_orders_r)){
    echo "
      <tr>
        <td>$cur[order_id]</td>
        <td>$cur[product_no]</td>
      </tr>";
  }
  echo"</table><br>";


?>
