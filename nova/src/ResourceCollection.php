<?php

namespace Laravel\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ResourceCollection extends Collection
{
    /**
     * Return the authorized resources of the collection.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Nova\ResourceCollection
     */
    public function authorized(Request $request)
    {
        return $this->filter(function ($resource) use ($request) {
            return $resource::authorizedToViewAny($request);
        });
    }

    /**
     * Return the resources available to be displayed in the navigation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Nova\ResourceCollection
     */
    public function availableForNavigation(Request $request)
    {
        return $this->filter(function ($resource) use ($request) {
            return $resource::availableForNavigation($request);
        });
    }

    /**
     * Return the searchable resources for the collection.
     *
     * @return \Laravel\Nova\ResourceCollection
     */
    public function searchable()
    {
        return $this->filter(function ($resource) {
            return $resource::$globallySearchable;
        });
    }
}
