<?php

if (!function_exists('api_error_response')) {

    /**
     * description
     *
     * @param \Exception $e
     * @return
     */
    function api_error_response(Exception $e)
    {
        return response()->json([
            'status'  => 'failed',
            'message' => 'failed to get resources',
            'data'    => ['description' => $e->getMessage()]
        ], 400);
    }
}
