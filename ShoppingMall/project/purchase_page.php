<!--주문 내역 저장-->
<?
  include './dbconn.php';
  session_start();

  $mem_id = $_SESSION['mem_id']; //현재 로그인한 회원의 회원 번호 저장
  $dst = $_POST['dst']; //insert_destination.php 에서 입력 받은 배송지

  $max_q = "SELECT max(order_id) FROM orders";
  $max_r = mysqli_query($conn, $max_q);
  $max = mysqli_fetch_array($max_r);
  $order_id = $max['max(order_id)'];  //orders 테이블에서 order_id가 가장 큰 투플의 order_id 값 저장
  //orders와 simple_orders 테이블에 새로 입력할 투플의  order_id 값은 orders 테이블에서 order_id가 가장 큰 값 + 1

  $get_basket_q = "SELECT *FROM basket WHERE mem_id = '$mem_id'"; //basket 테이블에서 mem_id = $mem_id인 투플들 찾기->basket 테이블에서 현재 로그인한 회원의 장바구니에 담긴 제품들 찾기
  $get_basket_r = mysqli_query($conn, $get_basket_q);
  $total = 0;
  while($cur = mysqli_fetch_array($get_basket_r)){
    $product_no = $cur['product_no'];
    $product_price = $cur['price'];
    $in_orders = "INSERT INTO orders VALUES($order_id + 1, $product_no)";
    $total += $product_price;
    mysqli_query($conn, $in_orders);
  }
  $in_simple_orders_q = "INSERT INTO simple_orders VALUES($order_id + 1, $mem_id, $total, '$dst')";
  mysqli_query($conn, $in_simple_orders_q);

  $query = "DELETE FROM basket
            WHERE mem_id = '$mem_id'";  //장바구니에 있는 제품들을 구매한것이므로, 현제 로그인한 회원의 장바구니를 비웁니다
  mysqli_query($conn, $query);

  echo"<script>location.href='main_page.php'</script>"; //메인 페이지(main_page.php)로 이동
?>
