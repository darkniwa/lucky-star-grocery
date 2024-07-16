<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;
    protected $table = 'page_contents';
    protected $fillable = ['page_id', 'key', 'value'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    // Add a method to decode the JSON-encoded value
    public function getDecodedValueAttribute()
    {
        return json_decode($this->value, true);
    }
    
}
