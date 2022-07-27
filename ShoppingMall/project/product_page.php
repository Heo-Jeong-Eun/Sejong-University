<a href = './show_basket.php'><input type = 'button' value = 'BASKET'></a><br> <!--장바구니로 이동하는 버튼-->

<center>
<h5> [ 제품 번호 / 제품 가격 ] </h5>

<!--product.php는 검색 해서 나오는 결과들 중 클릭한 제품의 상세 페이지 입니다 -->
<?
  include './dbconn.php';

  $cur_table = $_GET['item'];
  $product_no = $_GET['num'];

  $searched_query = "SELECT *FROM $cur_table WHERE product_no = $product_no"; //클릭한 제품의 투플을 찾음(ex: 남자 바지 검색후 제품 번호가 104001인 제품을 클릭 했으면, pants 테이블에서 product_no가 104001인 투플을 찾음)
  $searched_result = mysqli_query($conn, $searched_query);
  $searched = mysqli_fetch_array($searched_result); //클릭한 제품의 투플

  echo"$searched[product_no], $searched[price]원<br><br>"; //클릭한 제품의 제품번호와 가격 표시

  $img_src_1 = $product_no.'_1.png';
  $img_src_2 = $product_no.'_2.png';
  $img_src_3 = $product_no.'_3.png';
  echo"<a href = 'product_images/".$img_src_1."'><img name = 'img_1' src = 'product_images/".$img_src_1."' height='300' width = '300'></a><br>";
  echo"<a href = 'product_images/".$img_src_2."'><img name = 'img_2' src = 'product_images/".$img_src_2."' height='300' width = '300'></a><br>";
  echo"<a href = 'product_images/".$img_src_3."'><img name = 'img_3' src = 'product_images/".$img_src_3."' height='300' width = '300'></a><br><br>";
  //각 제품 마다 이미지 3개를 저장했으며, 해당 이미지 3개를 보여줌

  if($cur_table != 'shoes'){
    $find_query = "SELECT *FROM $cur_table
                  WHERE line = $searched[line]
                  AND thickness = $searched[thickness]
                  AND product_no != $product_no
                  AND (product_no div 1000) = ($product_no div 1000)";
                  //신발을 제외한 모든 부류의 제품들 중, 현재 보고 있는 제품과 같은 부류의 제품이고, 현재 보고 있는 제품이 아니며, 현재 보고 있늦 제품의 thickness값과 line 값이 같은 투플들 찾음
                  //(ex:현재 보고 있는 제품이 남자 바지이며, thickness == 2, line == 2일때, 남자 바지 중 thickness == 2이며 line == 2인 투플들 찾음)
    $find_result = mysqli_query($conn, $find_query);
    echo"Products similar to this one:<br>";
    while($found = mysqli_fetch_array($find_result)){ //
      echo "
      <br>
        <table width='100' border='1'>
        <tr>
          <td><a href = 'product_page.php?num=$found[product_no]&item=$cur_table'>$found[product_no]</a></td>
        </tr>
        </table>
      ";
    } //(ex:현재 보고 있는 제품이 남자 바지이며, thickness == 2, line == 2일때, 남자 바지 중 thickness == 2이며 line == 2인 투플들 표시 & 해당 제품의 상세 페이지(product_page.php)로 가는 링크)
  }
  else{ //현재보고 있는 제품이 신발일때
    $find_query = "SELECT *FROM $cur_table
                  WHERE width >= $searched[width]
                  AND product_no != $product_no
                  AND (product_no div 1000) = ($product_no div 1000)";
                  //신발들 중, 현재 보고 있는 제품이 아니며, 현재 보고 있늦 제품과 width의 값이 같은 투플들 찾음
    $find_result = mysqli_query($conn, $find_query);
    echo"Products similar to this one:<br>";
    while($found = mysqli_fetch_array($find_result)){
      echo "
      <br>
        <table width='100' border='1'>
        <tr>
          <td><a href = 'product_page.php?num=$found[product_no]&item=$cur_table'>$found[product_no]</a></td>
        </tr>
        </table>
      ";
    } //(ex:신발들 중, 현재 보고 있는 제품이 아니며, 현재 보고 있늦 제품과 width의 값이 같은 투플들 표시 & 해당 제품의 상세 페이지(product_page.php)로 가는 링크)
  }

  session_start();
  if($_SESSION['user_id']){ //세션의 'user_id' 값이 null이 아니면 로그인을 했다는 뜻입니다 => 그러므로, 로그인한 회원의 신체 사이즈와 맞는 제품들 추천가능 & 현재 보고 있는 제품을 장바구니에 담는게 가능
    $cur_id = $_SESSION['user_id'];
    $my_size_q = "SELECT *FROM size
                  WHERE id = '$cur_id'";  //현재 로그인한 회원의 신체사이즈 찾기
    $my_size_r = mysqli_query($conn, $my_size_q);
    $my_size = mysqli_fetch_array($my_size_r);

    $flag = 0;  //비슷한 제품을 찾았다는 변수
    if($cur_table == 'pants'){
        if($my_size['leg_len'] == null){  //다리 길이(leg_len)를 입력하지 않으면 바지를 추천 받을 수 없음
            echo "Please save your leg length!";
        }
        else if($my_size['waist_len'] == null){ //허리 둘레(waist_len)를 입력하지 않으면 바지를 추천 받을 수 없음
            echo "Please save your waist length!";
        }
        else{
          echo "<br>Products similar to my body:<br>";
          $find_similar_q = "SELECT *FROM $cur_table
                          WHERE total_len >= $my_size[leg_len] - 5 AND total_len <= $my_size[leg_len] + 5
                          AND waist_len >= $my_size[waist_len] - 5 AND waist_len <= $my_size[waist_len] + 5";


          $find_similar_r = mysqli_query($conn, $find_similar_q);
          $flag = 1;
        }
    }

    if($cur_table == 'm_top'){
        if($my_size['shoulder_len'] == null){
            echo "Please save your shoulder width!";
        }
        else if($my_size['chest_len'] == null){
            echo "Please save your chest length!";
        }
        else{
          echo "<br>Products similar to my body:<br>";
          $find_similar_q = "SELECT *FROM $cur_table
                          WHERE shoulder_len >= $my_size[shoulder_len] - 5 AND shoulder_len <= $my_size[shoulder_len] + 5
                          AND chest_len >= $my_size[chest_len] - 5 AND chest_len <= $my_size[chest_len] + 5";
          $find_similar_r = mysqli_query($conn, $find_similar_q);
          $flag = 1;
        }
    }
    if($cur_table == 'shoes'){
        if($my_size['foot_h'] == null){
            echo "Please save your foot length!";
        }
        else if($my_size['foot_w'] == null){
            echo "Please save your foot width!";
        }
        else{
          echo "<br>Products similar to my body:<br>";
          $find_similar_q = "SELECT *FROM $cur_table
                          WHERE total_len >= $my_size[foot_h] - 5 AND total_len <= $my_size[foot_h] + 5
                          AND width >= $my_size[foot_w] - 1 AND width <= $my_size[foot_w] + 1";
          $find_similar_r = mysqli_query($conn, $find_similar_q);
          $flag = 1;
        }
    }
    if($cur_table == 'f_top' && ($product_no/1000) != 201){ //핸재 보고 있는 제품이 여자 원피스가 아닐때
        if($my_size['chest_len'] == null){
            echo "Please save your chest length!";
        }
        else if($my_size['waist_len'] == null){
            echo "Please save your waist width!";
        }
        else{
          echo "<br>Products similar to my body:<br>";
          $find_similar_q = "SELECT *FROM $cur_table
                          WHERE chest_len >= $my_size[chest_len] - 3 AND chest_len <= $my_size[chest_len] + 3
                          AND waist_len - 10 >= $my_size[waist_len] - 3 AND waist_len - 10 <= $my_size[waist_len] + 3";
          $find_similar_r = mysqli_query($conn, $find_similar_q);
          $flag = 1;
        }
    }
    if($cur_table == 'f_top' && ($product_no/1000) == 201){ //핸재 보고 있는 제품이 여자 원피스일때
        if($my_size['chest_len'] == null){
            echo "Please save your chest length!";
        }
        else if($my_size['waist_len'] == null){
            echo "Please save your waist width!";
        }
        else if($my_size['user_height'] == null){
            echo "Please save your height!";
        }
        else{
          echo "<br>Products similar to my body:<br>";
          $find_similar_q = "SELECT *FROM $cur_table
                          WHERE chest_len >= $my_size[chest_len] - 3 AND chest_len <= $my_size[chest_len] + 3
                          AND waist_len - 10 >= $my_size[waist_len] - 3 AND waist_len - 10 <= $my_size[waist_len] + 3
                          AND total_len >= ($my_size[user_height] - 70) - 5 AND total_len <= ($my_size[user_height] - 70) + 5";
          $find_similar_r = mysqli_query($conn, $find_similar_q);
          $flag = 1;
        }
    }
    if($cur_table == 'skirt'){
        if($my_size['waist_len'] == null){
            echo "Please save your waist width!";
        }
        else if($my_size['leg_len'] == null){
            echo "Please save your leg length!";
        }
        else{
          echo "<br>Products similar to my body:<br>";
          $find_similar_q = "SELECT *FROM $cur_table
                          WHERE waist_len - 50 >= $my_size[waist_len] - 3 AND waist_len - 50 <= $my_size[waist_len] + 3
                          AND total_len >= ($my_size[leg_len]/2) - 5 AND total_len <= ($my_size[leg_len]/2) + 5";
          $find_similar_r = mysqli_query($conn, $find_similar_q);
          $flag = 1;
        }
    }//부속 질의 사용 시, size 테이블을 적게는 4번, 많게는 6번 참조하게 되므로, 부속 질의를 사용하지 않았습니다

    if($flag == 1){
      while($found_similar = mysqli_fetch_array($find_similar_r)){
        echo "
          <table width='100' border='1'>
          <tr>
            <td><a href = 'product_page.php?num=$found_similar[product_no]&item=$cur_table'>$found_similar[product_no]</a></td>
          </tr>
          </table>
        ";
      }
    }

    echo"<br><br><a href = 'add_to_basket.php?add_product=$product_no&item=$cur_table&price=$searched[price]'><input type = 'button' value = 'ADD Basket'></a><br>";
    //(로그인한 상태에서만 버튼이 보여짐)버튼 클릭시, 현재 보고있는 제품을 장바구니에 담기. 실제 장바구니 테이블에 저장을 하기 위해 add_to_basket.php로 이동
  }
?>
</center>
