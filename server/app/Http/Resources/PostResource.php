<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    // membuat properti baru untuk variable status dan message
    public $status;
    public $message;

    /**
     * __construct
     *
     * @param mixed $status
     * @param mixed $message
     * @param mixed $resource
     * @return void
     */

    // membuat methode baru dengan jenis _construct,
    // fungsi ini akan dipanggil pertama kali dijalankan ketika class PostResource dipanggil
    // didalam terdapat 3 variabel status, message, dan resource
    public function __construct($status, $message,  $resource)
    {
        // variabel $resource merupakan data yang akan ditransformasi. Ini merupakan data model yang dikirim dari controller
        parent::__construct($resource);

        // varibel $status merupakan properti yang isinya data boolean yaitu true dan false
        $this->status = $status;

        // varibel $message merupakan properti yang isinya berupa pesan tentang hasil yang dibuat.
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     * 
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->resource
        ];
    }
}
