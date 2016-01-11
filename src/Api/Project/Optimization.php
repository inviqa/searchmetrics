<?php namespace Searchmetrics\Api\Project;

use Searchmetrics\Api\ApiEndpoint;

/**
 * Class Optimization.
 *
 * @package Searchmetrics\Api\Project
 */
class Optimization extends ApiEndpoint
{

    /**
     * URL endpoint for creating a new Searchmetrics scan.
     */
    const POST_CONTENT_REQUEST_ENDPOINT = 'ProjectOptimizationPostValueContentRequest';

    /**
     * URL endpoint for getting the status of a scan.
     */
    const GET_LIST_CONTENT_STATUS_ENDPOINT = 'ProjectOptimizationGetListContentStatus';

    /**
     * URL endpoint for retrieving scan data.
     */
    const GET_LIST_CONTENT_DETAIL_ENDPOINT = 'ProjectOptimizationGetListContentDetail';

    /**
     * @param string $keyword
     * @param int $project_id
     * @param int $se_id
     * @param string $additional_keywords
     * @param string $name
     * @param string $text
     *
     * @see http://api.searchmetrics.com/v3/documentation/api-calls/service/ProjectOptimizationPostValueContentRequest
     *
     * @return array
     *   The response from the ProjectOptimizationPostValueContentRequest endpoint.
     */
    public function postValueContentRequest(
        $keyword,
        $project_id,
        $se_id,
        $additional_keywords = null,
        $name = null,
        $text = null
    ) {

        $args = compact(
            'keyword',
            'project_id',
            'se_id',
            'additional_keywords',
            'name',
            'text'
        );

        return $this->connection->makePostRequest(self::POST_CONTENT_REQUEST_ENDPOINT, $args);

    }


    /**
     * @param int $crawl_id
     * @param int $project_id
     *
     * @see http://api.searchmetrics.com/v3/documentation/api-calls/service/ProjectOptimizationGetListContentStatus
     *
     * @return array
     *   The response from the ProjectOptimizationGetListContentStatus endpoint.
     */
    public function getListContentStatus($crawl_id, $project_id)
    {

        $args = compact(
            'crawl_id',
            'project_id'
        );

        return $this->connection->makeGetRequest(self::GET_LIST_CONTENT_STATUS_ENDPOINT, $args);

    }


    /**
     * @param int $crawl_id
     * @param int $project_id
     * @param int $limit
     * @param int $offset
     * @param string $sort
     * @param string $type
     * @param string $show
     *
     * @see http://api.searchmetrics.com/v3/documentation/api-calls/service/ProjectOptimizationGetListContentDetail
     *
     * @return array
     *   The response from the ProjectOptimizationGetListContentDetail endpoint.
     */
    public function getListContentDetail(
        $crawl_id,
        $project_id,
        $limit = null,
        $offset = null,
        $sort = null,
        $type = null,
        $show = null
    ) {

        $args = compact(
            'crawl_id',
            'project_id',
            'limit',
            'offset',
            'type',
            'sort',
            'show'
        );

        return $this->connection->makeGetRequest(self::GET_LIST_CONTENT_DETAIL_ENDPOINT, $args);

    }
}
