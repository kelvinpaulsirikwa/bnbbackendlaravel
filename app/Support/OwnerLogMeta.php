<?php

namespace App\Support;

use Illuminate\Http\Request;

/**
 * Call from hotel/owner controllers to attach "what changed" to the current request.
 * The LogHotelOwnerActivity middleware will read these and save to hotel_owner_logs.
 * Uses separate request keys from AdminLogMeta so admin and owner logs do not clash.
 */
class OwnerLogMeta
{
    private const KEY_DESCRIPTION = 'owner_log_description';
    private const KEY_SUBJECT_TYPE = 'owner_log_subject_type';
    private const KEY_SUBJECT_ID = 'owner_log_subject_id';
    private const KEY_OLD_VALUES = 'owner_log_old_values';
    private const KEY_NEW_VALUES = 'owner_log_new_values';

    public static function setDescription(string $description): void
    {
        self::request()->attributes->set(self::KEY_DESCRIPTION, $description);
    }

    public static function setSubject(string $type, $id): void
    {
        self::request()->attributes->set(self::KEY_SUBJECT_TYPE, $type);
        self::request()->attributes->set(self::KEY_SUBJECT_ID, $id);
    }

    public static function setChanges(?array $oldValues, ?array $newValues): void
    {
        if ($oldValues !== null) {
            self::request()->attributes->set(self::KEY_OLD_VALUES, $oldValues);
        }
        if ($newValues !== null) {
            self::request()->attributes->set(self::KEY_NEW_VALUES, $newValues);
        }
    }

    public static function describe(string $description, ?string $subjectType = null, $subjectId = null, ?array $oldValues = null, ?array $newValues = null): void
    {
        self::setDescription($description);
        if ($subjectType !== null) {
            self::setSubject($subjectType, $subjectId);
        }
        self::setChanges($oldValues, $newValues);
    }

    public static function getDescription(Request $request): ?string
    {
        return $request->attributes->get(self::KEY_DESCRIPTION);
    }

    public static function getSubjectType(Request $request): ?string
    {
        return $request->attributes->get(self::KEY_SUBJECT_TYPE);
    }

    public static function getSubjectId(Request $request)
    {
        return $request->attributes->get(self::KEY_SUBJECT_ID);
    }

    public static function getOldValues(Request $request): ?array
    {
        return $request->attributes->get(self::KEY_OLD_VALUES);
    }

    public static function getNewValues(Request $request): ?array
    {
        return $request->attributes->get(self::KEY_NEW_VALUES);
    }

    protected static function request(): Request
    {
        return app('request');
    }
}
