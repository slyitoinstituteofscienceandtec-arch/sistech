<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'status',
        'two_factor_enabled',
        'last_login_at',
        'campus',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
        ];
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'lecturer_id');
    }

    public function parentRecord()
    {
        return $this->hasOne(ParentModel::class);
    }

    public function notifications_list()
    {
        return $this->hasMany(Notification::class);
    }

    public function loginHistory()
    {
        return $this->hasMany(LoginHistory::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isPrincipal()
    {
        return $this->role === 'principal';
    }

    public function isRegistrar()
    {
        return $this->role === 'registrar';
    }

    public function isAccountant()
    {
        return $this->role === 'accountant';
    }

    public function isLecturer()
    {
        return $this->role === 'lecturer';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isParent()
    {
        return $this->role === 'parent';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isAdmin()
    {
        return in_array($this->role, ['super_admin', 'principal', 'registrar', 'accountant', 'staff']);
    }
}
