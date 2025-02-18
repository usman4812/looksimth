<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if(method_exists($this->resource, 'getRoleNames')){
            $role = $this->getRoleNames()[0];
        }else{
            $role=null;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'about'=> $this->about,
            // 'image' => $this->image? url('/').'/'.$this->image:null,
            'role'=> $role ,
            'gender'=> $this->gender,
            'status'=> $this->status,
            'device_token'=> $this->device_token,
            'created_at'=> $this->created_at,
            'online_status' => $this->online_status,
            'worker_cash_total' => $this->additional['worker_cash_total'] ?? null,
        ];
    }
}
