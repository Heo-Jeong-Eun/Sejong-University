package com.classroom.check;

import android.content.Context;
import android.content.SharedPreferences;

public class Sharedpreference {

    public final static String PREFNAME_ID = "shared_id";

    public final static String PREFKEY_ID = "ID";


    //멤버이름
    public final static String PREFKEY_NAME = "name";

    //사용자이름
    public static String getSharedPrefNAME(Context context) {
        SharedPreferences pref = context.getSharedPreferences(PREFNAME_ID, Context.MODE_PRIVATE);
        return pref.getString(PREFKEY_NAME, "");
    }

    public static void setSharedPrefNAME(Context context, String value) {
        SharedPreferences pref = context.getSharedPreferences(PREFNAME_ID, Context.MODE_PRIVATE);
        SharedPreferences.Editor prefEditor = pref.edit();
        prefEditor.putString(PREFKEY_NAME, value);
        prefEditor.commit();
    }



    public static String getSharedPrefID(Context context) {
        SharedPreferences pref = context.getSharedPreferences(PREFNAME_ID, Context.MODE_PRIVATE);
        return pref.getString(PREFKEY_ID, "");
    }

    public static void setSharedPrefID(Context context, String value) {
        SharedPreferences pref = context.getSharedPreferences(PREFNAME_ID, Context.MODE_PRIVATE);
        SharedPreferences.Editor prefEditor = pref.edit();
        prefEditor.putString(PREFKEY_ID, value);
        prefEditor.commit();
    }


}
