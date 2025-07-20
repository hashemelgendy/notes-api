<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class NoteQuery
{
    public function getMyNotes(): Collection
    {
        return Auth::user()->notes;
    }
}
