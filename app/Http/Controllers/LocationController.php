<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $query = Location::query();
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('region', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%")
                  ->orWhere('ward', 'like', "%{$search}%")
                  ->orWhere('street', 'like', "%{$search}%");
            });
        }
        
        // Region filter
        if ($request->filled('region')) {
            $query->where('region_code', $request->get('region'));
        }
        
        // District filter
        if ($request->filled('district')) {
            $query->where('district_code', $request->get('district'));
        }
        
        $locations = $query->latest()->paginate(50)->withQueryString();
        
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'region' => 'required|string|max:100',
            'region_code' => 'required|string|max:10',
            'district' => 'required|string|max:100',
            'district_code' => 'required|string|max:10',
            'ward' => 'required|string|max:100',
            'ward_code' => 'required|string|max:10',
            'street' => 'nullable|string|max:100',
            'place' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        Location::create($validated);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Location created successfully.');
    }

    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'region' => 'required|string|max:100',
            'region_code' => 'required|string|max:10',
            'district' => 'required|string|max:100',
            'district_code' => 'required|string|max:10',
            'ward' => 'required|string|max:100',
            'ward_code' => 'required|string|max:10',
            'street' => 'nullable|string|max:100',
            'place' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $location->update($validated);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()
            ->route('locations.index')
            ->with('success', 'Location deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'mimes:csv,txt|max:10240',
        ]);

        $files = $request->file('files');
        $totalImportedCount = 0;
        $totalSkippedCount = 0;
        $processedFiles = 0;
        $errorFiles = [];

        // Ensure imports directory exists
        $importsPath = storage_path('app/imports');
        if (!is_dir($importsPath)) {
            mkdir($importsPath, 0755, true);
        }

        foreach ($files as $index => $file) {
            try {
                // Get file content directly instead of storing
                $fileContent = file_get_contents($file->getRealPath());
                
                // Process CSV content directly
                $lines = explode("\n", $fileContent);
                $importedCount = 0;
                $skippedCount = 0;
                
                // Skip header row if it exists
                if (!empty($lines) && str_contains($lines[0], 'region')) {
                    array_shift($lines);
                }
                
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line)) continue;
                    
                    // Parse CSV line
                    $row = str_getcsv($line);
                    
                    if (count($row) >= 8) {
                        // Check if location already exists to avoid duplicates
                        $existing = Location::where('region_code', $row[1])
                            ->where('district_code', $row[3])
                            ->where('ward_code', $row[5])
                            ->first();
                        
                        if (!$existing) {
                            Location::create([
                                'region' => $row[0] ?? '',
                                'region_code' => $row[1] ?? '',
                                'district' => $row[2] ?? '',
                                'district_code' => $row[3] ?? '',
                                'ward' => $row[4] ?? '',
                                'ward_code' => $row[5] ?? '',
                                'street' => $row[6] ?? '',
                                'place' => $row[7] ?? '',
                                'is_active' => true,
                            ]);
                            
                            $importedCount++;
                        } else {
                            $skippedCount++;
                        }
                    }
                }
                
                $totalImportedCount += $importedCount;
                $totalSkippedCount += $skippedCount;
                $processedFiles++;
                
            } catch (\Exception $e) {
                $errorFiles[] = $file->getClientOriginalName() . ': ' . $e->getMessage();
            }
        }
        
        // Build success message
        $message = "Import completed successfully! ";
        $message .= "{$processedFiles} file(s) processed, {$totalImportedCount} records imported.";
        if ($totalSkippedCount > 0) {
            $message .= " {$totalSkippedCount} duplicates skipped.";
        }
        
        // Add error information if any files failed
        if (!empty($errorFiles)) {
            $message .= " " . count($errorFiles) . " file(s) had errors.";
            session()->flash('import_errors', $errorFiles);
        }
        
        return redirect()
            ->route('locations.index')
            ->with('success', $message);
    }

    public function export()
    {
        $locations = Location::all();
        
        $filename = 'tanzania_locations_' . date('Y_m_d_His') . '.csv';
        
        $headers = [
            'Region',
            'Region Code',
            'District',
            'District Code',
            'Ward',
            'Ward Code',
            'Street',
            'Place',
            'Status'
        ];
        
        $callback = function() use ($locations) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, $headers);
            
            // Add data
            foreach ($locations as $location) {
                fputcsv($file, [
                    $location->region,
                    $location->region_code,
                    $location->district,
                    $location->district_code,
                    $location->ward,
                    $location->ward_code,
                    $location->street,
                    $location->place,
                    $location->is_active ? 'Active' : 'Inactive'
                ]);
            }
            
            fclose($file);
            return file_get_contents('php://output');
        };
        
        return response($callback(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
