<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta content="二维码支付测试" name="keywords">
	<meta content="二维码支付测试" name="description">
	<title>二维码支付测试</title>
</head>
<body>
@if($result['resultCode'] == '0000')
	{!!$code!!}
@else
	{{$result['message']}}
@endif
</body>
</html>