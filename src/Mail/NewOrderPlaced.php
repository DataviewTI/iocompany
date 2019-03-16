<?php

namespace Dataview\IOCompany\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Company;
use Illuminate\Database\Eloquent\Model;

class NewOrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $formData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Array $data)
    {
        $this->data = $data;
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
                    ->view('Company::mail.new-order-placed')->with(['data' => $this->data]);
    }

}
