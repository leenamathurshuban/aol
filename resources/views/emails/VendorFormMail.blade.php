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
                <td colspan="3">
                    <h4 style="margin:25px 0 0 0;padding:6px;text-align:justify;">
                        Thank you for showing interest to work with the Art of Living Trust. We request you to click the link on this message and fill in all your details to update our master data. In case of any clarifications, please reach us on purchase@in.artofliving.org
                    </h4>
                </td>
            </tr>
           <!--  <tr>
                <td colspan="3"><h4 style="margin:25px 0 0 0;padding:6px;text-align:justify;"><b>{{-- $data['message'] --}}</h4></td> 
            </tr> -->
            <tr>
                <td colspan="3" style="text-align: center;">
                    {{ link_to_route('vendorForm','Click Here',Auth::guard('employee')->user()->employee_code,['style'=>"background-color: #f37220;font-size: 16px;color: #fff;padding: 8px 15px;border-radius: 4px;margin: 15px 0;display: inline-block;text-decoration: none;"]) }}
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