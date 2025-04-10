<?php

namespace App\Http\Requests\Product;

use App\Helpers\ResponseFormatter;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sku' => 'required|string|max:100|unique:mysql.products,sku',
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'categoryId' => 'required|uuid|exists:mysql.categories,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'sku.required' => 'SKU is empty.',
            'sku.string' => 'SKU must be a string.',
            'sku.max' => 'SKU length must not more than 100 characters.',
            'sku.unique' => 'SKU is unique.',
            'name.required' => 'Name is empty.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name length must not more than 255 characters.',
            'price.required' => 'Price is empty.',
            'price.integer' => 'Price must be an integer.',
            'price.min' => 'Price must not negative.',
            'stock.required' => 'Stock is empty.',
            'stock.integer' => 'Stock must be an integer.',
            'stock.min' => 'Stock must not negative.',
            'categoryId.required' => 'Category ID is empty.',
            'categoryId.uuid' => 'Category ID must be a valid UUID.',
            'categoryId.exists' => 'Category ID not found.',
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
}
