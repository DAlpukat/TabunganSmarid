<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kotak Saran</title>
</head>
<body>
    <h2>Ada saran baru dari pengguna:</h2>
    <p><strong>Nama:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Pesan:</strong> {{ $data['message'] }}</p>
</body>
</html>