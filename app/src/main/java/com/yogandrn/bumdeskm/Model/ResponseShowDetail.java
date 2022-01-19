package com.yogandrn.bumdeskm.Model;

public class ResponseShowDetail {
  private int harga, qty, stok, jml_terjual;
  private String pesan, barang, deskripsi, gambar;

  public int getHarga() {
    return harga;
  }

  public void setHarga(int harga) {
    this.harga = harga;
  }

  public int getQty() {
    return qty;
  }

  public void setQty(int qty) {
    this.qty = qty;
  }

  public int getStok() {
    return stok;
  }

  public void setStok(int stok) {
    this.stok = stok;
  }

  public String getPesan() {
    return pesan;
  }

  public void setPesan(String pesan) {
    this.pesan = pesan;
  }

  public String getBarang() {
    return barang;
  }

  public void setBarang(String barang) {
    this.barang = barang;
  }

  public String getDeskripsi() {
    return deskripsi;
  }

  public void setDeskripsi(String deskripsi) {
    this.deskripsi = deskripsi;
  }

  public String getGambar() {
    return gambar;
  }

  public void setGambar(String gambar) {
    this.gambar = gambar;
  }

  public int getJml_terjual() {
    return jml_terjual;
  }

  public void setJml_terjual(int jml_terjual) {
    this.jml_terjual = jml_terjual;
  }
}
