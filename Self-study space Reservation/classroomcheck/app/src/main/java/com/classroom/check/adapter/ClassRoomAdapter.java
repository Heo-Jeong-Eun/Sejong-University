package com.classroom.check.adapter;

import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Filter;
import android.widget.Filterable;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.appcompat.widget.AppCompatCheckBox;
import androidx.recyclerview.widget.RecyclerView;

import com.classroom.check.R;
import com.classroom.check.TimeTableActivity;
import com.classroom.check.item.ClassRoom;


import java.util.ArrayList;


public class ClassRoomAdapter extends RecyclerView.Adapter<ClassRoomAdapter.MyViewHolder> implements View.OnClickListener, Filterable {

    public ArrayList<ClassRoom> alClassroom;
    public ArrayList<ClassRoom> filteredList;
    Context context;

    public ClassRoomAdapter(Context context, ArrayList<ClassRoom> pushList) {
        this.context = context;
        this.alClassroom = pushList;
        this.filteredList = alClassroom;    }

    public void setAlClassroom(ArrayList<ClassRoom> alClassroom) {
        this.alClassroom = alClassroom;
        this.filteredList = alClassroom;
    }

    @Override
    public ClassRoomAdapter.MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_classroom,null);
        MyViewHolder viewHolder = new MyViewHolder(v);
        return viewHolder;
    }

    @Override
    public void onBindViewHolder(final ClassRoomAdapter.MyViewHolder holder, final int position) {

            holder.tv_classroom.setText(filteredList.get(position).getClassroom());
        holder.tv_seat.setText(filteredList.get(position).getClass_room_seat()+"좌석");
            if(filteredList.get(position).getClass_room_purpose()==1) {
                holder.iv_purpose.setBackgroundColor(Color.RED);
            }else{
                holder.iv_purpose.setBackgroundColor(Color.GREEN);
            }
            holder.myLayout.setTag(position);
            holder.myLayout.setOnClickListener(this);
    /*    holder.tv_msg.setText(pushDataList.get(position).getPush_content());
        holder.tv_date.setText(pushDataList.get(position).getReg_dttm());*/

        /*holder.tv.setTag(position);
        holder.nameTextView.setOnClickListener(this);*/

    }
    @Override
    public void onClick(View view) {
        //아이템 클릭시 세부정보 확인
        int position  = (int) view.getTag();
        Intent intent = new Intent(context, TimeTableActivity.class);
        intent.putExtra("name",filteredList.get(position).getClassroom());
        context.startActivity(intent);
    }


    @Override
    public int getItemCount() {
        return filteredList.size();
    }

    public static class MyViewHolder extends RecyclerView.ViewHolder{

        public TextView tv_classroom;
        public TextView tv_seat;
        public ImageView iv_purpose;
        public RelativeLayout myLayout;

        Context context;

        public MyViewHolder(View itemView) {
            super(itemView);
            myLayout = (RelativeLayout) itemView;



            tv_classroom = itemView.findViewById(R.id.tv_classroom);

            tv_seat = itemView.findViewById(R.id.tv_seat);

            iv_purpose = itemView.findViewById(R.id.iv_purpose);
         /*   tv_msg = (TextView) itemView.findViewById(R.id.tv_msg);
            tv_date = (TextView) itemView.findViewById(R.id.tv_date);*/


            context = itemView.getContext();

        }


    }

    @Override
    public Filter getFilter() {
        return new Filter() {
            @Override
            protected FilterResults performFiltering(CharSequence constraint) {
                String charString = constraint.toString();
                if(charString.isEmpty()) {
                    filteredList = alClassroom;
                } else {
                    ArrayList<ClassRoom> filteringList = new ArrayList<>();
                    for(ClassRoom name : alClassroom) {
                        if(name.getClassroom().toLowerCase().contains(charString.toLowerCase())) {
                            filteringList.add(name);
                        }
                    }
                    filteredList = filteringList;
                }
                FilterResults filterResults = new FilterResults();
                filterResults.values = filteredList;
                return filterResults;
            }

            @Override
            protected void publishResults(CharSequence constraint, FilterResults results) {
                filteredList = (ArrayList<ClassRoom>)results.values;
                notifyDataSetChanged();
            }
        };
    }
}