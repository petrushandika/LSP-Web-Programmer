<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SettingApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $settings = Setting::paginate(15);
            return response()->json($settings, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving settings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'company_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone_number' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'description' => 'nullable|string|max:1000',
            ]);

            $setting = Setting::create($validated);

            return response()->json([
                'message' => 'Setting created successfully',
                'data' => $setting
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating setting',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $setting = Setting::findOrFail($id);
            
            return response()->json([
                'message' => 'Setting retrieved successfully',
                'data' => $setting
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Setting not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $setting = Setting::findOrFail($id);

            $validated = $request->validate([
                'company_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone_number' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'description' => 'nullable|string|max:1000',
            ]);

            $setting->update($validated);

            return response()->json([
                'message' => 'Setting updated successfully',
                'data' => $setting->fresh()
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating setting',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $setting = Setting::findOrFail($id);
            $setting->delete();

            return response()->json([
                'message' => 'Setting deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting setting',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get application configuration summary
     */
    public function summary(): JsonResponse
    {
        try {
            $totalSettings = Setting::count();
            $latestSetting = Setting::latest()->first();
            
            $summary = [
                'total_settings' => $totalSettings,
                'has_configuration' => $totalSettings > 0,
                'latest_setting' => $latestSetting,
                'configuration_completeness' => $this->calculateCompleteness($latestSetting),
            ];

            return response()->json([
                'message' => 'Settings summary retrieved successfully',
                'data' => $summary
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving settings summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate configuration completeness percentage
     */
    private function calculateCompleteness($setting): int
    {
        if (!$setting) {
            return 0;
        }

        $fields = ['company_name', 'email', 'phone_number', 'address', 'description'];
        $completedFields = 0;

        foreach ($fields as $field) {
            if (!empty($setting->$field)) {
                $completedFields++;
            }
        }

        return round(($completedFields / count($fields)) * 100);
    }
}