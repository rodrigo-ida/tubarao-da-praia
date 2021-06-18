<?php

namespace App\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ActiveOffersCriteria
 * @package namespace App\Criteria;
 */
class ActiveOffersCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereActive(true)
            ->where(function ($query) {
                $query->where('begins_at', '<=', Carbon::today())
                    ->orWhereNull('begins_at');
            })
            ->where(function ($query) {
                $query->where('expires_at', '>=', Carbon::today())
                    ->orWhereNull('expires_at');
            });
    }
}
