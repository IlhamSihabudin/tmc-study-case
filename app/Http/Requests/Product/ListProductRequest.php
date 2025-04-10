<?php

namespace App\Http\Requests\Product;

use App\Helpers\ResponseFormatter;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ListProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $queryString = $_SERVER['QUERY_STRING'] ?? '';

        $this->merge([
            'sku' => $this->extractQueryParam($queryString, 'sku'),
            'name' => $this->extractQueryParam($queryString, 'name'),
            'category_id' => $this->extractQueryParam($queryString, 'category.id'),
            'category_name' => $this->extractQueryParam($queryString, 'category.name'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sku' => 'array',
            'sku.*' => 'string|max:100',
            'name' => 'array',
            'name.*' => 'string|max:255',
            'price_start' => 'numeric|min:0',
            'price_end' => 'numeric|gt:price_start',
            'stock_start' => 'numeric|min:0',
            'stock_end' => 'numeric|gt:stock_start',
            'category_id' => 'array',
            'category_id.*' => 'uuid',
            'category_name' => 'array',
            'category_name.*' => 'string|max:255',
            'size' => 'numeric|min:1',
            'current' => 'numeric|min:1',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return mixed
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $message = $validator->messages();
        $response = ResponseFormatter::error($message);
        throw new ValidationException($validator, $response);
    }

    /**
     * Extracts the value of a specific query parameter from the query string.
     *
     * @param string $queryString The query string to search in.
     * @param string $param The name of the parameter to extract.
     * @return array An array of values for the specified parameter.
     */
    protected function extractQueryParam(string $queryString, string $param): array
    {
        preg_match_all('/' . preg_quote($param, '/') . '=([^&]+)/', $queryString, $matches);
        return $matches[1] ?? [];
    }
}
