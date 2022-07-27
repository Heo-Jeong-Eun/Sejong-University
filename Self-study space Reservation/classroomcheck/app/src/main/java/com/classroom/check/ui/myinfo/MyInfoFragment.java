package com.classroom.check.ui.myinfo;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.Observer;
import androidx.lifecycle.ViewModelProviders;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.Volley;
import com.classroom.check.LoginActivity;
import com.classroom.check.MainActivity;
import com.classroom.check.R;
import com.classroom.check.Sharedpreference;
import com.classroom.check.adapter.ClassRoomAdapter;
import com.classroom.check.adapter.RoomInfoAdapter;
import com.classroom.check.item.ClassRoom;
import com.classroom.check.item.RoomInfo;
import com.classroom.check.web.GetMyinfoRequest;
import com.classroom.check.web.LoginRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

public class MyInfoFragment extends Fragment {

    private MyInfoViewModel myInfoViewModel;

    private RecyclerView myRecycler;

    ArrayList<RoomInfo> alRoomInfo = new ArrayList<>();

    RoomInfoAdapter roomInfoAdapter;

    private RequestQueue queue;

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {
        myInfoViewModel =
                ViewModelProviders.of(this).get(MyInfoViewModel.class);
        View root = inflater.inflate(R.layout.fragment_myinfo, container, false);
        myRecycler = root.findViewById(R.id.recycler);
        myinfoRequest();

        return root;
    }

    private void initList() {

        myRecycler.addItemDecoration(new DividerItemDecoration(getContext(), DividerItemDecoration.VERTICAL));

        roomInfoAdapter = new RoomInfoAdapter(getContext(),alRoomInfo);
        myRecycler.setAdapter(roomInfoAdapter);
        roomInfoAdapter.notifyDataSetChanged();
        Log.e("getItemCount",roomInfoAdapter.getItemCount()+" "+alRoomInfo.size());
    }


    public void myinfoRequest(){
        String strId = Sharedpreference.getSharedPrefID(getContext());
        String strDate = new SimpleDateFormat("yyyy-MM-dd").format(new Date());
        GetMyinfoRequest myinfoRequest = new GetMyinfoRequest( "?id="+strId+"&r_date1="+strDate , responseListner, errorListener);
        // 실제 서버 응답 할 수 있는 tfRequest 생성
        if (queue == null) {
            queue = Volley.newRequestQueue(getContext());
        }


        queue.add(myinfoRequest);

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
                alRoomInfo.clear();
                if(data.length()>0){

                    for(int i = 0;i<data.length();i++){
                        JSONObject roominfo =data.getJSONObject(i).getJSONObject("roominfo");
                        String class_room_number = roominfo.getString("class_room_number");
                        String r_date = roominfo.getString("r_date");
                        int class_time = roominfo.getInt("class_time");
                        alRoomInfo.add(new RoomInfo(class_room_number,r_date,class_time));
                    }
                }else{
                    Toast.makeText(getContext(), "데이터 환경을 확인해주세요.", Toast.LENGTH_SHORT).show();
                }
                initList();
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
            Toast.makeText(getActivity(), "데이터 환경을 확인해주세요.", Toast.LENGTH_SHORT).show();
        }
    };
}
