# 🎟️ TiketIdol.com — Sistem Pemesanan Tiket Konser Idol (K-Pop)

Aplikasi website pemesanan tiket konser resmi untuk grup idol ternama seperti **BABYMONSTER**, **aespa**, **NewJeans**, dan **IU**, dibangun menggunakan **Laravel 12** dan **MySQL** dengan alur dan antarmuka terinspirasi oleh pemesanan tiket pesawat/event di **tiket.com**.

---

## 🌟 Fitur Utama

### 1. 🔍 Katalog & Pencarian Konser Idol (tiket.com Style)
- **Hero Banner Unggulan**: Highlight konser BABYMONSTER "HELLO MONSTERS" Jakarta di ICE BSD dengan info tanggal, venue, dan harga tiket mulai dari Rp 1.100.000.
- **Widget Pencarian Dinamis**: Filter berdasarkan Artis Idol (BABYMONSTER, aespa, NewJeans, IU), Kota/Venue, atau kata kunci.
- **Kupon Promo Banner**: Kupon diskon seperti `BABYMONSTERID` (10% s.d. Rp 250.000), `MONSTIEZVIP` (Potongan Rp 100.000), dan `TIKETIDOL50` (Potongan Rp 50.000).

### 2. 🎪 Detail Konser & Denah Panggung Interaktif
- **Informasi Lengkap Konser**: Lineup, tanggal, jam konser & open gate, nama promotor resmi, dan syarat & ketentuan pemesanan tiket (maksimal 4 tiket per NIK).
- **Denah Panggung & Kursi (Interactive SVG Seating Map)**: Visualisasi panggung utama, runway thrust, zona VIP Soundcheck, CAT 1 Festival, CAT 2 Center Tribune, CAT 3 Wing Tribune, dan CAT 4 Upper Tribune.
- **Pilihan Kategori Tiket (Tier Selection)**:
  - Kartu kategori dengan harga, tipe (*Standing* atau *Numbered Seated*), pintu masuk (gate).
  - Daftar benefit eksklusif (*Soundcheck Pass, Exclusive Lanyard, Fast-track line, dll.*).
  - Indikator sisa kuota tiket secara langsung.
  - Selector jumlah tiket (- / +) dengan batas maksimal 4 tiket dan kalkulasi subtotal *real-time*.

### 3. 📝 Formulir Pemesanan & Rincian Pesanan (Checkout tiket.com)
- **Step Progress Bar**: 1. Pilih Tiket ➔ 2. Detail Pemesan ➔ 3. Pembayaran ➔ 4. E-Ticket.
- **Countdown Timer**: Penghitung mundur batas waktu 15:00 menit untuk mengamankan kuota tiket.
- **Data Pemesan (Contact Details)**: Nama Lengkap (sesuai KTP/Paspor), Email penerima tiket, No. WhatsApp/HP, dan NIK KTP.
- **Data Pengunjung / Pemegang Tiket (Passenger Style)**: Pengisian identitas setiap tiket dengan tombol *switch* "Sama dengan data pemesan" pada Tiket 1.
- **Rincian Biaya (Price Breakdown)**:
  - Harga Tiket (x jumlah)
  - Pajak Hiburan & Pemerintah (10%)
  - Biaya Layanan Platform Tiket (Admin Fee)
  - Form voucher promo dengan validasi otomatis (AJAX)
  - **Total Pembayaran Bersih (All-in Nett)**.
- **Pilihan Metode Pembayaran**: QRIS (Rekomendasi), Virtual Account BCA, Mandiri (Livin'), BRI (BRIMO).

### 4. 💳 Simulasi Pembayaran
- Kode Pesanan unik (contoh: `TK-BAB-2026-XXXXX`).
- Tampilan QRIS dengan kode QR dinamis berskala nasional atau Nomor Virtual Account yang dapat disalin dengan 1 klik.
- Tombol **Simulasikan Bayar Sekarang (Berhasil)** yang langsung mengonfirmasi status pembayaran menjadi *PAID* dan memotong kuota tiket secara aman.

### 5. 🎫 E-Ticket Resmi Ber-Barcode & Nomor Antrean / Kursi
- Format tiket elektronik modern (*perforated concert pass*) dengan lekukan potongan karcis.
- Nama pengunjung, NIK, kategori tiket, waktu, dan pintu masuk (*entry gate*).
- **Nomor Antrean (Queue Number)** otomatis untuk kategori Standing (contoh: `QN-0042`) atau **Nomor Kursi (Seat Number)** untuk kategori Seated (contoh: `SEC-TRB-ROW-A-12`).
- Barcode dan QR Code resmi untuk validasi scanner di pintu gerbang.
- Tombol **Cetak / Simpan E-Ticket (PDF)** yang kompatibel dengan print preview browser.

### 6. 🔎 Cek Pesanan / My Booking
- Fasilitas mandiri bagi pengguna untuk mencari riwayat pesanan cukup dengan memasukkan **Kode Pesanan** atau **Email Pemesan**.

### 7. 🛠️ Admin Dashboard & CRUD Manajemen
- **CRUD Konser**: Tambah konser baru, lihat detail, edit informasi, dan hapus konser.
- **CRUD Kategori Tiket**: Tambah tier kategori (VIP, CAT 1, dll.), ubah kuota, harga, warna label, benefit, dan hapus kategori.
- **Manajemen Pesanan & Keuangan**:
  - Statistik KPI: Total Pendapatan, Tiket Terjual, Total Transaksi, dan Pesanan Menunggu Pembayaran.
  - Tabel transaksi lengkap dengan filter status (*paid, unpaid, cancelled*).
  - Halaman detail transaksi untuk memeriksa identitas pemesan & pengunjung, serta opsi ubah status pembayaran manual.

---

## 🗄️ Konfigurasi Database MySQL

Database baru telah dibuat khusus untuk proyek ini agar tidak mengganggu database proyek lain:
- **Database**: `db_tiket_konser_idol`
- **Host**: `127.0.0.1` (Port 3306)
- **Username**: `root`
- **Password**: *(kosong)*

---

## 🚀 Cara Menjalankan Proyek

1. Pastikan Apache dan MySQL (XAMPP) dalam keadaan berjalan.
2. Jalankan server Laravel:
   ```bash
   php artisan serve
   ```
3. Akses aplikasi melalui browser:
   - **Situs Pemesanan (Publik)**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
   - **Cek Pesanan / E-Ticket**: [http://127.0.0.1:8000/cek-pesanan](http://127.0.0.1:8000/cek-pesanan)
   - **Admin Panel (CRUD)**: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)
