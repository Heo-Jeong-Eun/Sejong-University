package com.classroom.check;

import androidx.appcompat.app.AppCompatActivity;

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
import com.classroom.check.web.AddMyinfoRequest;
import com.classroom.check.web.AdduserRequest;

public class SignUpActivity extends AppCompatActivity implements View.OnClickListener {

    private RequestQueue queue;

    EditText et_id,et_name,et_pass;

    Button btn_join;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_up);

        et_id= findViewById(R.id.et_id);
        et_name = findViewById(R.id.et_name);
        et_pass = findViewById(R.id.et_pass);

        btn_join = findViewById(R.id.btn_join);
        btn_join.setOnClickListener(this);

    }

    private void addUser(String id,String name,String pass) {



        AdduserRequest adduserRequest = new AdduserRequest("?id=" + id + "&name=" + name + "&password=" + pass, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.e("response", response);
                Toast.makeText(SignUpActivity.this, "추가되었습니다.", Toast.LENGTH_LONG).show();
                ;
                finish();
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(SignUpActivity.this, "추가되지 않았습니다.", Toast.LENGTH_LONG).show();
            }
        });
        // 실제 서버 응답 할 수 있는 tfRequest 생성
        if (queue == null) {
            queue = Volley.newRequestQueue(SignUpActivity.this);
        }


        queue.add(adduserRequest);
    }

    @Override
    public void onClick(View view) {
        if(view == btn_join){
            addUser(et_id.getText().toString(),et_name.getText().toString(),et_pass.getText().toString());
        }
    }
}
