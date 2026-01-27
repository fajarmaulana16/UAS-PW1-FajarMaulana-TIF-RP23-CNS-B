# 🎯 Fitur Edit Produk - URL Gambar

## ✨ Fitur Baru yang Ditambahkan

### Toggle Upload/URL Gambar
Sekarang di halaman **Edit Produk** (`admin/edit.php`), Anda bisa memilih antara:
- **Upload File**: Upload gambar dari komputer (drag & drop supported)
- **URL Gambar**: Masukkan link gambar dari internet

### Cara Penggunaan:

1. **Buka halaman edit produk**: `admin/edit.php?id=[product_id]`
2. **Pilih tipe gambar**:
   - Klik **"Upload File"** untuk upload gambar baru
   - Klik **"URL Gambar"** untuk menggunakan link gambar
3. **Upload File**:
   - Drag & drop gambar atau klik area upload
   - Preview gambar akan muncul otomatis
   - Mendukung format: JPG, PNG, GIF, WebP, BMP, SVG (max 2MB)
4. **URL Gambar**:
   - Masukkan URL lengkap gambar (contoh: `https://example.com/image.jpg`)
   - Preview gambar akan muncul otomatis
   - Validasi URL dan format gambar otomatis

### Keunggulan:
- ✅ **Fleksibel**: Bisa upload file atau pakai URL
- ✅ **Preview Real-time**: Lihat gambar sebelum simpan
- ✅ **Drag & Drop**: Upload lebih mudah
- ✅ **Validasi Otomatis**: Cek format dan URL valid
- ✅ **UI Modern**: Interface yang user-friendly

### Testing:
Jalankan `test_edit_url.php` untuk test fitur secara otomatis.

---
**Dikembangkan untuk Toko Sepatu - Admin Panel** 🚀