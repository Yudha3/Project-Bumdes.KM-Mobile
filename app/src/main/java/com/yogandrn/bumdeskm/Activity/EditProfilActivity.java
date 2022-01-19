package com.yogandrn.bumdeskm.Activity;

import android.content.Intent;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.bumptech.glide.Glide;
import com.yogandrn.bumdeskm.API.APIRequestData;
import com.yogandrn.bumdeskm.API.RetroServer;
import com.yogandrn.bumdeskm.Global;
import com.yogandrn.bumdeskm.Model.ResponseUser;
import com.yogandrn.bumdeskm.R;
import com.yogandrn.bumdeskm.SessionManager;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class EditProfilActivity extends AppCompatActivity {

    SessionManager sessionManager;
    private int IMG_REQUEST = 23;
    private Bitmap bitmap;
    private Button btnSimpan;
    private ImageView imgEdit;
    private TextView btnChoose;
    private EditText etFullname, etEmail, etNoTelp;
    private RadioGroup radioKelamin;
    private RadioButton rdLaki, rdPerempuan;
    private ProgressBar pbEdit;
    private SwipeRefreshLayout srlEdit;
    private String email, fullname, no_telp;
    private String encodedImage, nullImage;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_edit_profil);
        getWindow().addFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);
        setTitle("Edit Profil");

        sessionManager = new SessionManager(EditProfilActivity.this);
        imgEdit = findViewById(R.id.img_edit_profil);
        btnChoose = findViewById(R.id.btn_choose_edit);
        btnSimpan = findViewById(R.id.btn_simpan_edit);
        etEmail = findViewById(R.id.et_email_edit);
        etFullname = findViewById(R.id.et_fullname_edit);
        etNoTelp = findViewById(R.id.et_notelp_edit);
        radioKelamin = findViewById(R.id.radio_jkelamin_edit);
        rdLaki = findViewById(R.id.rd_laki);
        rdPerempuan = findViewById(R.id.rd_perempuan);
        pbEdit = findViewById(R.id.progress_edit);
        srlEdit = findViewById(R.id.srl_edit_profil);

        getUserData();
        radioKelamin.check(R.id.rd_laki);

        srlEdit.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                srlEdit.setRefreshing(true);
                getUserData();
                srlEdit.setRefreshing(false);
            }
        });

        btnChoose.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(EditProfilActivity.this, UbahFotoProfil.class);
                startActivity(intent);
            }
        });

        btnSimpan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (etFullname.getText().equals("")){etFullname.setError("Tidak boleh kosong");}
                else if (etEmail.getText().equals("")){etEmail.setError("Tidak boleh kosong");}
                else if (etNoTelp.getText().equals("")){etNoTelp.setError("Tidak boleh kosong");}
                else {
                    fullname = etFullname.getText().toString();
                    email = etEmail.getText().toString();
                    no_telp = etNoTelp.getText().toString();
                    simpanData();
                }
            }
        });
    }


    private void simpanData() {
        pbEdit.setVisibility(View.VISIBLE);
       String id = String.valueOf(sessionManager.getSessionID());
        int terpilih = radioKelamin.getCheckedRadioButtonId();
        RadioButton JK = (RadioButton) findViewById(terpilih);
        String jkelamin = String.valueOf(JK.getText().toString());

        APIRequestData apiRequestData = RetroServer.koneksiRetrofit().create(APIRequestData.class);
        Call<ResponseUser> callSimpan = apiRequestData.updateUser(id, fullname, jkelamin,email, no_telp);
        callSimpan.enqueue(new Callback<ResponseUser>() {
            @Override
            public void onResponse(Call<ResponseUser> call, Response<ResponseUser> response) {
                String pesan = response.body().getPesan();
                if (pesan.equals("BERHASIL")) {
                    Toast.makeText(EditProfilActivity.this, "Data berhasil diubah", Toast.LENGTH_SHORT).show();
                    getUserData();
                    pbEdit.setVisibility(View.GONE);
                    startActivity(new Intent(EditProfilActivity.this, ProfilActivity.class));
                    finish();
                } else if (pesan.equals("EMAIL EXIST")) {
                    Toast.makeText(EditProfilActivity.this, "Email sudah digunakan\nCobalah menggunakan email yang lain", Toast.LENGTH_SHORT).show();
                    pbEdit.setVisibility(View.GONE);
                }else if (pesan.equals("GAGAL")) {
                    Toast.makeText(EditProfilActivity.this, "Gagal mengubah data\nCobalah beberapa saat lagi", Toast.LENGTH_SHORT).show();
                    pbEdit.setVisibility(View.GONE);
                } else if (pesan.equals("NOT CONNECTED")) {
                    Toast.makeText(EditProfilActivity.this, "Gagal menghubungi server\nPeriksa koneksi internet Anda", Toast.LENGTH_SHORT).show();
                    pbEdit.setVisibility(View.GONE);
                }
            }

            @Override
            public void onFailure(Call<ResponseUser> call, Throwable t) {
                pbEdit.setVisibility(View.GONE);
                Toast.makeText(EditProfilActivity.this, "Terjadi kesalahan :\n" + t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void getUserData(){
        pbEdit.setVisibility(View.VISIBLE);
        String id = String.valueOf(sessionManager.getSessionID());

        APIRequestData apiRequestData = RetroServer.koneksiRetrofit().create(APIRequestData.class);
        Call<ResponseUser> callData = apiRequestData.getUser(id);
        callData.enqueue(new Callback<ResponseUser>() {
            @Override
            public void onResponse(Call<ResponseUser> call, Response<ResponseUser> response) {
                String fullname = response.body().getFullname();
                String username = response.body().getUsername();
                String email = response.body().getEmail();
                String no_telp = response.body().getNo_telp();
                String foto_profil = response.body().getFoto_profil();

                Glide.with(getApplicationContext()).load(Global.IMG_USER_URL + foto_profil).placeholder(R.drawable.user).circleCrop().into(imgEdit);
                etEmail.setText(email);
                etFullname.setText(fullname);
                etNoTelp.setText(no_telp);
                pbEdit.setVisibility(View.GONE);
            }

            @Override
            public void onFailure(Call<ResponseUser> call, Throwable t) {
                pbEdit.setVisibility(View.GONE);
            }
        });
    }

    @Override
    public boolean onSupportNavigateUp() {
        onBackPressed();
        return true;
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
    }
}