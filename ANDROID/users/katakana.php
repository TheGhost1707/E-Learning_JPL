<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huruf katakana</title>
    <link rel="stylesheet" href="../css/style-user.css">
</head>
<body>
<header>
<div class="profile">
    <?php
    // Mengaktifkan session pada PHP
    session_start();
    // Menghubungkan PHP dengan koneksi database
    $koneksi = mysqli_connect("localhost","root","","e_learning_jpl");
    // Periksa apakah 'id' ada dalam session sebelum mengaksesnya
    if (isset($_SESSION['id'])) {
        // Query untuk mengambil nama dan level pengguna dari tabel user (asumsi nama tabel adalah "user" dan kolom level adalah "level")
        $id = $_SESSION['id']; // Mengambil ID pengguna dari session
        $sql = "SELECT nama, progres_level, foto_profile FROM user WHERE id = '$id'";
        $result = mysqli_query($koneksi, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Ambil data nama, level, dan gambar profil
            $row = mysqli_fetch_assoc($result);
            $nama = $row["nama"];
            $progres_level = $row["progres_level"];
            $profile_picture = $row["foto_profile"];
        
            // Tampilkan gambar profil jika tersedia
            if (!empty($profile_picture)) {
                // Tampilkan gambar dari database dengan menggunakan tag img
                echo "<img src='../uploads_profile/$profile_picture' alt='Profile Picture'>";
            } else {
                // Tampilkan gambar default jika gambar profil tidak tersedia
                echo "<img src='../../images/default_profile_picture.jpg' alt='Profile Picture'>";
            }        

            // Output nama dan level
            echo "<div class='profile-info'>";
            echo "<span>$nama</span>";
            echo "<p id='levelText'>$progres_level</p>";

            // Output progress bar
            echo "<div class='progress-bar'>";
            echo "<div class='progress' style='width: $progres_level%;'></div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "0 results";
        }
         // Script PHP untuk menentukan level
         if (mysqli_num_rows($result) > 0) {
            $exp_points = $progres_level;
        
            // Lakukan sesuatu dengan nilai exp_points, seperti menentukan level berdasarkan progres
            $levelText = "";
            $levelColor = ""; // Inisialisasi variabel untuk warna level
            if ($exp_points >= 0 && $exp_points < 25) {
                $levelText = 'Beginner';
                $levelColor = '#00ff00'; // Warna hijau untuk level Beginner
            } else if ($exp_points >= 25 && $exp_points < 50) {
                $levelText = 'Master';
                $levelColor = '#ffff00'; // Warna kuning untuk level Master
            } else if ($exp_points >= 50 && $exp_points < 75) {
                $levelText = 'Grandmaster';
                $levelColor = '#0000ff'; // Warna biru untuk level Grandmaster
            } else {
                $levelText = 'Expert';
                $levelColor = '#ff0000'; // Warna merah untuk level Expert
            }
        
            // Output level yang ditentukan dengan warna khusus
            echo "<script>
                var levelText = document.getElementById('levelText');
                levelText.textContent = '$levelText';
                levelText.style.color = '$levelColor'; // Terapkan warna khusus
            </script>";
        }
    } else {
        // Jika 'id' tidak ada dalam session, tampilkan pesan kesalahan
        echo "Session 'id' not found";
    }
    ?>
