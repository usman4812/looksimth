<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditCardType;
use App\Models\Diet;
use App\Models\DiscountType;
use App\Models\EhMealCustomerGroup;
use App\Models\EhMealStatus;
use App\Models\Ingredient;
use App\Models\MealSize;
use App\Models\MealType;
use App\Models\PlanType;
use App\Models\Setting;
use App\Models\Source;
use App\Models\Vendor;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $sidebarCounts;

    public function __construct()
    {
        // Initialize shared sidebar data
        $this->sidebarCounts = [
            'totalMealType' => MealType::count(),
            'totalIngredients' => Ingredient::count(),
            'totalDiets' => Diet::count(),
            'totalMealSize' => MealSize::count(),
            'totalPlanType' => PlanType::count(),
            'totalVendor' => Vendor::count(),
            'totalStatus' => EhMealStatus::count(),
            'totalCustomerGroup' => EhMealCustomerGroup::count(),
            'totalSource' => Source::count(),
            'totalDiscountType' => DiscountType::count(),
            'totalCreditCardType' => CreditCardType::count(),
        ];
    }
    public function setting(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate(
                [
                    'meal_days' => 'required|array|min:0|max:2',
                    'meal_days.*' => 'in:tue,wed,thu,fri,sat,sun',
                ],
                [
                    'meal_days.max' => 'System does not support more than 2 meal days a week, and will require improvements to the meal auto-selector. Contact developer.',
                ]
            );
            $setting = Setting::updateOrCreate(
                ['id' => 1],
                [
                    'meal_days' => implode(',', $request->meal_days),
                    'deadline_day' => $request->deadline_day,
                    'deadline_day_new' => $request->deadline_day_new,
                    'delivery_times' => $request->delivery_times,
                    'delivery_disclaimer' => $request->delivery_disclaimer,
                    'pickup_times' => $request->pickup_times,
                    'pickup_disclaimer' => $request->pickup_disclaimer,
                    'cafe_hours'        => $request->cafe_hours,
                    'pickup_urmc_times' => $request->pickup_urmc_times,
                    'urmc_delivery_disabled' => $request->urmc_delivery_disabled,
                    'urmc_delivery_message' => $request->urmc_delivery_message,
                ]
            );

            if ($setting) {
                return redirect()->route('admin.settings')->with('success', 'Settings updated successfully');
            } else {
                return redirect()->route('admin.settings')->with('error', 'Something went wrong.');
            }
        } else {
            $setting = Setting::first();
            $data['title'] = 'General Setting';
            $data['meta_desc'] = 'Settings Description';
            $data['keyword'] = '';

            return view('admin.pages.setting.general')->with([
                'data' => $data,
                'setting' => $setting
            ] + $this->sidebarCounts);
        }
    }
    // All meals Types
    public function meal_type_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $mealTypes = MealType::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $mealTypes =  $mealTypes->where(function ($q) use ($search) {
                    $q->orWhere("id", "LIKE", "%" . $search . "%");
                    $q->orWhere("title", "LIKE", "%" . $search . "%");
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("sort_order", "LIKE", "%" . $search . "%");
                    $q->orWhere("status", "LIKE", "%" . $search . "%");
                });
            }
            $mealTypes =  $mealTypes->get();
            $listing = [];
            foreach ($mealTypes as $key => $mealType) {
                $editButton = '';
                if (auth()->user()->can('manage settings')) {
                    $editButton = '<a href="javascript:void(0);" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style"
                    data-record="' . htmlspecialchars(json_encode($mealType)) . '" ><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('manage settings')) {
                    $deleteButton = '<a href="' . route('admin.settings.meal.types.delete', $mealType->uuid) . '"
                        class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style">
                        <i class="fa-solid fa-trash"></i>Delete
                     </a>';
                }
                // dd($is_premium->plans->type);
                $mealTypeStatus = '';
                if ($mealType->status == 1) {
                    $mealTypeStatus = '<span class="badge badge-primary badge-style">Active</span>';
                } else {
                    $mealTypeStatus = '<span class="badge badge-danger badge-style">In-active</span>';
                }
                $listing[] = [
                    '<div class="ps-4 d-flex align-items-center">
                    <div class="symbol symbol-86px me-5">
                        <span class="symbol-label bg-light">
                            <img src="' . asset('images/meal_types/' . $mealType->image) . '" style="width:54%; height:45%; object-fit:cover; border-radius:0.475rem;" alt=""php/>
                        </span>
                    </div>
                        <div class="d-flex justify-content-start flex-column">
                        ' . $mealType->title . '
                       </div>
                </div>',
                    $mealType->name,
                    $mealType->sort_order,
                    $mealTypeStatus,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Meals Type';
            $data['meta_desc'] = 'Meals Type Description';
            $data['keyword'] = '';

            return view('admin.pages.setting.meal_type')->with([
                'data' => $data
            ] + $this->sidebarCounts);
        }
    }
    // Add Meal types

    public function add_meal_types(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
            'name' => 'required',
            'sort_order' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|file|mimes:jpeg,jpg,png,webp|max:2048',
            ]);
            $image = $request->file('image');
            $fileName = preg_replace('/\s+/', '_', strtolower($request->name)) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/meal_types');
            $image->move($destinationPath, $fileName);
            $imageName = $fileName;
        }
        $mealType = MealType::create([
            'uuid' => generate_uuid_key(),
            'title' => $request->title,
            'name' => $request->name,
            'sort_order' => $request->sort_order,
            'status' => $request->status,
            'image'  => $imageName ?? '',
        ]);
        return response()->json(['success' => true, 'message' => 'Meal type added successfully.']);
    }

    // update Meals types
    public function update_meal_types(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required|boolean',
            'name' => 'required',
            'sort_order' => 'required',
        ]);
        $mealType = MealType::where('uuid', $request->uuid)->first();
        if ($mealType) {
            $mealType->title = $request->title;
            $mealType->name = $request->name;
            $mealType->sort_order = $request->sort_order;
            $mealType->status = $request->status;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = preg_replace('/\s+/', '_', strtolower($request->name)) . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('images/meal_types');
                if ($mealType->image && file_exists($destinationPath . '/' . $mealType->image)) {
                    unlink($destinationPath . '/' . $mealType->image);
                }
                $image->move($destinationPath, $fileName);
                $mealType->image = $fileName;
            }
            $mealType->save();
            return response()->json([
                'success' => true,
                'message' => 'Meal type updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Meal type not found.',
            ], 404);
        }
    }
    // Delete Meal Type
    public function delete_meal_type($uuid)
    {
        $mealType = MealType::where('uuid', $uuid)->first();
        if (!$mealType) {
            return response()->json([
                'success' => false,
                'message' => 'Meal type not found.'
            ], 404);
        }

        $mealType->delete();
        return response()->json([
            'success' => true,
            'message' => 'Meal type deleted successfully.'
        ]);
    }


    // All Ingredients
    public function ingredient_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $ingredients = Ingredient::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $ingredients =  $ingredients->where(function ($q) use ($search) {
                    $q->orWhere("id", "LIKE", "%" . $search . "%");
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("status", "LIKE", "%" . $search . "%");
                });
            }
            $ingredients =  $ingredients->get();
            $listing = [];
            foreach ($ingredients as $key => $ingredient) {
                $editButton = '';
                if (auth()->user()->can('edit settings')) {
                    $editButton = '<a href="javascript:void(0);" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style"
                     data-record="' . htmlspecialchars(json_encode($ingredient)) . '" ><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('edit settings')) {
                    $deleteButton = '<a href="' . route('admin.settings.ingredient.delete', $ingredient->uuid) . '"
                        class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style">
                        <i class="fa-solid fa-trash"></i>Delete
                     </a>';
                }
                // dd($is_premium->plans->type);
                $ingredientStatus = '';
                if ($ingredient->status == 1) {
                    $ingredientStatus = '<span class="badge badge-primary">Active</span>';
                } else {
                    $ingredientStatus = '<span class="badge badge-danger">In-active</span>';
                }
                $listing[] = [
                    '<div class="ps-4 d-flex align-items-center">
                        <div class="symbol symbol-86px me-5">
                            <span class="symbol-label bg-light">
                                <img src="' . asset('images/ingredients/' . $ingredient->icon) . '" style="width:54%; height:45%; object-fit:cover; border-radius:0.475rem;" />
                            </span>
                        </div>
                            <div class="d-flex justify-content-start flex-column">
                            ' . $ingredient->name . '
                           </div>
                    </div>',
                    $ingredient->sort_order,
                    $ingredientStatus,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Ingredients';
            $data['meta_desc'] = 'Ingredients Description';
            $data['keyword'] = '';

            return view('admin.pages.setting.ingredient')->with([
                'data' => $data
            ] + $this->sidebarCounts);
        }
    }
    // Add Ingredients
    public function add_ingredient(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sort_order' => 'required|integer',
            'status' => 'required',
            'icon' => 'required'
        ]);
        if ($request->hasFile('icon')) {
            $request->validate([
                'icon' => 'required|file|mimes:jpeg,jpg,png,webp|max:2048',
            ]);
            $image = $request->file('icon');
            $fileName = preg_replace('/\s+/', '_', strtolower($request->name)) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/ingredients');
            $image->move($destinationPath, $fileName); // Move the file to the public directory
            $imageName = $fileName;
        }
        $ingredient = Ingredient::create([
            'uuid' => generate_uuid_key(),
            'name' => $request->name,
            'sort_order' => $request->sort_order,
            'status' => $request->status,
            'icon' => $imageName,
        ]);
        return response()->json(['success' => true, 'message' => 'Ingredient added successfully.']);
    }
    // update Ingredients
    public function update_ingredient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'status' => 'required',
        ]);

        $ingredient = Ingredient::where('uuid', $request->uuid)->first();
        if ($ingredient) {
            $ingredient->name = $request->name;
            $ingredient->sort_order = $request->sort_order;
            $ingredient->status = $request->status;
            if ($request->hasFile('icon')) {
                $image = $request->file('icon');
                $fileName = preg_replace('/\s+/', '_', strtolower($request->name)) . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('images/ingredients');

                // Delete the old icon if it exists
                if ($ingredient->icon && file_exists($destinationPath . '/' . $ingredient->icon)) {
                    unlink($destinationPath . '/' . $ingredient->icon);
                }
                $image->move($destinationPath, $fileName);
                $ingredient->icon = $fileName;
            }
            $ingredient->save();
            return response()->json([
                'success' => true,
                'message' => 'Ingredient updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Ingredient not found.',
            ], 404);
        }
    }

    // Delete Ingredient
    public function delete_ingredient($uuid)
    {
        $ingredient = Ingredient::where('uuid', $uuid)->first();
        if (!$ingredient) {
            return response()->json([
                'success' => false,
                'message' => 'Ingredient not found.'
            ], 404);
        }
        $ingredient->delete();
        return response()->json([
            'success' => true,
            'message' => 'Ingredient deleted successfully.'
        ]);
    }

    // All Diets
    public function diets_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $diets = Diet::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $diets = $diets->where(function ($q) use ($search) {
                    $q->orWhere("id", "LIKE", "%" . $search . "%");
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("status", "LIKE", "%" . $search . "%");
                });
            }
            $diets =   $diets->get();
            $listing = [];
            foreach ($diets as $key => $diet) {
                $editButton = '';
                if (auth()->user()->can('edit settings')) {
                    $editButton = '<a href="javascript:void(0);" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style"
                    data-record="' . htmlspecialchars(json_encode($diet)) . '" ><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('edit settings')) {
                    $deleteButton = '<a href="' . route('admin.settings.diets.delete', $diet->uuid) . '"
                        class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style">
                        <i class="fa-solid fa-trash"></i>Delete
                     </a>';
                }
                // dd($is_premium->plans->type);
                $dietStatus = '';
                if ($diet->status == 1) {
                    $dietStatus = '<span class="badge badge-primary">Active</span>';
                } else {
                    $dietStatus = '<span class="badge badge-danger">In-active</span>';
                }
                $listing[] = [
                    $diet->name,
                    $diet->abbr,
                    $diet->sort_order,
                    $diet->description,
                    $dietStatus,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Diets';
            $data['meta_desc'] = 'Diets Description';
            $data['keyword'] = '';

            return view('admin.pages.setting.diet')->with([
                'data' => $data,
            ] + $this->sidebarCounts);
        }
    }

    // Add Diets
    public function add_diet(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'abbr' => 'required',
            'sort_order' => 'required|integer',
            'status' => 'required',
        ]);

        $diet = Diet::create([
            'uuid' => generate_uuid_key(),
            'name' => $request->name,
            'abbr' => $request->abbr,
            'sort_order' => $request->sort_order,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return response()->json(['success' => true, 'message' => 'Diet added successfully.']);
    }

    // Update Diet
    public function update_diet(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'abbr' => 'required',
            'sort_order' => 'required|integer',
            'status' => 'required|boolean',
        ]);
        $diet = Diet::where('uuid', $request->uuid)->first();
        if ($diet) {
            $diet->name = $request->name;
            $diet->abbr = $request->abbr;
            $diet->sort_order = $request->sort_order;
            $diet->description = $request->description;
            $diet->status = $request->status;
            $diet->save();

            return response()->json([
                'success' => true,
                'message' => 'Diet updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Diet not found.',
            ], 404);
        }
    }

    // Delete Diet
    public function delete_diet($uuid)
    {
        $diet = Diet::where('uuid', $uuid)->first();
        if (!$diet) {
            return response()->json([
                'success' => false,
                'message' => 'Diet not found.'
            ], 404);
        }
        $diet->delete();
        return response()->json([
            'success' => true,
            'message' => 'Diet deleted successfully.'
        ]);
    }

    // Meal Size List
    public function meal_size_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $mealSizes = MealSize::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $mealSizes =  $mealSizes->where(function ($q) use ($search) {
                    $q->orWhere("id", "LIKE", "%" . $search . "%");
                    $q->orWhere("title", "LIKE", "%" . $search . "%");
                    $q->orWhere("sort_order", "LIKE", "%" . $search . "%");
                    $q->orWhere("calories_per_day", "LIKE", "%" . $search . "%");
                    $q->orWhere("short_description", "LIKE", "%" . $search . "%");
                    $q->orWhere("servings", "LIKE", "%" . $search . "%");
                    $q->orWhere("protein", "LIKE", "%" . $search . "%");
                    $q->orWhere("sides", "LIKE", "%" . $search . "%");
                });
            }
            $mealSizes =  $mealSizes->get();
            $listing = [];
            foreach ($mealSizes as $key => $mealSize) {
                $editButton = '';
                if (auth()->user()->can('manage settings')) {
                    $editButton = '<a href="javascript:void(0);" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style"
                    data-record="' . htmlspecialchars(json_encode($mealSize)) . '" ><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('manage settings')) {
                    $deleteButton = '<a href="' . route('admin.settings.meal.size.delete', $mealSize->uuid) . '"
                        class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style">
                        <i class="fa-solid fa-trash"></i>Delete
                     </a>';
                }
                $mealSizeStatus = '';
                if ($mealSize->status == 1) {
                    $mealSizeStatus = '<span class="badge badge-primary">Active</span>';
                } else {
                    $mealSizeStatus = '<span class="badge badge-danger">In-active</span>';
                }
                $listing[] = [
                    $mealSize->title,
                    $mealSize->sort_order,
                    $mealSize->description,
                    $mealSize->short_description,
                    $mealSize->calories_per_day,
                    $mealSize->servings,
                    $mealSize->protein,
                    $mealSize->sides,
                    $mealSizeStatus,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Meals Size';
            $data['meta_desc'] = 'Meals Size Description';
            $data['keyword'] = '';

            return view('admin.pages.setting.meal_size')->with([
                'data' => $data
            ] + $this->sidebarCounts);
        }
    }
    // Add Meal Size
    public function add_meal_size(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'sort_order' => 'required|integer',
            'status' => 'required',
        ]);
        $mealSize = MealSize::create([
            'uuid' => generate_uuid_key(),
            'title' => $request->title,
            'sort_order' => $request->sort_order,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'calories_per_day' => $request->calories_per_day,
            'servings' => $request->servings,
            'protein' => $request->protein,
            'sides' => $request->sides,
            'status' => $request->status,
        ]);
        return response()->json(['success' => true, 'message' => 'Meal Size added successfully.']);
    }
    // Update Meal Size
    public function update_meal_size(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'sort_order' => 'required|integer',
            'status' => 'required',
        ]);
        $mealSize = MealSize::where('uuid', $request->uuid)->first();
        if ($mealSize) {
            $mealSize->title = $request->title;
            $mealSize->sort_order = $request->sort_order;
            $mealSize->description = $request->description;
            $mealSize->short_description = $request->short_description;
            $mealSize->calories_per_day = $request->calories_per_day;
            $mealSize->servings = $request->servings;
            $mealSize->protein = $request->protein;
            $mealSize->sides = $request->sides;
            $mealSize->status = $request->status;
            $mealSize->save();

            return response()->json([
                'success' => true,
                'message' => 'Meal Size updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Meal Size not found.',
            ], 404);
        }
    }
    // Delete Meal Size
    public function delete_meal_size($uuid)
    {
        $mealSize = MealSize::where('uuid', $uuid)->first();
        if (!$mealSize) {
            return response()->json([
                'success' => false,
                'message' => 'Meal Size not found.'
            ], 404);
        }
        $mealSize->delete();
        return response()->json([
            'success' => true,
            'message' => 'Meal Size deleted successfully.'
        ]);
    }

    // Plan Type List
    public function plan_types_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $plantypes = PlanType::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $plantypes = $plantypes->where(function ($q) use ($search) {
                    $q->orWhere("id", "LIKE", "%" . $search . "%");
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("title", "LIKE", "%" . $search . "%");
                    $q->orWhere("sort_order", "LIKE", "%" . $search . "%");
                    $q->orWhere("status", "LIKE", "%" . $search . "%");
                });
            }
            $plantypes =   $plantypes->get();
            $listing = [];
            foreach ($plantypes as $key => $plantype) {
                $editButton = '';
                if (auth()->user()->can('edit settings')) {
                    $editButton = '<a href="javascript:void(0);" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style"
                    data-record="' . htmlspecialchars(json_encode($plantype)) . '" ><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('edit settings')) {
                    $deleteButton = '<a href="' . route('admin.settings.plan.types.delete', $plantype->uuid) . '"
                        class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style">
                        <i class="fa-solid fa-trash"></i>Delete
                     </a>';
                }
                // dd($is_premium->plans->type);
                $planTypeStatus = '';
                if ($plantype->status == 1) {
                    $planTypeStatus = '<span class="badge badge-primary">Active</span>';
                } else {
                    $planTypeStatus = '<span class="badge badge-danger">In-active</span>';
                }
                $listing[] = [
                    $plantype->name,
                    $plantype->title,
                    $plantype->description,
                    $plantype->sort_order,
                    $plantype->is_public,
                    $planTypeStatus,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Plan Type';
            $data['meta_desc'] = 'Plan Type Description';
            $data['keyword'] = '';

            return view('admin.pages.setting.plan_type')->with([
                'data' => $data
            ] + $this->sidebarCounts);
        }
    }
    // Plan Types Add
    public function add_plan_type(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'sort_order' => 'required|integer',
            'status' => 'required',
        ]);
        $plantype = PlanType::create([
            'uuid' => generate_uuid_key(),
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order,
            'status' => $request->status,
            'is_public' => $request->is_public,
        ]);
        return response()->json(['success' => true, 'message' => 'Plan Type added successfully.']);
    }

    // Update Plan Type
    public function update_plan_types(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'sort_order' => 'required|integer',
            'status' => 'required',
        ]);
        $planType = PlanType::where('uuid', $request->uuid)->first();
        if ($planType) {
            $planType->name = $request->name;
            $planType->title = $request->title;
            $planType->description = $request->description;
            $planType->sort_order = $request->sort_order;
            $planType->status = $request->status;
            $planType->is_public = $request->is_public;
            $planType->save();
            return response()->json([
                'success' => true,
                'message' => 'Plan Type updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Plan Type not found.',
            ], 404);
        }
    }
    // Delete Plan Type
    public function delete_plan_types($uuid)
    {
        $planType = PlanType::where('uuid', $uuid)->first();
        if (!$planType) {
            return response()->json([
                'success' => false,
                'message' => 'Plan Type not found.'
            ], 404);
        }
        $planType->delete();
        return response()->json([
            'success' => true,
            'message' => 'Plan Type deleted successfully.'
        ]);
    }

    // Vendor list
    public function vendor_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $vendors = Vendor::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $vendors = $vendors->where(function ($q) use ($search) {
                    $q->orWhere("id", "LIKE", "%" . $search . "%");
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("status", "LIKE", "%" . $search . "%");
                });
            }
            $vendors =   $vendors->get();
            $listing = [];
            foreach ($vendors as $key => $vendor) {
                $editButton = '';
                if (auth()->user()->can('edit settings')) {
                    $editButton = '<a href="javascript:void(0);" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style"
                        data-record="' . htmlspecialchars(json_encode($vendor)) . '" ><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('edit settings')) {
                    $deleteButton = '<a href="' . route('admin.settings.vendors.delete', $vendor->uuid) . '"
                            class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style">
                        <i class="fa-solid fa-trash"></i>Delete
                         </a>';
                }
                // dd($is_premium->plans->type);
                $vendorStatus = '';
                if ($vendor->status == 1) {
                    $vendorStatus = '<span class="badge badge-primary">Active</span>';
                } else {
                    $vendorStatus = '<span class="badge badge-danger">In-active</span>';
                }
                $listing[] = [
                    $vendor->name,
                    $vendor->description,
                    $vendorStatus,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Vendor';
            $data['meta_desc'] = 'Vendor Description';
            $data['keyword'] = '';

            return view('admin.pages.setting.vendor')->with([
                'data' => $data
            ] + $this->sidebarCounts);
        }
    }
    // Add Vendor
    public function add_vendor(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);
        $vendor = Vendor::create([
            'uuid' => generate_uuid_key(),
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return response()->json(['success' => true, 'message' => 'Vendor added successfully.']);
    }
    // Update Vendor
    public function update_vendor(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);
        $vendor = Vendor::where('uuid', $request->uuid)->first();
        if ($vendor) {
            $vendor->name = $request->name;
            $vendor->description = $request->description;
            $vendor->status = $request->status;
            $vendor->save();
            return response()->json([
                'success' => true,
                'message' => 'Vendor updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Vendor not found.',
            ], 404);
        }
    }
    // Delete Vendor
    public function delete_vendor($uuid)
    {
        $vendor = Vendor::where('uuid', $uuid)->first();
        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor not found.'
            ], 404);
        }
        $vendor->delete();
        return response()->json([
            'success' => true,
            'message' => 'Vendor deleted successfully.'
        ]);
    }


    // Status List
    public function status_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $mealStatus = EhMealStatus::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $mealStatus =  $mealStatus->where(function ($q) use ($search) {
                    $q->orWhere("id", "LIKE", "%" . $search . "%");
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("sort_order", "LIKE", "%" . $search . "%");
                });
            }
            $mealStatus =   $mealStatus->get();
            $listing = [];
            foreach ($mealStatus as $key => $status) {
                $editButton = '';
                if (auth()->user()->can('manage settings')) {
                    $editButton = '<a href="javascript:void(0);" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style"
                    data-record="' . htmlspecialchars(json_encode($status)) . '" ><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('manage settings')) {
                    $deleteButton = '<a href="' . route('admin.settings.status.delete', $status->uuid) . '"
                        class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style">
                        <i class="fa-solid fa-trash"></i>Delete
                     </a>';
                }
                $listing[] = [
                    '<div class="ps-4 d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                        ' . $status->name . '
                       </div>
                </div>',
                    // $status->title,
                    $status->type,
                    $status->sort_order,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Status';
            $data['meta_desc'] = 'Status Description';
            $data['keyword'] = '';

            return view('admin.pages.setting.status')->with([
                'data' => $data
            ] + $this->sidebarCounts);
        }
    }
    // Add Status
    public function add_status(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'sort_order' => 'required',
        ]);
        $status = EhMealStatus::create([
            'uuid' => generate_uuid_key(),
            'name' => $request->name,
            'type' => $request->type,
            'sort_order' => $request->sort_order,
        ]);
        return response()->json(['success' => true, 'message' => 'Status added successfully.']);
    }

    // Update Status
    public function update_status(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'sort_order' => 'required',
        ]);
        $status = EhMealStatus::where('uuid', $request->uuid)->first();
        if ($status) {
            $status->name = $request->name;
            $status->type = $request->type;
            $status->sort_order = $request->sort_order;
            $status->save();
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Status not found.',
            ], 404);
        }
    }
    // Delete Status
    public function delete_status($uuid)
    {
        $status = EhMealStatus::where('uuid', $uuid)->first();
        if (!$status) {
            return response()->json([
                'success' => false,
                'message' => 'Status not found.'
            ], 404);
        }
        $status->delete();
        return response()->json([
            'success' => true,
            'message' => 'Status deleted successfully.'
        ]);
    }
    // Customer Group List
    public function customer_group_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $customerGroups = EhMealCustomerGroup::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $customerGroups =  $customerGroups->where(function ($q) use ($search) {
                    $q->orWhere("id", "LIKE", "%" . $search . "%");
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("sort_order", "LIKE", "%" . $search . "%");
                });
            }
            $customerGroups =   $customerGroups->get();
            $listing = [];
            foreach ($customerGroups as $key => $customerGroup) {
                $editButton = '';
                if (auth()->user()->can('manage settings')) {
                    $editButton = '<a href="javascript:void(0);" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style"
                    data-record="' . htmlspecialchars(json_encode($customerGroup)) . '" ><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('manage settings')) {
                    $deleteButton = '<a href="' . route('admin.settings.customer.group.delete', $customerGroup->uuid) . '"
                        class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style">
                        <i class="fa-solid fa-trash"></i>Delete
                     </a>';
                }
                $customerGroupStatus = '';
                if ($customerGroup->status == 1) {
                    $customerGroupStatus = '<span class="badge badge-primary">Active</span>';
                } else {
                    $customerGroupStatus = '<span class="badge badge-danger">In-active</span>';
                }
                $listing[] = [
                    $customerGroup->name,
                    $customerGroupStatus,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Customer Group';
            $data['meta_desc'] = 'Customer Group Description';
            $data['keyword'] = '';

            return view('admin.pages.setting.customer_group')->with([
                'data' => $data
            ] + $this->sidebarCounts);
        }
    }

    // Customer Group Add
    public function add_customer_group(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);
        $customerGroup = EhMealCustomerGroup::create([
            'uuid' => generate_uuid_key(),
            'name' => $request->name,
            'status' => $request->status,
        ]);
        return response()->json(['success' => true, 'message' => 'Customer Group added successfully.']);
    }
    public function update_customer_group(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);
        $editCustomerGroup = EhMealCustomerGroup::where('uuid', $request->uuid)->first();
        if ($editCustomerGroup) {
            $editCustomerGroup->name = $request->name;
            $editCustomerGroup->status = $request->status;
            $editCustomerGroup->save();
            return response()->json([
                'success' => true,
                'message' => 'Customer Group updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Customer Group not found.',
            ], 404);
        }
    }
    public function delete_customer_group($uuid)
    {
        $customerGroup = EhMealCustomerGroup::where('uuid', $uuid)->first();
        if (!$customerGroup) {
            return response()->json([
                'success' => false,
                'message' => 'Customer Group not found.'
            ], 404);
        }
        $customerGroup->delete();
        return response()->json([
            'success' => true,
            'message' => 'Customer Group deleted successfully.'
        ]);
    }

    // Source List
    public function source_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $sources = Source::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $sources =  $sources->where(function ($q) use ($search) {
                    $q->orWhere("id", "LIKE", "%" . $search . "%");
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("sort_order", "LIKE", "%" . $search . "%");
                });
            }
            $sources = $sources->get();
            $listing = [];
            foreach ($sources as $key => $source) {
                $editButton = '';
                if (auth()->user()->can('manage settings')) {
                    $editButton = '<a href="javascript:void(0);" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style"
                    data-record="' . htmlspecialchars(json_encode($source)) . '" ><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('manage settings')) {
                    $deleteButton = '<a href="' . route('admin.settings.source.delete', $source->uuid) . '"
                        class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style">
                        <i class="fa-solid fa-trash"></i>Delete
                     </a>';
                }
                $sourceStatus = '';
                if ($source->status == 1) {
                    $sourceStatus = '<span class="badge badge-primary">Active</span>';
                } else {
                    $sourceStatus = '<span class="badge badge-danger">In-active</span>';
                }
                $listing[] = [
                    $source->name,
                    $sourceStatus,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Source';
            $data['meta_desc'] = 'Source Description';
            $data['keyword'] = '';

            return view('admin.pages.setting.source')->with([
                'data' => $data
            ] + $this->sidebarCounts);
        }
    }

    // Add Source 
    public function add_source(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);
        $source = Source::create([
            'uuid' => generate_uuid_key(),
            'name' => $request->name,
            'status' => $request->status,
        ]);
        return response()->json(['success' => true, 'message' => 'Source added successfully.']);
    }
    // Update Source
    public function update_source(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);
        $editSource = Source::where('uuid', $request->uuid)->first();
        if ($editSource) {
            $editSource->name = $request->name;
            $editSource->status = $request->status;
            $editSource->save();
            return response()->json([
                'success' => true,
                'message' => 'Source updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Source not found.',
            ], 404);
        }
    }
    // Delete Source
    public function delete_source($uuid)
    {
        $source = Source::where('uuid', $uuid)->first();
        if (!$source) {
            return response()->json([
                'success' => false,
                'message' => 'Source not found.'
            ], 404);
        }
        $source->delete();
        return response()->json([
            'success' => true,
            'message' => 'Source deleted successfully.'
        ]);
    }

    // Discount Type List
    public function discount_type_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $discount_types = DiscountType::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $discount_types =  $discount_types->where(function ($q) use ($search) {
                    $q->orWhere("id", "LIKE", "%" . $search . "%");
                    $q->orWhere("title", "LIKE", "%" . $search . "%");
                    $q->orWhere("status", "LIKE", "%" . $search . "%");
                });
            }
            $discount_types = $discount_types->get();
            $listing = [];
            foreach ($discount_types as $key => $type) {
                $editButton = '';
                if (auth()->user()->can('manage settings')) {
                    $editButton = '<a href="javascript:void(0);" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style"
                    data-record="' . htmlspecialchars(json_encode($type)) . '" ><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('manage settings')) {
                    $deleteButton = '<a href="' . route('admin.settings.discount.type.delete', $type->uuid) . '"
                        class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style">
                        <i class="fa-solid fa-trash"></i>Delete</a>';
                }
                $discountTypeStatus = '';
                if ($type->status == 1) {
                    $discountTypeStatus = '<span class="badge badge-primary">Active</span>';
                } else {
                    $discountTypeStatus = '<span class="badge badge-danger">In-active</span>';
                }
                $listing[] = [
                    $type->title,
                    $discountTypeStatus,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Discount Type List';
            $data['meta_desc'] = 'Discount Type Description';
            $data['keyword'] = '';

            return view('admin.pages.setting.discount_type')->with([
                'data' => $data
            ] + $this->sidebarCounts);
        }
    }
    // Discount Type Add
    public function add_discount_type(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $discount_type = DiscountType::create([
            'uuid' => generate_uuid_key(),
            'title' => $request->title,
            'status' => $request->status,
        ]);
        return response()->json(['success' => true, 'message' => 'Discount Type added successfully.']);
    }

    // Discount Type Update
    public function update_discount_type(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $discount_type = DiscountType::where('uuid', $request->uuid)->first();
        if ($discount_type) {
            $discount_type->title = $request->title;
            $discount_type->status = $request->status;
            $discount_type->save();
            return response()->json([
                'success' => true,
                'message' => 'Discount Type updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Discount Type not found.',
            ], 404);
        }
    }
    // Discount Type Delete
    public function delete_discount_type($uuid)
    {
        $discount_type = DiscountType::where('uuid', $uuid)->first();
        if (!$discount_type) {
            return response()->json([
                'success' => false,
                'message' => 'Discount Type not found.'
            ], 404);
        }
        $discount_type->delete();
        return response()->json([
            'success' => true,
            'message' => 'Discount Type deleted successfully.'
        ]);
    }

    // Credit Card Type List
    public function credit_card_type_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $card_types = CreditCardType::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $card_types =  $card_types->where(function ($q) use ($search) {
                    $q->orWhere("id", "LIKE", "%" . $search . "%");
                    $q->orWhere("title", "LIKE", "%" . $search . "%");
                    $q->orWhere("status", "LIKE", "%" . $search . "%");
                });
            }
            $card_types = $card_types->get();
            $listing = [];
            foreach ($card_types as $key => $type) {
                $editButton = '';
                if (auth()->user()->can('manage settings')) {
                    $editButton = '<a href="javascript:void(0);" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style"
                    data-record="' . htmlspecialchars(json_encode($type)) . '" ><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('manage settings')) {
                    $deleteButton = '<a href="' . route('admin.settings.credit.card.type.delete', $type->uuid) . '"
                        class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style">
                        <i class="fa-solid fa-trash"></i>Delete</a>';
                }
                $cardTypeStatus = '';
                if ($type->status == 1) {
                    $cardTypeStatus = '<span class="badge badge-primary">Active</span>';
                } else {
                    $cardTypeStatus = '<span class="badge badge-danger">In-active</span>';
                }
                $listing[] = [
                    $type->title,
                    $cardTypeStatus,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Credit Card Type List';
            $data['meta_desc'] = 'Credit Card Type Description';
            $data['keyword'] = '';

            return view('admin.pages.setting.credit_card_types')->with([
                'data' => $data
            ] + $this->sidebarCounts);
        }
    }
    // Credit Card Type Add
    public function add_credit_card_type(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $credit_card_type = CreditCardType::create([
            'uuid' => generate_uuid_key(),
            'title' => $request->title,
            'status' => $request->status,
        ]);
        return response()->json(['success' => true, 'message' => 'Credit Card Type added successfully.']);
    }
    // Credit Card Type Edit
    public function update_credit_card_type(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $card_type = CreditCardType::where('uuid', $request->uuid)->first();
        if ($card_type) {
            $card_type->title = $request->title;
            $card_type->status = $request->status;
            $card_type->save();
            return response()->json([
                'success' => true,
                'message' => 'Credit Card Type updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Credit Card Type not found.',
            ], 404);
        }
    }

    // Credit Card Type Delete
    public function delete_credit_card_type($uuid)
    {
        $card_type = CreditCardType::where('uuid', $uuid)->first();
        if (!$card_type) {
            return response()->json([
                'success' => false,
                'message' => 'Credit Card Type not found.'
            ], 404);
        }
        $card_type->delete();
        return response()->json([
            'success' => true,
            'message' => 'Credit Card Type deleted successfully.'
        ]);
    }
}
