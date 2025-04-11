<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jumat Beramal - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function scrollToSection(id) {
            $('html, body').animate({
                scrollTop: $('#' + id).offset().top
            }, 800);
        }

        document.addEventListener("DOMContentLoaded", function() {
            fetch('grafik_data.php')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.label);
                    const totals = data.map(item => item.total);

                    const ctx = document.getElementById('grafikSumbangan').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Sumbangan',
                                data: totals,
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                                borderWidth: 2,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</head>
<body class="font-sans bg-blue-200 text-gray-800">
    <nav class="bg-cream-200 shadow-md fixed w-full z-10 top-0">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <a class="text-xl font-bold text-blue-600" href="#">Jumat Beramal</a>
            <button class="lg:hidden" onclick="document.getElementById('menu').classList.toggle('hidden')">☰</button>
            <ul id="menu" class="hidden lg:flex space-x-6 ">
                <li><a href="#welcome" class="hover:text-blue-400" onclick="scrollToSection('welcome')">Home</a></li>
                <li><a href="#about" class="hover:text-blue-400" onclick="scrollToSection('about')">Tentang</a></li>
                <li><a href="#chart" class="hover:text-blue-400" onclick="scrollToSection('chart')">Grafik</a></li>
                <li><a href="#purpose" class="hover:text-blue-400" onclick="scrollToSection('purpose')">Tujuan</a></li>
                <li><a href="#creator" class="hover:text-blue-400" onclick="scrollToSection('creator')">Pembuat</a></li>
                <li><a href="#location" class="hover:text-blue-400" onclick="scrollToSection('location')">Lokasi</a></li>
                <li><a href="login.php" class="hover:text-blue-400" onclick="scrollToSection('location')">Login</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mx-auto mt-20 px-6">
        <section id="welcome" class="text-center my-8">
            <h1 class="text-3xl font-bold text-blue-700">Selamat Datang</h1>
        </section>
        <hr>
        <section id="about" class="my-8 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-blue-700">Tentang Website ini</h2>
            <p>Website ini dibuat untuk memenuhi syarat kelulusan kami</p>
        </section>

    <!-- Konten -->
        <section id="chart" class="my-8 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-blue-700">Grafik Sumbangan</h2>
            <canvas id="grafikSumbangan"></canvas>
            <br>
            <a href="dashboard_guest.php" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg ">Lihat Rekapan</a>
        </section>
        <div class="container mx-auto mt-6 p-4 text-center">
        <h2 class="text-2xl font-semibold text-blue-900">ingin bersedekah?,hubungi kontak dibawah ini</h2>
        <a href="" class="mt-4 inline-block bg-green-400 text-white px-4 py-2 rounded-lg ">📞 085856884861</a>
        <a href="" class="mt-4 inline-block bg-green-400 text-white px-4 py-2 rounded-lg ">📞 085233290306</a>
    </div>
        <section id="purpose" class="my-8 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-blue-700">Tujuan Website</h2>
            <p>Website ini dibuat untuk mempermudah akses mencatat dan merekap sumbangan Jumat Beramal.</p>
        </section>

        <section id="creator" class="my-8 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-blue-700">Pembuat Website</h2>
            <div class="flex flex-wrap justify-center gap-6">
                <div class="text-center max-w-xs bg-cream-100 p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-medium">Muhammad Afifuddin Muchtar</h3>
                    <p>Kelas: XII PPLG 2</p>
                </div>
                <div class="text-center max-w-xs bg-cream-100 p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-medium">Muhammad Adidtya Putra Ramadhan</h3>
                    <p>Kelas: XII PPLG 2</p>
                </div>
            </div>
        </section>

        <section id="location" class="my-8 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-blue-700">Lokasi Sekolah</h2>
    <div class="w-full h-64 sm:h-80 md:h-96 lg:h-[500px] rounded-lg overflow-hidden">
        <iframe 
            class="w-full h-full border-0"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.6743782644635!2d112.75168237367328!3d-7.047497092954712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd805921a687535%3A0xe56ef0cbff25e78!2sSMK%20Negeri%202%20Bangkalan%20(SMK%20Pusat%20Keunggulan)!5e0!3m2!1sid!2sid!4v1742306318436!5m2!1sid!2sid"
            allowfullscreen
            loading="lazy">
        </iframe>
    </div>
</section>
    </div>
</body>
</html>
