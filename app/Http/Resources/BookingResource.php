<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => $this->user ? [
                'name' => $this->user->name,
                'role' => $this->user->getRoleNames()[0] ?? null
            ] : null,

            'worker_id' => $this->worker_id,
            'worker' => $this->worker ? [
                'name' => $this->worker->name,
                'email' => $this->worker->email,
                'phone' => $this->worker->phone,
            ] : null,
            'total' => $this->total,
            'date' => $this->date,
            'from' => $this->from,
            'to' => $this->to,
            'description' => $this->description,
            'contract_file' => $this->getContractFileUrls(),
            'status' => $this->status,
            'warranty_date' => $this->warranty_date,
            'invoice_number' => $this->invoice_number,
            'auth_number' => $this->auth_number,
            'description' => $this->description,
            'payment_type' => $this->payment_type,
            'total_cash' => $this->total_cash,
            'material_cash' => $this->material_cash,
            'total_charge' => $this->total_charge,
            'rest_cash' => $this->rest_cash,
            'worker_cash' => $this->worker_cash,
            'worker_material_cost' => $this->worker_material_cost,
            'office_cash' => $this->office_cash,
            'created_at' => $this->created_at,
            "service"    => new ServiceResource($this->service),
        ];
    }

    private function getContractFileUrls()
    {
        // Decode the JSON contract_file attribute into an array
        $files = json_decode($this->contract_file, true) ?? [];

        // Generate full URLs for each file
        return array_map(function ($file) {
            return asset('storage/contract_files/' . $file);
        }, (array) $files);
    }
}
