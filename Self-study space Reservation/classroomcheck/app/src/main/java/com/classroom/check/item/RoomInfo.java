package com.classroom.check.item;

public class RoomInfo {
    String class_room_number;
    String r_date;
    int class_time;

    public RoomInfo(String class_room_number, String r_date, int class_time) {
        this.class_room_number = class_room_number;
        this.r_date = r_date;
        this.class_time = class_time;
    }

    public String getClass_room_number() {
        return class_room_number;
    }

    public void setClass_room_number(String class_room_number) {
        this.class_room_number = class_room_number;
    }

    public String getR_date() {
        return r_date;
    }

    public void setR_date(String r_date) {
        this.r_date = r_date;
    }

    public int getClass_time() {
        return class_time;
    }

    public void setClass_time(int class_time) {
        this.class_time = class_time;
    }
}
