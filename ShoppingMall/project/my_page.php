<!--마이 페이지 -->
<a href = './main_page.php'><input type = 'button' value = 'MAIN PAGE'></a><br><br>

<style>
div {
  border: 3px solid black;
  margin-top: 70px;
  margin-bottom: 10px;
  margin-right: 100px;
  margin-left: 100px;
}
</style>

<center>
<div>
<br><br>
<?
  include './dbconn.php';

  session_start();

  $mem_id = $_SESSION['mem_id'];

  if(!$mem_id){ //로그인 상태가 아님
    echo"<script>alert('Please login in first')</script>";
    echo"<script>location.href='login_page.php'</script>";
  }
  else{
    $get_basket_q = "SELECT *FROM basket WHERE mem_id = '$mem_id'";
    $get_basket_r = mysqli_query($conn, $get_basket_q);
    echo"[ 장바구니 ] <br>";
    while($cur_A = mysqli_fetch_array($get_basket_r)){
      echo "
        <table width='250' border='1'>
        <tr>
          <td>$cur_A[product_no]</td>
          <td>$cur_A[price]원</td>
          <td><a href = './delete_from_basket.php?product_no=$cur[product_no]'><input type = 'button' value = '삭제'></a></td>
          <br>
        </tr>
        </table><br>";
    }//장바구니 보여줌

    if(mysqli_num_rows($get_basket_r)){
      echo "<a href = './insert_destination.php'><input type = 'button' value = '구매하기'></a><br>";
    }//장바구니에 있는 제품들 구매하기(구매시, 배송지 입력을 해야하므로, insert_destination.php로 이동)

    $get_orders_q = "SELECT orders.order_id, COUNT(*) as num, simple_orders.total_price, simple_orders.destination
                      FROM orders LEFT JOIN simple_orders
                      on orders.order_id = simple_orders.order_id
                      where simple_orders.mem_id = $mem_id
                      GROUP BY order_id";
    $get_orders_r = mysqli_query($conn, $get_orders_q);

    echo"<br><br>[ 주문 내역 ]<br><br>";
    echo "
      <table width='500' border='1'>
      <tr>
        <td>주문 번호</td>
        <td>주문 갯수</td>
        <td>총 주문 가격</td>
        <td>배송지</td>
        <td>상세히 보기</td>
      </tr>";
    while($cur_B = mysqli_fetch_array($get_orders_r)){
      echo "
        <tr>
          <td>$cur_B[order_id]</td>
          <td>$cur_B[num]</td>
          <td>$cur_B[total_price]원</td>
          <td>$cur_B[destination]</td>
          <td><a href = './purchase_detail.php?order_id=$cur_B[order_id]'><input type = 'button' value = '상세히'></a></td>
        </tr>";
    }//현재 로그인 한 회원의 주문 내역 중, 주문 번호, 한 개의 주문 번호 당 주문한 제품의 갯수, 그리고 총 주문 가격 표시
    echo"</table><br>";

    echo"<br<br><br><br><a href = './edit_mySize.php?mem_id=$mem_id'><input type = 'button' value = '신체 사이즈 수정'></a>";

    echo"<br><br><a href = './check_myInfo.php'><input type = 'button' value = '회원 탈퇴하기'></a><br><br>";
  }
?>
<br><br>
</div>
</center>
