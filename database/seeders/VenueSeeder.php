<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $venues = [
            [
                'city_id'       => '1',
                'name'          => 'Elite Padel Club',
                'email'         => 'elite.padel@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'The premier destination for padel enthusiasts. Nikmati premium padel experience di Elite Padel Club Arandra dengan total 6 courts — 2 Black Turfs (Super Panoramic) dan 4 Teal Turfs (Panoramic). Lengkap dengan warm-up area, bathrooms, dan F&B.',
                'rules'         => '<p> • Pengguna wajib hadir sesuai jadwal pemesanan.<br> • Gunakan perlengkapan olahraga yang sesuai dan bersih.<br> • Segala risiko aktivitas olahraga menjadi tanggung jawab pribadi pengguna. </p>',
                'address'       => 'Jl. Cempaka Putih Raya No.1, Arandra Residence, Jakarta Pusat, DKI Jakarta 10510',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '6',
                'name'          => 'Courtline',
                'email'         => 'courtline@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => '2 IPF-Certified Panoramic Courts complemented by spacious and luxurious communual areas, designed for comfort and aesthetics',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jalan Nanjung Nomor 2, Kecamatan Cimahi, Kota Cimahi, Jawa Barat 40533',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '21',
                'name'          => 'NV Padel Jakarta',
                'email'         => 'nv.padel@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'COMING SOON',
                'rules'         => 'COMING SOON',
                'address'       => 'Jl. Aster II No.19B, Pohruboh, Condongcatur, Kec. Depok, Kab. Sleman, Daerah Istimewa Yogyakarta 55281',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '1',
                'name'          => 'Royal Padel',
                'email'         => 'royal.padel@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Royal Padel Club menjadi destinasi olahraga padel dengan konsep unik : rooftop view, yang menghadirkan pengalaman bermain eksklusif dengan pemandangan kota dari ketinggian. Royal Padel Club menghadirkan suasana berbeda -- memadukan olahraga, gaya hidup, komunitas dalam satu tempat yang modern dan stylish.',
                'rules'         => '</p><p>• Hadir tepat waktu sesuai jadwal booking.<br>• Gunakan pakaian dan alas kaki olahraga yang sesuai.<br>• Jaga barang pribadi masing-masing.<br>• Gunakan fasilitas dengan baik dan bertanggung jawab.<br>• Risiko cedera selama aktivitas olahraga menjadi tanggung jawab pengguna.</p>',
                'address'       => 'Jl. Ir. H. Juanda Raya No. 1 RT.8/RW.1, Ps. Baru, Sawah Besar JAKARTA PUSAT 10710',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '1',
                'name'          => 'Hall Bulutangkis Pasar Jatirawasari By SR',
                'email'         => 'hall.bulutangkis@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Kenari Futsal Badminton terdiri dari 1 lapangan Futsal dan 3 Lapangan Badminton',
                'rules'         => '</p><p>• Hadir tepat waktu sesuai jadwal booking.<br>• Gunakan pakaian dan alas kaki olahraga yang sesuai.<br>• Jaga barang pribadi masing-masing.<br>• Gunakan fasilitas dengan baik dan bertanggung jawab.<br>• Risiko cedera selama aktivitas olahraga menjadi tanggung jawab pengguna.</p>',
                'address'       => 'Jl. Salemba Raya Rw. 5 Kenari Kec. Senen Jakarta Pusat Jakarta Pusat',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '32',
                'name'          => 'Corta Society',
                'email'         => 'corta.society@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'private panoramic Court di Kota Tangerang Selatan',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Hartono Raya No.3, RT.003/RW.006, Klp. Indah, Kec. Tangerang, Kota Tangerang, Banten 15118',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '1',
                'name'          => 'GBK Sports Complex',
                'email'         => 'gbk.sports@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'GBK Sports Complex merupakan kawasan olahraga terpadu yang menyediakan berbagai fasilitas olahraga berstandar nasional dan internasional. Berlokasi di area yang strategis dan mudah diakses di pusat Jakarta, kawasan ini menjadi pilihan utama untuk aktivitas olahraga, latihan, maupun penyelenggaraan berbagai kegiatan berskala besar.',
                'rules'         => '</p><p>• Dengan memasuki area venue, setiap orang dianggap telah memahami jadwal dan ketentuan penggunaan fasilitas.<br>• Seluruh waktu penggunaan mengikuti sistem pemesanan yang berlaku.<br>• Untuk kenyamanan bersama, penggunaan pakaian dan perlengkapan olahraga yang sesuai sangat dianjurkan.<br>• Aktivitas olahraga memiliki risiko, sehingga kondisi kesehatan pribadi menjadi tanggung jawab masing-masing.<br>• Barang bawaan tidak berada dalam pengawasan pengelola venue.<br>• Fasilitas yang tersedia wajib digunakan secara bijak dan bertanggung jawab.<br>• Tindakan yang mengganggu ketertiban, keamanan, atau kenyamanan bersama tidak diperkenankan.</p>',
                'address'       => 'Jl. Pintu Satu Senayan, Gelora, Kecamatan Tanah Abang, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10270',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '2',
                'name'          => 'Courtyard Padel Club',
                'email'         => 'courtyard.padel@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'At Courtyard Padel Club, we redefine the art of padel, offering a distinguished and refined experience for connoisseurs of the sport. Located in the heart of West Jakarta, our premier club is a sanctuary where sophistication meets athleticism, creating an exclusive environment for players who seek the highest standards of both competition and leisure.',
                'rules'         => '</p><p>• Setiap pengguna wajib mematuhi jadwal pemesanan yang telah disepakati.<br>• Waktu penggunaan tidak dapat diperpanjang akibat keterlambatan pengguna.<br>• Penggunaan venue hanya diperkenankan untuk aktivitas olahraga yang sesuai.<br>• Pengguna wajib mengenakan perlengkapan dan pakaian olahraga yang aman dan layak.<br>• Pengguna bertanggung jawab penuh atas kondisi kesehatan dan keselamatan diri selama berada di area venue.<br>• Pengelola venue tidak bertanggung jawab atas cedera, kecelakaan, atau kejadian di luar kendali selama aktivitas berlangsung.<br>• Barang pribadi merupakan tanggung jawab masing-masing pengguna.<br>• Dilarang merusak, mengubah, atau menggunakan fasilitas secara tidak semestinya.<br>• Segala bentuk kerusakan fasilitas akibat kelalaian pengguna akan dikenakan biaya penggantian.<br>• Dilarang merokok, membawa barang terlarang, atau melakukan tindakan yang mengganggu keamanan dan kenyamanan bersama.<br>• Setiap pengguna wajib menjaga kebersihan area venue sebelum, selama, dan setelah penggunaan.<br>• Pelanggaran terhadap peraturan dapat dikenakan sanksi sesuai ketentuan yang berlaku.</p>',
                'address'       => 'Courtyard Padel Club Jl. Prisma Raya No.1, RT.1/RW.7, Kb. Jeruk, Kec. Kb. Jeruk, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11530, Indonesia',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '2',
                'name'          => 'Orange Garden Padel Club',
                'email'         => 'orange.garden@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Memiliki 4 Padel Court di Jakarta Barat',
                'rules'         => '</p><p>• Setiap pengguna wajib mematuhi jadwal pemesanan yang telah disepakati.<br>• Waktu penggunaan tidak dapat diperpanjang akibat keterlambatan pengguna.<br>• Penggunaan venue hanya diperkenankan untuk aktivitas olahraga yang sesuai.<br>• Pengguna wajib mengenakan perlengkapan dan pakaian olahraga yang aman dan layak.<br>• Pengguna bertanggung jawab penuh atas kondisi kesehatan dan keselamatan diri selama berada di area venue.<br>• Pengelola venue tidak bertanggung jawab atas cedera, kecelakaan, atau kejadian di luar kendali selama aktivitas berlangsung.<br>• Barang pribadi merupakan tanggung jawab masing-masing pengguna.<br>• Dilarang merusak, mengubah, atau menggunakan fasilitas secara tidak semestinya.<br>• Segala bentuk kerusakan fasilitas akibat kelalaian pengguna akan dikenakan biaya penggantian.<br>• Dilarang merokok, membawa barang terlarang, atau melakukan tindakan yang mengganggu keamanan dan kenyamanan bersama.<br>• Setiap pengguna wajib menjaga kebersihan area venue sebelum, selama, dan setelah penggunaan.<br>• Pelanggaran terhadap peraturan dapat dikenakan sanksi sesuai ketentuan yang berlaku.</p>',
                'address'       => 'Intercon, TKJ, Blok M 1. DKI Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '2',
                'name'          => 'Homeground Padel Premiere Kedoya',
                'email'         => 'homeground.padel@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Homeground Padel Premiere',
                'rules'         => '</p><p>• Setiap pengguna wajib mematuhi jadwal pemesanan yang telah disepakati.<br>• Waktu penggunaan tidak dapat diperpanjang akibat keterlambatan pengguna.<br>• Penggunaan venue hanya diperkenankan untuk aktivitas olahraga yang sesuai.<br>• Pengguna wajib mengenakan perlengkapan dan pakaian olahraga yang aman dan layak.<br>• Pengguna bertanggung jawab penuh atas kondisi kesehatan dan keselamatan diri selama berada di area venue.<br>• Pengelola venue tidak bertanggung jawab atas cedera, kecelakaan, atau kejadian di luar kendali selama aktivitas berlangsung.<br>• Barang pribadi merupakan tanggung jawab masing-masing pengguna.<br>• Dilarang merusak, mengubah, atau menggunakan fasilitas secara tidak semestinya.<br>• Segala bentuk kerusakan fasilitas akibat kelalaian pengguna akan dikenakan biaya penggantian.<br>• Dilarang merokok, membawa barang terlarang, atau melakukan tindakan yang mengganggu keamanan dan kenyamanan bersama.<br>• Setiap pengguna wajib menjaga kebersihan area venue sebelum, selama, dan setelah penggunaan.<br>• Pelanggaran terhadap peraturan dapat dikenakan sanksi sesuai ketentuan yang berlaku.</p>',
                'address'       => 'JI. Pilar Raya No.7A, Kedoya Sel., Kec. Kb. Jeruk, Jakarta, Daerah Khusus Ibukota Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '2',
                'name'          => 'Atlas Padel',
                'email'         => 'atlas.padel@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Di Atlas Padel kami mengunakan teknologi pengecoran menggunakan titik laser dan meteran air sehingga 98% permukaan pada lapangan rata, untuk rumput sintetik kami berstandard International sehingga menghasilkan pantulan bola lebih stabil serta mengurangi efek licin saat bermain.',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Raya Puri Indah blok Q ( sebelah mall puri indah 2 )',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '2',
                'name'          => 'Lucky Tennis Indoor',
                'email'         => 'lucky.tennis@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Lapangan Tennis Indoor | Harga Tertera Jam 6-16 sudah inclued dengan ballboy | Harga Tertera di jam 17-23 sudah inclued dengan Ballboy dan lampu.',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jalan strategi 3/57.kav hankam Rt 017/02.Joglo Kembangan jakarta barat 11640',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '2',
                'name'          => 'Vlocity Arena',
                'email'         => 'vlocity.arena@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Vlocity Arena Premium Padel and Badminton court',
                'rules'         => '</p><p>• Hadir tepat waktu sesuai jadwal booking.<br>• Gunakan pakaian dan alas kaki olahraga yang sesuai.<br>• Jaga barang pribadi masing-masing.<br>• Gunakan fasilitas dengan baik dan bertanggung jawab.<br>• Risiko cedera selama aktivitas olahraga menjadi tanggung jawab pengguna.</p>',
                'address'       => 'KM.1, Jl. Daan Mogot No.111 , RT.10/RW.2, Wijaya Kusuma, Kec. Grogol petamburan, Jakarta, Daerah Khusus Ibukota Jakarta 11460',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '2',
                'name'          => 'Jawara Badminton Kapuk',
                'email'         => 'jawara.badminton@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => '7 Lapangan Badminton Berstandar BWF',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Kali Kapuk Timur No.6, Kedaung Kali Angke, Kecamatan Cengkareng, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11720',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '2',
                'name'          => 'Homeground Puri Kembangan',
                'email'         => 'homeground.puri@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Mini Soccer with best location at West Jakarta',
                'rules'         => '</p><p>• Hadir tepat waktu sesuai jadwal booking.<br>• Gunakan pakaian dan alas kaki olahraga yang sesuai.<br>• Jaga barang pribadi masing-masing.<br>• Gunakan fasilitas dengan baik dan bertanggung jawab.<br>• Risiko cedera selama aktivitas olahraga menjadi tanggung jawab pengguna.</p>',
                'address'       => 'Jl. Kembangan Utara, Kembangan Utara, Kec. Kembangan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11610',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '2',
                'name'          => 'Centro Mini Soccer Utan Jati',
                'email'         => 'centro.mini@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => '1 Lapangan Mini Soccer standar FIFA',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Utan Jati No.6, RT.6/RW.12, Kalideres, Kec. Kalideres, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11840',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '2',
                'name'          => 'Jorta Arena',
                'email'         => 'jorta.arena@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Located inside Pasar Segar Cengkareng (Citra Kalideres Jakarta Barat) our sport facilities offers unique and accessible place to enjoy your favorite sports.',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'VP44+82H, Jl utan jati, pegadungan,kec. Kalideres',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '31',
                'name'          => 'Land’s End Beach Tennis',
                'email'         => 'lands.end@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Step onto our Beach Tennis Court at Land’s End PIK 2! Our court is where good vibes meet great rallies. Whether you’re smashing serves or just having a blast with friends, the sunny, sandy setup guarantees endless fun and a splash of sporty excitement!',
                'rules'         => '</p><p>• Dengan memasuki area venue, setiap orang dianggap telah memahami jadwal dan ketentuan penggunaan fasilitas.<br>• Seluruh waktu penggunaan mengikuti sistem pemesanan yang berlaku.<br>• Untuk kenyamanan bersama, penggunaan pakaian dan perlengkapan olahraga yang sesuai sangat dianjurkan.<br>• Aktivitas olahraga memiliki risiko, sehingga kondisi kesehatan pribadi menjadi tanggung jawab masing-masing.<br>• Barang bawaan tidak berada dalam pengawasan pengelola venue.<br>• Fasilitas yang tersedia wajib digunakan secara bijak dan bertanggung jawab.<br>• Tindakan yang mengganggu ketertiban, keamanan, atau kenyamanan bersama tidak diperkenankan.</p>',
                'address'       => 'Land’s End PIK 2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '3',
                'name'          => 'Gading Slam Tennis Court',
                'email'         => 'gading.slam@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Lapangan Tennis Indoor di Kelapa Gading. 1 court indoor di lengkapi dengan penyewaan raket, bola, mesin pelontar bola. Untuk harga yang tercantum sudah termasuk ball boy dan untuk sesi malam dari jam 17-24 harga yang tercantum sudah include dengan penerangan (lampu) dan ball boy. Tunggu apalagi yuk booking sekarang 📝🎾',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Rawa Sengon Raya No. 50 kelapa Gading Barat',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '3',
                'name'          => 'El Patio Padel - Pluit',
                'email'         => 'el.patio@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'El Patio Padel | IG: elpatiopadel.id Follow us to stay in the loop! ♾️',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jalan Taman Pluit Permai Timur No.2 RT.5/RW.5, Pluit, Jakarta Utara 14450',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '3',
                'name'          => 'Bestindo Sport Center',
                'email'         => 'bestindo.sport@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Sport Center Jakarta Utara | 2 Lapangan Mini Soccer | 1 Lapangan Futsal Outdoor | 5 Lapangan Badminton | 2 Lapangan Padel | 2 Lapangan Basket 3x3',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl.Pegangsaan Dua No.60, Jakarta Utara',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '3',
                'name'          => 'BBS PIK Sport Facilities',
                'email'         => 'bbs.pik@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'BBS PIK Sport Facilities memiliki beberapa lapangan premium dan fasilitas terbaik yang bisa anda gunakan untuk berolahraga bersama keluarga, kerabat dan teman anda.',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Walet Elok 8 Blok R8 No. 1, Pantai Indah Kapuk',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '4',
                'name'          => 'Dreamcourt Grafika Sport Arena Padel',
                'email'         => 'dreamcourt.grafika@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Grafika Sport Arena By Dream Court | Padel Court, memiliki 1 court padel merupakan sport arena yang menawarkan pengalaman bermain yang baik bagi para pemain dari semua level.',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Grafika No.58, Lebak Bulus, Kecamatan Cilandak, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12440',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '4',
                'name'          => 'Roar Performance Center',
                'email'         => 'roar.performance@gmai.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'untuk sewa dengan kegiatan komersial (pertandingan resmi dan shoot promosi iklan) bisa menghubungi management vanue ROAR terlebih dahulu | w.a 0815-1008-6890',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Bangka VIII No. 1c, RT. 05/RW.12, Pela Mampang, Kec. Mampang Prapatan., Kota Jakarta Selatan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '4',
                'name'          => 'Antam Sports Center',
                'email'         => 'antam.sports@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => '2 Lapangan Multi Fungsi',
                'rules'         => '</p><p>• Setiap penggunaan venue tunduk pada ketentuan dan jadwal yang telah ditetapkan.<br>• Waktu yang terlewat akibat keterlambatan tidak dapat dikompensasikan.<br>• Standar keselamatan mengharuskan penggunaan perlengkapan olahraga yang sesuai.<br>• Risiko cedera atau kecelakaan selama aktivitas berada di luar tanggung jawab pengelola.<br>• Segala bentuk kerusakan fasilitas akan dikenakan biaya penggantian.<br>• Area venue wajib dijaga kebersihan dan ketertibannya setiap saat.<br>• Pelanggaran terhadap peraturan dapat berakibat pada penghentian penggunaan fasilitas.</p>',
                'address'       => 'Antam Office Park, RT 10, RW.4 Tanjung Barat, Jagakarsa.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '4',
                'name'          => 'MST Golf Arena Agora Golf Simulator',
                'email'         => 'mst.golf@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'penyedia retail kebutuhan golf dan indoor golf simulator untuk 1 Bay golf simulator bisa di isi oleh 4 pemain',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. M.H. Thamrin No.10 L1 #5, Kb. Melati, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '4',
                'name'          => 'Soccer Serenia Mansion',
                'email'         => 'soccer.serenia@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Soccer Serenia Mansion Mini Soccer Fields',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Karang Tengah Raya No.9, RT.1/RW.3, Kelurahaan, Lb. Bulus, Kec. Cilandak, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12440',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '5',
                'name'          => 'Get Padel Jakarta',
                'email'         => 'get.padel@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'We’re officially open and excited to welcome you, Get Players! | Located on the border of East Jakarta and Bekasi, our venue offers two premium padel courts for casual games, training sessions, and everything in between. Easy to access and community-friendly, the space is modern, welcoming, and full of positive energy, with great air circulation to keep you comfortable while you’re playing or waiting.',
                'rules'         => '</p><p>• Demi kenyamanan bersama, harap datang sesuai jadwal yang telah dipesan.<br>• Waktu bermain tetap berjalan meskipun datang terlambat.<br>• Pastikan menggunakan perlengkapan olahraga yang aman dan nyaman.<br>• Jaga barang bawaan pribadi selama berada di area venue.<br>• Gunakan seluruh fasilitas dengan bijak agar dapat dinikmati bersama.<br>• Aktivitas olahraga dilakukan atas kesadaran dan tanggung jawab pribadi.</p',
                'address'       => 'Jl. Janur Raya Blok CJ, Pondok Kelapa, Jakarta Timur 13450',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '5',
                'name'          => 'Fortuna Sports Arena',
                'email'         => 'fortuna.sports@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Lapangan basket outdoor dengan fasilitas toilet, locker room, kantin, yang terpadu dengan lapangan futsal dan kolam renang',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Robusta Raya, No 1. Pondok Kopi, Jakarta Timur',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '5',
                'name'          => 'Futsal Rooftop PTC',
                'email'         => 'futsal.rooftop@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'terletak dilantai Roof Pulogadung Trade Centre terdapat area parkir yang luas',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Pulogadung Trade Centre lantai Roof Jl. Raya Bekasi KM 21 Jakarta Timur 13920',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '1',
                'name'          => 'Amalfi Court By VY',
                'email'         => 'amalfi.court@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => '2 private padel court in cempaka putih with amalfi coast vibes',
                'rules'         => '</p><p>• Setiap penggunaan venue tunduk pada ketentuan dan jadwal yang telah ditetapkan.<br>• Waktu yang terlewat akibat keterlambatan tidak dapat dikompensasikan.<br>• Standar keselamatan mengharuskan penggunaan perlengkapan olahraga yang sesuai.<br>• Risiko cedera atau kecelakaan selama aktivitas berada di luar tanggung jawab pengelola.<br>• Segala bentuk kerusakan fasilitas akan dikenakan biaya penggantian.<br>• Area venue wajib dijaga kebersihan dan ketertibannya setiap saat.<br>• Pelanggaran terhadap peraturan dapat berakibat pada penghentian penggunaan fasilitas.</p>',
                'address'       => 'Jl Cempaka Putih Timur Raya No 21. RT. 12 RW. 7 Cempaka Putih Timur. Kota Jakarta Pusat. Jakarta 10510',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '6',
                'name'          => 'Youth Club',
                'email'         => 'youth.club@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => '2 Courts | Racket Rental Facility Restroom with Shower | Cafe and Seating Area | Designated Smoking Area',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jalan Terusan Buah Batu No.333',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '9',
                'name'          => 'Sriwedari Cibubur Tennis Court',
                'email'         => 'sriwedari.cibubur@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Where every rally brings energy, every serve brings joy, and every match ends with smiles. Part of @cibuburtennisclub',
                'rules'         => '</p><p>• Demi kenyamanan bersama, harap datang sesuai jadwal yang telah dipesan.<br>• Waktu bermain tetap berjalan meskipun datang terlambat.<br>• Pastikan menggunakan perlengkapan olahraga yang aman dan nyaman.<br>• Jaga barang bawaan pribadi selama berada di area venue.<br>• Gunakan seluruh fasilitas dengan bijak agar dapat dinikmati bersama.<br>• Aktivitas olahraga dilakukan atas kesadaran dan tanggung jawab pribadi.</p>',
                'address'       => 'Taman Sriwedari Cibubur Jl Puri Sriwedari Perumahan, Harjamukti, Kec Cimanggis, Kota Depok, Jawa Barat 16454',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '9',
                'name'          => 'Persada Sports Facilities',
                'email'         => 'persada.sports@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Persada Sports Facilities',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Raya Halim Perdanakusuma, Halim Perdanakusuma, Kec. Makasar, Kota Depok, Jawa Barat 13610',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '1',
                'name'          => 'I On Padel Cempaka Putih',
                'email'         => 'i.on@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'I On Padel Cempaka Putih Indoor court hall',
                'rules'         => '</p><p>• Hadir tepat waktu sesuai jadwal booking.<br>• Gunakan pakaian dan alas kaki olahraga yang sesuai.<br>• Jaga barang pribadi masing-masing.<br>• Gunakan fasilitas dengan baik dan bertanggung jawab.<br>• Risiko cedera selama aktivitas olahraga menjadi tanggung jawab pengguna.</p>',
                'address'       => 'Transmart Cempaka Putih Lantai 3 Jl Jenderal Ahmad Yani No. 83 Jakarta Pusat',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '22',
                'name'          => 'Padel Playy Brawijaya',
                'email'         => 'padel.play@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Time to Playy | Berlokasi di Kodam Brawijaya dengan lapangan berstandar terbaik',
                'rules'         => '</p><p>• Setiap sesi penggunaan mengikuti jadwal pemesanan yang telah ditentukan.<br>• Kehadiran tepat waktu sangat dianjurkan demi kelancaran aktivitas.<br>• Perlengkapan dan pakaian olahraga yang sesuai wajib digunakan.<br>• Barang pribadi sepenuhnya menjadi tanggung jawab masing-masing.</p>',
                'address'       => 'JL.HAYAM WURUK No.52 KetNo.40 RT.0/0 WONOKROMO SAWUNGGALING, WONOKROMO, KOTA SURABAYA, JAWA TIMUR',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '31',
                'name'          => 'Powerhouse Padel',
                'email'         => 'powerhouse.padel@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => '4 Indoor padel courts | High ceiling 14 meter | Up to 35 cars parking area | Full air conditioning toilet',
                'rules'         => '</p><p>• Seluruh aktivitas di dalam venue berjalan sesuai jadwal yang telah dipesan.<br>• Keterlambatan tidak mengubah durasi penggunaan fasilitas.<br>• Demi keamanan dan kenyamanan, perlengkapan olahraga yang layak harus digunakan.<br>• Kondisi fisik yang prima sangat disarankan sebelum beraktivitas.<br>• Segala bentuk kerusakan fasilitas akibat kelalaian akan menjadi tanggung jawab pengguna.<br>• Kebersihan dan ketertiban area wajib dijaga bersama.</p>',
                'address'       => 'Jl. Kejaksaan Raya, No.60, RT.003, RW.03, Kelurahan Kreo, Kecamatan Larangan, Kota Tangerang, Provinsi Banten, Kode Pos 15156.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '31',
                'name'          => 'Namapa Arena',
                'email'         => 'napama.arena@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'NaMaPa Arena menyediakan lapangan Bulutangkis, Cafe & Resto dan Wedding Venue',
                'rules'         => '</p><p>• Setiap sesi penggunaan mengikuti jadwal pemesanan yang telah ditentukan.<br>• Kehadiran tepat waktu sangat dianjurkan demi kelancaran aktivitas.<br>• Perlengkapan dan pakaian olahraga yang sesuai wajib digunakan.<br>• Barang pribadi sepenuhnya menjadi tanggung jawab masing-masing.</p>',
                'address'       => 'Jl. Kelurahan A, Jurang Mangu Timur., Kec. Pd. Aren, Kota Tangerang Selatan, Banten 15222',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '31',
                'name'          => 'Galaxy Sports Center Pik 2',
                'email'         => 'galaxy.sports@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Menyediakan lapangan badminton , basket , futsal , tennis dan minisoccer',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl Imam Bonjol Kav BR-03B',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '31',
                'name'          => 'Bulls Gym Resort Club',
                'email'         => 'bulls.gym@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Bulls Gym Indonesia hadir dengan atmosfer yang dinamis, menyediakan beragam fasilitas fitness untuk berbagai kalangan—pemula hingga atlet—dengan pendekatan “unsurpassed leisure experience” bagi seluruh anggota.',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jalan Boulevard CitraGarden Serpong Blok F No 1, Cisauk, Tangerang',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '31',
                'name'          => 'Sola Sport Hall',
                'email'         => 'sola.sport@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Tersedia lapangan multifungsi basket dan futsal. Lapangan hard court. | Lapangan basket garis hitam | Lapangan futsal garis kuning',
                'rules'         => '</p><p>• Seluruh aktivitas di dalam venue berjalan sesuai jadwal yang telah dipesan.<br>• Keterlambatan tidak mengubah durasi penggunaan fasilitas.<br>• Demi keamanan dan kenyamanan, perlengkapan olahraga yang layak harus digunakan.<br>• Kondisi fisik yang prima sangat disarankan sebelum beraktivitas.<br>• Segala bentuk kerusakan fasilitas akibat kelalaian akan menjadi tanggung jawab pengguna.<br>• Kebersihan dan ketertiban area wajib dijaga bersama.</p>',
                'address'       => 'Nusa Loka, Jalan Batam Blok J11, 4 Selatan BSD No.Kav 02 Sektor 14, Rw. Mekar Jaya, Kec. Serpong, Kota Tangerang Selatan, Banten 15310',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '3',
                'name'          => 'BBS KJ Secondary Sports Field',
                'email'         => 'bbs.kj@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => '1 Tennis Field (hanya lapangan) | 1 Basketball Field (hanya lapangan) | 1 Futsal Field (hanya lapangan)',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Arjuna Sel No. Kav 87 4 RT4/12',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '31',
                'name'          => 'Sport Center Tangerang',
                'email'         => 'sport.center@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Sport Center Tangerang provides various type of sport courts',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Raya Legok - Karawaci No.52, Bojong Nangka, Kecamatan Kelapa Dua, Kabupaten Tangerang, Banten 15810',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '32',
                'name'          => 'Rekket Space Padel BSD',
                'email'         => 'rekket.space@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Rekket Space Padel BSD',
                'rules'         => '</p><p>• Setiap sesi penggunaan mengikuti jadwal pemesanan yang telah ditentukan.<br>• Kehadiran tepat waktu sangat dianjurkan demi kelancaran aktivitas.<br>• Perlengkapan dan pakaian olahraga yang sesuai wajib digunakan.<br>• Barang pribadi sepenuhnya menjadi tanggung jawab masing-masing.</p>',
                'address'       => 'Jalan Buaran viktor, BSD, Tangerang Selatan. Sebelah SPBU Pertamina dan KFC',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '32',
                'name'          => 'Lapangan Tennis Pusdik Lantas',
                'email'         => 'lapangan.tennis@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => '1 Lapangan Tennis Outdoor di dalam Pusdik Lantas',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Bhayangkara Raya No. 1 Paku Jaya Serpong Utara Tangerang Selatan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '32',
                'name'          => 'Salve Badminton Hall',
                'email'         => 'salve.badminton@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Tersedia 5 lapangan bulutangkis dengan kualitas karpet baik',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jalan Buaran Timur no 71, Jelupang, Serpong Utara, Tangerang Selatan, 15323',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '32',
                'name'          => 'Sweat And Social',
                'email'         => 'sweet.and@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'The only place where sweat makes you more social! 4 premium panoramic courts',
                'rules'         => '</p><p>• Dengan memasuki area venue, setiap orang dianggap telah memahami jadwal dan ketentuan penggunaan fasilitas.<br>• Seluruh waktu penggunaan mengikuti sistem pemesanan yang berlaku.<br>• Untuk kenyamanan bersama, penggunaan pakaian dan perlengkapan olahraga yang sesuai sangat dianjurkan.<br>• Aktivitas olahraga memiliki risiko, sehingga kondisi kesehatan pribadi menjadi tanggung jawab masing-masing.<br>• Barang bawaan tidak berada dalam pengawasan pengelola venue.<br>• Fasilitas yang tersedia wajib digunakan secara bijak dan bertanggung jawab.<br>• Tindakan yang mengganggu ketertiban, keamanan, atau kenyamanan bersama tidak diperkenankan.</p>',
                'address'       => 'Arcici Sport Center, Jl. Cempaka Putih Barat 26, RT 3/RW 7, Cemp. Putih Bar., Kec. Cemp Putih',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '1',
                'name'          => 'Menteng Tennis Club @ Common Grounds Terra',
                'email'         => 'menteng.tennis@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Menteng Tennis Club - at Common Grounds Terra | 1 Private Outdoor Hard Court Private Locker Room & Shower included',
                'rules'         => '</p><p>• Hadir tepat waktu sesuai jadwal booking.<br>• Gunakan pakaian dan alas kaki olahraga yang sesuai.<br>• Jaga barang pribadi masing-masing.<br>• Gunakan fasilitas dengan baik dan bertanggung jawab.<br>• Risiko cedera selama aktivitas olahraga menjadi tanggung jawab pengguna.</p>',
                'address'       => 'Surabaya St No.8, RT.1/RW.5, Menteng, Central Jakarta City, Jakarta 10310',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'city_id'       => '32',
                'name'          => 'Modern Golf & Country Club',
                'email'         => 'modern.golf@gmail.com',
                'password'      => Hash::make('password123'),
                'phone'         => '081908196194',
                'description'   => 'Modern Golf & Country Club',
                'rules'         => '</p><p>• Pengguna wajib mengikuti jadwal pemesanan yang telah ditentukan.<br>• Keterlambatan tidak mengubah waktu penggunaan venue.<br>• Gunakan perlengkapan dan pakaian olahraga yang sesuai.<br>• Pastikan kondisi tubuh dalam keadaan sehat sebelum beraktivitas.<br>• Dilarang merusak fasilitas atau menggunakan fasilitas di luar peruntukannya.<br>• Harap menjaga kebersihan dan ketertiban area venue.<br>• Barang pribadi menjadi tanggung jawab masing-masing pengguna.</p>',
                'address'       => 'Jl. Modern Golf Raya Kota Modern No.99, RT.001/RW.008, Klp. Indah, Kec. Tangerang, Kota Tangerang, Banten 15117',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        $latitude  = -6.16744800;
        $longitude = 106.83108600;
        $map = 'https://maps.app.goo.gl/xKkhqeLLGzdHwoEy9';

        $venues = collect($venues)->map(function ($venue) use ($latitude, $longitude, $map) {
            return array_merge($venue, [
                'latitude'   => $latitude,
                'longitude'  => $longitude,
                'link_map'   => $map
            ]);
        })->toArray();

        DB::table('venues')->insert($venues);
    }
}
