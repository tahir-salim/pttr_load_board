<html><head>
    <title>PTTR LoadBoard</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 800px; margin: auto; border: 1px solid #ddd; background-color: #ffffff;">
        <tbody>
            <tr>
                <td style="padding: 20px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                            <tr>
                             
                                @if($image == null || $image == '/assets/images/logo.webp')
                                <td style="width: 33.33%;padding: 0;background: #192f62;/* padding: 20px; */text-align: center;height: 165px;" align="left">
                                    <img src="{{asset('assets/images/logo.webp')}}" alt="Company Logo" style="max-width: 150px;">
                                </td>
                                @else
                                <td style="width: 33.33%;padding: 0; text-align: center;height: 165px;" align="left">
                                    <img src="{{asset('assets/invoices/'.$image)}}" alt="Company Logo" style="max-width: 150px;">
                                </td>
                                @endif
                                
                                
                                <td style="width: 33.33%;padding: 20px;line-height: 1.5;color: #999;" valign="center">
                                    <strong style="color: #000;">Bill To</strong></br>
                                    {{  $user ?  $user['name'] : '' }}</br>
                                    {{  $user ?  $user['phone'] : '' }}</br>
                                    {{  $user ?  $user['address'] : '' }}
                                </td>
                                <td style="width: 33.33%;padding: 20px;line-height: 1.5;color: #999;" valign="center">
                                    <strong style="color: #000;">Payable To</strong></br>
                                    {{  $company ?  $company['name'] : '' }}</br>
                                    {{  $company ?  $company['phone'] : '' }}</br>
                                    {{  $company ?  $company['address'] : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;height: 100px;" colspan="3">
                                    <h2 style="margin: 0;padding: 0;font-size: 50px;">Invoice</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0px;" colspan="3">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td style="padding: 10px 10px 10px 0;">
                                                    <h4 style="margin: 0;padding: 0;line-height: 1.5;color: #999;"><strong style="color: #000;">
                                                        Invoice #:</strong> {{ $invoice_no ? $invoice_no : '' }}
                                                    </h4>
                                                </td>
                                                <td style="padding: 10px 10px 10px 0;">
                                                    <h4 style="margin: 0;padding: 0;line-height: 1.5;color: #999;"><strong style="color: #000;">
                                                        Ref #: </strong> {{ $shipment['reference_id'] ? $shipment['reference_id'] : '_' }}
                                                    </h4>
                                                </td>
                                                <td style="padding: 10px 10px 10px 0;">
                                                    <h4 style="margin: 0;padding: 0;line-height: 1.5;color: #999;">
                                                        <strong style="color: #000;">Created:</strong> {{ $created_at ? \Carbon\Carbon::parse($created_at)->format('d M Y') : '' }}
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;width: 100%;" colspan="3">
                                    <table width="100%" cellpadding="5" cellspacing="0" border="1" style="border-collapse: collapse; border: 1px solid #ddd;">
                                        <tbody>
                                            <tr style="background-color: #f1f1f1;">
                                                <td colspan="2" style="padding: 15px 10px;background: #303536;">
                                                    <strong style="color: #fff;">LOAD DETAILS</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Origin</th>
                                                <td style="padding: 10px;">{{ $shipment['origin'] ? $shipment['origin'] : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Destination</th>
                                                <td style="padding: 10px;">{{ $shipment['destination'] ? $shipment['destination'] : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Type</th>
                                                <td style="padding: 10px;">{{ $shipment['equipment_type'] ? $shipment['equipment_type']['name'] : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Weight</th>
                                                <td style="padding: 10px;">{{ $shipment['weight'] ? $shipment['weight'] : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Shipping Start Date</th>
                                                <td style="padding: 10px;">{{ $shipment['from_date'] ? \Carbon\Carbon::parse($shipment['from_date'])->format('d M Y') : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Shipping End Date</th>
                                                <td style="padding: 10px;">{{ $shipment['to_date'] ? \Carbon\Carbon::parse($shipment['to_date'])->format('d M Y') : '' }}</td>
                                            </tr>
                                            <tr style="background-color: #f1f1f1;">
                                                <th style="text-align: left; padding: 10px;">Total Rate</th>
                                                <td style="padding: 10px; text-align: left;">${{ $invoice_amount ? $invoice_amount : '' }}</td>
                                            </tr>
                                            <tr style="background-color: #f1f1f1;">
                                                <th colspan="2" style="text-align: left; padding: 10px;">Rates And Charges</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Comments</th>
                                                <td style="padding: 10px;">{{ $comment ? strip_tags($comment) : '_' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
