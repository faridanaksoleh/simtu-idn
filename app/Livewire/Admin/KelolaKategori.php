<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;

class KelolaKategori extends Component
{
    public $categories, $name, $type, $description, $is_active = true, $category_id;
    public $isEdit = false;
    public $deleteCategoryId = null;

    // 🔥 TAMBAHKAN LISTENER
    protected $listeners = ['deleteConfirmed' => 'performDelete'];

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
        $this->category_id = null;
        $this->deleteCategoryId = null;
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

        $this->dispatch('showSuccess', [
            'message' => 'Kategori berhasil ditambahkan.'
        ]);

        $this->resetInputFields();
        $this->dispatch('closeModal');
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

        $this->dispatch('showSuccess', [
            'message' => 'Kategori berhasil diperbarui.'
        ]);

        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    // 🔥 METHOD UNTUK SWEETALERT CONFIRMATION
    public function confirmDelete($id)
    {
        $this->deleteCategoryId = $id;
        $category = Category::findOrFail($id);
        
        $this->dispatch('showDeleteConfirmation', [
            'title' => 'Hapus Kategori?',
            'text' => "Yakin ingin menghapus kategori {$category->name}?",
            'confirmText' => 'Ya, Hapus!',
            'cancelText' => 'Batal',
            'id' => $id
        ]);
    }

    // 🔥 METHOD YANG DIPANGGIL SETELAH KONFIRMASI
    public function performDelete()
    {
        if ($this->deleteCategoryId) {
            $category = Category::findOrFail($this->deleteCategoryId);
            $categoryName = $category->name;
            $category->delete();
            
            $this->dispatch('showSuccess', [
                'message' => "Kategori {$categoryName} berhasil dihapus."
            ]);
            
            $this->deleteCategoryId = null;
        }
    }

    // 🔥 FALLBACK METHOD
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $categoryName = $category->name;
        $category->delete();
        
        $this->dispatch('showSuccess', [
            'message' => "Kategori {$categoryName} berhasil dihapus."
        ]);
    }
}