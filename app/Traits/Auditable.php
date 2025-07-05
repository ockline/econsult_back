<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\Audit; // Assuming you have an Audit model

trait Auditable
{
    // Automatically log when a model is created
    public static function bootAuditable()
    {
        static::created(function ($model) {
            $model->logAudit('created');
        });

        // Automatically log when a model is updated
        static::updated(function ($model) {
            $model->logAudit('updated');
        });

        // Automatically log when a model is deleted
        static::deleted(function ($model) {
            $model->logAudit('deleted');
        });
    }

    /**
     * Log the changes to the Audit table
     *
     * @param string $event
     */
    protected function logAudit($event)
    {

        $user = Auth::user(); // Get the authenticated user
        $ipAddress = Request::ip(); // Get the request IP address
        $userAgent = Request::header('User-Agent'); // Get the user agent from the request

        $auditData = [
            'user_id' => $user ? $user->id : null, // Log user ID if authenticated
            'event' => $event,
            'auditable_id' => $this->id,
            'auditable_type' => get_class($this),
            'old_values' => $event === 'updated' ? $this->getOriginal() : null,
            'new_values' => $event !== 'deleted' ? $this->getDirty() : null,
            'url' => Request::fullUrl(),
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'user_type' => $user ? $user->role : null, // Assuming you have roles defined
            'tags' => null, // You can define tags if needed
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Insert the audit record into the Audit table
        Audit::create($auditData);
    }
}
