<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projects extends Model
{

    /**
     * @return HasMany
     */
    public function cases() {

        return $this->hasMany('App\Cases');

    }

    /**
     * @return HasMany
     */
    public function notes() {

        return $this->hasMany('App\Notes');

    }

    /**
     * @return HasMany
     */
    public function tasks() {

        return $this->hasMany('App\Tasks');

    }
}
