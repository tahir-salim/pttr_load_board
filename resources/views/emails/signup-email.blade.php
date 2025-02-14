<!DOCTYPE html>
<html>
<head>
    <title>Welcoming Email</title>
</head>

<body>
    <div style="font-size: 16px; line-height: 140%; text-align: left; word-wrap: break-word;">
        <p style="line-height: 140%;"><strong>Welcome to PTTR Loadboard – Your Gateway to Seamless Freight Management!</strong></p>
        <hr />
        <p style="line-height: 140%;"><strong>Hi {{$userData['first_name']}},</strong></p>
        <p style="line-height: 140%;">Welcome to the PTTR Loadboard community! We’re thrilled to have you on board. At PTTR, we’re dedicated to making your freight management experience as smooth and efficient as possible.</p>
        <p style="line-height: 140%;"> </p>
        <p style="line-height: 140%;"><strong>Package Details:</strong></p>
        <p style="line-height: 140%;">Type : {{($package->name)}}</p>
        <p style="line-height: 140%;">Total Amount : ${{($ownerAmount[0] + ($userSubscriptionAmount * count($seat)))}}<br />Seats : ({{count($seat)}} users)</p>
        <p style="line-height: 140%;"> </p>
        <p style="line-height: 140%;">Thank you for joining PTTR Loadboard. We’re excited to help you streamline your freight operations and drive your success!</p>
        <p style="line-height: 140%;">If you have any questions or need support, please don’t hesitate to reach out to us.</p>
        <p style="line-height: 140%;"> </p>
        <p style="line-height: 140%;">Happy loading!</p>
        <p style="line-height: 140%;">Best Regards,<br />The PTTR Loadboard Team</p>
        <hr />
        <p style="line-height: 140%;">Feel free to customize the links and contact information as needed.</p>
    </div>
</body>

</html>
