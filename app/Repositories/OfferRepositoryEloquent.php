<?php

namespace App\Repositories;

use App\Offer;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class OfferRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OfferRepositoryEloquent extends BaseRepository implements OfferRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Offer::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
