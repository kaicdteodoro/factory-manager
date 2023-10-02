<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SampleRepository;
use App\Models\Sample;
use App\Validators\SampleValidator;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class SampleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SampleRepositoryEloquent extends BaseRepository implements SampleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Sample::class;
    }



    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
