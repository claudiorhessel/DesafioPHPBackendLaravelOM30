<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\File;

class FileApiController extends Controller
{
    public function index()
    {
        try {
            $fileType = File::paginate();

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
            $validateFile = Validator::make($request->all(), File::rules());

            if($validateFile->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateFile->errors()
                ], 401);
            }

            $filePath = $request->file("photo")->storeAs('public/apiFiles', uniqid(date('His')));

            $file = File::create([
                'file_type_id' => $request->file_type_id,
                'patient_id' => $request->patient_id,
                'original_name' => $request->original_name,
                'extension' => $request->extension,
                'file_path' => $request->file_path,
                'file_size' => $request->file_size,
                'hash' => $request->hash
            ]);

            return response()->json([
                'status' => true,
                'data' => $file
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

            $fileType = File::find($id);

            if(!$fileType) {
                return response()->json([
                    'status' => false,
                    'message' => 'File not found'
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

            $validateFile = Validator::make($request->all(), File::rules());

            if($validateFile->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateFile->errors()
                ], 401);
            }

            $fileType = File::find($id);

            if(!$fileType) {
                return response()->json([
                    'status' => false,
                    'message' => 'File not found'
                ], 404);
            }

            $fileType->update([
                'name' => $request->name,
                'allowed_extensions' => $request->allowed_extensions
            ]);

            return response()->json([
                'status' => true,
                'message' => 'File successfully updated'
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

            $fileType = File::find($id);

            if(!$fileType) {
                return response()->json([
                    'status' => false,
                    'message' => 'File not found'
                ], 404);
            }

            $fileType->delete();

            return response()->json([
                'status' => true,
                'message' => 'File successfully deleted'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
