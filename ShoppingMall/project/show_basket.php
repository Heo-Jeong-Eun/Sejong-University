<a href = './main_page.php'><input type = 'button' value = 'MAIN PAGE'></a><br><br><br> <!--버튼 클릭시, 메인페이지(main_page.php)로 이동-->

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

<!-- 장바구니에 담긴 제품들 표시-->
<?
  include './dbconn.php';
  session_start();

  $mem_id = $_SESSION['mem_id'];
  if($mem_id){  //$mem_id 가 null 값이 아니면 로그인을 했다는 뜻 입니다 => 그러므로, 로그인한 회원 장바구니 조회 가능
    $get_basket_q = "SELECT *FROM basket WHERE mem_id = '$mem_id'"; //bakset 테이블에서 mem_id가 $mem_id인 투플들 찾음 => 현재 로그인한 회원의 장바구니 찾기
    $get_basket_r = mysqli_query($conn, $get_basket_q);
    while($cur = mysqli_fetch_array($get_basket_r)){
      echo "
        <br>
        <table width='250' border='1'>
        <tr>
          <td>$cur[product_no]</td>
          <td>$cur[price]원</td>
          <td><a href = './delete_from_basket.php?product_no=$cur[product_no]'><input type = 'button' value = '삭제'></a></td>
        </tr><br>
        </table><br>
      "; //삭제 버튼 클릭시, 같은 줄에 표시되는 제품을 장바구니에서 제거. 제거하기 위해서 delete_from_basket.php로 이동
    }
    if(mysqli_num_rows($get_basket_r)){
      echo "<br><br><a href = './insert_destination.php'><input type = 'button' value = '구매하기'></a><br><br><br>";
      //구매하기 버튼을 누르면 현재 장바구니에 있는 제품들 구매하게 됩니다. 구매 전에 먼저 배송지를 입력->배송지를 입력하기 위해 insert_destination.php로 이동
    }
  }

  else{ //$mem_id 값이 null이므로 현재 로기은을 하지 않은 상태
      echo"<script>alert('Please login in first')</script>";
      echo"<script>location.href='login_page.php'</script>"; //로그인 하기 위해 로그인 페이지(login_page.php)로 이동
  }
?>
</div>
</center>
