<?php

namespace App\Http\Controllers\api\MedicalProvider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController as BaseController;
use Validator;
use App\Traits\MediaTrait;
use Str;
use Auth;
use App\Models\MedicalProviderReports;
use App\Models\CustomerPurchaseDetails;
use App\Models\CustomerRegistration;
use Storage;

class ReportsController extends Controller
{

    use MediaTrait;

    public function add_new_report(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'report_title' => 'required',
            'customer_package_purchage_id' => 'required',
            'report_path' => 'required|mimes:pdf,png,jpeg,tiff',
        ]);
        
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

      

        $report_input = [];
        $report_input['report_title'] = $request->report_title;
        $report_input['customer_package_purchage_id'] = $request->customer_package_purchage_id;
        $report_input['report_path'] = $request->report_path;

      
        if ($request->has('report_path')){

            $report_input['report_path'] = $this->verifyAndUpload($request, 'report_path', 'providerreports');
            $original_name = $request->file('report_path')->getClientOriginalName();
            $report_input['report_name'] = $original_name;
        }

       
        // $report_input['medical_provider_id'] =  Auth::user()->id;
        // $report_input['created_by'] = Auth::user()->id;

        $report_input['medical_provider_id'] =  1;
        $report_input['created_by'] = 1;

        $AddNewReports = MedicalProviderReports::create($report_input);

        if (!empty($AddNewReports)) {
            return response()->json([
                'status' => 200,
                'message' => 'Report added successfully.',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Report not added.',
            ]);
        }

    }


//    public function patient_package_purchage_list()
//     {
        
//         $patientList = CustomerPurchaseDetails::with(['customer','package'])->where('status', 'active')
//         ->get();
        

//         if (!empty($patientList)){
//             return response()->json([
//                 'status' => 200,
//                 'message' => 'Patient package Purchage list found.',
//                 'patient_package_purchage_list' => $patientList,
//             ]);
//         } else{
//             return response()->json([
//                 'status' => 404,
//                 'message' => 'Something went wrong. Patient package Purchage list not found.',
//             ]);
//         }
//     }


public function patient_package_purchage_list()
{
    $patientList = CustomerPurchaseDetails::with(['customer', 'package'])->where('status', 'active')->get();

    if (!empty($patientList)) {
        $formattedList = [];

        foreach ($patientList as $purchase) {
            $customerPurchaseId = $purchase->id;
            $customerId = $purchase->customer->id;
            $packageId = $purchase->package->id;
            $patientName = $purchase->customer->full_name;
            $packageName = $purchase->package->package_name;

          
            $id = implode(',', [$customerPurchaseId, $customerId, $packageId]);
            $name=$patientName . ' - ' . $packageName;

            // Add the concatenated data to the formatted list
            $formattedList[] = [
                'id' => $id,
                'name' => $name,
            ];
        }

        return response()->json([
            'status' => 200,
            'message' => 'Patient package Purchase list found.',
            'formatted_patient_package_purchase_list' => $formattedList,
        ]);
    } else {
        return response()->json([
            'status' => 404,
            'message' => 'Something went wrong. Patient package Purchase list not found.',
        ]);
    }
}




    public function provider_all_reports_list()
    {

        $provider_report_list = MedicalProviderReports::with(['customerPackagePurchase.customer', 'provider', 'provider_logo'])
        ->where('created_by', 1)
        ->where('status', 'active')
        ->get();


       


    
    $formatted_data = [];
    
    foreach ($provider_report_list as $report){
        $customerPurchasePackage = $report->customerPackagePurchase;
        $providerData = $report->provider;
        $providerLogo = $report->provider_logo; 
        $customerData = $customerPurchasePackage->customer;
    
        $packageIndex = null;
    
        foreach ($formatted_data as $index => $formattedItem) {
            if ($formattedItem['customer_purchased_package']['order_id'] == $customerPurchasePackage->order_id) {
                $packageIndex = $index;
                break;
            }
        }
    
        if ($packageIndex !== null){
            $formatted_data[$packageIndex]['reports'][] = [
                'id' => $report->id,
                'report_title' => $report->report_title,
                'report_path' => $report->report_path,
                'report_name' => $report->report_name,
                'created_at' => $report->created_at,
            ];
        } else {
         
            $formatted_data[] = [
                'customer_purchased_package' => [
                    'order_id' => $customerPurchasePackage->order_id,
                ],
                'provider_data' => [
                    
                    'logo_path' => isset($providerLogo) ? $providerLogo->company_logo_image_path: null, 
                ],
                'customer_data' => [
                    'name' => $customerData->first_name . ' ' . $customerData->last_name,
                ],
                'reports' => [
                    [
                        'id' => $report->id,
                        'report_title' => $report->report_title,
                        'report_path' => $report->report_path,
                        'report_name' => $report->report_name,
                        'created_at' => $report->created_at,
                    ],
                ],
            ];
        }
    }

     if (!empty($provider_report_list)){
            return response()->json([
                'status' => 200,
                'message' => 'Provider report list found.',
                'provider_report_list' =>   $formatted_data,
            ]);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'Something went wrong. Provider report list not found.',
            ]);
        }
}







}
