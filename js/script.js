// JavaScript
let index = 0;
const images = document.querySelectorAll('.carousel-image');

function nextSlide() {
    images[index].style.display = 'none';
    index = (index + 1) % images.length;
    images[index].style.display = 'block';
}

// Set interval untuk mengubah slide setiap beberapa detik
setInterval(nextSlide, 3000); // Ubah angka 3000 menjadi durasi yang diinginkan (dalam milidetik)
