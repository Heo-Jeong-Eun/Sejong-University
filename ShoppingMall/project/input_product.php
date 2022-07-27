<!-- resgister>product.php에서 입력 받은 정보로 실제 테이블에 새로운 제품 저장-->
<?
  include './dbconn.php';

  $gender = $_POST['gender'];
  if($gender == 'female'){
    $item_type = $_POST['f_select'];
  }
  else{
    $item_type = $_POST['m_select'];
  }

  if($item_type == 'f_dress' || $item_type == 'f_outer' || $item_type == 'f_shirt' || $item_type == 'f_tshirt'){
    $cur_table = 'f_top';
    if($item_type == 'f_dress'){$item_code = 201;}
    if($item_type == 'f_outer'){$item_code = 202;}
    if($item_type == 'f_shirt'){$item_code = 203;}
    if($item_type == 'f_tshirt'){$item_code = 204;}
  }
  else if($item_type == 'm_outer' || $item_type == 'm_shirt' || $item_type == 'm_tshirt'){
    $cur_table = 'm_top';
    if($item_type == 'm_outer'){$item_code = 101;}
    if($item_type == 'm_shirt'){$item_code = 102;}
    if($item_type == 'm_tshirt'){$item_code = 103;}
  }
  else if($item_type == 'm_pants' || $item_type == 'f_pants'){
    $cur_table = 'pants';
    if($item_type == 'm_pants'){$item_code = 104;}
    if($item_type == 'f_pants'){$item_code = 205;}
  }
  else if($item_type == 'f_skirt'){
    $cur_table = 'skirt';
    $item_code = 206;
  }
  else if($item_type == 'm_shoes' || $item_type == 'f_shoes'){
    $cur_table = 'shoes';
    if($item_type == 'm_shoes'){$item_code = 105;}
    if($item_type == 'f_shoes'){$item_code = 207;}
  }
  //show_result.php에서와 동일

  $total_len = $_POST['total_len'];
  $shoulder_len = $_POST['shoulder_len'];
  $chest_len = $_POST['chest_len'];
  $arm_len = $_POST['arm_len'];
  $waist_len = $_POST['waist_len'];
  $hem_len = $_POST['hem_len'];
  $width = $_POST['width'];
  $heel = $_POST['heel'];
  $stretch = $_POST['stretch'];
  $line = $_POST['line'];
  $thickness = $_POST['thickness'];
  $price = $_POST['price'];

  $flag = 0;
  if($price == null){
    $flag = 1;
  }
  if($item_type != 'f_shoes' && $item_type != 'm_shoes'){
    if($stretch == null || $line == null || $thickness == null){
      $flag = 1;
    }
  }
  if($item_type == 'm_outer' || $item_type == 'm_shirt' || $item_type == 'm_tshirt'){
    if($total_len == null || $shoulder_len == null || $chest_len == null || $arm_len == null){
      $flag = 1;
    }
  }
  if($item_type == 'f_dress' || $item_type == 'f_outer' || $item_type == 'f_shirt' || $item_type == 'f_tshirt'){
    if($total_len == null  || $chest_len == null || $arm_len == null || $waist_len == null){
      $flag = 1;
    }
  }
  if($item_type == 'f_pants' || $item_type == 'm_pants'){
    if($total_len == null  || $waist_len == null || $hem_len == null){
      $flag = 1;
    }
  }
  if($item_type == 'f_shoes' || $item_type == 'm_shoes'){
    if($total_len == null  || $width == null || $heel == null){
      $flag = 1;
    }
  }
  if($item_type == 'f_skirt'){
    if($total_len == null  || $waist_len == null){
      $flag = 1;
    }
  }

  if($flag == 1){ //$flag 값이 1 이면, 입력한 수치 중 적어도 하나의 수치가 공백이라는 것을 뜻함
    echo"<script>alert('Please input all the required information')</script>";  //제품 등록시 모든 수치를 입력 해야되므로, 모든 수치를 입력해달라고 사용자에게 알려줌
    echo"<script>location.href='./register_product.php'</script>";
  }
  else{
      $get_product_no_q = "SELECT max(product_no) FROM $cur_table WHERE (product_no div 1000) = $item_code";
      $get_product_no_r = mysqli_query($conn, $get_product_no_q);
      $max = mysqli_fetch_array($get_product_no_r);
      $new_product_no = $max['max(product_no)'];  //등록할 제품 부류 중 product_no 값이 가장 큰 값을 저장
      //ex:현재 남자 바지 중 제품 번호(product_no) 값이 가장 큰 값이 104010일때, 새로운 남자 바지 등록시 새로운 제품의 제품 번호는 104011로 저장한다

      if($item_type == 'm_outer' || $item_type == 'm_shirt' || $item_type == 'm_tshirt'){
          $register_item_query = "INSERT INTO $cur_table VALUES($new_product_no + 1, $total_len, $shoulder_len, $chest_len, $arm_len, $stretch, $line, $thickness, $price)";
      }
      if($item_type == 'f_dress' || $item_type == 'f_outer' || $item_type == 'f_shirt' || $item_type == 'f_tshirt'){
          $register_item_query = "INSERT INTO $cur_table VALUES($new_product_no + 1, $total_len,  $chest_len, $waist_len, $arm_len, $stretch, $line, $thickness, $price)";
      }
      if($item_type == 'f_pants' || $item_type == 'm_pants'){
          $register_item_query = "INSERT INTO $cur_table VALUES($new_product_no + 1, $total_len, $waist_len, $hem_len, $stretch, $line, $thickness, $price)";
      }
      if($item_type == 'f_skirt'){
        $register_item_query = "INSERT INTO $cur_table VALUES($new_product_no + 1, $total_len, $waist_len, $stretch, $line, $thickness, $price)";
      }
      if($item_type == 'f_shoes' || $item_type == 'm_shoes'){
          $register_item_query = "INSERT INTO $cur_table VALUES($new_product_no + 1, $total_len, $width, $heel, $price)";
      }
      //제품 종류마다 필요로 하는 수치가 다르므로 if문으로 나눔

      mysqli_query($conn, $register_item_query);
      echo"<script>alert('Product successfully registered!')</script>";
      echo"<script>location.href='./main_page.php'</script>"; //메인페이지(main_page.php)로 이동
  }


?>
