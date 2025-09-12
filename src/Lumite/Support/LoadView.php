<?php

namespace Lumite\Support;

use Lumite\Support\Pagination\Paginator;
use stdClass;

class LoadView
{
    /**
     * @param $view
     * @param $data
     * @param $loadHtml
     * @return mixed
     */
    public static function View($view, $data, $loadHtml): mixed
    {
        /*this is for original data get from pagination data*/
        $originalData = self::extractDataIfExistPagination($data);

        /*this is for getting pagination links var from original pagination data*/
        $paginateData = self::extractPaginationData($data);

        extract($originalData);  /*convert array key as variable here*/
        extract($paginateData); /*convert array key as variable here*/

        $engine = new \Lumite\Support\Blade\Engine(ROOT_PATH . '/views', ROOT_PATH . '/storage/views');

        // Build variables as previously extracted into scope
        $vars = [];
        if (is_array($originalData)) {
            $vars = array_merge($vars, $originalData);
        }
        if (is_array($paginateData)) {
            $vars = array_merge($vars, $paginateData);
        }

        if ($loadHtml) {
            return $engine->render($view, $vars, true);
        }

        return $engine->render($view, $vars);
    }


    /**
     * @param mixed $data
     * @return mixed
     */
    private static function extractDataIfExistPagination(mixed $data): mixed
    {
        // If not iterable, return as-is
        if (!is_iterable($data)) {
            return $data;
        }

        $result = [];

        foreach ($data as $key => $item) {
            if (is_array($item)) {
                if (isset($item['data'])) {
                    $result[$key] = $item['data'];
                    continue;
                }

                if (isset($item['simple']['data'])) {
                    $result[$key] = $item['simple']['data'];
                    continue;
                }
            }

            // If it's object or doesn't have pagination keys, keep as-is
            $result[$key] = $item;
        }

        return $result;
    }

    /**
     * @param $data
     * @return array
     */
    private static function extractPaginationData($data): array
    {
        $result['render'] = new stdClass();
        $response = [];

        if (is_object($data)) {
            return self::handlePaginatedObject($data, $result);
        }

        if (is_array($data)) {
            return self::handlePaginatedArray($data, $result);
        }

        return array_merge($result, $response);
    }

    // resolveBladeOrPhp removed; rendering is delegated to Engine

    /**
     * @param object $data
     * @param array $result
     * @return array
     */
    private static function handlePaginatedObject(object $data, array $result): array
    {
        $response = [];

        if (isset($data->data)) {
            $response['data'] = $data->data;
            unset($data->data);
            $result['render']->links = Paginator::pagination($data);

        } elseif (isset($data->simple) && isset($data->simple->data)) {
            $response['data'] = $data->simple->data;
            unset($data->simple->data);
            $result['render']->links = Paginator::simplePagination($data->simple);

        } else {
            $response['data'] = $data;
        }

        return array_merge($result, $response);
    }

    /**
     * @param array $data
     * @param array $result
     * @return array
     */
    private static function handlePaginatedArray(array $data, array $result): array
    {
        $response = [];

        foreach ($data as $key => $item) {
            if (is_array($item)) {
                $response[$key] = self::extractFromArray($item, $result);

            } elseif (is_object($item)) {
                $response[$key] = self::extractFromObject($item, $result);

            } else {
                $response[$key] = $item;
            }
        }

        return array_merge($result, $response);
    }

    /**
     * @param array $item
     * @param array $result
     * @return mixed
     */
    private static function extractFromArray(array $item, array &$result): mixed
    {
        if (isset($item['data'])) {
            $data = $item['data'];
            unset($item['data']);
            $result['render']->links = Paginator::pagination((object)$item);
            return $data;

        } elseif (isset($item['simple']['data'])) {
            $data = $item['simple']['data'];
            unset($item['simple']['data']);
            $result['render']->links = Paginator::simplePagination((object)$item['simple']);
            return $data;
        }

        return $item;
    }

    /**
     * @param object $item
     * @param array $result
     * @return object
     */
    private static function extractFromObject(object $item, array &$result): object
    {
        if (isset($item->data)) {
            $data = $item->data;
            unset($item->data);
            $result['render']->links = Paginator::pagination($item);
            return $data;

        } elseif (isset($item->simple) && isset($item->simple->data)) {
            $data = $item->simple->data;
            unset($item->simple->data);
            $result['render']->links = Paginator::simplePagination($item->simple);
            return $data;
        }

        return $item;
    }

}