</div>
</header>
<main>
<p style="text-align:center; font-weight:bold; font-size:28px;">Huruf Katakana</p>
<hr style="width:250px; margin-bottom:80px; border:2px solid;">
        <div class="box-container2">
            <img src="../images/katakana/a.png" id="katakana-a">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/i.png" id="katakana-i">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/u.png" id="katakana-u">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/e.png" id="katakana-e">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/o.png" id="katakana-o">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ka.png" id="katakana-ka">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ki.png" id="katakana-ki">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ku.png" id="katakana-ku">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ke.png" id="katakana-ke">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ko.png" id="katakana-ko">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/sa.png" id="katakana-sa">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/shi.png" id="katakana-shi">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/su.png" id="katakana-su">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/se.png" id="katakana-se">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/so.png" id="katakana-so">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ta.png" id="katakana-ta">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/chi.png" id="katakana-chi">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/tsu.png" id="katakana-tsu">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/te.png" id="katakana-te">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/to.png" id="katakana-to">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ma.png" id="katakana-ma">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/mi.png" id="katakana-mi">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/mu.png" id="katakana-mu">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/me.png" id="katakana-me">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/mo.png" id="katakana-mo">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ya.png" id="katakana-ya">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/yu.png" id="katakana-yu">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/yo.png" id="katakana-yo">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ra.png" id="katakana-ra">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ri.png" id="katakana-ri">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ru.png" id="katakana-ru">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/re.png" id="katakana-re">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ro.png" id="katakana-ro">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/wa.png" id="katakana-wa">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/o.png" id="katakana-wo">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/n.png" id="katakana-n">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ga.png" id="katakana-ga">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/gi.png" id="katakana-gi">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/gu.png" id="katakana-gu">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ge.png" id="katakana-ge">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/go.png" id="katakana-go">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/za.png" id="katakana-za">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ji.png" id="katakana-zi">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/zu.png" id="katakana-zu">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ze.png" id="katakana-ze">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/zo.png" id="katakana-zo">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/da.png" id="katakana-da">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ji2.png" id="katakana-ji">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/zu2.png" id="katakana-zu2">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/de.png" id="katakana-de">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/do.png" id="katakana-do">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/ba.png" id="katakana-ba">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/bi.png" id="katakana-bi">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/bu.png" id="katakana-bu">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/be.png" id="katakana-be">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/bo.png" id="katakana-bo">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/pa.png" id="katakana-pa">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/pi.png" id="katakana-pi">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/pu.png" id="katakana-pu">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/pe.png" id="katakana-pe">
        </div>
        <div class="box-container2">
            <img src="../images/katakana/po.png" id="katakana-po">
        </div>
</main>
<audio id="audio-a" src="../audio/hiragana_katakana/a.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaA = document.getElementById('katakana-a');
        const audioA = document.getElementById('audio-a');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaA.addEventListener('click', function() {
            audioA.play();
        });
    </script>
<audio id="audio-i" src="../audio/hiragana_katakana/i.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaI = document.getElementById('katakana-i');
        const audioI = document.getElementById('audio-i');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaI.addEventListener('click', function() {
            audioI.play();
        });
    </script>
<audio id="audio-u" src="../audio/hiragana_katakana/u.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaU = document.getElementById('katakana-u');
        const audioU = document.getElementById('audio-u');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaU.addEventListener('click', function() {
            audioU.play();
        });
    </script>
<audio id="audio-e" src="../audio/hiragana_katakana/e.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaE = document.getElementById('katakana-e');
        const audioE = document.getElementById('audio-e');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaE.addEventListener('click', function() {
            audioE.play();
        });
    </script>
<audio id="audio-o" src="../audio/hiragana_katakana/o.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaO = document.getElementById('katakana-o');
        const audioO = document.getElementById('audio-o');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaO.addEventListener('click', function() {
            audioO.play();
        });
    </script>
<audio id="audio-ka" src="../audio/hiragana_katakana/ka.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaKA = document.getElementById('katakana-ka');
        const audioKA = document.getElementById('audio-ka');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaKA.addEventListener('click', function() {
            audioKA.play();
        });
    </script>
<audio id="audio-ki" src="../audio/hiragana_katakana/ki.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaKI = document.getElementById('katakana-ki');
        const audioKI = document.getElementById('audio-ki');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaKI.addEventListener('click', function() {
            audioKI.play();
        });
    </script>
<audio id="audio-ku" src="../audio/hiragana_katakana/ku.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaKU = document.getElementById('katakana-ku');
        const audioKU = document.getElementById('audio-ku');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaKU.addEventListener('click', function() {
            audioKU.play();
        });
    </script>
<audio id="audio-ke" src="../audio/hiragana_katakana/ke.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaKE = document.getElementById('katakana-ke');
        const audioKE = document.getElementById('audio-ke');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaKE.addEventListener('click', function() {
            audioKE.play();
        });
    </script>
<audio id="audio-ko" src="../audio/hiragana_katakana/ko.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaKO = document.getElementById('katakana-ko');
        const audioKO = document.getElementById('audio-ko');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaKO.addEventListener('click', function() {
            audioKO.play();
        });
    </script>
<audio id="audio-sa" src="../audio/hiragana_katakana/sa.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaSA = document.getElementById('katakana-sa');
        const audioSA = document.getElementById('audio-sa');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaSA.addEventListener('click', function() {
            audioSA.play();
        });
    </script>
<audio id="audio-shi" src="../audio/hiragana_katakana/shi.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaSHI = document.getElementById('katakana-shi');
        const audioSHI = document.getElementById('audio-shi');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaSHI.addEventListener('click', function() {
            audioSHI.play();
        });
    </script>
