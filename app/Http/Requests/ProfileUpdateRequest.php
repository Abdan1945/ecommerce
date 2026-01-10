<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Semua user yang login boleh update profil
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Rules validasi update profil
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/',
            ],

            'address' => [
                'nullable',
                'string',
                'max:500',
            ],

            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ],
        ];
    }

    /**
     * Pesan error custom (Bahasa Indonesia)
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'phone.regex' => 'Format nomor telepon tidak valid. Gunakan 08xx atau +628xx.',
            'avatar.max' => 'Ukuran foto maksimal 2MB.',
            'avatar.dimensions' => 'Dimensi foto harus antara 100x100 hingga 2000x2000 pixel.',
        ];
    }

    /**
     * Nama atribut untuk pesan error
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'email' => 'alamat email',
            'phone' => 'nomor telepon',
            'address' => 'alamat',
            'avatar' => 'foto profil',
        ];
    }
}
