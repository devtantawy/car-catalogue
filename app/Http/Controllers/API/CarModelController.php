<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\CarModelResource;
use App\Models\CarModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class CarModelController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $carModels = CarModel::all();

        return $this->sendResponse(CarModelResource::collection($carModels), 'Car Models retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'price' => 'required|decimal:2',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage    = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
        $input['user_id'] = $request->user()->id;

        // dd($input);
        $carModel = CarModel::create($input);

        return $this->sendResponse(new CarModelResource($carModel), 'Car Model created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $carModel = CarModel::find($id);

        if (is_null($carModel)) {
            return $this->sendError('CarModel not found.');
        }

        return $this->sendResponse(new CarModelResource($carModel), 'Car Model retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarModel $carModel): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'price' => 'required|decimal:2',
            'description' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage    = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        } else {
            unset($input['image']);
        }

        $carModel->make        = $input['make'];
        $carModel->model       = $input['model'];
        $carModel->year        = $input['year'];
        $carModel->price       = $input['price'];
        $carModel->description = $input['description'];
        $carModel->image       = $carModel->image;

        $carModel->save();

        return $this->sendResponse(new CarModelResource($carModel), 'Car Model updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarModel $carModel): JsonResponse
    {
        $carModel->delete();

        return $this->sendResponse([], 'Car Model deleted successfully.');
    }
}
