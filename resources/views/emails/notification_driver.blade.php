<!DOCTYPE html>
<html>
<head>
	<title>Trip For You</title>
</head>
<body>
    <h4>Trip Information</h4>
	<p>Trip ID: {{$trip_id}}</p>
	<p>Passanger ID: {{$trips->user_id}}</p>
	<p>Passanger name: {{$name}}</p>
	<p>Trip date: {{ Carbon\Carbon::parse($request->date)->format('Y-m-d') }}</p>
	<p>Trip time: {{ Carbon\Carbon::parse($request->date)->format('H:i A') }}</p>
	<p>Pick up location: {{@print_r($request->start_point)}}</p>
	<p>Drop off location: {{@print_r($request->end_point)}}</p>
	<p>Price: {{$trips->price}}</p>
	<br/>
	<p style="background: yellow;padding: 10px;width: 40%;font-weight: 600;font-size: 14px;"> تم حجز رحلتك المجدولة لشخص واحد أو عده أشخاص
افتح صفحة الحجوزات لديك
ملاحظه مهمه عند عدم اكتمال المقاعد المطلوبة من الركاب نوصي بتغيير سعر الرحله لجذب ركاب فقط على Discuont
( رافقتكم السلامة). لاتنسى من ربط حزام الأمان.  تعليقات الركاب على الرحلات مهمه لتقييمك. تأخير الرحلات او عدم التزامك بالوقت وجوده الخدمه المقدمة تؤثر على مراجعات العملاء الركاب لمقدم الخدمة (مالك السيارة)
</p>
</body>
</html>