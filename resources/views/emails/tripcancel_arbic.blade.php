<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البريد الإلكتروني لإلغاء الرحلة</title>
</head>

<body>
    <p><strong>تاريخ الإلغاء:</strong> {{ $cancellationDate }}</p>
    <p><strong>معلومات الرحلة:</strong></p>
    <ul>
        <li><strong>تاريخ الرحلة:</strong> {{ $tripStartDate }}</li>
        <li><strong>نقطة البداية:</strong> {{ $trip_start }}</li>
        <li><strong>نقطة النهاية:</strong> {{ $trip_end }}</li>
        <li><strong>اسم العلامة التجارية:</strong> {{ $brand_name }}</li>
        <li><strong>اسم السائق:</strong> {{ $driver_name }}</li>
    </ul>
    <p><strong>تم الإلغاء بواسطة:</strong> {{ $canceledBy }}</p>

    <span>
        <h3>ألغى العميل رحلته لحالة الطوارئ، يرجى التخفيض لجذب العملاء الجدد.</h3>
    </span>
</body>

</html>