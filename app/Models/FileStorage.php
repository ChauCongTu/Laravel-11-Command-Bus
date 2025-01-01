<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileStorage extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'files';
    protected $fillable = ['path', 'original_name', 'ext', 'file_name', 'url', 'upload_by'];
    public function uploadBy (): BelongsTo{
        return $this->belongsTo(User::class, 'upload_by');
    }
}
