<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    use ApiResponses, AuthorizesRequests;
    protected $policyClass;
    public function include(string $relationship):bool
    {
        $param = request()->get('include');
        if (!isset($param)) {
            return false;
        }

        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValues);
    }

    /**
     * @throws AuthorizationException
     */
    public function isAble($ability, $targetModel)
    {
         return $this->authorize($ability, [$targetModel, $this->policyClass]);

    }
}
