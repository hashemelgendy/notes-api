<?php

namespace App\GraphQL\Mutations;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteMutation
{
    /**
     * Update Note
     *
     * @param $_
     * @param array $args
     * @return Note
     */
    public function update($_, array $args): Note
    {
        $note = Note::where('id', $args['id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $note->update($args);
        return $note;
    }

    /**
     * Delete Note
     *
     * @param $_
     * @param array $args
     * @return Note
     */
    public function delete($_, array $args): Note
    {
        $note = Note::where('id', $args['id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $note->delete();
        return $note;
    }
}
