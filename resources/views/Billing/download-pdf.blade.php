<!DOCTYPE html>
<html>

<head>
    <title>PTTR LoadBoard</title>
</head>

<style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #555;
        }
        .invoice-container {
            max-width: 800px;
            padding-top:0;
            padding: 30px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            border-radius: 10px;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            
        }
        .invoice-header h2 {
            margin: 0;
            font-size: 36px;
            color: #333;
            margin-bottom:2rem;
        }
        .company-logo{ width: 200px; height:128px; padding-top:20px; float:left;  background: #192f62; text-align:center; border-radius:2rem; }
        .company-logo img{ max-width:60%; }
        .company-details {
            text-align: right;
        }
        .company-details img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .company-details div {
            margin-bottom: 5px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .invoice-table td, .invoice-table th {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .invoice-table th {
            background: #f8f8f8;
            font-weight: bold;
            text-align: left;
        }
        .invoice-details td {
            padding-bottom: 20px;
        }
        .total-row {
            background: #f8f8f8;
            font-weight: bold;
            border-top: 2px solid #333;
        }
        .right-align {
            text-align: right;
        }
    </style>

<body>
    <div class="invoice-container">
        <div class="invoice-header1">
            <div class="company-logo">
                <img src="assets/images/logo.webp" alt="Company Logo">
            </div>
            <div class="company-details">
                {{-- {{dd($company)}} --}}
                <div><strong>PTTR Load Board</strong></div>
                <div>Phone: {{$company->phone}}</div>
                <div>Zip Code: {{$company->zip_code}}</div>
                <div>Email: {{auth()->user()->email}}</div>
                <div>{{$company->address}}</div>
            </div>
        </div>
        <div class="invoice-header">
            <h4>Subscription #: {{ $subscription->subscription_id }}</h4>
            <h4>Created: {{ \Carbon\Carbon::parse($subscription->created_at)->format('d M Y') }}</h4>
        </div>
        <table class="invoice-table">
            <tr class="invoice-details">
                <td colspan="2"><strong>User Name :</strong> {{ $subscription->user->name }}
                </td>
            </tr>
            <tr class="invoice-details">
                <td colspan="2"><strong>User Email :</strong> {{ $subscription->user->email }}
                </td>
            </tr>
            <tr>
                <th>Package Name</th>
                <td>{{ $subscription->package->name }}</td>
            </tr>
            <tr>
                <th>Transaction ID</th>
                <td>{{ $subscription->transaction_id }}</td>
            </tr>
            <tr class="total-row">
                <th>Amount</th>
                <td class="right-align">${{ $subscription->amount }}</td>
            </tr>
            <tr class="total-row">
                <th>Expiry Date</th>
                <td class="right-align">{{ \Carbon\Carbon::parse($subscription->expired_at)->format('d M Y') }}</td>
            </tr>
            
        </table>
    </div>



</body>

</html>
