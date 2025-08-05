<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Str;

class APIKey extends Model
{
    protected $fillable = [
        'name',
        'secret',
        'scopes',
        'expires'
    ];

    protected $table = 'api_keys';

    public static function createFromName(string $name, array $scopes, string &$secret): APIKey
    {
        $secret = Str::random(64);

        $key = new APIKey([
            'name' => $name,
            'scopes' => json_encode($scopes),
            'secret' => hash('sha256', $secret),
            'expires' => Carbon::now()->addDays(90)
        ]);
        $key->save();
        Cache::flush();

        return $key;
    }

    public function bearerToken(string $actualSecret): string
    {
        return base64_encode(json_encode([
            'key' => $actualSecret,
            'name' => $this->name
        ]));
    }

    public static function getByNameAndKey(string $name, string $key): APIKey|null
    {
        $cacheKey = 'api-key-' . hash('sha256', $name . $key);
        return Cache::remember($cacheKey, 60, function() use($name, $key) {
            return APIKey::where('name', '=', $name)->where('secret', '=', hash('sha256', $key))->first();
        });
    }

    public function isExpired(): bool
    {
        $ttl = Carbon::parse($this->expires);
        if (!$ttl) {
            return false;
        }

        return $ttl->isPast();
    }

    public static function validate(string $name, string $key)
    {
        $cacheKey = 'api-key-' . hash('sha256', $name . $key);

        $key = APIKey::getByNameAndKey($name, $key);
        
        if ($key === null) {
            Cache::forget($cacheKey);
            return null;
        }
        
        if ($key->isExpired()) {
            return null;
        }

        return $key;
    }

    public function getScopes()
    {
        return json_decode($this->getAttribute('scopes'));
    }

    public function hasScope(string|array $scope): bool
    {
        $scopes = $this->getScopes();
        if (in_array('*', $scopes)) {
            return true;
        }

        if (is_string($scope)) {
            return in_array($scope, $scopes);
        }
        foreach ($scope as $oneScope) {
            if (!$this->hasScope($oneScope)) {
                return false;
            }
        }
        return true;
    }
}