<audio id="audio-su" src="../audio/hiragana_katakana/su.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaSU = document.getElementById('katakana-su');
        const audioSU = document.getElementById('audio-su');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaSU.addEventListener('click', function() {
            audioSU.play();
        });
    </script>
<audio id="audio-se" src="../audio/hiragana_katakana/se.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaSE = document.getElementById('katakana-se');
        const audioSE = document.getElementById('audio-se');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaSE.addEventListener('click', function() {
            audioSE.play();
        });
    </script>
<audio id="audio-so" src="../audio/hiragana_katakana/so.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaSO = document.getElementById('katakana-so');
        const audioSO = document.getElementById('audio-so');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaSO.addEventListener('click', function() {
            audioSO.play();
        });
    </script>
<audio id="audio-ta" src="../audio/hiragana_katakana/ta.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaTA = document.getElementById('katakana-ta');
        const audioTA = document.getElementById('audio-ta');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaTA.addEventListener('click', function() {
            audioTA.play();
        });
    </script>
<audio id="audio-chi" src="../audio/hiragana_katakana/chi.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaCHI = document.getElementById('katakana-chi');
        const audioCHI = document.getElementById('audio-chi');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaCHI.addEventListener('click', function() {
            audioCHI.play();
        });
    </script>
<audio id="audio-tsu" src="../audio/hiragana_katakana/tsu.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaTSU = document.getElementById('katakana-tsu');
        const audioTSU = document.getElementById('audio-tsu');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaTSU.addEventListener('click', function() {
            audioTSU.play();
        });
    </script>
<audio id="audio-te" src="../audio/hiragana_katakana/te.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaTE = document.getElementById('katakana-te');
        const audioTE = document.getElementById('audio-te');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaTE.addEventListener('click', function() {
            audioTE.play();
        });
    </script>
<audio id="audio-to" src="../audio/hiragana_katakana/to.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaTO = document.getElementById('katakana-to');
        const audioTO = document.getElementById('audio-to');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaTO.addEventListener('click', function() {
            audioTO.play();
        });
    </script>
<audio id="audio-ma" src="../audio/hiragana_katakana/ma.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaMA = document.getElementById('katakana-ma');
        const audioMA = document.getElementById('audio-ma');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaMA.addEventListener('click', function() {
            audioMA.play();
        });
    </script>
<audio id="audio-mi" src="../audio/hiragana_katakana/mi.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaMI = document.getElementById('katakana-mi');
        const audioMI = document.getElementById('audio-mi');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaMI.addEventListener('click', function() {
            audioMI.play();
        });
    </script>
<audio id="audio-mu" src="../audio/hiragana_katakana/mu.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaMU = document.getElementById('katakana-mu');
        const audioMU = document.getElementById('audio-mu');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaMU.addEventListener('click', function() {
            audioMU.play();
        });
    </script>
<audio id="audio-me" src="../audio/hiragana_katakana/me.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaME = document.getElementById('katakana-me');
        const audioME = document.getElementById('audio-me');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaME.addEventListener('click', function() {
            audioME.play();
        });
    </script>
<audio id="audio-mo" src="../audio/hiragana_katakana/mo.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaMO = document.getElementById('katakana-mo');
        const audioMO = document.getElementById('audio-mo');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaMO.addEventListener('click', function() {
            audioMO.play();
        });
    </script>
<audio id="audio-ya" src="../audio/hiragana_katakana/ya.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaYA = document.getElementById('katakana-ya');
        const audioYA = document.getElementById('audio-ya');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaYA.addEventListener('click', function() {
            audioYA.play();
        });
    </script>
<audio id="audio-yu" src="../audio/hiragana_katakana/yu.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaYU = document.getElementById('katakana-yu');
        const audioYU = document.getElementById('audio-yu');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaYU.addEventListener('click', function() {
            audioYU.play();
        });
    </script>
<audio id="audio-yo" src="../audio/hiragana_katakana/yo.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaYO = document.getElementById('katakana-yo');
        const audioYO = document.getElementById('audio-yo');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaYO.addEventListener('click', function() {
            audioYO.play();
        });
    </script>
<audio id="audio-ra" src="../audio/hiragana_katakana/ra.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaRA = document.getElementById('katakana-ra');
        const audioRA = document.getElementById('audio-ra');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaRA.addEventListener('click', function() {
            audioRA.play();
        });
    </script>
<audio id="audio-ri" src="../audio/hiragana_katakana/ri.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaRI = document.getElementById('katakana-ri');
        const audioRI = document.getElementById('audio-ri');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaRI.addEventListener('click', function() {
            audioRI.play();
        });
    </script>
