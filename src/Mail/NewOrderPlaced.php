<?php

namespace Dataview\IOCompany\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Company;

class NewOrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $formData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Array $order)
    {
        $order['wirecard_data'] = json_decode($order['wirecard_data']);
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contato@palmjob.com.br', 'PalmJob')
                    ->subject('Pagamento da sua assinatura Palmjob')
                    ->view('Company::mail.new-order-placed')->with(['order' => $this->order]);
    }
}
