<?php

namespace Backend\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BaseModel extends Model
{
    protected bool $saveUserId = false;

    protected array $autoRemoveImages = [];

    protected static function booted(): void
    {
        parent::booted();

        static::creating(function (BaseModel $model) {
            if ($model->saveUserId) {
                if (empty($model->user_id)) {
                    $model->user_id = Auth::id();
                }
            }
        });
        static::updating(function (BaseModel $model) {
            foreach ($model->autoRemoveImages as $image) {
                if ($model->isDirty($image)) {
                    if (! blank($model->getOriginal($image))) {
                        File::delete(public_path($model->getOriginal($image)));
                    }
                }
            }
        });
        static::deleting(function (BaseModel $model) {
            if (property_exists($model, 'forceDeleting') && ! $model->forceDeleting) {
                return;
            }
            foreach ($model->autoRemoveImages as $image) {
                if (! blank($model->{$image})) {
                    File::delete(public_path($model->{$image}));
                }
            }
        });
    }
}