<audio id="audio-ru" src="../audio/hiragana_katakana/ru.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaRU = document.getElementById('katakana-ru');
        const audioRU = document.getElementById('audio-ru');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaRU.addEventListener('click', function() {
            audioRU.play();
        });
    </script>
<audio id="audio-re" src="../audio/hiragana_katakana/re.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaRE = document.getElementById('katakana-re');
        const audioRE = document.getElementById('audio-re');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaRE.addEventListener('click', function() {
            audioRE.play();
        });
    </script>
<audio id="audio-ro" src="../audio/hiragana_katakana/ro.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaRO = document.getElementById('katakana-ro');
        const audioRO = document.getElementById('audio-ro');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaRO.addEventListener('click', function() {
            audioRO.play();
        });
    </script>
<audio id="audio-wa" src="../audio/hiragana_katakana/wa.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaWA = document.getElementById('katakana-wa');
        const audioWA = document.getElementById('audio-wa');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaWA.addEventListener('click', function() {
            audioWA.play();
        });
    </script>
<audio id="audio-wo" src="../audio/hiragana_katakana/o.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaWO = document.getElementById('katakana-wo');
        const audioWO = document.getElementById('audio-wo');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaWO.addEventListener('click', function() {
            audioWO.play();
        });
    </script>
<audio id="audio-n" src="../audio/hiragana_katakana/n.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaN = document.getElementById('katakana-n');
        const audioN = document.getElementById('audio-n');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaN.addEventListener('click', function() {
            audioN.play();
        });
    </script>
<audio id="audio-ga" src="../audio/hiragana_katakana/ga.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaGA = document.getElementById('katakana-ga');
        const audioGA = document.getElementById('audio-ga');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaGA.addEventListener('click', function() {
            audioGA.play();
        });
    </script>
<audio id="audio-gi" src="../audio/hiragana_katakana/gi.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaGI = document.getElementById('katakana-gi');
        const audioGI = document.getElementById('audio-gi');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaGI.addEventListener('click', function() {
            audioGI.play();
        });
    </script>
<audio id="audio-gu" src="../audio/hiragana_katakana/gu.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaGU = document.getElementById('katakana-gu');
        const audioGU = document.getElementById('audio-gu');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaGU.addEventListener('click', function() {
            audioGU.play();
        });
    </script>
<audio id="audio-ge" src="../audio/hiragana_katakana/ge.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaGE = document.getElementById('katakana-ge');
        const audioGE = document.getElementById('audio-ge');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaGE.addEventListener('click', function() {
            audioGE.play();
        });
    </script>
<audio id="audio-go" src="../audio/hiragana_katakana/go.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaGO = document.getElementById('katakana-go');
        const audioGO = document.getElementById('audio-go');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaGO.addEventListener('click', function() {
            audioGO.play();
        });
    </script>
<audio id="audio-za" src="../audio/hiragana_katakana/za.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaZA = document.getElementById('katakana-za');
        const audioZA = document.getElementById('audio-za');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaZA.addEventListener('click', function() {
            audioZA.play();
        });
    </script>
<audio id="audio-zi" src="../audio/hiragana_katakana/ji.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaZI = document.getElementById('katakana-zi');
        const audioZI = document.getElementById('audio-zi');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaZI.addEventListener('click', function() {
            audioZI.play();
        });
    </script>
<audio id="audio-zu" src="../audio/hiragana_katakana/zu.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaZU = document.getElementById('katakana-zu');
        const audioZU = document.getElementById('audio-zu');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaZU.addEventListener('click', function() {
            audioZU.play();
        });
    </script>
<audio id="audio-ze" src="../audio/hiragana_katakana/ze.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaZE = document.getElementById('katakana-ze');
        const audioZE = document.getElementById('audio-ze');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaZE.addEventListener('click', function() {
            audioZE.play();
        });
    </script>
<audio id="audio-zo" src="../audio/hiragana_katakana/zo.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaZO = document.getElementById('katakana-zo');
        const audioZO = document.getElementById('audio-zo');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaZO.addEventListener('click', function() {
            audioZO.play();
        });
    </script>
<audio id="audio-da" src="../audio/hiragana_katakana/da.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaDA = document.getElementById('katakana-da');
        const audioDA = document.getElementById('audio-da');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaDA.addEventListener('click', function() {
            audioDA.play();
        });
    </script>
