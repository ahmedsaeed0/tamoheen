<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Lang;

class tripCancel extends Mailable
{
    use Queueable, SerializesModels;

    public $cancellationDate;
    public $tripStartDate;
    public $canceledBy;
    public $trip_start;
    public $trip_end;
    public $brand_name;
    public $driver_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->cancellationDate = $data['cancellationDate'];
        $this->tripStartDate = $data['tripStartDate'];
        $this->canceledBy = $data['canceledBy'];
        $this->trip_start = $data['pick_up'];
        $this->trip_end = $data['drop'];
        $this->brand_name = $data['brand_name'];
        $this->driver_name = $data['driver_name'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (Lang::locale() == 'en'){
            return $this->subject('Trip is cancelled')
            ->view('emails.tripcancel');
        }else{
            return $this->subject('Trip is cancelled')
            ->view('emails.tripcancel_arbic');
        }
        
    }
}
