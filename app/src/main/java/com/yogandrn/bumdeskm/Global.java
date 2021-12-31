package com.yogandrn.bumdeskm;

import com.yogandrn.bumdeskm.API.APIRequestData;
import com.yogandrn.bumdeskm.API.RetroServer;
import com.yogandrn.bumdeskm.Model.ResponseModel;

import java.text.NumberFormat;
import java.util.Locale;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class Global {
    public static String id_user;
    public static String fullname;
//    public static String IMG_PRODUK_URL = "http://undeveloppedcity.000webhostapp.com/android/img/produk/";
    public static String IMG_PRODUK_URL = "http://ws-tif.com/bumdes.km/images/barang/";
//    public static String IMG_USER_URL = "http://undeveloppedcity.000webhostapp.com/android/img/user/";public static String IMG_PRODUK_URL = "http://undeveloppedcity.000webhostapp.com/android/img/produk/";
    public static String IMG_USER_URL = "http://ws-tif.com/bumdes.km/images/user/";
    public static int total;
    public static int totalPreorder;
    SessionManager sessionManager;
    public static  String id;

    public int getTotal(String id){
        APIRequestData apiRequestData = RetroServer.koneksiRetrofit().create(APIRequestData.class);
        Call<ResponseModel> countTotal = apiRequestData.countTotal(id);
        countTotal.enqueue(new Callback<ResponseModel>() {
            @Override
            public void onResponse(Call<ResponseModel> call, Response<ResponseModel> response) {
                int hasil = response.body().getKode();
                total = hasil;
            }

            @Override
            public void onFailure(Call<ResponseModel> call, Throwable t) {
                int hasil = 0;
                total = hasil;
            }
        });
        return total;
    }
    public int getTotalPreorder(String id){
        APIRequestData apiRequestData = RetroServer.koneksiRetrofit().create(APIRequestData.class);
        Call<ResponseModel> countTotal = apiRequestData.countPreorder(id);
        countTotal.enqueue(new Callback<ResponseModel>() {
            @Override
            public void onResponse(Call<ResponseModel> call, Response<ResponseModel> response) {
                int hasil = response.body().getKode();
                totalPreorder = hasil;
            }

            @Override
            public void onFailure(Call<ResponseModel> call, Throwable t) {
                int hasil = 0;
                totalPreorder = hasil;
            }
        });
        return totalPreorder;
    }

    public static String formatRupiah(int number) {
        Locale localeID = new Locale("IND", "ID");
        NumberFormat numberFormat = NumberFormat.getCurrencyInstance(localeID);
        String formatRupiah = numberFormat.format(number);
        String[] split = formatRupiah.split(",");
        int length = split[0].length();
        return split[0].substring(0,2) + " " + split[0].substring(2,length);
    }
}
