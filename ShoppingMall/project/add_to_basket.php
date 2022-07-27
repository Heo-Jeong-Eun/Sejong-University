<!-- 현재 보고 있던 제품을 장바구니에 담기-->
<?
  include './dbconn.php';
  session_start();

  $mem_id = $_SESSION['mem_id'];
  $add_product = $_GET['add_product'];
  $price = $_GET['price'];
  $item_type = $_GET['item'];


  $query_A = "SELECT *FROM basket WHERE mem_id = '$mem_id'";
  $result_A = mysqli_query($conn, $query_A);
  $flag = 0;
  while($row = mysqli_fetch_array($result_A)){
    if($row['product_no'] == $add_product){ //현재 보고 있는 제품이 이미 장바구니에 담겨져 있음
      echo"<script>alert('This item is already in the basket')</script>";
      echo"<script>location.href='product_page.php?num=$add_product&item=$item_type'</script>";
      $flag = 1;
    }
  }
  if($flag == 0){
    $query_B = "INSERT INTO basket VALUES($mem_id, $add_product, $price)";  //basket 테이블에 회원 번호, 제품 번호, 가격 저장
    mysqli_query($conn, $query_B);

    echo"<script>alert('Item has been added to the basket')</script>";
  }

  echo"<script>location.href='product_page.php?num=$add_product&item=$item_type'</script>"; //현재 장바구니에 담은 제품의 상세 페이지로 이동
?>
