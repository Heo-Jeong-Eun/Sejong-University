<!-- 제품 검색 페이지-->
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

  function show_searchable(cur_name){  //입력 가능한 수치들만 표시(ex: 바지는 총 기장, 허리 둘레, 밑단 그리고 가격만 입력 가능하도록 보여줌)
    reset_searchable();
    document.search_bar.submitButton.style.display = 'inline';

    if(cur_name == 'm_outer' || cur_name == 'm_shirt' || cur_name == 'm_tshirt'){
      document.getElementById('total_len_text').style.display = 'inline';
      document.getElementById('shoulder_len_text').style.display = 'inline';
      document.getElementById('chest_len_text').style.display = 'inline';
      document.getElementById('arm_len_text').style.display = 'inline';

      document.search_bar.total_len.style.display = 'inline';
      document.search_bar.shoulder_len.style.display = 'inline';
      document.search_bar.chest_len.style.display = 'inline';
      document.search_bar.arm_len.style.display = 'inline';
    }
    if(cur_name == 'f_dress' || cur_name == 'f_outer' || cur_name == 'f_shirt' || cur_name == 'f_tshirt'){
      document.getElementById('total_len_text').style.display = 'inline';
      document.getElementById('chest_len_text').style.display = 'inline';
      document.getElementById('waist_len_text').style.display = 'inline';
      document.getElementById('arm_len_text').style.display = 'inline';

      document.search_bar.total_len.style.display = 'inline';
      document.search_bar.chest_len.style.display = 'inline';
      document.search_bar.waist_len.style.display = 'inline';
      document.search_bar.arm_len.style.display = 'inline';
    }
    if(cur_name == 'f_pants' || cur_name == 'm_pants'){
      document.getElementById('total_len_text').style.display = 'inline';
      document.getElementById('waist_len_text').style.display = 'inline';
      document.getElementById('hem_len_text').style.display = 'inline';

      document.search_bar.total_len.style.display = 'inline';
      document.search_bar.waist_len.style.display = 'inline';
      document.search_bar.hem_len.style.display = 'inline';
    }
    if(cur_name == 'f_skirt'){
      document.getElementById('total_len_text').style.display = 'inline';
      document.getElementById('waist_len_text').style.display = 'inline';

      document.search_bar.total_len.style.display = 'inline';
      document.search_bar.waist_len.style.display = 'inline';
    }
    if(cur_name == 'f_shoes' || cur_name == 'm_shoes'){
      document.getElementById('total_len_text').style.display = 'inline';
      document.getElementById('width_text').style.display = 'inline';
      document.getElementById('heel_text').style.display = 'inline';

      document.search_bar.total_len.style.display = 'inline';
      document.search_bar.width.style.display = 'inline';
      document.search_bar.heel.style.display = 'inline';
    }
      document.getElementById('price_text').style.display = 'inline';
    document.search_bar.price.style.display = 'inline';
  }
  function reset_searchable(){ //입력 가능한 모든 수치들을 안보이게 해줌
    document.getElementById('total_len_text').style.display = 'none';
    document.getElementById('shoulder_len_text').style.display = 'none';
    document.getElementById('chest_len_text').style.display = 'none';
    document.getElementById('arm_len_text').style.display = 'none';
    document.getElementById('waist_len_text').style.display = 'none';
    document.getElementById('hem_len_text').style.display = 'none';
    document.getElementById('width_text').style.display = 'none';
    document.getElementById('heel_text').style.display = 'none';
    document.getElementById('price_text').style.display = 'none';

    document.search_bar.total_len.style.display = 'none';
    document.search_bar.shoulder_len.style.display = 'none';
    document.search_bar.chest_len.style.display = 'none';
    document.search_bar.arm_len.style.display = 'none';
    document.search_bar.waist_len.style.display = 'none';
    document.search_bar.hem_len.style.display = 'none';
    document.search_bar.width.style.display = 'none';
    document.search_bar.heel.style.display = 'none';
    document.search_bar.price.style.display = 'none';

    document.search_bar.submitButton.style.display = 'none';
  }

