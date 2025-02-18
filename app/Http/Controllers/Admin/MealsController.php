<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diet;
use App\Models\EhMealDiet;
use App\Models\EhMealFile;
use App\Models\EhMealIngredient;
use App\Models\EhNutritionFacts;
use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\MealSize;
use App\Models\MealType;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MealsController extends Controller
{
    public function meals_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $meals = Meal::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $meals = $meals->where(function ($q) use ($search) {
                    $q->orWhere("title", "LIKE", "%" . $search . "%");
                    $q->orWhere("description", "LIKE", "%" . $search . "%");
                });
            }
            $meals = $meals->with('mealType', 'mealDiets', 'vendorDetails', 'mediaGallery')->get();
            $listing = [];
            foreach ($meals as $key => $meal) {
                $editButton = '';
                if (auth()->user()->can('edit meals')) {
                    $editButton = '<a href="' . route('admin.meals.edit', ['uuid' => $meal->uuid]) . '" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 wrap-all-style"><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('delete meals')) {
                    $deleteButton = '<a href="' . route('admin.meals.delete', ['uuid' => $meal->uuid]) . '"   data-uuid="' . $meal->uuid . '" class="btn delete-btn main-warning-color btn-active-color-danger btn-sm px-4 me-5 wrap-all-style"><i class="fa-solid fa-trash"></i>Delete</a>';
                }
                $diets = '';
                $cntr = 0;
                foreach ($meal->mealDiets as $key => $diet) {
                    $diets .= '<span class="fam" style="background-color: ' . getRandomLightColor($cntr) . ';" title="' . $diet->dietDetails->name . '">' . $diet->dietDetails->name . '</span>';
                    $cntr++;
                }

                $gallery = $meal->mediaGallery->pluck('file');
                foreach ($gallery as $key => $file) {
                    $gallery[$key] = asset('storage/public/web_assets/media/meals/' . $meal->uuid . '/' . $file);
                }
                $galleryBtn = '';
                if (count($gallery) > 0) {
                    $galleryBtn = '<a data-gallery="' . htmlspecialchars(json_encode($gallery)) . '" class="btn view-gallery main-gallery-color btn-active-color-gallery btn-sm px-4 me-2 wrap-all-style"><i class="fa-solid fa-camera"></i>Gallery</a>';
                }
                $listing[] = [
                    '<div class="d-flex align-items-center justify-content-center">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-light">
                                <img src="' . asset('storage/public/web_assets/media/meals/' . $meal->uuid . '/' . $meal->image) . '"
                                   style="width:100%; height:100%;" alt="Meals Image"/>
                            </span>
                        </div>
                    </div>',
                    '<div class="meal_title">' . $meal->title . '</div>
                    <div class="meal_description mt-3">' . Str::limit($meal->description, 200) . '</div>
                    <div class="nutrition_facts mt-3">
                      470 kcal, 16g fat, 52g carb, 6g fiber, 21g protein, 490mg sodium
                    </div>
                    <div class="meal_labels mt-3">' . $diets . '</div>',
                    $meal->mealType->title,
                    $meal->vendorDetails->name,
                    "$ " . $meal->price,
                    ($meal->is_featured == 1) ? '<div class="right-icon-style"><i title="Yes" class="fa-solid fa-check"></i></div>' : '<div class="left-icon-style "><i title="No" class="fa-solid fa-xmark"></i></div>',
                    ($meal->is_autoselectable == 1) ? '<div class="right-icon-style"><i title="Yes" class="fa-solid fa-check"></i></div>' : '<div class="left-icon-style "><i title="No" class="fa-solid fa-xmark"></i></div>',
                    $galleryBtn . " " . $editButton . " " . $deleteButton

                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Meals List';
            $data['meta_desc'] = 'Meals Description';
            $data['keyword'] = '';
            return view('admin.pages.meals.list')->with([
                'data' => $data,
            ]);
        }
    }

    //  Add Meals
    public function add_meals(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'uuid' => 'required|string',
                'vendor_id' => 'required|string',
                'title' => 'required|string',
                'family_style' => 'required|integer',
                'meal_type_id' => 'required|string',
                // 'price' => 'required|string',
                'medicaid' => 'required|integer',
                'cafeteria' => 'required|integer',
                'ingredients' => 'required|array',
                'ingredients.*' => 'required|string',
                'diets' => 'required|array',
                'diets.*' => 'required|string',
                'image' => 'required|file|mimes:jpeg,jpg,png,webp'
            ]);

            $imageName = "";
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . "_" . $image->getClientOriginalName();
                $filePath  = $image->storeAs('public/web_assets/media/meals/' . $request->uuid, $fileName, 'public');
                $imageName = basename($filePath);
            }
            $mealAdd = Meal::create([
                'uuid' => $request->uuid,
                'title' => $request->title,
                'description' => $request->description,
                'meal_type_id' => $request->meal_type_id,
                'image' => $imageName,
                'family_style' => $request->family_style,
                'price' => $request->price,
                'vendor_id' => $request->vendor_id,
                'is_featured' => $request->is_featured,
                'medicaid' => $request->medicaid,
                'cafeteria' => $request->cafeteria,
                'is_autoselectable' => $request->is_autoselectable,
            ]);
            if ($mealAdd) {
                $assignMedia = EhMealFile::where('meal_id', $request->uuid)->update([
                    'assigned' => 1
                ]);
                $data = array_map(function ($diet) use ($request) {
                    return [
                        'uuid' => generate_uuid_key(),
                        'meal_id' => $request->uuid,
                        'diet_id' => $diet
                    ];
                }, $request->diets);
                $mealIngredients = EhMealDiet::insert($data);

                $dataIng = array_map(function ($ingredient) use ($request) {
                    return [
                        'uuid' => generate_uuid_key(),
                        'meal_id' => $request->uuid,
                        'ingredient_id' => $ingredient
                    ];
                }, $request->ingredients);
                $mealIngredients = EhMealIngredient::insert($dataIng);

                $nutritionFactsData = [];

                foreach ($request->meal['nutrition_facts_attributes'] as $nutrient) {
                    $nutritionFactsData[] = [
                        'uuid' => generate_uuid_key(),
                        'meal_id' => $request->uuid,
                        'meal_size_id' => $nutrient['meal_size_id'] ?? 0,
                        'calories' => $nutrient['calories'] ?? 0,
                        'fat' => $nutrient['fat'] ?? 0,
                        'carb' => $nutrient['carb'] ?? 0,
                        'fiber' => $nutrient['fiber'] ?? 0,
                        'protein' => $nutrient['protein'] ?? 0,
                        'sodium' => $nutrient['sodium'] ?? 0,
                    ];
                    $addNutrient = EhNutritionFacts::insert($nutritionFactsData);
                }
                // For Ajax Requests
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Meal Added Successfully'
                    ]);
                }
                return to_route('admin.meals')->with('success', 'Meal Added Successfully.');
            } else {
                return to_route('admin.meals')->with('error', 'Something Went Worng.');
            }
        } else {
            $mealTypes = MealType::select('uuid', 'title', 'status', 'sort_order')->where('status', 1)->orderBy('sort_order', 'ASC')->get();
            $ingredients = Ingredient::select('uuid', 'name', 'sort_order', 'status')->where('status', 1)->orderBy('sort_order', 'ASC')->get();
            $diets = Diet::select('uuid', 'name', 'sort_order', 'status')->where('status', 1)->orderBy('sort_order', 'ASC')->get();
            $mealSizes = MealSize::select('uuid', 'title', 'sort_order', 'servings', 'status')->where('status', 1)->where('servings', 1)->orderBy('sort_order', 'ASC')->get();
            $vendors = Vendor::select('uuid', 'name', 'status')->where('status', 1)->get();
            $data['title'] = 'Add Meals';
            $data['meta_desc'] = 'Add Meals Description';
            $data['keyword'] = '';
            return view('admin.pages.meals.add')->with([
                'data' => $data,
                'mealTypes' => $mealTypes,
                'ingredients' => $ingredients,
                'diets' => $diets,
                'mealSizes' => $mealSizes,
                'vendors' => $vendors,
            ]);
        }
    }

    // Edit Meals
    public function edit_meals(Request $request,$uuid)
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'vendor_id' => 'required|string',
                'title' => 'required|string',
                'family_style' => 'required|integer',
                'meal_type_id' => 'required|string',
                'price' => 'required|string',
                'medicaid' => 'required|integer',
                'cafeteria' => 'required|integer',
                'ingredients' => 'required|array',
                'ingredients.*' => 'required|string',
                'diets' => 'required|array',
                'diets.*' => 'required|string',
            ]);
            $editMeal = Meal::where('uuid', $uuid)->first();
            $imageName = $editMeal->image;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . "_" . $image->getClientOriginalName();
                $filePath  = $image->storeAs('public/web_assets/media/meals/' . $request->uuid, $fileName, 'public');
                $imageName = basename($filePath);
            }
            if ($editMeal) {
                $editMeal->image = $imageName;
                $editMeal->vendor_id = $request->vendor_id;
                $editMeal->title = $request->title;
                $editMeal->description = $request->description;
                $editMeal->family_style = $request->family_style;
                $editMeal->meal_type_id = $request->meal_type_id;
                $editMeal->price = $request->price;
                $editMeal->medicaid = $request->medicaid;
                $editMeal->cafeteria = $request->cafeteria;
                $editMeal->is_autoselectable = $request->is_autoselectable;
                $editMeal->is_featured = $request->is_featured;
                $editMeal->save();
            } else {
                return to_route('admin.meals')->with('error', 'Meal Not Found.');
            }
            if ($editMeal) {
                // update Diets
                EhMealDiet::where('meal_id', $uuid)->delete();
                $data = array_map(function ($diet) use ($request) {
                    return [
                        'uuid' => generate_uuid_key(),
                        'meal_id' => $request->uuid,
                        'diet_id' => $diet
                    ];
                }, $request->diets);
                $editMealDiets = EhMealDiet::insert($data);
                // Update ingredients
                EhMealIngredient::where('meal_id', $uuid)->delete();
                $dataIng = array_map(function ($ingredient) use ($request) {
                    return [
                        'uuid' => generate_uuid_key(),
                        'meal_id' => $request->uuid,
                        'ingredient_id' => $ingredient
                    ];
                }, $request->ingredients);
                $editMealIngredients = EhMealIngredient::insert($dataIng);
                // Update nutrition facts
                EhNutritionFacts::where('meal_id', $uuid)->delete();
                $nutritionFactsData = [];
                foreach ($request->meal['nutrition_facts_attributes'] as $nutrient) {
                    $nutritionFactsData[] = [
                        'uuid' => generate_uuid_key(),
                        'meal_id' => $uuid,
                        'meal_size_id' => $nutrient['meal_size_id'] ?? 0,
                        'calories' => $nutrient['calories'] ?? 0,
                        'fat' => $nutrient['fat'] ?? 0,
                        'carb' => $nutrient['carb'] ?? 0,
                        'fiber' => $nutrient['fiber'] ?? 0,
                        'protein' => $nutrient['protein'] ?? 0,
                        'sodium' => $nutrient['sodium'] ?? 0,
                    ];
                    $addNutrient = EhNutritionFacts::insert($nutritionFactsData);
                    // For Ajax Requests
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'meal' => $editMeal,
                        'message' => 'Meal Update Successfully'
                    ]);
                }
                }
                return to_route('admin.meals')->with('success', 'Meal Update Successfully.');
            } else {
                return to_route('admin.meals')->with('error', 'Meal Not Update.');
            }
        } else {
            $mealTypes = MealType::select('uuid', 'title', 'status', 'sort_order')->where('status', 1)->orderBy('sort_order', 'ASC')->get();
            $ingredients = Ingredient::select('uuid', 'name', 'sort_order', 'status')->where('status', 1)->orderBy('sort_order', 'ASC')->get();
            $diets = Diet::select('uuid', 'name', 'sort_order', 'status')->where('status', 1)->orderBy('sort_order', 'ASC')->get();
            $mealSizes = MealSize::select('uuid', 'title', 'sort_order', 'servings', 'status')->where('status', 1)->where('servings', 1)->orderBy('sort_order', 'ASC')->get();
            $vendors = Vendor::select('uuid', 'name', 'status')->where('status', 1)->get();
            $meal = Meal::where('uuid', $uuid)->first();
            $mealIngredients = EhMealIngredient::where('meal_id', $uuid)->pluck('ingredient_id')->toArray();
            $mealDiets = EhMealDiet::where('meal_id', $uuid)->pluck('diet_id')->toArray();
            $mealNutritionFacts = EhNutritionFacts::where('meal_id', $uuid)->get()->keyBy('meal_size_id');
            $mealMedia = EhMealFile::where('meal_id', $uuid)->get();
            $data['title'] = 'Edit Meals';
            $data['meta_desc'] = 'Edit Meals Description';
            $data['keyword'] = '';
            return view('admin.pages.meals.edit')->with([
                'data' => $data,
                'uuid' => $uuid,
                'mealTypes' => $mealTypes,
                'ingredients' => $ingredients,
                'diets' => $diets,
                'mealSizes' => $mealSizes,
                'vendors' => $vendors,
                'meal' => $meal,
                'mealIngredients' => $mealIngredients,
                'mealDiets' => $mealDiets,
                'mealNutritionFacts' => $mealNutritionFacts,
                'mealMedia' => $mealMedia,
            ]);
        }
    }
    // Delete MEals
    public function delete_meals($uuid)
    {
        $meal = Meal::where('uuid', $uuid)->first();
        if (!$meal) {
            return response()->json([
                'success' => false,
                'message' => 'Meal  not found.'
            ], 404);
        }
        $meal->delete();
        return response()->json([
            'success' => true,
            'message' => 'Meal  deleted successfully.'
        ]);
    }

    public function add_media(Request $request)
    {
        $request->validate([
            'meal_id' => 'required|string',
            'file' => 'required|file|mimes:jpeg,jpg,png,webp,mp4,mov,avi',
        ]);

        $fileName = "";
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . "_" . $file->getClientOriginalName();
            $filePath  = $file->storeAs('public/web_assets/media/meals/' . $request->meal_id, $fileName, 'public');
            $fileName = basename($filePath);
        }
        $media = EhMealFile::create([
            'uuid' => generate_uuid_key(),
            'meal_id' => $request->meal_id,
            'file' => $fileName,
            'assigned' => (isset($request->edit_meal)) ? 1 : 0
        ]);
        if ($media) {
            return response()->json(['message' => 'Media Uploaded Successfully.', 'success' => true, 'media' => $media], 200);
        } else {
            return response()->json(['message' => 'Media Not Uploaded.', 'success' => false], 400);
        }
    }

    public function delete_meal_file(Request $request)
    {
        $request->validate([
            'uuid' => 'required|string'
        ]);
        $media = EhMealFile::select('uuid', 'file')->where('uuid', $request->uuid)->first();
        if (is_null($media)) {
            return response()->json(['message' => 'Media Not Found.', 'success' => false], 400);
        } else {
            $mediaDel = EhMealFile::where('uuid', $request->uuid)->delete();
            if ($mediaDel) {
                return response()->json(['message' => 'Media Deleted Successfully.', 'success' => true], 200);
            } else {
                return response()->json(['message' => 'Media Not Deleted.', 'success' => false], 400);
            }
        }
    }

    // return meal type view
    public function get_add_meal_type_model()
    {
        return response()->json([
            'success' => true,
            'html' => view('admin.modals.add_meal_type')->render(),
        ]);
    }

    // update meal type dropdown
    public function get_meal_types()
    {
        $mealtypes = MealType::where('status', 1)->get();
        return response()->json([
            'success' => true,
            'data' => $mealtypes,
        ]);
    }

    // return ingredient view
    public function get_ingredient_model()
    {
        return response()->json([
            'success' => true,
            'html' => view('admin.modals.ingredient')->render(),
        ]);
    }

    // updated ingredients
    public function get_ingredients()
    {
        $ingredient = Ingredient::where('status', 1)->get();
        return response()->json([
            'success' => true,
            'data' => $ingredient,
        ]);
    }

    // Return Diet modal view
    public function get_diet_model()
    {
        return response()->json([
            'success' => true,
            'html' => view('admin.modals.diet')->render(),
        ]);
    }

    // updated diets
    public function get_diets()
    {
        $diets = Diet::where('status', 1)->get();
        return response()->json([
            'success' => true,
            'data' => $diets,
        ]);
    }

    // Return Meal size modal view
    public function get_meal_size_model()
    {
        return response()->json([
            'success' => true,
            'html' => view('admin.modals.meal_size')->render(),
        ]);
    }
    // Update meal size
    public function get_meal_size()
    {
        $mealSizes = MealSize::where('status', 1)->where('servings', 1)->get();
        return response()->json([
            'success' => true,
            'data' => $mealSizes,
        ]);
    }

    // Return vendor modal view
    public function get_vendor_modal()
    {
        return response()->json([
            'success' => true,
            'html' => view('admin.modals.vendor')->render(),
        ]);
    }

    // Update vendor
    public function get_vendors()
    {
        $vendors = Vendor::where('status', 1)->get();
        return response()->json([
            'success' => true,
            'data' => $vendors,
        ]);
    }
}
