<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta content="二维码支付测试" name="keywords">
	<meta content="二维码支付测试" name="description">
	<title>二维码支付测试</title>
</head>
<body>
<div style="padding:50px;text-align: center">
@if($result['resultCode'] == '0000')
<table style="width:100%">
	<tr>
		<td>商户号</td>
		<td>商户订单号</td>
		<td>平台订单号</td>
		<td>交易金额</td>
		<td>是否T0</td>
		<td>交易状态</td>
	@if($result['tradeState'] == 'SUCCESS')
		<td>支付银行</td>
		<td>支付完成时间</td>
	@endif
	</tr>
	<tr>
		<td>{{$result['gymchtId']}}</td>
		<td>{{$result['tradeSn']}}</td>
		<td>{{$result['transaction_id']}}</td>
		<td>{{$result['orderAmount']}}</td>
		<td>{{$result['t0Flag'] == 0 ? '否':'是'}}</td>
		<td>{{$result['tradeStateName']}}</td>
		@if($result['tradeState'] == 'SUCCESS')
			<td>{{$result['bankType']}}</td>
			<td>{{$result['timeEnd']}}</td>
		@endif
	</tr>
</table>
@else
	{{$result['message']}}
@endif
</div>
</body>
</html>