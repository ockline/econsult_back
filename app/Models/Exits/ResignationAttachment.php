<?php

namespace App\Models\Exits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ResignationAttachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'resignation_attachments';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'resignation_id',
        'name',
        'document_id',
        'document_group_id',
        'description',
        'size',
        'ext',
        'mine',
        'document_used',
    ];

    /**
     * Get the resignation that owns the attachment.
     */
    public function resignation()
    {
        return $this->belongsTo(Resignation::class);
    }

    /**
     * Get the file URL.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => url('resignations/' . $value),
        );
    }
}