</script>
</head>
<body>
  <a href = './main_page.php'><input type = 'button' value = 'BACK'></a>
  <br><br><br><br><br><br><br>

  <div>
  <center>
  <br>
  <form name = 'search_bar' action = 'show_result.php' method='post'>       <!--입력 받은 옷 종류 & 검색 수치들을 입력 폼으로 show_result.php 로 넘겨줌 -->
    <input type='radio' name='gender' value='female' onClick = 'f_selected()'>여자
    <input type='radio' name='gender' value='male' onClick = 'm_selected()'>남자<br>  <!--여자 옷을 검색할지 남자 옷을 검섹할지 정하기-->
    <br>
    <select name = 'f_select' id = 'f_select' style='display:none' onChange='item_selected(id)'> <!--여자 옷 중에서 어떤 부류의 옷을 검색할지 검색(ex: 여자 셔츠)-->
      <option value = 'f_dress' name = 'f_dress'> 원피스<br>
      <option value = 'f_outer' name = 'f_outer'> 아우터<br>
      <option value = 'f_shirt' name = 'f_shirt'> 셔츠<br>
      <option value = 'f_tshirt' name = 'f_tshirt'> 티셔츠<br>
      <option value = 'f_pants' name = 'f_pants'> 바지<br>
      <option value = 'f_skirt' name = 'f_skirt'> 치마<br>
      <option value = 'f_shoes' name = 'f_shoes'> 신발<br>
    </select>
    <select name = 'm_select' id = 'm_select' style='display:none' onChange='item_selected(id)'> <!--남자 옷 중에서 어떤 부류의 옷을 검색할지 검색(ex: 남자 셔츠)-->
      <option value = 'm_outer' name = 'm_outer'> 아우터<br>
      <option value = 'm_shirt' name = 'm_shirt'> 셔츠<br>
      <option value = 'm_tshirt' name = 'm_tshirt'> 티셔츠<br>
      <option value = 'm_pants' name = 'm_pants'> 바지<br>
      <option value = 'm_shoes' name = 'm_shoes'> 신발<br>
    </select>
    <br>
    <br>
    <p id = 'total_len_text' style='display:none'>총 기장:</p><input type = 'number' step = '1' min = '0' style='display:none' name = 'total_len'>
    <p id = 'shoulder_len_text' style='display:none'>어깨 넓이:</p><input type = 'number'  step = '1' min = '0' style='display:none' name = 'shoulder_len'>
    <p id = 'chest_len_text' style='display:none'>가슴 둘레:</p><input type = 'number' step = '1' min = '0' style='display:none' name = 'chest_len'>
    <p id = 'arm_len_text' style='display:none'>팔 길이:</p><input type = 'number'  step = '1' min = '0' style='display:none' name = 'arm_len'>
    <p id = 'waist_len_text' style='display:none'>허리 둘레:</p><input type = 'number' step = '1' min = '15' style='display:none' name = 'waist_len'>
    <p id = 'hem_len_text' style='display:none'>밑단:</p><input type = 'number' step = '1' min = '0' style='display:none' name = 'hem_len'>
    <p id = 'width_text' style='display:none'>폭:</p><input type = 'number' step = '1' min = '0' style='display:none' name = 'width'>
    <p id = 'heel_text' style='display:none'>굽 높이:</p><input type = 'number' step = '0.5' min = '0' style='display:none' name = 'heel'>
    <p id = 'price_text' style='display:none'>가격:</p><input type = 'number'  step = '1000' min = '0' style='display:none' name = 'price'>
    <br>
    <br>
    <input type = 'submit' value = '검색' name  = 'submitButton' style='display:none'>
  </form>
</center>
</div>
</body>
</html>
