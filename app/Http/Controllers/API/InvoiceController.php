<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use PDF;

class InvoiceController extends Controller
{
    public function createInvoice(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'shipment_id' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }
        $shipment = Shipment::find($request->shipment_id);
        // dd($shipment->user->name);
        if (isset($shipment)) {
        $invoice = new Invoice();
        $invoice->user_id = Auth::id();
        $invoice->shipment_id = $request->shipment_id;
        $invoice->customer = $shipment->user->name;
        $invoice->email = $shipment->user->email;
        $invoice->invoice_no = rand(100000, 999999);
        $invoice->po_no = rand(100000, 999999);
        $invoice->invoice_amount = $shipment->booking_rate;
        $invoice->shipping_date = $shipment->to_date;
        $invoice->delivery_date = $shipment->from_date;
        $invoice->total_miles = $shipment->miles;
        $invoice->image = '/assets/images/logo.webp';
        $invoice->save();

        // $invoice = Invoice::with('shipment.equipment_type','user.company')->where('id',$invoice->id)->get()->toArray();
        $invoice = Invoice::with('shipment.equipment_type','shipment.user.company','user.company')->where('id',$invoice->id)->get()->toArray();

        $data['invoice_no'] = $invoice[0]['invoice_no'];
        $data['email'] = $invoice[0]['email'];
        $data['created_at'] = $invoice[0]['created_at'];
        $data['customer'] = $invoice[0]['customer'];
        $data['po_no'] = $invoice[0]['po_no'];
        $data['invoice_amount'] = $invoice[0]['invoice_amount'];
        $data['total_miles'] = $invoice[0]['total_miles'];
        $data['image'] = $invoice[0]['image'];
        $data['comment'] = $invoice[0]['comment'];
        $data['user'] = $invoice[0]['user'];
        $data['user']['address'] = $invoice[0]['user']['parent_id'] == null ? $invoice[0]['user']['company']['address'] : User::where('id', $invoice[0]['user']['parent_id'])->first()->company->address;
        $data['shipment'] = $invoice[0]['shipment'];
        $data['company'] = $invoice[0]['user']['parent_id'] == null ? $invoice[0]['user']['company'] : User::where('id', $invoice[0]['user']['parent_id'])->first()->company;
        $pdf = PDF::loadView('emails.invoice-email', $data);

        Mail::send('emails.invoice-email', $data, function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["email"])
                    ->subject($data["customer"])
                    ->attachData($pdf->output(), "Invoice_No_" . $data['invoice_no'] . ".pdf");
            });
        return $this->formatResponse(
            'success',
            'invoice created successfully'
        );
        } else{
            return $this->formatResponse(
                'error',
                'shipment not found'
            );
        }
        // dd($shipment);
    }

    public function invoiceList()
    {
        $allInvoices = Invoice::where('user_id',Auth::id())->get();
        return $this->formatResponse(
            'success',
            'list of all invoices',
            $allInvoices,
            200
        );
    }

    public function invoiceDetail($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        return $this->formatResponse(
            'success',
            'get invoice details',
            $invoice,
            200
        );
    }
}
