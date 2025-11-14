<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'member' => $this->member->name,
            'book' => $this->book->title,
            'loan_date' => $this->loan_date,
            'return_date' => $this->return_date,
        ];
    }
}
