<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoteController extends ApiController
{
    /**
     * List Notes
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $notes = $request->user()->notes()->latest()->get();

        return $this->success(['notes' => $notes]);
    }

    /**
     * Store Note
     *
     * @param StoreNoteRequest $request
     * @return JsonResponse
     */
    public function store(StoreNoteRequest $request): JsonResponse
    {
        $data = $request->validated();
        $note = $request->user()->notes()->create($data);

        return $this->success(['note' => $note], 201);
    }

    /**
     * Update Note
     *
     * @param UpdateNoteRequest $request
     * @param Note $note
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateNoteRequest $request, Note $note): JsonResponse
    {
        $this->authorize('update', $note);

        $note->update($request->validated());

        return $this->success(['note' => $note]);
    }

    /**
     * Destroy Note
     *
     * @param Request $request
     * @param Note $note
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Request $request, Note $note): JsonResponse
    {
        $this->authorize('delete', $note);

        $note->delete();

        return $this->success(['message' => 'Note deleted']);
    }
}
