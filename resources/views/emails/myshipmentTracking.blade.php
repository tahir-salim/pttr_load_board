<html><head>
    <title>PTTR LoadBoard</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 800px; margin: auto; border: 1px solid #ddd; background-color: #ffffff;">
        <tbody><tr>
            <td style="padding: 20px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
              <tr>
                        <td style="width: 33.33%;padding: 0;background: #192f62;/* padding: 20px; */text-align: center;height: 165px;" align="left">
                            <img src="{{asset('/assets/images/logo-png.png')}}" alt="Company Logo" style="max-width: 150px;/* background: #192f62; *//* padding: 20px; */">
                        </td>
                      <td style="width: 33.33%;padding: 20px;line-height: 1.5;color: #999;" valign="center">
                        </td>
                        <td style="width: 33.33%;padding: 20px;line-height: 1.5;color: #999;" valign="center">
                        </td> 
                    </tr>

                    <tr>
                        <td style="padding-top: 0px;height: 70px;" colspan="3">
                            <h2 style="margin: 0px;padding: 0px;font-size: 25px;">Tracking Request</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 0px;height: 50px;" colspan="3">
                            <h2 style="margin: 0px;padding: 0;font-size: 15px;"><a style="background: #192F62; font-size: 1rem; color:#fff; font-weight: 500; display: inline-block; padding: 0.97em 2em; line-height: normal; border-radius: 15px; border: none;" href="{{$details['carrier_url']}}">Click Here to Tracking Request</a></h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 0px;height: 100px;" colspan="3">
                            <h5 style="margin: 0px;padding: 0px;font-size: 25px;">Tracking OTP is: {{$details['carrier_otp']}}</h5>
                        </td>
                    </tr>
                   
                    <tr>
                        <td style="padding-top: 0px;" colspan="3">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tbody><tr>
                                    <td style="padding: 10px 10px 10px 0;">
                                        <h4 style="margin: 0;padding: 0;line-height: 1.5;color: #999;"><strong style="
    color: #000;
">Carier Name  </strong> {{$details['carrier_name']}}</h4>
                                    </td>
                                    <td style="padding: 10px 10px 10px 0;">
                                        <h4 style="margin: 0;padding: 0;line-height: 1.5;color: #999;"><strong style="
    color: #000;
">Phone #: </strong> {{$details['carrier_phone']}}</h4>
                                    </td>
                                    <td style="padding: 10px 10px 10px 0;">
                                        <h4 style="margin: 0;padding: 0;line-height: 1.5;color: #999;"><strong style="
    color: #000;
">Carier Email </strong> {{$details['carrier_email']}}</h4>
                                    </td>
                                   
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 20px;width: 100%;" colspan="3
    ">
                            
            </td>
        </tr>
    </tbody></table>






</body></html>
