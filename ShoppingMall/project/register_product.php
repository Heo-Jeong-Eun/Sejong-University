<!--새로 등록할 제품의 정보 입력 -->
<?
  session_start();

  if($_SESSION['user_id'] != 'admin'){
    echo"<script>alert('Only an admin can input products')</script>";
    echo"<script>location.href='./main_page.php'</script>";
  }
?>
<html>
<style>
  div {
    border: 3px solid black;
    margin-top: 70px;
    margin-bottom: 10px;
    margin-right: 100px;
    margin-left: 100px;
  }
</style>

<head>
<script>
  function f_selected(){
    var select_f = document.getElementById('f_select');
    var select_m = document.getElementById('m_select');

    reset_searchable();
    select_f.selectedIndex = -1;
    select_m.selectedIndex = -1;
    select_f.style.display = 'inline';
    select_m.style.display = 'none';
  }
  function m_selected(){
    var select_f = document.getElementById('f_select');
    var select_m = document.getElementById('m_select');

    reset_searchable();
    select_f.selectedIndex = -1;
    select_m.selectedIndex = -1;
    select_f.style.display = 'none';
    select_m.style.display = 'inline';
  }

  function item_selected(selected_gender){
    var cur_selected = document.getElementById(selected_gender);
    var cur_selected_name = cur_selected.options[cur_selected.selectedIndex].value;

    show_searchable(cur_selected_name);
  }

  function show_searchable(cur_name){
    reset_searchable();
    document.input_bar.submitButton.style.display = 'inline';

    if(cur_name == 'm_outer' || cur_name == 'm_shirt' || cur_name == 'm_tshirt'){
      document.getElementById('total_len_text').style.display = 'inline';
      document.getElementById('shoulder_len_text').style.display = 'inline';
      document.getElementById('chest_len_text').style.display = 'inline';
      document.getElementById('arm_len_text').style.display = 'inline';

      document.input_bar.total_len.style.display = 'inline';
      document.input_bar.shoulder_len.style.display = 'inline';
      document.input_bar.chest_len.style.display = 'inline';
      document.input_bar.arm_len.style.display = 'inline';
    }
    if(cur_name == 'f_dress' || cur_name == 'f_outer' || cur_name == 'f_shirt' || cur_name == 'f_tshirt'){
      document.getElementById('total_len_text').style.display = 'inline';
      document.getElementById('chest_len_text').style.display = 'inline';
      document.getElementById('waist_len_text').style.display = 'inline';
      document.getElementById('arm_len_text').style.display = 'inline';

      document.input_bar.total_len.style.display = 'inline';
      document.input_bar.chest_len.style.display = 'inline';
      document.input_bar.waist_len.style.display = 'inline';
      document.input_bar.arm_len.style.display = 'inline';
    }
    if(cur_name == 'f_pants' || cur_name == 'm_pants'){
      document.getElementById('total_len_text').style.display = 'inline';
      document.getElementById('waist_len_text').style.display = 'inline';
      document.getElementById('hem_len_text').style.display = 'inline';

      document.input_bar.total_len.style.display = 'inline';
      document.input_bar.waist_len.style.display = 'inline';
      document.input_bar.hem_len.style.display = 'inline';
    }
    if(cur_name == 'f_skirt'){
      document.getElementById('total_len_text').style.display = 'inline';
      document.getElementById('waist_len_text').style.display = 'inline';

      document.input_bar.total_len.style.display = 'inline';
      document.input_bar.waist_len.style.display = 'inline';
    }
    if(cur_name == 'f_shoes' || cur_name == 'm_shoes'){
      document.getElementById('total_len_text').style.display = 'inline';
      document.getElementById('width_text').style.display = 'inline';
      document.getElementById('heel_text').style.display = 'inline';

      document.input_bar.total_len.style.display = 'inline';
      document.input_bar.width.style.display = 'inline';
      document.input_bar.heel.style.display = 'inline';
    }
    if(cur_name != 'f_shoes' && cur_name != 'm_shoes'){
      document.getElementById('stretch_text').style.display = 'inline';
      document.getElementById('line_text').style.display = 'inline';
      document.getElementById('thickness_text').style.display = 'inline';

      document.input_bar.stretch.style.display = 'inline';
      document.input_bar.line.style.display = 'inline';
      document.input_bar.thickness.style.display = 'inline';
    }

    document.getElementById('price_text').style.display = 'inline';
    document.input_bar.price.style.display = 'inline';
  }
  function reset_searchable(){
    document.getElementById('total_len_text').style.display = 'none';
    document.getElementById('shoulder_len_text').style.display = 'none';
    document.getElementById('chest_len_text').style.display = 'none';
    document.getElementById('arm_len_text').style.display = 'none';
    document.getElementById('waist_len_text').style.display = 'none';
    document.getElementById('hem_len_text').style.display = 'none';
    document.getElementById('width_text').style.display = 'none';
    document.getElementById('heel_text').style.display = 'none';
    document.getElementById('price_text').style.display = 'none';
    document.getElementById('stretch_text').style.display = 'none';
    document.getElementById('line_text').style.display = 'none';
    document.getElementById('thickness_text').style.display = 'none';

    document.input_bar.total_len.style.display = 'none';
    document.input_bar.shoulder_len.style.display = 'none';
    document.input_bar.chest_len.style.display = 'none';
    document.input_bar.arm_len.style.display = 'none';
    document.input_bar.waist_len.style.display = 'none';
    document.input_bar.hem_len.style.display = 'none';
    document.input_bar.width.style.display = 'none';
    document.input_bar.heel.style.display = 'none';
    document.input_bar.price.style.display = 'none';
    document.input_bar.stretch.style.display = 'none';
    document.input_bar.line.style.display = 'none';
    document.input_bar.thickness.style.display = 'none';

    document.input_bar.submitButton.style.display = 'none';
  }
  //search_page.php와 동일
