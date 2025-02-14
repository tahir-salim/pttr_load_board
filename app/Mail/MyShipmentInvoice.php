<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MyShipmentInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        //
         $this->details = $data;
    }

    public function build()
    {

        // return $this->view('view.name');
        return $this->subject('PTTR LOADBOARD Shipment Invoice')
                    ->view('emails.myShipmentInvoice');
    }
 
}


// namespace App\Mail;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;
// use Illuminate\Queue\SerializesModels;

// class MyShipmentStatusMail extends Mailable
// {
//     use Queueable, SerializesModels;

//     public $details;
//     /**
//      * Create a new message instance.
//      */
//     public function __construct($data)
//     {
//         //

//         $this->details = $data;

//     }
//     /**
//      * Build the message.
//      *
//      * @return $this
//      */

//     public function build()
//     {

//         // return $this->view('view.name');
//         return $this->subject('PTTR LOADBOARD New Update')
//                     ->view('emails.myshipmentStatus');
//     }
// }
