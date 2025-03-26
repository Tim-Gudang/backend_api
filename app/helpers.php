    <?php

    use Illuminate\Support\Facades\Storage;
    use Melihovv\Base64ImageDecoder\Base64ImageDecoder;
    use Illuminate\Support\Str;


    function uploadBase64Image($base64Image)
    {
        $decoder = new Base64ImageDecoder($base64Image, $allowedFormats = ['jpeg', 'png', 'jpg']);
        $decodedContent = $decoder->getDecodedContent();
        $format = $decoder->getFormat();
        $image = 'img/barang/' . Str::random(10) . '.' . $format;
        Storage::disk('public')->put($image, $decodedContent);

        return $image;
    }
