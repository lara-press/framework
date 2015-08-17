<?php namespace LaraPress\Auth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable;

    public $timestamps = false;
    protected $primaryKey = 'ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_login', 'user_nicename', 'user_email', 'display_name', 'user_pass'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['user_pass', 'remember_token'];

    public function getTable()
    {
        return DB_TABLE_PREFIX . 'users';
    }

    /**
     * @param $capability
     *
     * @return bool
     */
    public function can($capability)
    {
        return user_can($this->ID, $capability);
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->user_pass;
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->user_email;
    }

    /**
     * Update the user properties.
     *
     * @param array $attributes
     *
     * @return bool|int
     */
    public function update(array $attributes = [])
    {
        $attributes = array_merge($attributes, ['ID' => $this->ID]);

        if (is_wp_error(wp_update_user($attributes))) {
            return false;
        }

        $this->setRawAttributes($attributes, true);

        return true;
    }
}
