<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan - Sistem Sekolah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #2c3e50;
        }
        .error-container {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
        }
        h1 {
            font-size: 5rem;
            margin: 0;
            color: #e74c3c;
        }
        h2 {
            margin-top: 0;
            font-weight: 600;
        }
        p {
            margin-bottom: 2rem;
            color: #7f8c8d;
        }
        .btn {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .illustration {
            max-width: 200px;
            margin: 0 auto 1.5rem;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <svg class="illustration" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
            <line x1="12" y1="9" x2="12" y2="13"></line>
            <line x1="12" y1="17" x2="12.01" y2="17"></line>
        </svg>
        <h1>404</h1>
        <h2>Halaman Tidak Ditemukan</h2>
        <p>Maaf, halaman yang Anda cari tidak dapat ditemukan atau telah dipindahkan.</p>
        <a href="./login/index.php" class="btn">Kembali</a>
    </div>
</body>
</html>