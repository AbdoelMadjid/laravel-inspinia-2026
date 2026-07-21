<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Admin\System\AppFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppFeatureController extends Controller
{
    /**
     * Display a listing of app features.
     */
    public function index()
    {
        $features = AppFeature::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.system.app-features.index', compact('features'));
    }

    /**
     * Store a newly created feature.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:app_features,key',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['key'] = Str::slug($validated['key'], '_');
        $validated['category'] = $validated['category'] ?? 'general';
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        AppFeature::create($validated);
        AppFeature::clearCache();

        return redirect()->route('admin.app-features.index')->with('success', 'Fitur berhasil ditambahkan.');
    }

    /**
     * Update the specified feature.
     */
    public function update(Request $request, AppFeature $appFeature)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:app_features,key,' . $appFeature->id,
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['key'] = Str::slug($validated['key'], '_');
        $validated['category'] = $validated['category'] ?? 'general';
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $appFeature->update($validated);
        AppFeature::clearCache();

        return redirect()->route('admin.app-features.index')->with('success', 'Fitur berhasil diperbarui.');
    }

    /**
     * Toggle active status via AJAX or POST.
     */
    public function toggleStatus(Request $request, AppFeature $appFeature)
    {
        if ($request->has('is_active')) {
            $appFeature->is_active = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);
        } else {
            $appFeature->is_active = !$appFeature->is_active;
        }

        $appFeature->save();
        AppFeature::clearCache();

        $statusText = $appFeature->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $message = "Fitur {$appFeature->name} berhasil {$statusText}.";

        session()->flash('success', $message);

        if ($request->wantsJson() || $request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => (bool) $appFeature->is_active,
                'message' => $message
            ]);
        }

        return redirect()->route('admin.app-features.index')->with('success', $message);
    }

    /**
     * Remove the specified feature.
     */
    public function destroy(AppFeature $appFeature)
    {
        $name = $appFeature->name;
        $appFeature->delete();
        AppFeature::clearCache();

        return redirect()->route('admin.app-features.index')->with('success', "Fitur {$name} berhasil dihapus.");
    }
}
