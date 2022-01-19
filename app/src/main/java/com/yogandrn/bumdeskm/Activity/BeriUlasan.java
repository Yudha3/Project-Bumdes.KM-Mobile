package com.yogandrn.bumdeskm.Activity;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.DialogInterface;
import android.content.Intent;
import android.view.View;
import android.net.Uri;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.Toast;

import com.yogandrn.bumdeskm.API.APIRequestData;
import com.yogandrn.bumdeskm.API.RetroServer;
import com.yogandrn.bumdeskm.Model.ResponseModel;
import com.yogandrn.bumdeskm.R;
import com.yogandrn.bumdeskm.SessionManager;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class BeriUlasan extends AppCompatActivity {

    private String id_user, id_transaksi, ulasan;
    private EditText etUlasan;
    private Button btnKirim;
    private ProgressBar pbLoading;
    SessionManager sesi;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_beri_ulasan);
        setTitle("Beri Ulasan");

        sesi = new SessionManager(BeriUlasan.this);
        id_user = sesi.getSessionID();

        Bundle data = getIntent().getExtras();
        id_transaksi = data.getString("id_transaksi");

        etUlasan = findViewById(R.id.et_beri_ulasan);
        btnKirim = findViewById(R.id.btn_kirim_ulasan);
        pbLoading =findViewById(R.id.progress_beri_ulasan);

        btnKirim.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                ulasan = etUlasan.getText().toString();

                if (ulasan.equals("")) {
                    etUlasan.setError("Ulasan tidak boleh kosong");
                } else {
                    AlertDialog.Builder dialogConfirm = new AlertDialog.Builder(view.getContext());
                    dialogConfirm.setCancelable(true);
                    dialogConfirm.setTitle("Konfirmasi Pesanan");
                    dialogConfirm.setMessage("Apakah Anda yakin untuk melakukan konfirmasi pesanan?");
                    dialogConfirm.setPositiveButton("Konfirmasi", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {
                            kirimUlasan();
                            confirmOrder();
                        }
                    });
                    dialogConfirm.setNegativeButton("Batal", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {
                            dialogInterface.dismiss();
                        }
                    });
                    dialogConfirm.show();
                }
            }
        });
    }

    private void kirimUlasan() {
        pbLoading.setVisibility(View.VISIBLE);
        APIRequestData apiRequestData = RetroServer.koneksiRetrofit().create(APIRequestData.class);
        Call<ResponseModel> callUlasan = apiRequestData.kirimUlasan(id_user, id_transaksi, ulasan);
        callUlasan.enqueue(new Callback<ResponseModel>() {
            @Override
            public void onResponse(Call<ResponseModel> call, Response<ResponseModel> response) {
                String pesan = response.body().getPesan();
            }

            @Override
            public void onFailure(Call<ResponseModel> call, Throwable throwable) {
                Toast.makeText(BeriUlasan.this, "Terjadi kesalahan :\n" + throwable.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
        pbLoading.setVisibility(View.INVISIBLE);
    }

    private void confirmOrder() {
        pbLoading.setVisibility(View.VISIBLE);
        APIRequestData apiRequestData = RetroServer.koneksiRetrofit().create(APIRequestData.class);
        Call<ResponseModel> callKonfirmasi = apiRequestData.konfirmasiPesanan(id_transaksi);
        callKonfirmasi.enqueue(new Callback<ResponseModel>() {
            @Override
            public void onResponse(Call<ResponseModel> call, Response<ResponseModel> response) {
                String pesan = response.body().getPesan();
                if (pesan.equals("BERHASIL")) {
                    pbLoading.setVisibility(View.GONE);
                    Toast.makeText(BeriUlasan.this, "Pesanan Selesai", Toast.LENGTH_SHORT).show();
                    Intent konfirmasi = new Intent(BeriUlasan.this, ListPesanan.class);
                    konfirmasi.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                    konfirmasi.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    konfirmasi.setFlags(Intent.FLAG_ACTIVITY_NO_HISTORY);
                    startActivity(konfirmasi);
                    finish();
                } else if (pesan.equals("GAGAL")) {
                    pbLoading.setVisibility(View.GONE);
                    Toast.makeText(BeriUlasan.this, "Gagal melakukan konfirmasi", Toast.LENGTH_SHORT).show();
                } else if (pesan.equals("NOT CONNECTED")) {
                    pbLoading   .setVisibility(View.GONE);
                    Toast.makeText(BeriUlasan.this, "Terjadi kesalahan saat menghubungi server", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<ResponseModel> call, Throwable t) {
                pbLoading.setVisibility(View.GONE);
                Toast.makeText(BeriUlasan.this, "Terjadi kesalahan :\n" + t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }
}