</script>
</head>
<body>
  <a href = './main_page.php'><input type = 'button' value = 'BACK'></a>

  <center>
  <div>
  <form name = 'input_bar' action = 'input_product.php' method='post'>
    <br>
    <input type='radio' name='gender' value='female' onClick = 'f_selected()'>여자
    <input type='radio' name='gender' value='male' onClick = 'm_selected()'>남자</br>
    <br>
    <select name = 'f_select' id = 'f_select' style='display:none' onChange='item_selected(id)'>
      <option value = 'f_dress' name = 'f_dress'> 원피스
      <option value = 'f_outer' name = 'f_outer'> 아우터
      <option value = 'f_shirt' name = 'f_shirt'> 셔츠
      <option value = 'f_tshirt' name = 'f_tshirt'> 티셔츠
      <option value = 'f_pants' name = 'f_pants'> 바지
      <option value = 'f_skirt' name = 'f_skirt'> 치마
      <option value = 'f_shoes' name = 'f_shoes'> 신발
    </select>
    <select name = 'm_select' id = 'm_select' style='display:none' onChange='item_selected(id)'>
      <option value = 'm_outer' name = 'm_outer'> 아우터
      <option value = 'm_shirt' name = 'm_shirt'> 셔츠
      <option value = 'm_tshirt' name = 'm_tshirt'> 티셔츠
      <option value = 'm_pants' name = 'm_pants'> 바지
      <option value = 'm_shoes' name = 'm_shoes'> 신발
    </select>
    <br>
    <br>
    <p id = 'total_len_text' style='display:none'>총 기장:</p><input type = 'number' step = '1' min = '0' style='display:none' name = 'total_len'><br>
    <p id = 'shoulder_len_text' style='display:none'>어깨 넓이:</p><input type = 'number'  step = '1' min = '0' style='display:none' name = 'shoulder_len'><br>
    <p id = 'chest_len_text' style='display:none'>가슴 둘레:</p><input type = 'number' step = '1' min = '0' style='display:none' name = 'chest_len'><br>
    <p id = 'arm_len_text' style='display:none'>팔 길이:</p><input type = 'number'  step = '1' min = '0' style='display:none' name = 'arm_len'><br>
    <p id = 'waist_len_text' style='display:none'>허리 둘레:</p><input type = 'number' step = '1' min = '15' style='display:none' name = 'waist_len'><br>
    <p id = 'hem_len_text' style='display:none'>밑단:</p><input type = 'number' step = '1' min = '0' style='display:none' name = 'hem_len'><br>
    <p id = 'width_text' style='display:none'>폭:</p><input type = 'number' step = '1' min = '0' style='display:none' name = 'width'><br>
    <p id = 'heel_text' style='display:none'>굽 높이:</p><input type = 'number' step = '0.5' min = '0' style='display:none' name = 'heel'><br>
    <p id = 'stretch_text' style='display:none'>신축성:</p><input type = 'number' step = '1' min = '1' max = '3' style='display:none' name = 'stretch'><br>
    <p id = 'line_text' style='display:none'>라인:</p><input type = 'number' step = '1' min = '1' max = '3' style='display:none' name = 'line'><br>
    <p id = 'thickness_text' style='display:none'>두께:</p><input type = 'number'  step = '1' min = '1' max = '3' style='display:none' name = 'thickness'><br>
    <p id = 'price_text' style='display:none'>가격:</p><input type = 'number'  step = '1000' min = '0' style='display:none' name = 'price'><br>
    <br>
    <br>
    <input type = 'submit' value = '등록' name  = 'submitButton' style='display:none'>
  </form>
  </div>
  </center>
</body>
</html>
