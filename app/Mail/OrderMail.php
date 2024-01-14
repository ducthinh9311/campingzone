<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data,$total;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data,$total)
    {
        $this->data = $data;
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        return $this->subject('Đặt hàng thành công')->view('emails.success')->with([
            'data' => $this->data,
            'total' => $this->total,
        ]);
    }
}
