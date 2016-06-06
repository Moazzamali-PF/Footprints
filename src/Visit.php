<?php

namespace Kyranb\Footprints;

use Cookie;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{

    /**
     * The name of the database table
     * @var string
     */
    protected $table = 'visits';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at',
    ];


    /**
     * Constructor
     * Override constructor to set the table name @ time of instantiation
     */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('footprints.table_name'));
    }



    /**
     * Get the account that owns the visit.
     */
    public function account()
    {
        $model = config('footprints.model');

        return $this->belongsTo($model, config('footprints.column_name'));
    }

    /**
     * Scope a query to only include previous visits.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePreviousVisits($query)
    {
        return $query->where('cookie_token', Cookie::get(config('footprints.cookie_name')));
    }
}
