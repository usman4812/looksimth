<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EhMealPlan;
use App\Models\MealSize;
use App\Models\MealType;
use App\Models\Plan;
use App\Models\PlanType;
use App\Models\PlanVariant;
use App\Models\Setting;
use Illuminate\Http\Request;

class PlansContoller extends Controller
{
    public function plans_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $plans = Plan::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $plans = $plans->where(function ($q) use ($search) {
                    $q->orWhere("title", "LIKE", "%" . $search . "%");
                });
            }
            $plans = $plans->with('planType')->get();
            $listing = [];
            foreach ($plans as $key => $plan) {
                $editButton = '';
                if (auth()->user()->can('edit plans')) {
                    $editButton = '<a href="' . route('admin.plans.edit', ['uuid' => $plan->uuid]) . '" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 wrap-all-style"><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('delete plans')) {
                    $deleteButton = '<a href="' . route('admin.plans.delete', ['uuid' => $plan->uuid]) . '"   data-uuid="' . $plan->uuid . '" class="btn delete-btn main-warning-color btn-active-color-danger btn-sm px-4 me-5 wrap-all-style"><i class="fa-solid fa-trash"></i>Delete</a>';
                }
                $listing[] = [
                    $plan->title,
                    $plan->planType->title,
                    ($plan->is_public == 1) ? '<div class="right-icon-style"><i title="Yes" class="fa-solid fa-check"></i></div>' : '<div class="left-icon-style "><i title="No" class="fa-solid fa-xmark"></i></div>',

                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Plans - List';
            $data['meta_desc'] = 'Plans List Description';
            $data['keyword'] = '';
            return view('admin.pages.plans.list')->with([
                'data' => $data
            ]);
        }
    }
    // Plans Add
    public function add_plan(Request $request)
    {
        if ($request->isMethod('post')) {
            // dd($request->all());
            $request->validate([
                'title' => 'required',
                'unit' => 'required',
                'plan_type_id' => 'required',
            ]);
            $plan = Plan::create([
                'uuid' => generate_uuid_key(),
                'title' => $request->title,
                'unit'  => $request->unit,
                'description' => $request->description,
                'plan_type_id' => $request->plan_type_id,
                'is_public' => $request->is_public,
            ]);
            if ($plan) {
                foreach ($request['plan_variants'] as $variant) {
                    $mealDay = $variant['mealDay'] ?? [];
                    $plan_variant = PlanVariant::create([
                        'uuid' => generate_uuid_key(),
                        'plan_id' => $plan->uuid,
                        'is_public' => $variant['is_public'] ?? null,
                        'quantity' => $variant['quantity'] ?? null,
                        'quantity_min' => $variant['quantity_min'] ?? null,
                        'meal_size_id' => $variant['meal_size_id'] ?? null,
                        'price_per_week' => $variant['price_per_week'] ?? null,
                        'price_per_unit' => $variant['price_per_unit'] ?? null,
                        'num_meals_any' => $variant['num_meals_any'] ?? null,
                        'num_meals_breakfast' => $variant['num_meals_breakfast'] ?? null,
                        'num_meals_lunch' => $variant['num_meals_lunch'] ?? null,
                        'num_meals_dinner' => $variant['num_meals_dinner'] ?? null,
                        'num_meals_lunch_dinner' => $variant['num_meals_lunch_dinner'] ?? null,
                        'prefer_meal_type_id' => $variant['prefer_meal_type_id'] ?? null,
                        'price_per_unit_starting_at' => $variant['price_per_unit_starting_at'] ?? null,
                        'description' => $variant['description'] ?? null,
                        'auto_any_0' => $mealDay['auto_any_0'] ?? null,
                        'auto_any_1' => $mealDay['auto_any_1'] ?? null,
                        'auto_breakfast_0' => $mealDay['auto_breakfast_0'] ?? null,
                        'auto_breakfast_1' => $mealDay['auto_breakfast_1'] ?? null,
                        'auto_lunch_dinner_0' => $mealDay['auto_lunch_dinner_0'] ?? null,
                        'auto_lunch_dinner_1' => $mealDay['auto_lunch_dinner_1'] ?? null,
                    ]);
                }
                return redirect()->route('admin.plans')->with('success', 'Plan Added Successfully.');
            } else {
                return redirect()->route('admin.plans')->with('error', 'Something Went Wrong.');
            }
        } else {
            $mealSizes = MealSize::select('uuid', 'title', 'sort_order', 'servings', 'status')->where('status', 1)->where('servings', 1)->orderBy('sort_order', 'ASC')->get();
            $mealDays = Setting::pluck('meal_days');
            $mealTypes = MealType::select('uuid', 'title', 'status', 'sort_order')->where('status', 1)->orderBy('sort_order', 'ASC')->get();
            $plan_types = PlanType::select('uuid', 'title')->where('status', 1)->get();
            $data['title'] = 'Plans - Add';
            $data['meta_desc'] = 'Plans Add Description';
            $data['keyword'] = '';
            return view('admin.pages.plans.add')->with([
                'data' => $data,
                'mealSizes' => $mealSizes,
                'mealDays' => $mealDays,
                'mealTypes' => $mealTypes,
                'plan_types' => $plan_types,
            ]);
        }
    }

    // Plans Edit
    public function edit_plan(Request $request, $uuid)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required',
                'unit' => 'required',
                'plan_type_id' => 'required',
            ]);
            $editPlan = Plan::where('uuid', $uuid)->first();
            if ($editPlan) {
                $editPlan->title = $request->title;
                $editPlan->unit = $request->unit;
                $editPlan->description = $request->description;
                $editPlan->plan_type_id = $request->plan_type_id;
                $editPlan->is_public = $request->is_public ?? 0;
                $editPlan->save();
            } else {
                return redirect()->route('admin.plans')->with('error', 'Plan Not Found.');
            }
            if ($editPlan) {
                foreach ($request['plan_variants'] as $key => $variant) {
                    $mealDay = $variant['mealDay'] ?? [];
                    if (isset($variant['uuid']) && !empty($variant['uuid'])) {
                        $existingVariant = PlanVariant::where('uuid', $variant['uuid']);
                        $existingVariant->update([
                            'plan_id' => $editPlan->uuid,
                            'is_public' => $variant['is_public'] ?? null,
                            'quantity' => $variant['quantity'] ?? null,
                            'quantity_min' => $variant['quantity_min'] ?? null,
                            'meal_size_id' => $variant['meal_size_id'] ?? null,
                            'price_per_week' => $variant['price_per_week'] ?? null,
                            'price_per_unit' => $variant['price_per_unit'] ?? null,
                            'num_meals_any' => $variant['num_meals_any'] ?? null,
                            'num_meals_breakfast' => $variant['num_meals_breakfast'] ?? null,
                            'num_meals_lunch' => $variant['num_meals_lunch'] ?? null,
                            'num_meals_dinner' => $variant['num_meals_dinner'] ?? null,
                            'num_meals_lunch_dinner' => $variant['num_meals_lunch_dinner'] ?? null,
                            'prefer_meal_type_id' => $variant['prefer_meal_type_id'] ?? null,
                            'price_per_unit_starting_at' => $variant['price_per_unit_starting_at'] ?? null,
                            'description' => $variant['description'] ?? null,
                            'auto_any_0' => $mealDay['auto_any_0'] ?? null,
                            'auto_any_1' => $mealDay['auto_any_1'] ?? null,
                            'auto_breakfast_0' => $mealDay['auto_breakfast_0'] ?? null,
                            'auto_breakfast_1' => $mealDay['auto_breakfast_1'] ?? null,
                            'auto_lunch_dinner_0' => $mealDay['auto_lunch_dinner_0'] ?? null,
                            'auto_lunch_dinner_1' => $mealDay['auto_lunch_dinner_1'] ?? null,
                        ]);
                    } else {
                        PlanVariant::create([
                            'uuid' => generate_uuid_key(),
                            'plan_id' => $editPlan->uuid,
                            'is_public' => $variant['is_public'] ?? null,
                            'quantity' => $variant['quantity'] ?? null,
                            'quantity_min' => $variant['quantity_min'] ?? null,
                            'meal_size_id' => $variant['meal_size_id'] ?? null,
                            'price_per_week' => $variant['price_per_week'] ?? null,
                            'price_per_unit' => $variant['price_per_unit'] ?? null,
                            'num_meals_any' => $variant['num_meals_any'] ?? null,
                            'num_meals_breakfast' => $variant['num_meals_breakfast'] ?? null,
                            'num_meals_lunch' => $variant['num_meals_lunch'] ?? null,
                            'num_meals_dinner' => $variant['num_meals_dinner'] ?? null,
                            'num_meals_lunch_dinner' => $variant['num_meals_lunch_dinner'] ?? null,
                            'prefer_meal_type_id' => $variant['prefer_meal_type_id'] ?? null,
                            'price_per_unit_starting_at' => $variant['price_per_unit_starting_at'] ?? null,
                            'description' => $variant['description'] ?? null,
                            'auto_any_0' => $mealDay['auto_any_0'] ?? null,
                            'auto_any_1' => $mealDay['auto_any_1'] ?? null,
                            'auto_breakfast_0' => $mealDay['auto_breakfast_0'] ?? null,
                            'auto_breakfast_1' => $mealDay['auto_breakfast_1'] ?? null,
                            'auto_lunch_dinner_0' => $mealDay['auto_lunch_dinner_0'] ?? null,
                            'auto_lunch_dinner_1' => $mealDay['auto_lunch_dinner_1'] ?? null,
                        ]);
                    }
                }
                return redirect()->route('admin.plans')->with('success', 'Plan Updated Successfully.');
            }
            return redirect()->route('admin.plans')->with('error', 'Something Went Wrong.');
        } else {
            $plan = Plan::where('uuid', $uuid)->with('planVariants')->first();
            $mealSizes = MealSize::select('uuid', 'title', 'sort_order', 'servings', 'status')->where('status', 1)->where('servings', 1)->orderBy('sort_order', 'ASC')->get();
            $mealDays = Setting::pluck('meal_days');
            $mealTypes = MealType::select('uuid', 'title', 'status', 'sort_order')->where('status', 1)->orderBy('sort_order', 'ASC')->get();
            $plan_types = PlanType::select('uuid', 'title')->where('status', 1)->get();
            $data['title'] = 'Plans - Edit';
            $data['meta_desc'] = 'Plans Edit Description';
            $data['keyword'] = '';
            return view('admin.pages.plans.edit')->with([
                'data' => $data,
                'uuid' => $uuid,
                'mealSizes' => $mealSizes,
                'mealDays' => $mealDays,
                'mealTypes' => $mealTypes,
                'plan' => $plan,
                'plan_types' => $plan_types,
            ]);
        }
    }
    // Delete Plans
    public function delete_plan($uuid)
    {
        $plan = Plan::where('uuid', $uuid)->first();
        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Plan not found.'
            ], 404);
        }
        $plan->delete();
        return response()->json([
            'success' => true,
            'message' => 'Plan deleted successfully.'
        ]);
    }
}
