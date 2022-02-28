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
                <td colspan="3"><h4 style="margin:25px 0 0 0;padding:6px;text-align:justify;">Hi , <b>Approved Click on link and access your account using login detail . Thank You !</h4>
                    {{--
                        @if($data['account_status']==3)
                            <p>Username: <strong>{{$data['username']}}</strong><br>Password: <strong>{{$data['password']}}</strong></p>
                        @endif
                        --}}
                </td>
            </tr>
          {{--  <tr>
                <td colspan="3" style="text-align: center;">
                     link_to_route('vendorForm','Click Here','',['style'=>"background-color: #f37220;font-size: 16px;color: #fff;padding: 8px 15px;border-radius: 4px;margin: 15px 0;display: inline-block;text-decoration: none;"]) 
                </td>
            </tr>--}}
             <tr>
                <td style="background-color:#000;font-size: 12px;color: #fff;padding:5px 15px;">A: {{$data['fromAddress']}}</td>
                <td style="background-color:#000;text-align: center; font-size: 12px;color: #fff;padding:5px 15px;">P: {{$data['fromMobile']}}</td>
                <td style="background-color:#000;font-size: 12px;color: #fff;padding:5px 15px;">M: <a href="#" style="color:#fff;">{{$data['FromEmail']}}</a></td>
            </tr>
    </table>
</body>
</html>