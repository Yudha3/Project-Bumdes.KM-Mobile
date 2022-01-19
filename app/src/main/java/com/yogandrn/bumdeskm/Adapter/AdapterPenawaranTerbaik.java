package com.yogandrn.bumdeskm.Adapter;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.cardview.widget.CardView;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.yogandrn.bumdeskm.Activity.DetailProduk;
import com.yogandrn.bumdeskm.Global;
import com.yogandrn.bumdeskm.Model.ModelProduk;
import com.yogandrn.bumdeskm.R;

import java.text.NumberFormat;
import java.util.List;
import java.util.Locale;

public class AdapterPenawaranTerbaik extends RecyclerView.Adapter<AdapterPenawaranTerbaik.HolderProduk> {
    private Context ctx;
    private List<ModelProduk> listModel;

    public AdapterPenawaranTerbaik(Context ctx, List<ModelProduk> listModel) {
        this.ctx = ctx;
        this.listModel = listModel;
    }

    @NonNull
    @Override
    public HolderProduk onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_terlaris, parent, false);
        HolderProduk holder =  new HolderProduk(view);
        return holder;
    }

    @Override
    public void onBindViewHolder(@NonNull HolderProduk holder, int position) {
        ModelProduk modelProduk = listModel.get(position);

        String harga = formatRupiah(modelProduk.getHg_jual());

        holder.tvBarang.setText(modelProduk.getBarang());
        holder.tvHarga.setText(harga);
        holder.tvTerjual.setText(String.valueOf(modelProduk.getJml_terjual() + " terjual"));

        Glide.with(holder.itemView.getContext()).load(Global.IMG_PRODUK_URL + modelProduk.getGambar())
//                .apply(new RequestOptions().centerCrop())
                .into(holder.imgProduk);

        holder.cardProduk.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent showDetail = new Intent(ctx, DetailProduk.class);
                showDetail.putExtra("id_brg", String.valueOf(modelProduk.getId_brg()));
                ctx.startActivity(showDetail);
            }
        });
    }

    @Override
    public int getItemCount() {
        return listModel.size();
    }

    public class HolderProduk extends RecyclerView.ViewHolder {
        TextView tvTerjual, tvBarang, tvHarga;
        ImageView imgProduk, iconPreorder;
        RelativeLayout cardProduk;

        public HolderProduk(@NonNull View itemView) {
            super(itemView);
            cardProduk = itemView.findViewById(R.id.terlaris_card);
            tvBarang = itemView.findViewById(R.id.txt_namaproduk_terlaris);
            tvHarga = itemView.findViewById(R.id.txt_harga_terlaris);
            imgProduk = itemView.findViewById(R.id.img_terlaris);
            tvTerjual = itemView.findViewById(R.id.txt_terjual_terlaris);
        }
    }

    private String formatRupiah(int number) {
        Locale localeID = new Locale("IND", "ID");
        NumberFormat numberFormat = NumberFormat.getCurrencyInstance(localeID);
        String formatRupiah = numberFormat.format(number);
        String[] split = formatRupiah.split(",");
        int length = split[0].length();
        return split[0].substring(0,2) + " " + split[0].substring(2,length);
    }
}
