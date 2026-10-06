# AI Usage & Helpful Prompts

## Working Timeline

- **12.00–21.00:** audit desain Lovable, migrasi ke Laravel + Blade, implementasi catalog, Buyer Portal, Admin Portal, database, dan UI refinement.
- **07.00:** finishing visual, review requirement challenge, rebuild assets, dan menjalankan ulang automated tests.

## AI Tools Used

- **Lovable:** digunakan pada eksplorasi UI awal dan sebagai referensi visual Company Profile AJS.
- **Codex:** digunakan untuk audit project, migrasi Laravel, implementasi fitur, debugging, UI refinement, dokumentasi, dan testing.
- **Image generation:** digunakan untuk membuat visual operasional B2B cold-chain, sourcing network, warehouse, dan supply partnership yang konsisten dengan positioning AJS.

## Prompts That Helped Most

### 1. Audit dan migrasi aplikasi

> Audit project Lovable yang sudah ada sebelum mengubah apa pun. Identifikasi route, komponen reusable, assets, typography, warna, layout, navigasi, responsive behavior, dan content. Kemudian rebuild menjadi Laravel + Blade + Tailwind + MySQL tanpa mengubah arah visual Company Profile AJS menjadi template corporate generik.

Hasilnya: desain dan assets lama tetap menjadi referensi, sementara application logic dipindahkan ke struktur Laravel yang lebih mudah dijelaskan.

### 2. Flow procurement B2B

> Buat alur B2B procurement, bukan retail marketplace. Buyer dapat melihat commodity, memasukkan quantity sesuai MOQ dan stock, menambahkan ke cart, lalu mengirim Request Order. Request awal harus berstatus requested; stock hanya berkurang ketika admin mengonfirmasi request.

Hasilnya: alur buyer → request → admin review → confirm/reject sesuai dengan business rule challenge.

### 3. Validasi stok dan transaksi admin

> Pastikan quantity buyer tidak boleh di bawah MOQ atau melebihi available stock. Ketika admin confirm, lakukan validasi ulang dan kurangi stock dalam database transaction agar request tidak dianggap transaksi final sebelum direview.

Hasilnya: validasi berjalan di cart, submit request, dan confirmation admin; stock tidak berkurang saat request pertama dibuat.

### 4. UI B2B yang konsisten

> Pertahankan visual AJS tetapi ubah konteksnya menjadi B2B fish commodity trading and supply. Gunakan istilah Request Order atau Request Supply, tampilkan specification, MOQ, availability, cold-chain, sourcing, dan operational handling. Hindari tampilan restoran, marketplace retail, atau checkout payment.

Hasilnya: public profile, Buyer Portal, dan Admin Portal menggunakan bahasa visual yang sama tetapi tetap sesuai fungsi masing-masing.

### 5. Verifikasi demo challenge

> Tambahkan automated test untuk demo 300 KG Cakalang: buyer login, add to cart, submit Request Order, admin login, confirm request, lalu pastikan stock berubah dari 850 KG menjadi 550 KG.

Hasilnya: demo flow utama tercakup oleh automated test Laravel.
