<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\BookingResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validate = $request->validate([
            'search' => 'nullable',
            'limit' => 'nullable',
            'status' => 'nullable',
        ]);

        $user = auth()->user();
        $userBooking = Booking::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('worker_id', $user->id);
        })->get();
        $rows = BookingResource::collection($userBooking);
        return $rows;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $req_data = $request->all();
        $user = auth()->user();
        $req_data['user_id'] = $user->id;

        $validate = Validator::make($req_data, [
            'user_id' => 'required',
            // 'amount' => 'required',
            'date' => 'required',
            'from' => 'required',
            'to' => 'required',
            'contract_file' => 'required',
            'status' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }
        $imageNames = [];
        if ($request->hasFile('contract_file')) {
            foreach ($request->file('contract_file') as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('storage/contract_files');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true); // Create the folder with full permissions
                }
                $file->move($destinationPath, $imageName);
                $imageNames[] = $imageName;
            }
        }
        // Store JN format in the database
        $contractFileJson = json_encode($imageNames);
        $req_data['contract_file'] = $contractFileJson;
        $booking = Booking::create($req_data);
        $row = new BookingResource($booking);
        return response()->json($row, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        $userBooking = Booking::where('user_id', $user->id)->Where('id', $id)->first();
        if ($userBooking) {
            $row = new BookingResource($userBooking);
            return response()->json($row, 200);
        } else {
            return response()->json(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function cancelBooking($id)
    {
        $user = auth()->user();
        $userBooking = Booking::where('user_id', $user->id)->Where('id', $id)->first();
        if ($userBooking) {
            $userBooking->status = 'cancelled';
            $userBooking->save();
            $row = new BookingResource($userBooking);
            return response()->json($row, 200);
        } else {
            return response()->json(404);
        }
    }

    public function bookingStatusUpdate(Request $request, $id)
    {
        $user = auth()->user();
        $userBooking = Booking::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('worker_id', $user->id);
        })->where('id', $id)->first();

        if ($userBooking) {
            if ($request->status == 'completed') {
                $totalCash = $request->total_cash; // e.g., 1000
                $materialCash = $request->material_cash; // e.g., 100
                $paymentType = $request->payment_type;

                $restCash = $totalCash - $materialCash; // Common calculation
                $workerCash = 0;
                $workerMaterialCost = 0;
                $officeCash = 0;
                $totalCharge = 0;

                // Conditional logic based on payment type
                switch ($paymentType) {
                    case 'cash_payment':
                        $workerCash = 0.3 * $restCash; // 30% of rest cash
                        $workerMaterialCost = $workerCash + $materialCash;
                        $officeCash = $totalCash - $workerMaterialCost;
                        break;

                    case 'cash_tva_payment':
                        $tvaPercentage = $request->cash_tva_percentage ?? 19; // Default to 19%
                        $tvaAmount = ($tvaPercentage / 100) * $totalCash; // TVA calculation
                        $totalCharge = $totalCash + $tvaAmount; // Total charge including TVA
                        $restCash = $totalCash - $materialCash; // Cash excluding material cost
                        $workerCash = 0.3 * $restCash; // 30% of rest cash
                        $workerMaterialCost = $workerCash + $materialCash; // Worker total
                        $officeCash = $totalCash - $workerMaterialCost + $tvaAmount; // Office total
                        // Update the booking with calculated values
                        $userBooking->total_charge = $totalCharge; // Add this field if needed
                        break;

                    case 'cash_tax_payment':
                        $taxPercentage = $request->cash_tax_percentage ?? 10; // Default to 10%
                        $taxAmount = ($taxPercentage / 100) * $totalCash; // Tax calculation
                        $restCash = $totalCash - $materialCash - $taxAmount;

                        // Remaining cash after material and tax
                        $workerCash = 0.3 * $restCash; // 30% of the remaining cash

                        $workerMaterialCost = $workerCash + $materialCash; // Worker total
                        $officeCash = $totalCash - $workerMaterialCost; // Office total
                        break;
                    case 'card_tva':
                        $tvaPercentage = $request->cash_tva_percentage ?? 19; // Default to 19%
                        $tvaAmount = ($tvaPercentage / 100) * $totalCash;
                        $workerCash = 0.3 * $restCash; // 30% of rest cash
                        $workerMaterialCost = $workerCash + $materialCash;
                        $officeCash = $totalCash - $workerMaterialCost;
                        // $officeCash = 0; // Salary deducted from another job
                        break;

                    case 'card_tax':
                        $taxPercentage = $request->cash_tax_percentage ?? 10; // Default to 10%
                        $taxAmount = ($taxPercentage / 100) * $totalCash;
                        $restCash = $totalCash - $materialCash - $taxAmount;
                        $workerCash = 0.3 * $restCash; // 30% of the remaining cash after tax
                        $workerMaterialCost = $workerCash + $materialCash;
                        // $officeCash = 0; // Salary deducted from another job
                        $officeCash = $totalCash - $workerMaterialCost;
                        break;

                    default:
                        return response()->json(['message' => 'Invalid payment type'], 400);
                }

                // Update the booking with calculated values
                $userBooking->payment_type = $paymentType;
                $userBooking->total_cash = $totalCash;
                $userBooking->material_cash = $materialCash;
                $userBooking->total_charge  = $totalCharge;
                $userBooking->rest_cash = $restCash;
                $userBooking->worker_cash = $workerCash;
                $userBooking->worker_material_cost = $workerMaterialCost;
                $userBooking->office_cash = $officeCash;
            }
            $imageNames = [];
            if ($request->hasFile('contract_file')) {
                foreach ($request->file('contract_file') as $file) {
                    $imageName = time() . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('storage/contract_files');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true); // Create the folder with full permissions
                    }
                    $file->move($destinationPath, $imageName);
                    $imageNames[] = $imageName;
                }
            }
            $userBooking->contract_file = json_encode($imageNames);
            $userBooking->status = $request->status;
            $userBooking->invoice_number = $request->invoice_number;
            $userBooking->auth_number = $request->auth_number;
            $userBooking->description = $request->description;
            $userBooking->save();
            // Return the updated booking as a resource
            $row = new BookingResource($userBooking);
            return response()->json($row, 200);
        } else {
            // If no matching booking is found, return a 404 response
            return response()->json(['message' => 'Booking not found'], 404);
        }
    }

    public function onlineWorkerStatusUpdate(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'online_status' => 'required|string|in:online,offline',
        ]);
        $user->online_status = $validated['online_status'];
        $user->save();
        $workerCashTotal = Booking::where('worker_id', $user->id)->whereNotNull('worker_cash')->sum('worker_cash');
        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully.',
            'data' => (new UserResource($user))->additional(['worker_cash_total' => $workerCashTotal]),
        ]);
    }

    public function getWorkerJob(Request $request)
    {
        $user = auth()->user(); // Authenticated user

        $request->validate([
            'role' => 'required|in:worker,user',
        ]);

        if ($request->role === 'worker') {
            $bookings = Booking::with(['service'])
                ->where('worker_id', $user->id)
                ->get();
        } else {
            // User-specific bookings
            $bookings = Booking::with(['service'])
                ->where('user_id', $user->id)
                ->get();
        }

        // Transform data using BookingResource
        $rows = BookingResource::collection($bookings);

        return response()->json([
            'status' => 'success',
            'data' => $rows,
        ]);
    }
}
