<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Facturacion extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * The file path of the attachment.
     *
     * @var string
     */
    protected $attachmentPath;    
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($attachmentPath)
    {
        //
        $this->attachmentPath = $attachmentPath;
    }


    /**
     * enviar factura
     * adjunta archivo XML  y link para descargar PDF 
     * @return $this
     */
    public function build()
    {
        $uuid = $this->attachmentPath;
        // return $this->view('mails.sendEmailWithAttachment', compact('uuid') );
        $basePath = storage_path('facturas/');
        return $this->view('mails.facturacion', compact('uuid'))->attach($basePath.$this->attachmentPath.'.xml');
    }


    
} // class