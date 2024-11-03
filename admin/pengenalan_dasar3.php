<?php
// Menghubungkan PHP dengan koneksi database
include "koneksi.php";
// Query untuk mengambil data dari tabel pengenalan_dasar1
$sql = "SELECT huruf_jepang, arti_huruf, gambar FROM pengenalan_dasar1";
$result = $koneksi->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengenalan Dasar Admin</title>
    <link rel="stylesheet" href="../css/style-user.css">
    <link rel="icon" href="../images/icons/logo-web.png">
    <style>
        .container3 {
            width: 100%;
            margin: 50px auto;
            padding: 20px;
        }

        .header3 {
            border-radius: 30px;
            background: #7f54f1;
            color: #fff;
            padding: 50px 0;
            text-align: center;
            margin-bottom: 20px;
        }

        h1,
        h3 {
            color: #fff;
        }

        h2 {
            font-size: 30px;
            color: #fff;
            margin-top: 20px;
        }

        p {
            color: #fff;
            margin-bottom: 15px;
        }

        /* Section Styling */
        section {
            background: #8c99ef;
            padding: 50px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .kanji-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .kanji-item {
            text-align: center;
            padding: 10px;
            border: 1px solid #fff300;
            border-radius: 8px;
        }

        .kanji-item h3 {
            font-size: 24px;
            color: #fff300;
            margin-bottom: 8px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {

            h1 {
                text-align: center;
                font-size: 1.3em;
            }

            h2 {
                text-align: center;
                font-size: 1.3em;
            }

            p {
                font-size: 1em;
            }
        }

        .profile-pic {
            cursor: pointer;
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .profile-popup {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .popup-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 10px;
            text-align: center;
        }

        .popup-content img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var notification = document.querySelector('.notification');
            if (notification) {
                notification.classList.add('show');
                setTimeout(function() {
                    notification.classList.remove('show');
                }, 1500); // Notifikasi akan hilang setelah 3 detik
            }
        });
    </script>
</head>

<body>
    <header>
        <div class="profile">
            <?php
            // Mengaktifkan session pada PHP
            session_start();
            // Menghubungkan PHP dengan koneksi database
            include "koneksi.php";
            // Periksa apakah 'id' ada dalam session sebelum mengaksesnya
            if (isset($_SESSION['id'])) {
                // Query untuk mengambil nama dan level pengguna dari tabel user (asumsi nama tabel adalah "user" dan kolom level adalah "level")
                $id = $_SESSION['id']; // Mengambil ID pengguna dari session
                $sql = "SELECT nama, role, foto_profile FROM user WHERE id = '$id'";
                $result = mysqli_query($koneksi, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Ambil data nama, dan gambar profil
                    $row = mysqli_fetch_assoc($result);
                    $nama = $row["nama"];
                    $profile_picture = $row["foto_profile"];
                    $role = $row['role'];

                    // Tampilkan gambar profil jika tersedia
                    if (!empty($profile_picture)) {
                        // Tampilkan gambar dari database dengan menggunakan tag img
                        echo "<img src='../uploads_profile/$profile_picture' alt='Profile Picture' class='profile-pic'>";
                    } else {
                        // Tampilkan gambar default jika gambar profil tidak tersedia
                        echo "<img src='../images/default_profile_picture.jpg' alt='Profile Picture' class='profile-pic'>";
                    }

                    // Output nama dan level
                    echo "<div class='profile-info'>";
                    echo "<span>$nama</span>";
                    echo "<p>($role)</p>";
                    echo "</div>";
                } else {
                    echo "0 results";
                }
            }
            ?>
        </div>
        <div id="profile-popup" class="profile-popup">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <img src="<?php echo (!empty($profile_picture)) ? "../uploads_profile/$profile_picture" : "../images/default_profile_picture.jpg"; ?>" alt="Profile Picture">
                <h2 style="color:black;"><?php echo $nama; ?> (<?php echo $role ?>)</h2>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var profilePic = document.querySelector('.profile-pic');
                var popup = document.getElementById('profile-popup');
                var closeBtn = document.querySelector('.close-btn');

                profilePic.addEventListener('click', function() {
                    popup.style.display = 'block';
                });

                closeBtn.addEventListener('click', function() {
                    popup.style.display = 'none';
                });

                window.addEventListener('click', function(event) {
                    if (event.target == popup) {
                        popup.style.display = 'none';
                    }
                });
            });
        </script>
    </header>
    <main>
        <div class="container3">
            <header class="header3">
                <h1>Tata Cara Penulisan Bahasa Jepang</h1>
                <p style="text-align:center;">Memahami dasar-dasar penulisan huruf Jepang: Hiragana, Katakana, dan Kanji</p>
            </header>

            <!-- Hiragana Section -->
            <section>
                <h2>Huruf Hiragana</h2>
                <p>Hiragana adalah salah satu dari tiga sistem penulisan dalam bahasa Jepang. Hiragana digunakan terutama untuk kata asli Jepang dan untuk menulis kata-kata yang tidak memiliki kanji.</p>
                <strong>
                    <p style="text-align:center;">Contoh penulisan Hiragana :</p>
                </strong>
                <div class="kanji-grid">
                    <div class="kanji-item">
                        <h3>か (ka)</h3>
                        <p style="text-align:center;">Contoh kata: かさ (kasa) - payung</p>
                    </div>
                    <div class="kanji-item">
                        <h3>き (ki)</h3>
                        <p style="text-align:center;">Contoh kata: き (ki) - pohon</p>
                    </div>
                    <div class="kanji-item">
                        <h3>く (ku)</h3>
                        <p style="text-align:center;">Contoh kata: くち (kuchi) - mulut</p>
                    </div>
                    <div class="kanji-item">
                        <h3>け (ke)</h3>
                        <p style="text-align:center;">Contoh kata: けむり (kemuri) - asap</p>
                    </div>
                    <div class="kanji-item">
                        <h3>こ (ko)</h3>
                        <p style="text-align:center;">Contoh kata: こころ (kokoro) - hati</p>
                    </div>
                </div>
            </section>

            <!-- Katakana Section -->
            <section>
                <h2>Huruf Katakana</h2>
                <p>Katakana terutama digunakan untuk menulis kata-kata serapan dari bahasa asing dan nama-nama ilmiah. Sistem ini memiliki bentuk huruf yang lebih tajam dan kaku dibandingkan Hiragana.</p>
                <strong>
                    <p style="text-align:center;">Contoh penulisan Katakana :</p>
                </strong>
                <div class="kanji-grid">
                    <div class="kanji-item">
                        <h3>ト (to)</h3>
                        <p style="text-align:center;">Contoh kata: トマト (tomato) - tomat</p>
                    </div>
                    <div class="kanji-item">
                        <h3>サ (sa)</h3>
                        <p style="text-align:center;">Contoh kata: サラダ (sarada) - salad</p>
                    </div>
                    <div class="kanji-item">
                        <h3>ケ (ke)</h3>
                        <p style="text-align:center;">Contoh kata: ケーキ (kēki) - kue</p>
                    </div>
                    <div class="kanji-item">
                        <h3>ハ (ha)</h3>
                        <p style="text-align:center;">Contoh kata: ハンバーガー (hanbāgā) - hamburger</p>
                    </div>
                    <div class="kanji-item">
                        <h3>ナ (na)</h3>
                        <p style="text-align:center;">Contoh kata: ナイフ (naifu) - pisau</p>
                    </div>
                </div>
            </section>

            <!-- Kanji Section -->
            <section>
                <h2>Huruf Kanji</h2>
                <p>Kanji adalah huruf yang diambil dari karakter Cina dan digunakan untuk menulis sebagian besar kata benda, kata kerja, dan kata sifat dalam bahasa Jepang. Setiap kanji memiliki makna dan cara bacanya sendiri.</p>
                <strong>
                    <p style="text-align:center;">Contoh penulisan Kanji :</p>
                </strong>
                <div class="kanji-grid">
                    <div class="kanji-item">
                        <h3>月</h3>
                        <p style="text-align:center;">Bacaan: つき (tsuki) - bulan</p>
                    </div>
                    <div class="kanji-item">
                        <h3>木</h3>
                        <p style="text-align:center;">Bacaan: き (ki) - pohon</p>
                    </div>
                    <div class="kanji-item">
                        <h3>人</h3>
                        <p style="text-align:center;">Bacaan: ひと (hito) - orang</p>
                    </div>
                    <div class="kanji-item">
                        <h3>田</h3>
                        <p style="text-align:center;">Bacaan: た (ta) - sawah</p>
                    </div>
                    <div class="kanji-item">
                        <h3>車</h3>
                        <p style="text-align:center;">Bacaan: くるま (kuruma) - mobil</p>
                    </div>
                </div>
            </section>
            <!-- Struktur Dasar Kalimat Jepang -->
            <section>
                <h2>Struktur Dasar Kalimat dalam Bahasa Jepang</h2>
                <p>Bahasa Jepang memiliki struktur kalimat yang berbeda dengan bahasa Indonesia atau bahasa Inggris. Umumnya, struktur kalimat dalam bahasa Jepang mengikuti pola <strong>Subjek - Objek - Predikat</strong>.</p>
                <p>Contoh struktur kalimat dasar :</p>
                <div class="example-grid">
                    <div class="example-item">
                        <p><strong>わたし</strong> (watashi) - Saya</p>
                        <p><strong>は</strong> (wa) - partikel penanda subjek</p>
                        <p><strong>りんご</strong> (ringo) - apel</p>
                        <p><strong>を</strong> (o) - partikel penanda objek</p>
                        <p><strong>たべます</strong> (tabemasu) - makan</p>
                        <p>Contoh kalimat: わたしはりんごをたべます。<br><em>Watashi wa ringo o tabemasu.</em> (Saya makan apel.)</p>
                    </div>
                </div>
            </section>

            <!-- Penggunaan Partikel -->
            <section>
                <h2>Penggunaan Partikel</h2>
                <p>Partikel adalah elemen penting dalam bahasa Jepang yang berfungsi sebagai penanda peran kata dalam kalimat. Berikut adalah beberapa partikel dasar yang sering digunakan:</p>
                <ul>
                    <li><strong>は (wa)</strong> - menandakan subjek kalimat</li>
                    <li><strong>を (o)</strong> - menandakan objek kalimat</li>
                    <li><strong>に (ni)</strong> - digunakan untuk menunjukkan waktu atau tujuan</li>
                    <li><strong>で (de)</strong> - menunjukkan tempat atau sarana</li>
                    <li><strong>が (ga)</strong> - menandakan subjek khusus atau sesuatu yang baru dalam pembicaraan</li>
                </ul>
                <p>Contoh penggunaan partikel:</p>
                <div class="example-grid">
                    <div class="example-item">
                        <p><strong>わたしはがっこうでべんきょうします。</strong><br><em>Watashi wa gakkou de benkyou shimasu.</em> (Saya belajar di sekolah.)</p>
                    </div>
                    <div class="example-item">
                        <p><strong>かれがほんをよみます。</strong><br><em>Kare ga hon o yomimasu.</em> (Dia membaca buku.)</p>
                    </div>
                </div>
            </section>

            <!-- Contoh Kalimat Sederhana -->
            <section>
                <h2>Contoh Kalimat Sederhana</h2>
                <p>Berikut ini adalah beberapa contoh kalimat sederhana yang menggunakan pola Subjek - Objek - Predikat serta berbagai partikel :</p>
                <div class="example-grid">
                    <div class="example-item">
                        <p><strong>たなかさんはくるまをうんてんします。</strong><br><em>Tanaka-san wa kuruma o unten shimasu.</em> (Tuan Tanaka mengendarai mobil.)</p>
                    </div>
                    <div class="example-item">
                        <p><strong>わたしのともだちがこうえんにいます。</strong><br><em>Watashi no tomodachi ga kouen ni imasu.</em> (Teman saya ada di taman.)</p>
                    </div>
                    <div class="example-item">
                        <p><strong>ねこはつくえのうえにいます。</strong><br><em>Neko wa tsukue no ue ni imasu.</em> (Kucing berada di atas meja.)</p>
                    </div>
                </div>
            </section>
            <!-- Frasa dan Ekspresi Sehari-hari -->
            <section>
                <h2>Frasa dan Ekspresi Sehari-hari dalam Bahasa Jepang</h2>
                <p>Berikut beberapa frasa sehari-hari yang berguna untuk percakapan dasar dalam bahasa Jepang :</p>
                <ul>
                    <li><strong>おはようございます (ohayou gozaimasu)</strong> - Selamat pagi</li>
                    <li><strong>こんにちは (konnichiwa)</strong> - Selamat siang</li>
                    <li><strong>こんばんは (konbanwa)</strong> - Selamat malam</li>
                    <li><strong>ありがとう (arigatou)</strong> - Terima kasih</li>
                    <li><strong>すみません (sumimasen)</strong> - Maaf atau permisi</li>
                    <li><strong>おねがいします (onegai shimasu)</strong> - Tolong</li>
                </ul>
            </section>
        </div>
        </div>
    </main>
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h3><img src="../images/icons/about.png" alt="About Us Icon" class="footer-icon"> About Us</h3>
                <p>Aplikasi ini adalah website yang dibuat oleh mahasiswa universitas pakuan dalam memenuhi tugas akhir. Tentu aplikasi ini masih dalam tahap pengembangan, silahkan kirim laporan dan saran jika terjadi bug atau ingin membantu memberikan ide dan konsep buat pengembangannya. Terimakasih</p>
            </div>
            <div class="footer-column">
                <h3><img src="../images/icons/link.png" alt="Quick Links Icon" class="footer-icon"> Quick Links</h3>
                <ul>
                    <li><a href="Dashboard_admin.php">Halaman Utama</a></li>
                    <?php
                    // Menambahkan tombol logout jika pengguna telah login
                    if (isset($_SESSION['id'])) {
                        echo '<li><a href="logout.php">Logout</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="footer-column">
                <h3><img src="../images/icons/contact.png" alt="Contact Icon" class="footer-icon"> Contact Admin</h3>
                <p>Email: 085021006@student.unpak.ac.id</p>
                <p>Phone: 085180501629</p>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2024 E-Learning Japanese Language. Games and Learning.
        </div>