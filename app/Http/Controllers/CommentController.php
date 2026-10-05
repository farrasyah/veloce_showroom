<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Simpan komentar baru dari user yang sedang login untuk sebuah mobil.
     */
    public function store(Request $request, Car $car): RedirectResponse
    {
        $validated = $this->validateComment($request);

        $car->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $validated['content'],
            'rating'  => $validated['rating'] ?? null,
        ]);

        return back()->with('status', 'Komentar Anda berhasil ditambahkan.')->withFragment('komentar');
    }

    /**
     * Perbarui komentar milik sendiri (atau oleh admin).
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $this->authorizeOwner($request, $comment);

        $validated = $this->validateComment($request);

        $comment->update([
            'content' => $validated['content'],
            'rating'  => $validated['rating'] ?? null,
        ]);

        return back()->with('status', 'Komentar berhasil diperbarui.')->withFragment('komentar');
    }

    /**
     * Hapus komentar milik sendiri (atau oleh admin).
     */
    public function destroy(Request $request, Comment $comment): RedirectResponse
    {
        $this->authorizeOwner($request, $comment);

        $comment->delete();

        return back()->with('status', 'Komentar berhasil dihapus.')->withFragment('komentar');
    }

    private function validateComment(Request $request): array
    {
        return $request->validate([
            'content' => 'required|string|max:1000',
            'rating'  => 'nullable|integer|min:1|max:5',
        ]);
    }

    /**
     * Hanya pemilik komentar atau admin yang boleh mengubah/menghapus.
     */
    private function authorizeOwner(Request $request, Comment $comment): void
    {
        $user = $request->user();

        if (! $user || ($user->id !== $comment->user_id && ! $user->isAdmin())) {
            abort(403, 'Anda tidak berhak mengubah komentar ini.');
        }
    }
}
