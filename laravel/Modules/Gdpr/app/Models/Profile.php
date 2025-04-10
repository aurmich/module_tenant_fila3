<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Modules\User\Models\BaseProfile;

/**
 * Modules\Gdpr\Models\Profile.
 *
 * @property int                                                                                                           $id
 * @property string|null                                                                                                   $type
 * @property string|null                                                                                                   $first_name
 * @property string|null                                                                                                   $last_name
 * @property string|null                                                                                                   $full_name
 * @property string|null                                                                                                   $email
 * @property int                                                                                                           $id
 * @property string|null                                                                                                   $type
 * @property string|null                                                                                                   $first_name
 * @property string|null                                                                                                   $last_name
 * @property string|null                                                                                                   $full_name
 * @property string|null                                                                                                   $email
 *                                                                                                                                                    =======
 *                                                                                                                                                    >>>>>>> 76348cc6b642ef946f57e308db4e1c6210448bea
 * @property \Illuminate\Support\Carbon|null                                                                               $created_at
 * @property \Illuminate\Support\Carbon|null                                                                               $updated_at
 * @property string|null                                                                                                   $user_id
 * @property string|null                                                                                                   $updated_by
 * @property string|null                                                                                                   $created_by
 * @property \Illuminate\Support\Carbon|null                                                                               $deleted_at
 * @property string|null                                                                                                   $deleted_by
 * @property int                                                                                                           $is_active
 *                                                                                                                                                    =======
 * @property int                                                                                                           $id
 * @property string|null                                                                                                   $type
 * @property string|null                                                                                                   $first_name
 * @property string|null                                                                                                   $last_name
 * @property string|null                                                                                                   $full_name
 * @property string|null                                                                                                   $email
 * @property \Illuminate\Support\Carbon|null                                                                               $created_at
 * @property \Illuminate\Support\Carbon|null                                                                               $updated_at
 * @property string|null                                                                                                   $user_id
 * @property string|null                                                                                                   $updated_by
 * @property string|null                                                                                                   $created_by
 * @property \Illuminate\Support\Carbon|null                                                                               $deleted_at
 * @property string|null                                                                                                   $deleted_by
 * @property bool                                                                                                          $is_active
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes                                                             $extra
 * @property string                                                                                                        $avatar
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser>                                $deviceUsers
 * @property int|null                                                                                                      $device_users_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device>                                    $devices
 * @property int|null                                                                                                      $devices_count
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media>    $media
 * @property int|null                                                                                                      $media_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser>                                $mobileDeviceUsers
 * @property int|null                                                                                                      $mobile_device_users_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device>                                    $mobileDevices
 * @property int|null                                                                                                      $mobile_devices_count
 * @property \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property int|null                                                                                                      $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission>                                $permissions
 * @property int|null                                                                                                      $permissions_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role>                                      $roles
 * @property int|null                                                                                                      $roles_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team>                                      $teams
 * @property int|null                                                                                                      $teams_count
 * @property \Modules\Xot\Contracts\UserContract|null                                                                      $user
 * @property string|null                                                                                                   $user_name
 *
 * @method static \Modules\Gdpr\Database\Factories\ProfileFactory   factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile withoutRole($roles, $guard = null)
 *
 * @property string|null $deleted_by
 * @property int         $is_active
 *
 * @method static \Modules\Gdpr\Database\Factories\ProfileFactory   factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile withoutRole($roles, $guard = null)
 *
 * @property string|null $deleted_by
 * @property int         $is_active
 *
 * @method static \Modules\Gdpr\Database\Factories\ProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereUserId($value)
 *
 * @property \Modules\User\Models\DeviceUser             $pivot
 * @property \Modules\User\Models\Membership             $membership
 * @property string                                      $credits
 * @property string|null                                 $slug
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereSlug($value)
 *
 * @property int $oauth_enable
 * @property int $credentials_enable
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCredentialsEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereOauthEnable($value)
 *
 * @property string $uuid
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUuid($value)
 *
 * @mixin \Eloquent
 */
class Profile extends BaseProfile
{
    /** @var string */
    protected $connection = 'gdpr';
}
