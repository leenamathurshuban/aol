<!DOCTYPE html>
@php 
    $dummyImg=\App\Helpers\Helper::defaultImage($data['logo']);
@endphp
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$data['title']}}</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
   
        <table width="100%" border="0" style="font-size: 14px;font-family: 'Poppins', sans-serif;color:#000;" style="border-collapse: collapse;">
            
            <tr>
                <td colspan="3"><h4 style="margin:25px 0 0 0;padding:6px;text-align:justify;">Hi {{ $data['userName'] }}, <b>Your OTP code is : {{ $data['otp'] }}.</b>. If you want to contact with us. You can email {{ $data['toEmail'] }}. Thank You !</h4></td>
            </tr>
             <tr>
                <td style="background-color:#000;font-size: 12px;color: #fff;padding:5px 15px;">A: {{$data['fromAddress']}}</td>
                <td style="background-color:#000;text-align: center; font-size: 12px;color: #fff;padding:5px 15px;">P: {{$data['fromMobile']}}</td>
                <td style="background-color:#000;font-size: 12px;color: #fff;padding:5px 15px;">M: <a href="#" style="color:#fff;">{{$data['toEmail']}}</a></td>
                
            </tr>
    </table>
</body>
</html>