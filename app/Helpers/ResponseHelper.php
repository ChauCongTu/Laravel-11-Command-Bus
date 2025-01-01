<?php

namespace App\Helpers;

class ResponseHelper
{
    /**
     * Generate a standardized JSON response.
     *
     * This method provides a consistent structure for JSON responses, including
     * a status code, a status message derived from the code, a message, and optional data.
     * It is intended for use in API controllers to simplify response creation and ensure consistency.
     *
     * @param int $statusCode The HTTP status code for the response.
     * @param string $message A message describing the response.
     * @param mixed $data Optional data to include in the response.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public static function response(int $statusCode = 200, string $message = 'Operation successful', $data = null)
    {
        $isSuccess = $statusCode >= 200 && $statusCode < 300;

        $response = [
            'success' => $isSuccess,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a successful response.
     *
     * @param string $message A message describing the response.
     * @param mixed $data Optional data to include in the response.
     * @param int $statusCode The HTTP status code for the response.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public static function success($data = null, string $message = 'Success', int $statusCode = 200)
    {
        return self::response($statusCode, $message, $data);
    }

    /**
     * Return a failed response.
     *
     * @param string $message A message describing the response.
     * @param int $statusCode The HTTP status code for the response.
     * @param mixed $errors Optional errors to include in the response.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public static function fail(string $message = 'Failed', int $statusCode = 400, $errors = null)
    {
        return self::response($statusCode, $message, $errors);
    }
}
