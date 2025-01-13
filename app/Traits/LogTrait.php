<?php

namespace App\Traits;

use App\Models\Log;
use Error;
use Exception;

trait LogTrait
{
    public static function create($user_id, $type, $id, $action, $content)
    {
        try {
            Log::create([
                'user_id' => $user_id,
                'action' => $action,
                'modelable_type' => $type,
                'modelable_id' => $id,
                'content' => $content,
            ]);
        } catch(Exception $err) {
            throw new Error($err);
        }
    }
}
