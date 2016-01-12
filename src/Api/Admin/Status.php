<?php

namespace Searchmetrics\Api\Admin;

use Searchmetrics\Api\ApiEndpoint;

/**
 * Class Status.
 */
class Status extends ApiEndpoint
{
    /**
     * URL endpoint for project listing.
     */
    const LIST_PROJECTS_ENDPOINT = 'AdminStatusGetListProjects';

    /**
     * URL endpoint for project search engine listing.
     */
    const LIST_PROJECT_SEARCH_ENGINES_ENDPOINT = 'AdminStatusGetListProjectSearchEngines';

    /**
     * @param int $limit
     * @param int $offset
     *
     * @see http://api.searchmetrics.com/v3/documentation/api-calls/service/AdminStatusGetListProjects
     *
     * @return array
     *               The response from the AdminStatusGetListProjects endpoint.
     */
    public function getListProjects($limit = 10, $offset = 0)
    {
        $args = compact('limit', 'offset');

        return $this->connection->makeGetRequest(self::LIST_PROJECTS_ENDPOINT, $args);
    }

    /**
     * @param int $project_id
     *
     * @see http://api.searchmetrics.com/v3/documentation/api-calls/service/AdminStatusGetListProjectSearchEngines
     *
     * @return array
     *               The response from the AdminStatusGetListProjects endpoint.
     */
    public function getListProjectSearchEngines($project_id)
    {
        $args = compact('project_id');

        return $this->connection->makeGetRequest(self::LIST_PROJECT_SEARCH_ENGINES_ENDPOINT, $args);
    }
}
