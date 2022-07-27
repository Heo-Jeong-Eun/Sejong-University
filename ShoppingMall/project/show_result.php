<a href = './main_page.php'><input type = 'button' value = 'BACK'></a><br><br> <!--메인페이지로 이동하는 버튼-->

<style>

div {
  border: 3px solid black;
  margin-top: 70px;
  margin-bottom: 10px;
  margin-right: 100px;
  margin-left: 100px;
}

</style>

<div>
<center>
<br><br>
<table width="100" border="1">
<!--show_result.php는 제품 검색 페이지인 search_page.php에서 입력 받은 정보를 바탕으로 입력 받은 정보와 일치하는 제품들을 표시해주는 페이지-->
<?
  include './dbconn.php';

  $gender = $_POST['gender'];   //검색할 제품이 여자 옷인지 남자 옷인지 $gender에 저장
  if($gender == 'female'){ //검색할 옷이 여자 옷
    $item_type = $_POST['f_select']; //search_page.php에서 여자 옷 중 어떤 부류의 옷(원피스, 아우터, 셔츠, 티셔츠, 바지, 치마, 신발) 중 어떤 것인지 알려줌
  }
  else{ //검색할 옷이 남자 옷
    $item_type = $_POST['m_select']; //search_page.php에서 남자 옷 중 어떤 부류의 옷(아우터, 셔츠, 티셔츠, 바지, 신발) 중 어떤 것인지 알려줌
  }

  if($item_type == 'f_dress' || $item_type == 'f_outer' || $item_type == 'f_shirt' || $item_type == 'f_tshirt'){
    $cur_table = 'f_top'; //여자 원피스(f_dress), 여자 아우터(f_outer), 여자 셔츠(f_shirt), 여자 티셔츠(f_tshirt)의 정보는 모두 f_top 테이블에 저장되어 있음; $cur_table은 찾는 제품을 찾아오기 위해 탐색할 테이블을 저장한 변수
    if($item_type == 'f_dress'){$item_code = 201;} //여자 원피스(f_dress)의 제품 번호(product_no)의 앞 3 자리는 201 입니다
    if($item_type == 'f_outer'){$item_code = 202;} //여자 아우터(f_outer))의 제품 번호(product_no)의 앞 3 자리는 202 입니다
    if($item_type == 'f_shirt'){$item_code = 203;} //여자 셔츠(f_shirt)의 제품 번호(product_no)의 앞 3 자리는 203 입니다
    if($item_type == 'f_tshirt'){$item_code = 204;} //여자 티셔츠(f_tshirt)의 제품 번호(product_no)의 앞 3 자리는 204 입니다
  }
  else if($item_type == 'm_outer' || $item_type == 'm_shirt' || $item_type == 'm_tshirt'){
    $cur_table = 'm_top'; //남자 아우터(m_outer), 남자 셔츠(m_shirt), 남자 티셔츠(m_tshirt)의 정보는 모두 m_top 테이블에 저장되어 있음; $cur_table은 찾는 제품을 찾아오기 위해 탐색할 테이블을 저장한 변수
    if($item_type == 'm_outer'){$item_code = 101;} //남자 아우터(m_outer)의 제품 번호(product_no)의 앞 3 자리는 101 입니다
    if($item_type == 'm_shirt'){$item_code = 102;} //남자 셔츠(m_shirt)의 제품 번호(product_no)의 앞 3 자리는 102 입니다
    if($item_type == 'm_tshirt'){$item_code = 103;} //남자 티셔츠(m_tshirt)의 제품 번호(product_no)의 앞 3 자리는 103 입니다
  }
  else if($item_type == 'm_pants' || $item_type == 'f_pants'){
    $cur_table = 'pants'; //남자 바지(m_pants), 여자 바지(f_pants)의 정보는 모두 pants 테이블에 저장되어 있음; $cur_table은 찾는 제품을 찾아오기 위해 탐색할 테이블을 저장한 변수
    if($item_type == 'm_pants'){$item_code = 104;}  //남자 바지(m_pants) 제품 번호(product_no)의 앞 3 자리는 104 입니다
    if($item_type == 'f_pants'){$item_code = 205;}  //여지 바지(f_pants) 제품 번호(product_no)의 앞 3 자리는 205 입니다
  }
  else if($item_type == 'f_skirt'){
    $cur_table = 'skirt'; //여자 치마(f_skirt)의 정보는 skirt 테이블에 저장되어 있음; $cur_table은 찾는 제품을 찾아오기 위해 탐색할 테이블을 저장한 변수
    $item_code = 206;     //여지 치마(f_skirt) 제품 번호(product_no)의 앞 3 자리는 206 입니다
  }
  else if($item_type == 'm_shoes' || $item_type == 'f_shoes'){
    $cur_table = 'shoes'; //남자 신발(m_shoes), 여자 신발(f_shoes)의 정보는 모두 shoes 테이블에 저장되어 있음; $cur_table은 찾는 제품을 찾아오기 위해 탐색할 테이블을 저장한 변수
    if($item_type == 'm_shoes'){$item_code = 105;} //남자 신발(m_shoes) 제품 번호(product_no)의 앞 3 자리는 105 입니다
    if($item_type == 'f_shoes'){$item_code = 207;} //여지 신발(f_shoes) 제품 번호(product_no)의 앞 3 자리는 207 입니다
  }
  //$item_code는 검색하는 제품의 제품 번호 앞 3자리를 나타냄. (ex: 여자 신발을 검색 중이면 $item_code에 207 저장합니다. 왜냐하면, 모든 여자 신발의 제품 코드의 앞 3자리를 207로 저장했기 때문입니다.)

  echo"Gender: $gender<br>";
  echo"Search Item: $item_type<br><br>";

  $col = array();
  $num = array();
  $cnt = 0;
  if($_POST['total_len'] != null){
    $col[$cnt] = 'total_len';
    $num[$cnt] = $_POST['total_len'];
    $cnt++;
  }
  if($_POST['shoulder_len'] != null){
    $col[$cnt] = 'shoulder_len';
    $num[$cnt] = $_POST['shoulder_len'];
    $cnt++;
  }
  if($_POST['chest_len'] != null){
    $col[$cnt] = 'chest_len';
    $num[$cnt] = $_POST['chest_len'];
    $cnt++;
  }
  if($_POST['arm_len'] != null){
    $col[$cnt] = 'arm_len';
    $num[$cnt] = $_POST['arm_len'];
    $cnt++;
  }
  if($_POST['waist_len'] != null){
    $col[$cnt] = 'waist_len';
    $num[$cnt] = $_POST['waist_len'];
    $cnt++;
  }
  if($_POST['hem_len'] != null){
    $col[$cnt] = 'hem_len';
    $num[$cnt] = $_POST['hem_len'];
    $cnt++;
  }
  if($_POST['width'] != null){
    $col[$cnt] = 'width';
    $num[$cnt] = $_POST['width'];
    $cnt++;
  }
  if($_POST['heel'] != null){
    $col[$cnt] = 'heel';
    $num[$cnt] = $_POST['heel'];
    $cnt++;
  }
  if($_POST['price'] != null){
    $col[$cnt] = 'price';
    $num[$cnt] = $_POST['price'];
    $cnt++;
  } //입력한 수치들 중, null 값이 아닌 값들 중 어떤 길이인지는 $col에, 수치는 $num에 저장 (ex: 바지 밑단을 17이라고 입력 받으면 $col배열에 hem_len 그리고 $num 배열에는 17 저장)

  $query = "SELECT *FROM $cur_table WHERE (product_no div 1000) = $item_code";  //$cur_table 테이블 중에서, 제품 번호(product_no)의 앞 3자리가 $item_code랑 같은 투플들 찾음
  $result = mysqli_query($conn, $query);

  if($cnt == 0){  //search_page.php에서 검색할때, 하나의 수치도 검색하지 않았음
    while($row = mysqli_fetch_array($result)){ //수치를 하나도 입력 하지 않았으므로, $query를 통해 얻은 투플들을 모두 나타내줌
      echo "
        <tr>
          <td><a href = 'product_page.php?num=$row[product_no]&item=$cur_table'>$row[product_no]</a></td>
        </tr>
      "; //제품 표시 및 해당 제품의 상세 페이지 링크(클릭시 product_page.php로 넘어감)
    }
  }
  else{
    while($row = mysqli_fetch_array($result)){  //$query를 통해 얻은 투플들 중에서, 각 수치가 입력 받은 수치들의 +-3 범위 이내에 있는 투플들만 표시(ex:남자 바지 중 밑단이 17인 제품을 검색했으면, 남자 바지 중 밑단이 14~20인 투플들 나타냄)
      $flag = 0;
      for($i = 0; $i < $cnt; $i++){
        if($num[$i] >= $row[$col[$i]] - 3 && $num[$i] <= $row[$col[$i]] + 3){
          $flag++;  //(ex: 남자 바지 중 밑단이 17인 제품을 검색했을때, $row 투플의 밑단(hem_len)이 14(=17-3) ~ 20(17 + 3)이면 $flag 값 1 증가)
        }
      }

      if($flag == $cnt){ //(ex: 남자 바지 중 밑단이 17, 허리 둘레가 30인 제품을 검색 하면 $cnt == 2입니다. 이때, $flag ==$cnt이면 $row의 투플의 밑단(hem_len)과 허리 둘레(waist_len) 둘 다 입력 받은 수치의 +-3 범위에 있는 것을 나타냄
        echo "
          <tr>
            <td><a href = 'product_page.php?num=$row[product_no]&item=$cur_table'>$row[product_no]</a></td>
          </tr>
        "; //조건을 만족시키는 제품 표시 및 해당 제품의 상세 페이지 링크(클릭시 product_page.php로 넘어감)
      }
    }
  }

  mysqli_close($conn);
?>
</table>

<br><br>
</center>
</div>
