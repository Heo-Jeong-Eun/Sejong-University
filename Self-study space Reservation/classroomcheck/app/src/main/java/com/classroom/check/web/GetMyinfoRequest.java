package com.classroom.check.web;

import android.util.Log;

import com.android.volley.Response;
import com.android.volley.toolbox.StringRequest;

import java.util.HashMap;
import java.util.Map;

/*해당서버에 직접 로그인 요청을 보낼수 있도록 하는 액티비티*/

public class GetMyinfoRequest extends StringRequest { //StringRequest를 상속받아 사용
    final static private String URL = "getmyinfo.php";

    /*http://localhost:8080/publish/login/loginprocForPhone.jsp?mem_id=chasw12@naver.com&mem_passwd=1111*/

    // 접속할 서버주소를 의미 (자신의 웹서버주소 적용)
    private Map<String, String> parameters;
    // 맵 생성
    public GetMyinfoRequest(String url, Response.Listener<String> listener, Response.ErrorListener errorListener) {
        // LoginRequest는 유저 아이디, 비밀번호, 응답을 받을 수 있는 리스너 생성자구문
        super(Method.GET,WebDefine.BASE_URL+URL+url, listener, errorListener);
        String sUrl = WebDefine.BASE_URL+URL+url;
        Log.e("sUrl",sUrl);

        // 해당 URL에 파라미터들을 POST방식으로 해당 요청을 숨겨서 보냄
        parameters = new HashMap<>();

    }
    @Override
    public Map<String, String> getParams() {
        return parameters;
    }
}
