package com.classroom.check;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.DialogInterface;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.Volley;
import com.classroom.check.item.ClassRoom;
import com.classroom.check.view.TimeInfo;
import com.classroom.check.view.TimeTableView;
import com.classroom.check.web.AddMyinfoRequest;
import com.classroom.check.web.RoomRequest;
import com.classroom.check.web.RoomTimeRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Calendar;

public class TimeTableActivity extends AppCompatActivity {

    private TimeTableView tableView;
    private RequestQueue queue;

    ArrayList<TimeInfo> alTime = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_time_table);

        tableView = (TimeTableView)findViewById(R.id.tableView);
        tableView.setClickListener(new TimeTableView.clickListener() {
            @Override
            public void onClick(final TimeTableView.DAY day, final TimeTableView.TIME time) {
                boolean isExist =false;
                for(int i=0;i<alTime.size();i++){
                    if(alTime.get(i).getDay() == day && alTime.get(i).getTime()== time){
                        isExist = true;
                        break;
                    }
                }
                if(isExist){
                    Toast.makeText(TimeTableActivity.this, "강의가 있는 시간입니다.", Toast.LENGTH_SHORT).show();
                }else {
                    AlertDialog.Builder alert = new AlertDialog.Builder(TimeTableActivity.this);
                    alert.setMessage(day + " " + time + "추가하시겠습니까?");
                    alert.setPositiveButton("확인", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {
                            addClassRoom(day.ordinal(), time.ordinal());
                        }
                    });
                    alert.setNegativeButton("취소", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {

                        }
                    });
                    alert.show();
                }

            }
        });
        roomRequest();
    }
    public static String getCurday(int day){

        java.text.SimpleDateFormat formatter = new java.text.SimpleDateFormat("yyyy-MM-dd");

        Calendar c = Calendar.getInstance();

        c.set(Calendar.DAY_OF_WEEK,day + 2);

        return formatter.format(c.getTime());

    }



    private void addClassRoom(int day,int time) {



        AddMyinfoRequest addMyinfoRequest = new AddMyinfoRequest("?class_room_number=" + getIntent().getStringExtra("name") + "&id=" + Sharedpreference.getSharedPrefID(this) + "&r_date=" + getCurday(day) + "&class_time=" + (time + 1), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.e("response",response);
                Toast.makeText(TimeTableActivity.this,"추가되었습니다.",Toast.LENGTH_LONG).show();;
            }
        }, errorListener);
        // 실제 서버 응답 할 수 있는 tfRequest 생성
        if (queue == null) {
            queue = Volley.newRequestQueue(TimeTableActivity.this);
        }


        queue.add(addMyinfoRequest);
    }

    private void addTime() {

        tableView.clearAllSector();


        tableView.addTimeInfo(alTime);

    }
    public void roomRequest(){

        RoomTimeRequest roomRequest = new RoomTimeRequest( "?class_room_number="+getIntent().getStringExtra("name") , responseListner, errorListener);
        // 실제 서버 응답 할 수 있는 tfRequest 생성
        if (queue == null) {
            queue = Volley.newRequestQueue(TimeTableActivity.this);
        }


        queue.add(roomRequest);

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

                    for(int i = 0;i<data.length();i++){
                        JSONObject roominfo =data.getJSONObject(i).getJSONObject("timetable");
                        int class_day = roominfo.getInt("class_day")-1;
                        int class_time = roominfo.getInt("class_time")-1;

                        alTime.add(new TimeInfo("", TimeTableView.DAY.values()[class_day], TimeTableView.TIME.values()[class_time],Color.RED,0));
                    }
                }else{
                    Toast.makeText(TimeTableActivity.this, "데이터 환경을 확인해주세요.", Toast.LENGTH_SHORT).show();
                }

                addTime();

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
            Toast.makeText(TimeTableActivity.this, "데이터 환경을 확인해주세요.", Toast.LENGTH_SHORT).show();
        }
    };
}
