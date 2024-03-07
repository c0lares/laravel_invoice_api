<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    private array $types =['C' => 'Cartao', 'B' => 'boleto', 'P'=>'Pix'];

    public function toArray(Request $request): array
    {
        return[
            'user' => [
                'fullName' => $this->user->firstName .' '. $this->user->lastName,
                'email' => $this->user->email
            ],
            'type' => $this->types[$this->type],
            'value' => 'R$' . number_format($this->value,2,',','.'),
            'paid' => $this->paid ? 'Pago' :'Nao pago',
            'payment_date' => $this->payment_date
         ];
    }
}
