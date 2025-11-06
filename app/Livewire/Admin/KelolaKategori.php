<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;

class KelolaKategori extends Component
{
    public $categories, $name, $type, $description, $is_active = true, $category_id;
    public $isEdit = false;

    public function render()
    {
        $this->categories = Category::orderBy('created_at', 'desc')->get();
        return view('livewire.admin.kelola-kategori')
            ->layout('layouts.app');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->type = '';
        $this->description = '';
        $this->is_active = true;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|max:50',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Kategori berhasil ditambahkan.');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category_id = $id;
        $this->name = $category->name;
        $this->type = $category->type;
        $this->description = $category->description;
        $this->is_active = $category->is_active;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|max:50',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($this->category_id);
        $category->update([
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Kategori berhasil diperbarui.');
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
    }
}
