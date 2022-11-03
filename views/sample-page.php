<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sample Page</title>
</head>
<body>
    <h1>Original Image</h1>
    <img src="data:image/png;base64, <?= base64_encode($originalImageEncoded) ?>" />

    <h1>Cropped Image</h1>
    <img src="data:image/png;base64, <?= base64_encode($cropeedImageEncoded) ?>" />

    <h1>Resized Image</h1>
    <img src="data:image/png;base64, <?= base64_encode($resizedImageEncoded) ?>" />
</body>
</html>