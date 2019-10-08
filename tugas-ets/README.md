### Tugas ETS Basis Data Terdistribusi
# Implementasi Infrastruktur Multi-Master Basis Data

## Table of Contents
- [Implementasi Infrastruktur Multi-Master Basis Data](#implementasi-infrastruktur-multi-master-basis-data)
  - [Table of Contents](#table-of-contents)
  - [Deskripsi Tugas](#deskripsi-tugas)
  - [Desain dan Implementasi Infrastruktur](#desain-dan-implementasi-infrastruktur)


## Deskripsi Tugas
1. Desain dan implementasi infrastruktur
    - Desain infrastruktur basis data terdistribusi + load balancing
    - Implementasi infrastruktur basis data terdistribusi
2. Penggunaan basis data terdistribusi dalam aplikasi
   - Instalasi aplikasi tambahan (misal: Apache web server, PHP, dsb)
   - Konfigurasi aplikasi tambahan tersebut
   - Deskripsi aplikasi yang dipakai (bisa berupa project yang pernah dibuat sebelumnya, web CMS yang tinggal pakai (Wordpress, Joomla, Moodle, dsb), aplikasi desktop dengan backend database, dll).
   - Konfigurasi aplikasi untuk menggunakan basis data terdistribusi yang telah dibuat.
3. Simulasi fail-over
   - Lakukan fail-over dengan cara mematikan salah satu server basi data.
   - Tunjukkan bahwa aplikasi tetap dapat berjalan dengan baik
   - Jalankan kembali server yang sebelumnya mati
   - Tunjukkan bahwa server yang sebelumnya

## Desain dan Implementasi Infrastruktur
1. Desain Infrastruktur Basis Data Terdistribusi
    - Gambar Infrastruktur
    ![Gambar Desain Infrastruktur](desain/Desain&#32;Infrastruktur&#32;BDT.png)
    - Server\
    Terdapat 4 Server yang digunakan pada Tugas ETS dengan pembagian IP dan Spesifikasinya sebagai berikut :
        - Server Database
            1. MySQL Server 1
               - OS : `ubuntu-16.04`
               - RAM : `1024` MB
               - IP : `10.0.16.34`
            2. MySQL Server 2
               - OS : `ubuntu-16.04`
               - RAM : `1024` MB
               - IP : `10.0.16.35`
            3. MySQL Server 3
               - OS : `ubuntu-16.04`
               - RAM : `1024` MB
               - IP : `10.0.16.36`
        - Load Balancer
            1. Load Balancer
               - OS : `ubuntu-16.04`
               - RAM : `1024` MB
               - IP : `10.0.16.36`
