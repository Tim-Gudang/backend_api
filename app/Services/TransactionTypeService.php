<?php

namespace App\Services;

use App\Repositories\BarangCategoryRepository;
use App\Repositories\TransactionTypeRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class TransactionTypeService
{
    protected $transactionTypeRepository;
    public function __construct(TransactionTypeRepository $transactionTypeRepository)
    {
        $this->transactionTypeRepository = $transactionTypeRepository;
    }

    public function getAll()
    {
        return $this->transactionTypeRepository->getAll();
    }

    public function getById($id)
    {
        return $this->transactionTypeRepository->findById($id);
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255|unique:barang_categories,name',
        ], [
            'name.required' => 'Nama kategori barang wajib diisi',
            'name.unique' => 'Nama kategori barang sudah digunakan',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data['slug'] = Str::slug($data['name']);

        return $this->transactionTypeRepository->create($data);
    }

    public function update($id, array $data)
    {
        $transactionType = $this->transactionTypeRepository->findById($id);
        if (!$transactionType) {
            throw new \Exception('Tipe Transaksi tidak ditemukan.');
        }

        $validator = Validator::make($data, [
            'name' => "required|string|max:255|unique:barang_categories,name,{$transactionType->id}",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data['slug'] = Str::slug($data['name']);

        $this->transactionTypeRepository->update($transactionType, $data);

        return $transactionType;
    }

    public function delete($id)
    {
        $transactionType = $this->transactionTypeRepository->findById($id);
        if (!$transactionType) {
            throw new \Exception('Kategori barang tidak ditemukan');
        }

        return $this->transactionTypeRepository->delete($transactionType);
    }
}
