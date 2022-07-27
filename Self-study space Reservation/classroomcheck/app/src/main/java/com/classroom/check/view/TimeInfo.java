package com.classroom.check.view;

public class TimeInfo {
	String name;
	private TimeTableView.DAY day;
	private TimeTableView.TIME time;
	private int color;
	private int index;

	public TimeInfo(String name, TimeTableView.DAY day, TimeTableView.TIME time, int color, int index) {
		this.name = name;
		this.day = day;
		this.time = time;
		this.color = color;
		this.index = index;
	}

	public TimeTableView.DAY getDay() {
		return day;
	}

	public void setDay(TimeTableView.DAY day) {
		this.day = day;
	}

	public TimeTableView.TIME getTime() {
		return time;
	}

	public void setTime(TimeTableView.TIME time) {
		this.time = time;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public int getColor() {
		return color;
	}

	public void setColor(int color) {
		this.color = color;
	}

	public int getIndex() {
		return index;
	}

	public void setIndex(int index) {
		this.index = index;
	}
}
