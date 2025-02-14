<html><head>
    <title>PTTR LoadBoard</title>
            <link rel="icon" type="image/x-icon" href="{{asset('/assets/images/favicon.jpg')}}" />
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 800px; margin: auto; border: 1px solid #ddd; background-color: #ffffff;">
        <tbody>
            <tr>
                <td style="padding: 20px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                            <tr>
                                @if(isset($invoice[0]['image']))
                                    @if($invoice[0]['image'] == null || $invoice[0]['image'] == '/assets/images/logo.webp')
                                    <td style="width: 33.33%;padding: 0;background: #192f62;/* padding: 20px; */text-align: center;height: 165px;" align="left">
                                        <img src="{{asset('assets/images/logo.webp')}}" alt="Company Logo" style="max-width: 150px;">
                                    </td>
                                    @else
                                    <td style="width: 33.33%;padding: 0; text-align: center;height: 165px;" align="left">
                                        <img src="{{asset('assets/invoices/'. $invoice[0]['image'])}}" alt="Company Logo" style="max-width: 150px;">
                                    </td>
                                    @endif 
                                @else
                                     <td style="width: 33.33%;padding: 0;background: #192f62;/* padding: 20px; */text-align: center;height: 165px;" align="left">
                                        <img src="{{asset('assets/images/logo.webp')}}" alt="Company Logo" style="max-width: 150px;">
                                    </td>
                                
                                @endif
                                 
                                <td style="width: 33.33%;padding: 20px;line-height: 1.5;color: #999;" valign="center">
                                    <strong style="color: #000;">Bill To</strong></br>
                                    @if(auth()->user()->parent_id == null)
                                    {{ auth()->user()->company ? auth()->user()->company->name : '' }}</br>
                                    {{ auth()->user()->company ? auth()->user()->company->phone : '' }}</br>
                                    {{ auth()->user()->company ? auth()->user()->company->address : '' }}
                                    @else
                                        @php
                                            $childcomp = App\Models\Company::where('user_id',auth()->user()->parent_id)->first(); 
                                        @endphp
                                        @if(isset($childcomp) && $childcomp != null)
                                            {{ $childcomp->name}}</br>
                                            {{ $childcomp->phone }}</br>
                                            {{ $childcomp->address }}
                                        @endif
                                        
                                    @endif
                                    
                                </td>
                                <td style="width: 33.33%;padding: 20px;line-height: 1.5;color: #999;" valign="center">
                                    <strong style="color: #000;">Payable To</strong></br>
                                    
                                      @if($invoice[0]['shipment']['user']['parent_id'] == null)
                                        {{ $invoice[0]['shipment']['user']['company'] ? $invoice[0]['shipment']['user']['company']['name'] : '' }}</br>
                                        {{ $invoice[0]['shipment']['user']['company'] ? $invoice[0]['shipment']['user']['company']['phone'] : '' }}</br>
                                        {{ $invoice[0]['shipment']['user']['company'] ? $invoice[0]['shipment']['user']['company']['address'] : '' }}
                                    @else
                                        @php
                                            $childcomps = App\Models\Company::where('user_id',$invoice[0]['shipment']['user']['parent_id'])->first(); 
                                        @endphp
                                        @if(isset($childcomp) && $childcomp != null)
                                            {{ $childcomps->name}}</br>
                                            {{ $childcomps->phone }}</br>
                                            {{ $childcomps->address }}
                                        @endif
                                        
                                    @endif
                                   
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
                                                        Invoice #:</strong> {{ $invoice[0]['invoice_no'] ? $invoice[0]['invoice_no'] : '' }}
                                                    </h4>
                                                </td>
                                                <td style="padding: 10px 10px 10px 0;">
                                                    <h4 style="margin: 0;padding: 0;line-height: 1.5;color: #999;"><strong style="color: #000;">
                                                        Ref #: </strong> {{ $invoice[0]['shipment']['reference_id'] ? $invoice[0]['shipment']['reference_id'] : '_' }}
                                                    </h4>
                                                </td>
                                                <td style="padding: 10px 10px 10px 0;">
                                                    <h4 style="margin: 0;padding: 0;line-height: 1.5;color: #999;">
                                                        <strong style="color: #000;">Created:</strong> {{ $invoice[0]['created_at'] ? \Carbon\Carbon::parse($invoice[0]['created_at'])->format('d M Y') : '' }}
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
                                                <td style="padding: 10px;">{{ $invoice[0]['shipment']['origin'] ? $invoice[0]['shipment']['origin'] : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Destination</th>
                                                <td style="padding: 10px;">{{ $invoice[0]['shipment']['destination'] ? $invoice[0]['shipment']['destination'] : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Type</th>
                                                <td style="padding: 10px;">{{ $invoice[0]['shipment']['equipment_type'] ? $invoice[0]['shipment']['equipment_type']['name'] : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Weight</th>
                                                <td style="padding: 10px;">{{ $invoice[0]['shipment']['weight'] ? $invoice[0]['shipment']['weight'] : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Shipping Start Date</th>
                                                <td style="padding: 10px;">{{ $invoice[0]['shipment']['from_date'] ? \Carbon\Carbon::parse($invoice[0]['shipment']['from_date'])->format('d M Y') : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Shipping End Date</th>
                                                <td style="padding: 10px;">{{ $invoice[0]['shipment']['to_date'] ? \Carbon\Carbon::parse($invoice[0]['shipment']['to_date'])->format('d M Y') : '' }}</td>
                                            </tr>
                                            <tr style="background-color: #f1f1f1;">
                                                <th style="text-align: left; padding: 10px;">Total Rate</th>
                                                <td style="padding: 10px; text-align: left;">${{ $invoice[0]['invoice_amount'] ? $invoice[0]['invoice_amount'] : '' }}</td>
                                            </tr>
                                            <tr style="background-color: #f1f1f1;">
                                                <th colspan="2" style="text-align: left; padding: 10px;">Rates And Charges</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px;">Comments</th>
                                                <td style="padding: 10px;">{{ $invoice[0]['comment'] ? strip_tags($invoice[0]['comment']) : '_' }}</td>
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
