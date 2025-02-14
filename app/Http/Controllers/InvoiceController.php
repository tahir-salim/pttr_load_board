<?php

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Shipment;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PDF;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Invoice::select("*")->where('user_id', Auth::id())->orderBy('created_at', 'DESC');
            // dd($request->all());
            return DataTables::of($data)->addIndexColumn()->addColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })->addIndexColumn()->addColumn('invoice_amount', function ($row) {
                return '$' . $row->invoice_amount;
            })->addIndexColumn()->addColumn('total_miles', function ($row) {
                return $row->total_miles . ' miles';
            })
            ->addIndexColumn()->addColumn('origin_destination', function ($row) {
                return $row->shipment->origin .' / '.$row->shipment->destination;
            })
             ->addIndexColumn()->addColumn('pdf', function ($row) {
                 if($row->pdf != null){
                    $pdf = '<a href="' . asset($row->pdf) .'" target="_blank">View PDF</a>';
                 }else{
                     $pdf = '-';
                 }
                return $pdf;
            })
            ->addColumn('actions', function ($row) {
                // return '<i href="route(auth()->user()->type . '.invoice.index')')" class="fa fa-download btn btn-outline-success"></i>' . ' ' . '<i href="" class="fa fa-trash-alt btn btn-outline-danger"></i>';
                return '<div class="d-flex btnWrap"><a href="' . route(auth()->user()->type . '.invoice.show', [$row->id]) . '"class="fa fa-eye btn btn-outline-success" target="_blank"></a>'
                . '<a href="' . route(auth()->user()->type . '.invoice.destroy', [$row->id]) . '" class="fa fa-trash-alt btn btn-outline-danger"></a></div>';
            })->rawColumns(['actions', 'pdf', 'shipping_date', 'delivery_date', 'invoice_amount', 'total_miles','origin_destination'])->make(true);
        }

        return view('Invoices.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shipments = Shipment::where('trucker_id',auth()->user()->id)->get();
        // dd($shipments);
        if(isset($shipments)){
            return view('Invoices.create',get_defined_vars());
        }
        return view('Invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            "shipment_id"=>"required",
            "customer" => "required",
            "invoice_no" => "required",
            "po_no" => "required",
            "invoice_amount" => "required",
            "total_miles" => "required",
            "image"=>"mimes:jpeg,jpg,png",
            "pdf"=>"sometimes|mimes:pdf",
        ],[
            'shipment_id.required' => 'The Shipment field is required.',
        ]);

        $invoice = new Invoice();
        $invoice->user_id = Auth::id();
        $invoice->shipment_id = $request->shipment_id;
        $invoice->customer = $request->customer;
        $invoice->email = isset($request->email) ? $request->email : '';
        $invoice->invoice_no = $request->invoice_no;
        $invoice->po_no = $request->po_no;
        $invoice->invoice_amount = $request->invoice_amount;
        $invoice->total_miles = $request->total_miles;
        if($request->file('image')){
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->move(public_path('assets/invoices/'), $imageName);
            $invoice->image = $imageName;
        }
        if($request->file('pdf')){
            $pdf = $request->file('pdf');
            $pdfName = $pdf->getClientOriginalName();
            $pdfPath = $pdf->move(public_path('assets/invoices/'), $pdfName);
            $invoice->pdf = 'assets/invoices/'.$pdfName;
        }
        $invoice->comment = $request->comment ? $request->comment : '';
        $invoice->save();
        // dd($invoice);

        if (isset($request->email)) {
            $invoice = Invoice::with('shipment.equipment_type','shipment.user.company','user.company')->where('id',$invoice->id)->get()->toArray();
            // dd($data1);
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
            $data['shipment'] = $invoice[0]['shipment'];
            
            
            if($invoice[0]['shipment']['user']){
                if($invoice[0]['shipment']['user']['parent_id'] != null){
                    $data['company'] = Company::where('user_id',$invoice[0]['shipment']['user']['parent_id'])->first();
                }else{
                    $data['company'] = Company::where('user_id', $invoice[0]['shipment']['user']['id'])->first();
                }
            }
            
            if($invoice[0]['user']){
                if($invoice[0]['user']['parent_id'] != null){
                    $data['user'] = Company::where('user_id',$invoice[0]['user']['parent_id'])->first();
                }else{
                    $data['user'] = Company::where('user_id', $invoice[0]['user']['id'])->first();
                }
            }

            // dd($data);

            $pdf = PDF::loadView('emails.invoice-email', $data);
            $additionalAttachmentPath = isset($invoice[0]) ? isset($invoice[0]['pdf']) ? asset($invoice[0]['pdf']) : null : null;
            
             Mail::send('emails.invoice-email', $data, function ($message) use ($data, $pdf, $additionalAttachmentPath) {
                    $message->to($data["email"], $data["email"])
                        ->subject($data["customer"])
                        ->attachData($pdf->output(), "Invoice_No_" . $data['invoice_no'] . ".pdf");
        
                    if($additionalAttachmentPath != null){
                        $message->attach($additionalAttachmentPath, [
                            'as' => 'downloadPDF.pdf', 
                            'mime' => 'application/pdf',
                        ]);
                    }
                });
                
        
        
        
            // Mail::send('emails.invoice-email', $data, function ($message) use ($data, $pdf) {
            //     $message->to($data["email"], $data["email"])
            //         ->subject($data["customer"])
            //         ->attachData($pdf->output(), "Invoice_No_" . $data['invoice_no'] . ".pdf");
            // });
            
            
          
            return redirect()->route(auth()->user()->type . '.invoice.index')->with('success', "Invoice Created Successfully And Email Sent");
        } else {
            return redirect()->route(auth()->user()->type . '.invoice.index')->with('success', "Invoice Created Successfully");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::with('shipment.equipment_type','shipment.user.company','user.company')->where('id',$id)->get()->toArray();

        // dd($invoice);
        if(count($invoice) == 0){
            abort(404);
        };

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('Invoices.invoice', compact('invoice'));
        return $pdf->stream('invoice-no-' . $invoice[0]['invoice_no'] . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Invoice::find($id)->delete();
        return back()->with('success', "Invoice Deleted Successfully");
    }
}
