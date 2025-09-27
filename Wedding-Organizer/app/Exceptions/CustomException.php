<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Custom Exception untuk aplikasi Wedding Organizer
 * 
 * @package App\Exceptions
 */
class CustomException extends Exception
{
    /**
     * @var int
     */
    protected int $statusCode;

    /**
     * @var array
     */
    protected array $errors;

    /**
     * Constructor
     *
     * @param string $message
     * @param int $statusCode
     * @param array $errors
     * @param Exception|null $previous
     */
    public function __construct(
        string $message = 'Terjadi kesalahan',
        int $statusCode = 500,
        array $errors = [],
        Exception $previous = null
    ) {
        parent::__construct($message, 0, $previous);
        $this->statusCode = $statusCode;
        $this->errors = $errors;
    }

    /**
     * Get status code
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Render exception as JSON response
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $this->getMessage(),
        ];

        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        }

        return response()->json($response, $this->statusCode);
    }

    /**
     * Create validation exception
     *
     * @param string $message
     * @param array $errors
     * @return static
     */
    public static function validation(string $message = 'Validasi gagal', array $errors = []): static
    {
        return new static($message, 422, $errors);
    }

    /**
     * Create not found exception
     *
     * @param string $message
     * @return static
     */
    public static function notFound(string $message = 'Data tidak ditemukan'): static
    {
        return new static($message, 404);
    }

    /**
     * Create unauthorized exception
     *
     * @param string $message
     * @return static
     */
    public static function unauthorized(string $message = 'Tidak memiliki akses'): static
    {
        return new static($message, 401);
    }

    /**
     * Create forbidden exception
     *
     * @param string $message
     * @return static
     */
    public static function forbidden(string $message = 'Akses ditolak'): static
    {
        return new static($message, 403);
    }

    /**
     * Create bad request exception
     *
     * @param string $message
     * @param array $errors
     * @return static
     */
    public static function badRequest(string $message = 'Request tidak valid', array $errors = []): static
    {
        return new static($message, 400, $errors);
    }

    /**
     * Create internal server error exception
     *
     * @param string $message
     * @return static
     */
    public static function serverError(string $message = 'Terjadi kesalahan server'): static
    {
        return new static($message, 500);
    }
}