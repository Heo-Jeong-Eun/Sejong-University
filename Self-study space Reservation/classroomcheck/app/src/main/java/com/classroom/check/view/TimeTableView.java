package com.classroom.check.view;

import android.content.Context;
import android.util.AttributeSet;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;


import com.classroom.check.R;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;


//import kr.nexters.oneday.util.ViewUtil;

public class TimeTableView extends LinearLayout {

	private final static int[] TIME_SECTOR_COLOR_RES = {
			R.color.time_cell_1,
			R.color.time_cell_2,
			R.color.time_cell_3,
			R.color.time_cell_4,
			R.color.time_cell_5};

	private List<TimeSectorHolder> ref = new ArrayList<TimeSectorHolder>();;
	private static final int MAX_CELL_CNT = 28; // 8시부터 30분단위로 22시까지

	private LinearLayout innerLayout;

	public enum DAY {												//요일 (월~금)
		MON(0), TUE(1), WED(2), THU(3), FRI(4);
		int number;
		private DAY(int num) {
			this.number = num;
		}

		public int getNumber() {
			return number;
		}
	}

	/*
	 * _900 : 9:00 ~ 9:30
	 * _1830 : 18:30 ~ 19:00
	 * */
	public enum TIME {						//시간 (9:00 ~ 18:00)
		_800("08:00"),_830("08:30"),
		_900("09:00"),_930("09:30"),
		_1000("10:00"),_1030("10:30"),
		_1100("11:00"),_1130("11:30"),
		_1200("12:00"),_1230("12:30"),
		_1300("13:00"),_1330("13:30"),
		_1400("14:00"),_1430("14:30"),
		_1500("15:00"),_1530("15:30"),
		_1600("16:00"),_1630("16:30"),
		_1700("17:00"),_1730("17:30"),
		_1800("18:00"),_1830("18:30"),
		_1900("19:00"),_1930("19:30"),
		_2000("20:00"),_2030("20:30"),
		_2100("21:00"),_2130("21:30");


		String time;
		private TIME(String time) {
			this.time = time;
		}
	}

	public TimeTableView(Context context) {
		super(context);
		initialize(context);
	}

	public TimeTableView(Context context, AttributeSet attrs) {
		super(context, attrs);
		initialize(context);

		// 유저 정보랑 시간표정보는 이런식으로 가져온다.
//		DBAdapter dbAdapter = new PersonDBAdapter(getContext());
//		List<Person> userList = dbAdapter.getPeople();
//		List<TimeInfo> timeInfoList = dbAdapter.getUserTimeInfos("1");
	}

	public void initialize(Context context) {
		LayoutInflater inflater = LayoutInflater.from(getContext());
		inflater.inflate(R.layout.timetable, this);

		innerLayout = (LinearLayout) findViewById(R.id.timetable_inner_layout);
		LinearLayout linear = null;
		for (int i = 0; i < MAX_CELL_CNT * 5; i++) {
			if(i % MAX_CELL_CNT == 0) {
				linear = new LinearLayout(getContext());
				linear.setOrientation(LinearLayout.VERTICAL);
				innerLayout.addView(linear);
				((LayoutParams) linear.getLayoutParams()).weight = 1;
			}

			TimeSectorHolder holder = new TimeSectorHolder(getContext(), R.layout.time_sector);
			holder.setInfo(i);
			ref.add(holder);
			linear.addView(holder.root);
			((LayoutParams) holder.root.getLayoutParams()).weight = 1;

		}

		findViewById(R.id.bg_bar_time).scrollBy(0, -(int) ViewUtil.dipToPx(context,5));
	}

	private void addCountSector(String name, DAY day, TIME time, int color) {
		TimeSectorHolder holder = getHolder(day, time);
		String currentCnt = holder.text.getText().toString();


		setSectorColor(day, time, color,name);



	}

	/**
	 * @param colorNumber : 겹치는 숫자를 넣으면 됨 (1~5이상)
	 */
	private void setSectorColor(DAY day, TIME time, int colorNumber, String text) {
		/*int number = colorNumber;
		*//*if(colorNumber > 5) {
			number = 5;
		}*/

		TimeSectorHolder holder = getHolder(day, time);

		//int color = (colorNumber > 0) ? getContext().getResources().getColor(TIME_SECTOR_COLOR_RES[number - 1]) : Color.TRANSPARENT;
		//String text = (colorNumber > 0) ? String.valueOf(colorNumber) : "";

		holder.text.setBackgroundColor(colorNumber);
		holder.text.setText(String.valueOf(text));
	}

