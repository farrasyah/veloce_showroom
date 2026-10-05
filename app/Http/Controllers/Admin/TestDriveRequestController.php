<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestDriveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestDriveRequestController extends Controller
{
    /**
     * Daftar permintaan test drive yang dikirim user, dengan filter status.
     */
    public function index(Request $request): View
    {
        $query = TestDriveRequest::with('car')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $testDrives = $query->paginate(10)->withQueryString();

        return view('admin.testdrives.index', [
            'testDrives' => $testDrives,
            'statuses'   => TestDriveRequest::STATUSES,
        ]);
    }

    /**
     * Ubah status penanganan sebuah permintaan test drive.
     */
    public function update(Request $request, TestDriveRequest $testDrive): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(TestDriveRequest::STATUSES)),
        ]);

        $testDrive->update($validated);

        return back()->with('status', 'Status permintaan test drive dari "' . $testDrive->name . '" diperbarui.');
    }

    /**
     * Hapus permintaan test drive.
     */
    public function destroy(TestDriveRequest $testDrive): RedirectResponse
    {
        $name = $testDrive->name;
        $testDrive->delete();

        return back()->with('status', 'Permintaan test drive dari "' . $name . '" telah dihapus.');
    }
}
