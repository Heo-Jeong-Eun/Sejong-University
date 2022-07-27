package com.classroom.check.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.appcompat.widget.AppCompatCheckBox;
import androidx.recyclerview.widget.RecyclerView;

import com.classroom.check.R;
import com.classroom.check.item.ClassRoom;
import com.classroom.check.item.RoomInfo;
import com.classroom.check.view.TimeTableView;

import java.util.ArrayList;


public class RoomInfoAdapter extends RecyclerView.Adapter<RoomInfoAdapter.MyViewHolder> implements View.OnClickListener {

    public ArrayList<RoomInfo> alRoomInfo;
    Context context;

    public RoomInfoAdapter(Context context, ArrayList<RoomInfo> alRoomInfo) {
        this.context = context;
        this.alRoomInfo = alRoomInfo;
    }

    @Override
    public RoomInfoAdapter.MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_roominfo,null);
        MyViewHolder viewHolder = new MyViewHolder(v);
        return viewHolder;
    }

    @Override
    public void onBindViewHolder(final RoomInfoAdapter.MyViewHolder holder, final int position) {

            holder.tv_classroom.setText(alRoomInfo.get(position).getClass_room_number());
            holder.tv_date.setText(alRoomInfo.get(position).getR_date());
            holder.tv_time.setText(TimeTableView.TIME.values()[alRoomInfo.get(position).getClass_time()-1].name());


    }
    @Override
    public void onClick(View view) {
        //아이템 클릭시 세부정보 확인
        int position  = (int) view.getTag();
        /*Intent intent = new Intent(context,SubActivity.class);
        intent.putExtra("name",list.get(position).getName());
        intent.putExtra("vendor",list.get(position).getVendor());
        intent.putExtra("etc",list.get(position).toString());
        context.startActivity(intent);*/
    }


    @Override
    public int getItemCount() {
        return alRoomInfo.size();
    }

    public static class MyViewHolder extends RecyclerView.ViewHolder{

        public TextView tv_classroom;
        public TextView tv_date;
        public TextView tv_time;
        public LinearLayout myLayout;

        Context context;

        public MyViewHolder(View itemView) {
            super(itemView);
            myLayout = (LinearLayout) itemView;
            tv_classroom = itemView.findViewById(R.id.tv_classroom);

            tv_date = itemView.findViewById(R.id.tv_date);
            tv_time = itemView.findViewById(R.id.tv_time);

            context = itemView.getContext();

        }


    }


}