<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FileType;
use Illuminate\Support\Facades\Validator;

class FileTypeApiController extends Controller
{
    public function index()
    {
        try {
            $fileType = FileType::paginate();

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
            $validateFileType = Validator::make($request->all(), FileType::rules());

            if($validateFileType->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateFileType->errors()
                ], 401);
            }

            $fileType = FileType::create([
                'name' => $request->name,
                'allowed_extensions' => $request->allowed_extensions
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

            $fileType = FileType::find($id);

            if(!$fileType) {
                return response()->json([
                    'status' => false,
                    'message' => 'File Type not found'
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

            $validateFileType = Validator::make($request->all(), FileType::rules());

            if($validateFileType->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateFileType->errors()
                ], 401);
            }

            $fileType = FileType::find($id);

            if(!$fileType) {
                return response()->json([
                    'status' => false,
                    'message' => 'File Type not found'
                ], 404);
            }

            $fileType->update([
                'name' => $request->name,
                'allowed_extensions' => $request->allowed_extensions
            ]);

            return response()->json([
                'status' => true,
                'message' => 'File Type successfully updated'
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

            $fileType = FileType::find($id);

            if(!$fileType) {
                return response()->json([
                    'status' => false,
                    'message' => 'File Type not found'
                ], 404);
            }

            $fileType->delete();

            return response()->json([
                'status' => true,
                'message' => 'File Type successfully deleted'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
