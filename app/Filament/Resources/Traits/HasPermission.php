<?php

namespace App\Filament\Resources\Traits;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\PermissionHelper;

trait HasPermission
{
    abstract protected static function getResourceName(): string;
    public static function canViewAny(): bool
    {
        return PermissionHelper::check(static::getResourceName(), 'can_view_any');
    }

    public static function canCreate(): bool
    {
        return PermissionHelper::check(static::getResourceName(), 'can_create');
    }

    public static function canEdit(Model $record): bool
    {
        return PermissionHelper::check(static::getResourceName(), 'can_edit');
    }

    public static function canDelete(Model $record): bool
    {
        return PermissionHelper::check(static::getResourceName(), 'can_delete');
    }
}