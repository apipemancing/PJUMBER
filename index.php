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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .pembuat-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .pembuat {
            text-align: center;
            max-width: 300px;
        }
        .pembuat img {
            width: 100%;
            max-width: 200px;
            border-radius: 10px;
        }
        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }
        }
    </style>
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
                                borderColor: 'blue',
                                backgroundColor: 'rgba(0, 0, 255, 0.2)',
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
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Jumat Beramal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#welcome" onclick="scrollToSection('welcome')">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about" onclick="scrollToSection('about')">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#chart" onclick="scrollToSection('chart')">Grafik</a></li>
                    <li class="nav-item"><a class="nav-link" href="#purpose" onclick="scrollToSection('purpose')">Tujuan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#creator" onclick="scrollToSection('creator')">Pembuat</a></li>
                    <li class="nav-item"><a class="nav-link" href="#location" onclick="scrollToSection('location')">Lokasi</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5 pt-5">
        <section id="welcome" class="text-center my-2">
            <h1>Selamat Datang</h1>
        </section>
        <hr>
        <section id="about" class="my-5">
            <h2>Tentang Website ini</h2>
            <p>Website ini dibuat untuk memenuhi syarat kelulusan kami</p>
        </section>

        <section id="chart" class="my-5">
            <h2>Grafik Sumbangan</h2>
            <canvas id="grafikSumbangan"></canvas>
            <br>
            <a href="dashboard_guest.php" class="btn btn-primary">Lihat Detail</a>
        </section>

        <section id="purpose" class="my-5">
            <h2>Tujuan Website</h2>
            <p>Website ini dibuat untuk mempermudah akses mencatat dan merekap sumbangan Jumat Beramal yang diadakan di SMK Negeri 2 Bangkalan</p>
        </section>

        <section id="creator" class="my-5">
            <h2>Pembuat Website</h2>
            <div class="pembuat-container">
                <div class="pembuat">
                    <img src="images/pembuat1.jpg" alt="Pembuat 1">
                    <h3>Muhammad Afifuddin Muchtar</h3>
                    <p>Kelas: XII PPLG 2</p>
                </div>
                <div class="pembuat">
                    <img src="images/pembuat2.jpg" alt="Pembuat 2">
                    <h3>Muhammad Adidtya Putra Ramadhan</h3>
                    <p>Kelas: XII PPLG 2</p>
                </div>
            </div>
        </section>

        <section id="location" class="my-5">
            <h2>Lokasi Sekolah</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31677.326172010933!2d112.7439003!3d-7.0485044!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd805921a687535%3A0xe56ef0cbff25e78!2sSMK%20Negeri%202%20Bangkalan%20(SMK%20Pusat%20Keunggulan)!5e0!3m2!1sid!2sid!4v1740490924654!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </section>
    </div>
</body>
</html>
