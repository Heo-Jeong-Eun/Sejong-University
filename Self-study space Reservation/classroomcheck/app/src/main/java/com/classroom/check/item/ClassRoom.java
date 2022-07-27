package com.classroom.check.item;

public class ClassRoom
{
    String classroom;
    String class_room_seat;
    int class_room_purpose;



    public ClassRoom(String classroom, String class_room_seat, int class_room_purpose) {
        this.classroom = classroom;
        this.class_room_seat = class_room_seat;
        this.class_room_purpose = class_room_purpose;
    }

    public String getClassroom() {
        return classroom;
    }

    public void setClassroom(String classroom) {
        this.classroom = classroom;
    }

    public String getClass_room_seat() {
        return class_room_seat;
    }

    public void setClass_room_seat(String class_room_seat) {
        this.class_room_seat = class_room_seat;
    }

    public int getClass_room_purpose() {
        return class_room_purpose;
    }

    public void setClass_room_purpose(int class_room_purpose) {
        this.class_room_purpose = class_room_purpose;
    }
}
