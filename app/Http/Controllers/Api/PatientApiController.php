<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;

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
            $validateFileType = Validator::make($request->all(), Patient::rules());

            if($validateFileType->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateFileType->errors()
                ], 401);
            }

            $fileType = Patient::create([
                'name' => $request->name,
                'mother_name' => $request->mother_name,
                'birtdate' => $request->birtdate,
                'cpf' => $request->cpf,
                'cns' => $request->cns
            ]);

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

            $validateFileType = Validator::make($request->all(), Patient::rules());

            if($validateFileType->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateFileType->errors()
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
