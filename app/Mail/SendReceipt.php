<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReceipt extends Mailable
{
    use Queueable, SerializesModels;
    public $invoice;
    public $cashTrans;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice, $cashTrans)
    {
        $this->invoice      = $invoice;
        $this->cashTrans    = $cashTrans;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'minipos@me.io';
        $name    = 'Mini Pos';
        $subject = 'Minipos Invoice';


        return $this->view('cashier.cashier_mail_receipt')
                    ->from($address, $name)
                    ->subject($subject);;
    }
}
