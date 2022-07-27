package com.classroom.check.ui.classlist;

import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
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
import com.classroom.check.R;
import com.classroom.check.Sharedpreference;
import com.classroom.check.adapter.ClassRoomAdapter;
import com.classroom.check.item.ClassRoom;
import com.classroom.check.item.RoomInfo;
import com.classroom.check.web.GetMyinfoRequest;
import com.classroom.check.web.RoomRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

public class ClassListFragment extends Fragment {

    private ClassListViewModel classListViewModel;
    private RecyclerView myRecycler;

    ArrayList<ClassRoom> alClassRoom = new ArrayList<>();

    ClassRoomAdapter classRoomAdapter;

    private RequestQueue queue;

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {
        classListViewModel =
                ViewModelProviders.of(this).get(ClassListViewModel.class);
        View root = inflater.inflate(R.layout.fragment_class_list, container, false);

        myRecycler = (RecyclerView) root.findViewById(R.id.recycler);
        initList();
        final EditText editText = root.findViewById(R.id.et_class_room);
        editText.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                classRoomAdapter.getFilter().filter(charSequence);
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        return root;
    }

    private void initList() {

        myRecycler.addItemDecoration(new DividerItemDecoration(getContext(), DividerItemDecoration.VERTICAL));

        classRoomAdapter = new ClassRoomAdapter(getContext(),alClassRoom);
        myRecycler.setAdapter(classRoomAdapter);
        classRoomAdapter.notifyDataSetChanged();
        Log.e("getItemCount",classRoomAdapter.getItemCount()+"");
        roomRequest();
    }

    public void roomRequest(){

        RoomRequest roomRequest = new RoomRequest( "" , responseListner, errorListener);
        // 실제 서버 응답 할 수 있는 tfRequest 생성
        if (queue == null) {
            queue = Volley.newRequestQueue(getContext());
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
                alClassRoom.clear();
                if(data.length()>0){

                    for(int i = 0;i<data.length();i++){
                        JSONObject roominfo =data.getJSONObject(i).getJSONObject("timetable");
                        String class_room_number = roominfo.getString("class_room_number");
                        String class_room_seat = roominfo.getString("class_room_seat");
                        int class_room_purpose = roominfo.getInt("class_room_purpose");
                        alClassRoom.add(new ClassRoom(class_room_number,class_room_seat,class_room_purpose));
                    }
                }else{
                    Toast.makeText(getContext(), "데이터 환경을 확인해주세요.", Toast.LENGTH_SHORT).show();
                }

                classRoomAdapter.setAlClassroom(alClassRoom);
                classRoomAdapter.notifyDataSetChanged();

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
