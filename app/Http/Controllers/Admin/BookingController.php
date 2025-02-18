<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function booking_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $bookings = Booking::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $bookings = $bookings->where(function ($q) use ($search) {
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("email", "LIKE", "%" . $search . "%");
                    $q->orWhere("customer_group", "LIKE", "%" . $search . "%");
                });
            }
            $bookings = $bookings->latest()->get();
            $listing = [];
            foreach ($bookings as $key => $booking) {
                $editButton = '';
                if (auth()->user()->can('edit bookings')) {
                    $editButton = '<a href="' . route('booking.edit', ['id' => $booking->id]) . '" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 wrap-all-style"><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('delete bookings')) {
                    $deleteButton = '<a href="' . route('booking.delete', ['id' => $booking->id]) . '"   data-id="' . $booking->id . '" class="btn main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-5 wrap-all-style"><i class="fa-solid fa-trash"></i>Delete</a>';
                }
                $listing[] = [
                    @$booking->user->name ?? "N/A",
                    $booking->date,
                    $booking->from . "  To " . $booking->to,
                    $booking->description,
                    @$booking->service->title ?? "N/A",
                    $booking->payment_type ?? "N/A",
                    $booking->total_cash ?? "N/A",
                    $booking->material_cash    ?? "N/A",
                    $booking->rest_cash ?? "N/A",
                    $booking->worker_cash ?? "N/A",
                    $booking->office_cash ?? "N/A",
                    $booking->status,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Booking - List';
            $data['meta_desc'] = 'Booking Description';
            $data['keyword'] = '';
            return view('admin.booking.list')->with([
                'data' => $data
            ]);
        }
    }

    public function add_booking(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'user_id'        => 'required',
            ]);
            $booking = Booking::create([
                'user_id' => $request->user_id,
                'service_id' => $request->service_id,
                'address' => $request->address,
                'date' => $request->instance == 1 ? now() : $request->date,
                'from' => $request->from,
                'to' => $request->to,
                'worker_id' => $request->worker_id,
                'instance' => $request->instance,
                'description' => $request->description
            ]);
            if ($booking) {
                return redirect()->route('booking')->with('success', 'Booking added successfully');
            } else {
                return redirect()->route('booking')->with('error', 'Booking went wrong.');
            }
        } else {
            $users = User::select('id', 'name')->get();
            $workers = User::select('id', 'name')->get();
            $services = Service::select('id', 'title')->get();
            $data['title'] = 'Booking - Add';
            $data['meta_desc'] = 'Booking Description';
            $data['keyword'] = '';
            return view('admin.booking.add')->with([
                'data' => $data,
                'users' => $users,
                'services' => $services,
                'workers' => $workers
            ]);
        }
    }

    public function edit_booking(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'user_id'        => 'required',
            ]);
            $booking = Booking::findOrFail($id);
            if ($booking) {
                $booking->user_id = $request->user_id;
                $booking->service_id = $request->service_id;
                $booking->address = $request->address;
                $booking->date = $request->instance == 1 ? now() : $request->date;
                $booking->from = $request->from;
                $booking->to = $request->to;
                $booking->worker_id = $request->worker_id;
                $booking->instance = $request->instance;
                $booking->description = $request->description;
                $booking->save();
                return redirect()->route('booking')->with('success', 'Booking updated successfully');
            } else {
                return redirect()->route('booking')->with('error', 'Booking not found.');
            }
        } else {
            $booking = Booking::findOrFail($id);
            $users = User::select('id', 'name')->get();
            $workers = User::select('id', 'name')->get();
            $services = Service::select('id', 'title')->get();
            $data['title'] = 'Booking - Update';
            $data['meta_desc'] = 'Booking Description';
            $data['keyword'] = '';
            return view('admin.booking.edit')->with([
                'data' => $data,
                'booking' => $booking,
                'users' => $users,
                'services' => $services,
                'workers' => $workers

            ]);
        }
    }

    public function delete_booking($id) {
        $booking = Booking::findOrFail($id);
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found.'
            ], 404);
        }
       $booking->delete();
        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully.'
        ]);
    }
}