<audio id="audio-ji" src="../audio/hiragana_katakana/ji.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaJI = document.getElementById('katakana-ji');
        const audioJI = document.getElementById('audio-ji');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaJI.addEventListener('click', function() {
            audioJI.play();
        });
    </script>
<audio id="audio-zu2" src="../audio/hiragana_katakana/zu.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaZU2 = document.getElementById('katakana-zu2');
        const audioZU2 = document.getElementById('audio-zu2');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaZU2.addEventListener('click', function() {
            audioZU2.play();
        });
    </script>
<audio id="audio-de" src="../audio/hiragana_katakana/de.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaDE = document.getElementById('katakana-de');
        const audioDE = document.getElementById('audio-de');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaDE.addEventListener('click', function() {
            audioDE.play();
        });
    </script>
<audio id="audio-do" src="../audio/hiragana_katakana/do.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaDO = document.getElementById('katakana-do');
        const audioDO = document.getElementById('audio-do');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaDO.addEventListener('click', function() {
            audioDO.play();
        });
    </script>
<audio id="audio-ba" src="../audio/hiragana_katakana/ba.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaBA = document.getElementById('katakana-ba');
        const audioBA = document.getElementById('audio-ba');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaBA.addEventListener('click', function() {
            audioBA.play();
        });
    </script>
<audio id="audio-bi" src="../audio/hiragana_katakana/bi.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaBI = document.getElementById('katakana-bi');
        const audioBI = document.getElementById('audio-bi');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaBI.addEventListener('click', function() {
            audioBI.play();
        });
    </script>
<audio id="audio-bu" src="../audio/hiragana_katakana/bu.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaBU = document.getElementById('katakana-bu');
        const audioBU = document.getElementById('audio-bu');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaBU.addEventListener('click', function() {
            audioBU.play();
        });
    </script>
<audio id="audio-be" src="../audio/hiragana_katakana/be.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaBE = document.getElementById('katakana-be');
        const audioBE = document.getElementById('audio-be');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaBE.addEventListener('click', function() {
            audioBE.play();
        });
    </script>
<audio id="audio-bo" src="../audio/hiragana_katakana/bo.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaBO = document.getElementById('katakana-bo');
        const audioBO = document.getElementById('audio-bo');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaBO.addEventListener('click', function() {
            audioBO.play();
        });
    </script>
<audio id="audio-pa" src="../audio/hiragana_katakana/pa.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaPA = document.getElementById('katakana-pa');
        const audioPA = document.getElementById('audio-pa');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaPA.addEventListener('click', function() {
            audioPA.play();
        });
    </script>
<audio id="audio-pi" src="../audio/hiragana_katakana/pi.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaPI = document.getElementById('katakana-pi');
        const audioPI = document.getElementById('audio-pi');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaPI.addEventListener('click', function() {
            audioPI.play();
        });
    </script>
<audio id="audio-pu" src="../audio/hiragana_katakana/pu.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaPU = document.getElementById('katakana-pu');
        const audioPU = document.getElementById('audio-pu');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaPU.addEventListener('click', function() {
            audioPU.play();
        });
    </script>
<audio id="audio-pe" src="../audio/hiragana_katakana/pe.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaPE = document.getElementById('katakana-pe');
        const audioPE = document.getElementById('audio-pe');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaPE.addEventListener('click', function() {
            audioPE.play();
        });
    </script>
<audio id="audio-po" src="../audio/hiragana_katakana/po.mp3"></audio>
    <script>
        // Mengambil elemen gambar dan audio
        const hiraganaPO = document.getElementById('katakana-po');
        const audioPO = document.getElementById('audio-po');
        
        // Menambahkan event listener untuk memutar audio saat gambar diklik
        hiraganaPO.addEventListener('click', function() {
            audioPO.play();
        });
    </script>
<footer>
    <div class="footer-container">
        <div class="footer-column">
            <h3><img src="../images/icons/about.png" alt="About Us Icon" class="footer-icon"> About Us</h3>
            <p>Aplikasi ini adalah website yang dibuat oleh mahasiswa universitas pakuan dalam memenuhi tugas akhir. Tentu aplikasi ini masih dalam tahap pengembangan, silahkan kirim laporan dan saran jika terjadi bug atau ingin membantu memberikan ide dan konsep buat pengembangannya. Terimakasih</p>
        </div>
        <div class="footer-column">
            <h3><img src="../images/icons/link.png" alt="Quick Links Icon" class="footer-icon"> Quick Links</h3>
            <ul>
                <li><a href="Dashboard_user.php">Halaman Utama</a></li>
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
</footer>
</body>
</html>