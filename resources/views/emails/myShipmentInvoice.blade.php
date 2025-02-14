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
                               {{--  <strong style="color: #000;">Bill To</strong>
                             <br/>
                            {{$details['bil_comp_name']}}
                            <br/>
                            {{$details['bil_comp_phone']}}
                            <br/>
                            {{$details['bil_comp_add']}} --}}
                        </td>
                        <td style="width: 33.33%;padding: 20px;line-height: 1.5;color: #999;" valign="center">
                           {{--  <strong style="color: #000;">Payable To</strong>
                            <br/>
                            {{$details['pay_comp_name']}}
                            <br/>
                            {{$details['pay_comp_phone']}}
                            <br/>
                            {{$details['pay_comp_add']}}   --}}
                        </td> 
                    </tr>
                    @if($details['url'] != null)
                    <tr>
                        <td style="padding-top: 20px;height: 100px;" colspan="3">
                            <h2 style="margin: 0;padding: 0;font-size: 25px;">Tracking Required</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 10px;height: 100px;" colspan="3">
                            <h2 style="margin: 0px;padding: 0;font-size: 15px;"><a style="background: #192F62; font-size: 1rem; color:#fff; font-weight: 500; display: inline-block; padding: 0.97em 2em; line-height: normal; border-radius: 15px; border: none;" href="{{$details['url']}}">Click Here to Tracking Request</a></h2>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding-top: 0px;" colspan="3">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tbody><tr>
                                    <td style="padding: 10px 10px 10px 0;">
                                        <h4 style="margin: 0;padding: 0;line-height: 1.5;color: #999;"><strong style="
    color: #000;
">shipment #:</strong> {{$details['shipment_id']}}</h4>
                                    </td>
                                    <td style="padding: 10px 10px 10px 0;">
                                        <h4 style="margin: 0;padding: 0;line-height: 1.5;color: #999;"><strong style="
    color: #000;
">Ref #: </strong> {{$details['ref_no']}}</h4>
                                    </td>
                                    <td style="padding: 10px 10px 10px 0;">
                                        <h4 style="margin: 0;padding: 0;line-height: 1.5;color: #999;"><strong style="
    color: #000;
">Created:</strong> {{$details['invoice_date']}}</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 20px;width: 100%;" colspan="3
    ">
                            <table width="100%" cellpadding="5" cellspacing="0" border="1" style="border-collapse: collapse; border: 1px solid #ddd;">
                                <tbody><tr style="background-color: #f1f1f1;">
                                    <td colspan="2" style="
    padding: 15px 10px;
    background: #303536;
"><strong style="
    color: #fff;
">LOAD DETAILS</strong></td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; padding: 10px;">Origin</th>
                                    <td style="padding: 10px;">{{$details['origin']}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; padding: 10px;">Destination</th>
                                    <td style="padding: 10px;">{{$details['destination']}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; padding: 10px;">Type</th>
                                    <td style="padding: 10px;">{{$details['equipment_type']}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; padding: 10px;">Weight</th>
                                    <td style="padding: 10px;">{{$details['weight']}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; padding: 10px;">Shipping Start Date</th>
                                    <td style="padding: 10px;">{{$details['start']}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; padding: 10px;">Shipping End Date</th>
                                    <td style="padding: 10px;">{{$details['end']}}</td>
                                </tr>
                                @if(!isset($details['is_trucker']))
                                <tr style="background-color: #f1f1f1;">
                                    <th style="text-align: left; padding: 10px;">Total Rate</th>
                                    <td style="padding: 10px; text-align: left;">${{$details['price']}}</td>
                                </tr>
                                <tr style="background-color: #f1f1f1;">
                                    <th colspan="2" style="text-align: left; padding: 10px;">Rates And Charges</th>
                                </tr>
                                @endif
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody></table>






</body></html>
