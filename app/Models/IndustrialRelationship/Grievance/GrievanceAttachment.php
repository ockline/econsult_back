<?php

namespace App\Models\IndustrialRelationship\Grievance;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrievanceAttachment extends Model
{
    use HasFactory,SoftDeletes, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'grievance_attachments';

    protected $fillable = [
         'name','grievance_id','document_id','document_group_id','description','size','ext','mine','document_used', 'file_path'
    ];

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => url('grievances/'.$value),
        );
    }
}
