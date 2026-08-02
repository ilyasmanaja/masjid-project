<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardMember extends Model
{
    protected $guarded = [];

    /**
     * Memecah string nama HANYA berdasarkan Enter / Baris Baru (Newline)
     */
    public function getNameListAttribute(): array
    {
        if (empty($this->name)) {
            return [];
        }

        // Split HANYA berdasarkan baris baru (Enter)
        $names = preg_split('/\r\n|\r|\n/', $this->name);

        return array_values(array_filter(array_map('trim', $names)));
    }
}