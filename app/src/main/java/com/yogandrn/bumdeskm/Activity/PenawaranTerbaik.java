package com.yogandrn.bumdeskm.Activity;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.os.Bundle;
import android.view.View;
import android.view.WindowManager;
import android.widget.ProgressBar;
import android.widget.Toast;

import com.yogandrn.bumdeskm.API.APIRequestData;
import com.yogandrn.bumdeskm.API.RetroServer;
import com.yogandrn.bumdeskm.Adapter.AdapterPenawaranTerbaik;
import com.yogandrn.bumdeskm.Adapter.AdapterProduk;
import com.yogandrn.bumdeskm.Model.ModelProduk;
import com.yogandrn.bumdeskm.Model.ResponseProduk;
import com.yogandrn.bumdeskm.R;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class PenawaranTerbaik extends AppCompatActivity {

    private RecyclerView rvProduk;
    private RecyclerView.Adapter adapter;
    private RecyclerView.LayoutManager layoutManager;
    private List<ModelProduk> listData = new ArrayList<>();
    private SwipeRefreshLayout srlKatalog;
    private ProgressBar pbKatalog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_penawaran_terbaik);
        getWindow().addFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);
        setTitle("Penawaran Terbaik Kami");
        
        srlKatalog = findViewById(R.id.srl_terlaris);
        pbKatalog = findViewById(R.id.progress_terlaris);
        layoutManager =  new LinearLayoutManager(PenawaranTerbaik.this, LinearLayoutManager.VERTICAL, false);
        rvProduk = findViewById(R.id.recycler_terlaris);

        rvProduk.setLayoutManager(layoutManager);
        retrieveData();

        srlKatalog.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                srlKatalog.setRefreshing(true);
                retrieveData();
                srlKatalog.setRefreshing(false);
            }
        });
    }

    private void retrieveData() {
        pbKatalog.setVisibility(View.VISIBLE);
        APIRequestData apiRequestData = RetroServer.koneksiRetrofit().create(APIRequestData.class);
        Call<ResponseProduk> getData = apiRequestData.penawaranTerbaik();

        getData.enqueue(new Callback<ResponseProduk>() {
            @Override
            public void onResponse(Call<ResponseProduk> call, Response<ResponseProduk> response) {
                int kode = response.body().getKode();
                String pesan = response.body().getPesan();

                listData = response.body().getData();

                adapter = new AdapterPenawaranTerbaik(PenawaranTerbaik.this, listData);
                rvProduk.setAdapter(adapter);
                adapter.notifyDataSetChanged();
                pbKatalog.setVisibility(View.GONE);
            }

            @Override
            public void onFailure(Call<ResponseProduk> call, Throwable t) {
                pbKatalog.setVisibility(View.GONE);
                Toast.makeText(PenawaranTerbaik.this, "Gagal menghubungi server", Toast.LENGTH_SHORT).show();
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