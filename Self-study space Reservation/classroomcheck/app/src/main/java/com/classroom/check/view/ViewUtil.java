package com.classroom.check.view;

import android.content.Context;
import android.util.TypedValue;


public class ViewUtil {
	public static float dipToPx(Context context, float dip) {
		return TypedValue.applyDimension(TypedValue.COMPLEX_UNIT_DIP, dip, context.getResources().getDisplayMetrics());
	}
	

}