	/*private void setSectorColor(DAY day, TIME time, int colorNumber,String name) {
		int number = colorNumber;
		if(colorNumber > 5) {
			number = 5;
		}

		TimeSectorHolder holder = getHolder(day, time);

		int color = (colorNumber > 0) ? getContext().getResources().getColor(TIME_SECTOR_COLOR_RES[number - 1]) : Color.TRANSPARENT;
		String text = (colorNumber > 0) ? String.valueOf(colorNumber) : "";

		holder.text.setBackgroundColor(color);
		holder.text.setText(String.valueOf(name));
	}*/

	private TimeSectorHolder getHolder(DAY day, TIME time) {
		TimeSectorHolder dummy = new TimeSectorHolder();
		dummy.day = day;
		dummy.time = time;

		int location = ref.indexOf(dummy);
		if(location == -1) {
			throw new IllegalArgumentException();
		}
		TimeSectorHolder holder = ref.get(location);
		return holder;
	}

	public void setSelectedMode(boolean isSelectedMode) {
		Iterator<TimeSectorHolder> it = ref.iterator();
		while(it.hasNext()) {
			TimeSectorHolder holder = it.next();
			holder.setSelectedMode(isSelectedMode);
		}
	}

	public void setModifiedMode() {
		Iterator<TimeSectorHolder> it = ref.iterator();
		while(it.hasNext()) {
			TimeSectorHolder holder = it.next();

			clearSector(holder);

		}
	}



	public void addTimeInfo(ArrayList<TimeInfo> timeInfos) {
		if(timeInfos == null) {
			return;
		}
		for(TimeInfo info : timeInfos) {
			addCountSector(info.name, info.getDay(), info.getTime(),info.getColor());
		}
	}



	public void clearAllSector() {
		for(TimeSectorHolder holder : ref) {
			clearSector(holder);
		}
	}

	private void clearSector(TimeSectorHolder holder) {
		holder.root.setSelected(false);

		setSectorColor(holder.day, holder.time, 0,"");
	}

	private class TimeSectorHolder {
		private View root;
		private TextView text;
		private DAY day;
		private TIME time;



		private TimeSectorHolder() { }

		private TimeSectorHolder(Context context, int resource) {
			root = LayoutInflater.from(context).inflate(R.layout.time_sector, null);
			text = (TextView) root.findViewById(R.id.timesector_text);

			root.setOnClickListener(selectorListener);
		}

		private void setSelectedMode(boolean isSelectedMode) {
			root.setSelected(false);
			if(isSelectedMode) {
				root.setOnClickListener(selectorListener);
			} else {

			}
		}

		private void setInfo(final int position) {
			final int dayIndex = position / MAX_CELL_CNT;
			switch(dayIndex) {

				case 0: day = DAY.MON; break;

				case 1: day = DAY.TUE; break;

				case 2: day = DAY.WED; break;

				case 3: day = DAY.THU; break;

				case 4: day = DAY.FRI; break;

			}

			final int timeIndex = position - (dayIndex * MAX_CELL_CNT);
			switch(timeIndex) {
				case 0: time = TIME._800; break;
				case 1: time = TIME._830; break;

				case 2: time = TIME._900; break;
				case 3: time = TIME._930; break;

				case 4: time = TIME._1000; break;
				case 5: time = TIME._1030; break;

				case 6: time = TIME._1100; break;
				case 7: time = TIME._1130; break;

				case 8: time = TIME._1200; break;
				case 9: time = TIME._1230; break;

				case 10: time = TIME._1300; break;
				case 11: time = TIME._1330; break;

				case 12: time = TIME._1400; break;
				case 13: time = TIME._1430; break;

				case 14: time = TIME._1500; break;
				case 15: time = TIME._1530; break;

				case 16: time = TIME._1600; break;
				case 17: time = TIME._1630; break;

				case 18: time = TIME._1700; break;
				case 19: time = TIME._1730; break;

				case 20: time = TIME._1800; break;
				case 21: time = TIME._1830; break;

				case 22: time = TIME._1900; break;
				case 23: time = TIME._1930; break;

				case 24: time = TIME._2000; break;
				case 25: time = TIME._2030; break;

				case 26: time = TIME._2100; break;
				case 27: time = TIME._2130; break;

			}
		}

		@Override
		public boolean equals(Object o) {
			if(!(o instanceof TimeSectorHolder)) {
				return false;
			}
			TimeSectorHolder other = (TimeSectorHolder) o;
			if(time == other.time && day == other.day) {
				return true;
			}
			return false;
		}

		private OnClickListener selectorListener = new OnClickListener() {

			@Override
			public void onClick(View v) {
				//root.setSelected(!root.isSelected());
				System.out.println("select"+day+" "+time);
				if(clickListener!=null){
					clickListener.onClick(day,time);
				}
			}
		};

	}
	clickListener clickListener;

	public void setClickListener(TimeTableView.clickListener clickListener) {
		this.clickListener = clickListener;
	}

	public interface clickListener{
		public void onClick(DAY day, TIME time);
	}

}
