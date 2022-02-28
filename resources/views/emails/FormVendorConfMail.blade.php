{{--<p>Vendor Code {{ $data['vendor_code'] }}</p>
<p>Userid {{ $data['venodr_email'] }}</p>
<p>Password {{ $data['venodr_pswd'] }}</p>
<p>Thank you for registering as an approved vendor with the Art of Living Trust. <a href="{{url('vendor/login')}}" class="btn btn-primary">Login</a></p>--}}

<!DOCTYPE html>
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
                <td colspan="3"><h4 style="margin:25px 0 0 0;padding:6px;text-align:justify;">Hi , <b>Thank you for registering as an approved vendor with the Art of Living Trust.</h4>
                </td>
            </tr>
             <tr>
                <td style="background-color:#000;font-size: 12px;color: #fff;padding:5px 15px;">A: {{$data['fromAddress']}}</td>
                <td style="background-color:#000;text-align: center; font-size: 12px;color: #fff;padding:5px 15px;">P: {{$data['fromMobile']}}</td>
                <td style="background-color:#000;font-size: 12px;color: #fff;padding:5px 15px;">M: <a href="#" style="color:#fff;">{{$data['FromEmail']}}</a></td>
            </tr>
    </table>
</body>
</html>
