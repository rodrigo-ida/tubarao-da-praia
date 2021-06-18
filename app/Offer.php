<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'active',
        'begins_at',
        'expires_at',
        'image_filename',
        'coupon_limit',
    ];

    static $images_storage_path = 'media/offers';

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    /**
     * Checks if this offer has a image defined
     * @return bool true if the image_filename is defined or false otherwise
     */
    public function hasImage()
    {
        return $this->image_filename && !empty($this->image_filename);
    }

    /**
     * Returns the Path of the image or null in case the image_file attribute is not set or empty.
     * Internally, uses hasImage function to verify this question
     * @return string|null
     */
    public function getImagePath()
    {
        if (!$this->hasImage()) {
            return null;
        }
        return self::$images_storage_path . '/' . $this->image_filename;
    }

    /**
     * Returns the URL of the image or null in case the image_file attribute is not set or empty.
     * Internally, uses hasImage function to verify this question
     * @return string|null
     */
    public function getImageURL()
    {
        return $this->hasImage() ? asset('storage/' . $this->getImagePath()) : null;
    }

    public function isActive(){
        return is_null($this->active) ? false : $this->active;
    }

    /**
     * Checks whether the initial clauses are satisfied
     * @return bool true when the variable $begins_at is not defined or if is, when the current (today) date is greater or equal to that date. Returns false otherwise.
     */
    protected function checkBeginsAt(){
        $now = Carbon::today();
        $begins = is_null($this->begins_at) ? null : is_string($this->begins_at) ? Carbon::parse($this->begins_at) : $this->begins_at;
        $begins_pass = $begins == null ? true : $now->greaterThanOrEqualTo($begins);
        return $begins_pass;
    }

    /**
     * Checks whether the expiration clauses are satisfied
     * @return bool true when the variable $expires_at is not defined or if is, when the current (today) date is lower or equal to that date. Returns false otherwise.
     */
    protected function checkExpiresAt(){
        $now = Carbon::today();
        $expires = is_null($this->expires_at) ? null : is_string($this->expires_at) ? Carbon::parse($this->expires_at) : $this->expires_at;
        $expires_pass = $expires == null ? true : $now->lessThanOrEqualTo($expires);
        return $expires_pass;
    }

    /**
     * Check if the client can use this offer.
     * @return bool true in case can use it. Returns false otherwise
     */
    public function canClientUseIt(){
        if (!$this->isActive()) {
            return false;
        }
        return $this->checkBeginsAt() && $this->checkExpiresAt();
    }
}
