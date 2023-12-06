<?php

namespace App\Http\Controllers\api\MedicalProvider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController as BaseController;
use Validator;
use App\Traits\MediaTrait;
use Str;
use App\Models\ToursDetails;
use App\Models\VehicleBrand;
use App\Models\ComfortLevels;
use Auth;

class ToursController extends BaseController
{
    use MediaTrait;
    //
    public function add_tour(Request $request){

        $validator = Validator::make($request->all(), [
            'tour_name' => 'required',
            'tour_description' => 'required',
            'tour_days' => 'required',
            'tour_image_path' => 'required',
            'tour_price' => 'required',
            'tour_other_services' => 'required',
            'platform_type' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $tour_input = [];
        $tour_input['tour_name'] = $request->tour_name;
        $tour_input['tour_description'] = $request->tour_description;
        $tour_input['tour_days'] = $request->tour_days;
        if ($request->has('tour_image_path')) {
            $tour_input['tour_image_path'] = $this->verifyAndUpload($request, 'tour_image_path', 'tour_images');
            $original_name = $request->file('tour_image_path')->getClientOriginalName();
            $tour_input['tour_image_name'] = $original_name;
        }
        $tour_input['tour_price'] = $request->tour_price;
        $tour_input['tour_other_services'] = $request->tour_other_services;
        $tour_input['platform_type'] = $request->platform_type;

        $tour_input['created_by'] = Auth::user()->id;
        $AddNewAcommodition = ToursDetails::create($tour_input);
        if (!empty($AddNewAcommodition)) {
            return response()->json([
                'status' => 200,
                'message' => 'Tour created successfully.',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Tour not created.',
            ]);
        }
    }

    public function tour_list()
    {
        $ToursDetails = ToursDetails::where('status', 'active')
        ->select(
            'id',
            'tour_name',
            'tour_description',
            'tour_days',
            'tour_image_path',
            'tour_image_name',
            'tour_price',
            'tour_other_services',
            'platform_type',
            'status',
            'created_by'
        )
            ->get();

        if (!empty($ToursDetails)) {
            return response()->json([
                'status' => 200,
                'message' => 'Tours Details found.',
                'tour_details' => $ToursDetails,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Something went wrong. Details not found.',
            ]);
        }
    }

    public function edit_tour_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tour_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $tour_input = [];
        $tour_input['tour_name'] = $request->tour_name;
        $tour_input['tour_description'] = $request->tour_description;
        $tour_input['tour_days'] = $request->tour_days;
        if ($request->has('tour_image_path')) {
            $tour_input['tour_image_path'] = $this->verifyAndUpload($request, 'tour_image_path', 'tour_images');
            $original_name = $request->file('tour_image_path')->getClientOriginalName();
            $tour_input['tour_image_name'] = $original_name;
        }
        $tour_input['tour_price'] = $request->tour_price;
        $tour_input['tour_other_services'] = $request->tour_other_services;
        $tour_input['platform_type'] = $request->platform_type;

        $tour_input['created_by'] = Auth::user()->id;
        $edit_tour = ToursDetails::where('id', $request->tour_id)->update($tour_input);

        if (!empty($edit_tour)) {
            return response()->json([
                'status' => 200,
                'message' => 'Tour details updated successfully.',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Something went wrong. Details not updated.',
            ]);
        }

    }

    public function delete_tour(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tour_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $status_update['status'] = 'delete';
        $status_update['modified_by'] = Auth::user()->id;
        $status_update['modified_ip_address'] = $request->ip();

        $delete_tour = ToursDetails::where('id', $request->tour_id)->update($status_update);
        if (!empty($delete_tour)) {
            return response()->json([
                'status' => 200,
                'message' => 'Tour details deleted successfully.',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Something went wrong. Details not deleted.',
            ]);
        }
    }


}
