package com.classroom.check;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.Volley;
import com.classroom.check.web.LoginRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class LoginActivity extends AppCompatActivity implements View.OnClickListener {

    EditText et_id;

    EditText et_pass;

    Button btn_login;

    Button btn_join;

    private RequestQueue queue;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        et_id = findViewById(R.id.et_id);
        et_pass = findViewById(R.id.et_pass);

        btn_login = findViewById(R.id.btn_login);
        btn_join = findViewById(R.id.btn_join);

        btn_login.setOnClickListener(this);
        btn_join.setOnClickListener(this);

    }

    @Override
    public void onClick(View view) {
        if(view == btn_login) {
            loginRequest();
        }else if(view == btn_join){
            Intent intent = new Intent(LoginActivity.this,SignUpActivity.class);
            startActivity(intent);
        }
    }

    public void loginRequest(){
        String strId = et_id.getText().toString();
        String strPw = et_pass.getText().toString();
        LoginRequest loginRequest = new LoginRequest( "?id="+strId+"&password="+strPw , responseListner, errorListener);
        // 실제 서버 응답 할 수 있는 tfRequest 생성
        if (queue == null) {
            queue = Volley.newRequestQueue(LoginActivity.this);
        }

        // loginRequest를 queue에 담아 실행
        queue.add(loginRequest);
                /* 정상적으로 tfRequest가 보내지고 그 결과로 나온 Response가 jsonResponse를 통해서 다루어지게 됨
                 따라서 오류난경우만 예외처리함 */
    }

    Response.Listener<String> responseListner = new Response.Listener<String>() {
        @Override
        public void onResponse(String response) {
            // Response 에서 리스너를 만들어서 결과를 받아올 수 있도록 함
            String value = response.replace("ï»¿","");
            Log.e("value",value);
               /* try {
                    value = new String(response.getBytes("ISO-8859-1"), "UTF-8");
                } catch (UnsupportedEncodingException e) {
                    e.printStackTrace();
                }*/



            JSONObject jsonObject = null;

            try {
                jsonObject = new JSONObject(value);
                Log.e("value",value);
                JSONArray data = jsonObject.getJSONArray("data");
                //{"data":[{"user":{"id":"2020001","name":"1234"}}]}
                if(data.length()>0){
                    JSONObject user =data.getJSONObject(0).getJSONObject("user");
                    Intent intent = new Intent(LoginActivity.this,MainActivity.class);
                    intent.putExtra("name",user.getString("name"));
                    startActivity(intent);

                    Sharedpreference.setSharedPrefNAME(LoginActivity.this, user.getString("name"));
                    Sharedpreference.setSharedPrefID(LoginActivity.this,et_id.getText().toString());


                    finish();
                }else{
                    Toast.makeText(LoginActivity.this, "ID/PW 다시 확인하거나 데이터 환경을 확인해주세요.", Toast.LENGTH_SHORT).show();
                }
                //if (D) Log.d("version", version + " " + Sharedpreference.getSettingVersion(MainActivity.this));

            } catch (JSONException e) {
                e.printStackTrace();
            }




            // 예외처리
        }
    };
    Response.ErrorListener errorListener = new Response.ErrorListener() {
        @Override
        public void onErrorResponse(VolleyError error) {
     //      Log.e("erroor",error.getMessage());
            Toast.makeText(LoginActivity.this, "ID/PW 다시 확인하거나 데이터 환경을 확인해주세요.", Toast.LENGTH_SHORT).show();
        }
    };
}
