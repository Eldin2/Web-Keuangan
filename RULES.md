# UML Project Rules

Seluruh aturan berikut wajib dipatuhi.

---

# General Rules

Jangan mengubah business process.

Jangan mengubah aktor.

Jangan mengubah nama class.

Jangan mengubah nama atribut.

Jangan mengubah relasi.

Jangan mengubah sequence.

Jangan membuat asumsi.

Ikuti uml.md.

---

# Source of Truth

Selalu gunakan:

```
uml/uml.md
```

Sebagai sumber utama.

---

# Diagram Rules

Satu file hanya boleh memiliki:

- satu page

dan

- satu diagram.

---

# File Rules

Gunakan struktur folder berikut.

```
uml/

usecase/

activity/
    OrangTuaSiswa/
    AdminSekolah/
    KepalaSekolah/

classdiagram/

```

Jangan menyimpan file di lokasi lain.

---

# Existing File Rules

Jika file sudah ada.

Lakukan langkah berikut.

1.

Buka file.

2.

Bandingkan dengan uml.md.

3.

Jika sudah sama.

Jangan ubah.

4.

Jika berbeda.

Perbaiki hanya bagian yang berbeda.

---

# XML Rules

Pastikan XML draw.io:

- valid
- dapat dibuka
- tidak rusak
- tidak ada tag hilang
- tidak ada id rusak

---

# Layout Rules

Diagram harus:

- landscape
- rapi
- tidak overlap
- alignment konsisten
- spacing konsisten
- ukuran shape konsisten
- ukuran font konsisten
- connector jelas

---

# UML Rules

## Use Case

Gunakan:

- Actor
- Use Case
- Include
- Extend
- Association
- System Boundary

---

## Activity

Gunakan:

- Initial Node
- Action
- Decision
- Merge
- Fork
- Join
- Final Node

---

## Class

Gunakan:

- Class
- Attribute
- Method
- Association
- Multiplicity
- Aggregation
- Composition
- Generalization

---



# Validation Checklist

Sebelum menyimpan file.

Pastikan:

☐ XML valid

☐ draw.io dapat membuka file

☐ hanya satu page

☐ hanya satu diagram

☐ tidak ada connector putus

☐ tidak ada connector menggantung

☐ tidak ada overlap

☐ alignment benar

☐ font konsisten

☐ ukuran shape konsisten

☐ seluruh actor sesuai uml.md

☐ seluruh proses sesuai uml.md

☐ seluruh relasi sesuai uml.md

☐ tidak ada langkah hilang

☐ tidak ada langkah tambahan

☐ tidak ada typo

☐ seluruh connector tersambung

---

# QA Review

Lakukan review akhir.

Jika menemukan:

- proses hilang
- relasi salah
- layout buruk
- simbol UML salah
- XML rusak

Maka lakukan perbaikan sebelum menyimpan.

---

# Completion Rule

Diagram dianggap selesai apabila:

- sesuai uml.md
- lolos seluruh checklist
- XML valid
- dapat dibuka di draw.io
- mudah dipahami
- memenuhi standar UML 2.x