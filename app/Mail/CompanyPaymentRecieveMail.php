<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyPaymentRecieveMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $company;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice, $company)
    {
        $this->invoice = $invoice;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.companypaymentrecieve');
    }
}
