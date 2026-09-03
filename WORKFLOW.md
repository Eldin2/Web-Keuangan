# UML Generation Workflow

Project ini menggunakan workflow bertahap.

Seluruh diagram harus dibuat berdasarkan:

```
uml/uml.md
```

Jangan membuat diagram berdasarkan asumsi.

Selalu ikuti urutan workflow berikut.

---

# Tahap 1

Baca:

```
uml/uml.md
```

Pahami:

- actor
- use case
- activity
- class


Jangan membuat diagram.

Hanya lakukan analisis.

---

# Tahap 2

Identifikasi diagram yang diminta.

Contoh:

Activity Diagram Login Pegawai

Cari hanya diagram tersebut.

Abaikan diagram lainnya.

---

# Tahap 3

Lakukan analisis.

Identifikasi:

- actor

- action

- decision

- merge

- relasi

- object

- class

- lifeline

- message

Pastikan seluruh elemen ditemukan.

---

# Tahap 4

Bandingkan dengan uml.md.

Pastikan:

- tidak ada langkah hilang

- tidak ada langkah tambahan

- tidak ada nama berbeda

---

# Tahap 5

Generate draw.io XML.

Gunakan standar UML 2.x.

Gunakan komponen draw.io.

---

# Tahap 6

Lakukan review.

Bandingkan kembali dengan uml.md.

Jika berbeda.

Perbaiki.

---

# Tahap 7

Lakukan QA.

Jika seluruh checklist lolos.

Simpan file.

Jika belum.

Perbaiki.

---

# Urutan Diagram

Diagram dibuat dengan urutan berikut.

## Use Case

```
uml/usecase/use-case.drawio
```

---

## Activity Orang Tua Siswa

```
uml/activity/OrangTuaSiswa/login.drawio

uml/activity/OrangTuaSiswa/menginput-pembayaran.drawio

uml/activity/OrangTuaSiswa/membuat-tagihan.drawio
```

---

## Activity Admin Sekolah

```
uml/activity/AdminSekolah/login.drawio

uml/activity/AdminSekolah/mengelola-data-siswa.drawio

uml/activity/AdminSekolah/mengelola-users.drawio

uml/activity/AdminSekolah/mengelola-tagihan.drawio

uml/activity/AdminSekolah/memvalidasi-pembayaran.drawio

uml/activity/AdminSekolah/menginput-kas-sekolah.drawio

uml/activity/AdminSekolah/mengelola-data-guru.drawio

uml/activity/AdminSekolah/mengelola-gaji-guru.drawio

uml/activity/AdminSekolah/merekapitulasi-pembayaran.drawio

uml/activity/AdminSekolah/mengelola-rekening-sekolah.drawio
```

---

## Activity Kepala Sekolah

```
uml/activity/KepalaSekolah/login.drawio

uml/activity/KepalaSekolah/memvalidasi-laporan.drawio
```

---

## Class Diagram

```
uml/classdiagram/class-diagram.drawio
```

---



# Working Rule

Kerjakan hanya SATU diagram.

Setelah selesai.

Berhenti.

Tunggu perintah berikutnya.

Jangan membuat diagram lain.

Jangan membuat file lain.

Jangan mengubah file yang tidak diminta.