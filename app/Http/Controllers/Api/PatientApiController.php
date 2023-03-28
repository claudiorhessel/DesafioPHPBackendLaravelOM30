<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\FileType;
use App\Models\AddressType;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\FileApiController;

class PatientApiController extends Controller
{
    public function index()
    {
        try {
            $fileType = Patient::paginate();

            return response()->json([
                'status' => true,
                'data' => $fileType,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatePatient = Validator::make($request->all(), Patient::rules());

            if($validatePatient->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validatePatient->errors()
                ], 401);
            }

            $fileType = FileType::where('name', 'patient_photo')->first();
            if(!$fileType) {
                return response()->json([
                    'status' => false,
                    'message' => 'File Type not found'
                ], 401);
            }

            $addressType = AddressType::where('name', 'patient_address')->first();
            if(!$addressType) {
                return response()->json([
                    'status' => false,
                    'message' => 'Address Type not found'
                ], 401);
            }

            $patient = Patient::create([
                'name' => $request->name,
                'mother_name' => $request->mother_name,
                'birtdate' => $request->birtdate,
                'cpf' => $request->cpf,
                'cns' => $request->cns
            ]);

            $request->request->add([
                "patient_id" => $patient->id,
                "file_type_id" => $fileType->id,
                "address_type_id" => $addressType->id,
                "original_name" => $request->file('photo')->getClientOriginalName(),
                "file_size" => $request->file('photo')->getSize(),
                "file_path" => storage_path("app/public/apiFiles"),
                "hash" => uniqid(date('His'))
            ]);

            if($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $file = (new FileApiController)->store($request);
            }

            return response()->json([
                'status' => true,
                'data' => $patient
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'id must by a number'
                ], 401);
            }

            $fileType = Patient::find($id);

            if(!$fileType) {
                return response()->json([
                    'status' => false,
                    'message' => 'Patient not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $fileType
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'id must by a number'
                ], 401);
            }

            $validatePatient = Validator::make($request->all(), Patient::rules());

            if($validatePatient->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validatePatient->errors()
                ], 401);
            }

            $fileType = Patient::find($id);

            if(!$fileType) {
                return response()->json([
                    'status' => false,
                    'message' => 'Patient not found'
                ], 404);
            }

            $fileType->update([
                'name' => $request->name,
                'mother_name' => $request->mother_name,
                'birtdate' => $request->birtdate,
                'cpf' => $request->cpf,
                'cns' => $request->cns
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Patient successfully updated'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'id must by a number'
                ], 401);
            }

            $fileType = Patient::find($id);

            if(!$fileType) {
                return response()->json([
                    'status' => false,
                    'message' => 'Patient not found'
                ], 404);
            }

            $fileType->delete();

            return response()->json([
                'status' => true,
                'message' => 'Patient successfully deleted'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
