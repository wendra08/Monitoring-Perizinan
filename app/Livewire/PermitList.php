<?php

namespace App\Livewire;

use App\Models\Permit;
use Livewire\Component;

class PermitList extends Component
{
    public $search = '';
    public $status = 'all';
    public $expiry = '';
    public $sortBy = 'expiry_date';
    public $sortOrder = 'asc';
    public $division = '';

    public $selectedPermits = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'expiry' => ['except' => ''],
        'division' => ['except' => ''],
        'sortBy' => ['except' => 'expiry_date'],
        'sortOrder' => ['except' => 'asc'],
    ];

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedPermits = $this->getFilteredPermits()->pluck('id')->toArray();
        } else {
            $this->selectedPermits = [];
        }
    }

    public function updatedSelectedPermits()
    {
        $this->selectAll = count($this->selectedPermits) === $this->getFilteredPermits()->count();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'status', 'expiry', 'division', 'sortBy', 'sortOrder']);
    }

    public function clearSelection()
    {
        $this->selectedPermits = [];
        $this->selectAll = false;
    }

    private function getFilteredPermits()
    {
        $query = Permit::query();

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('permit_name', 'like', "%{$this->search}%")
                  ->orWhere('permit_number', 'like', "%{$this->search}%")
                  ->orWhere('boss_name', 'like', "%{$this->search}%")
                  ->orWhere('boss_email', 'like', "%{$this->search}%")
                  ->orWhere('division', 'like', "%{$this->search}%");
            });
        }

        // Status filter
        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }

        // Division filter
        if ($this->division) {
            $query->where('division', $this->division);
        }

        // Expiry filter
        if ($this->expiry) {
            switch ($this->expiry) {
                case 'expired':
                    $query->where('expiry_date', '<', now());
                    break;
                case '30_days':
                    $query->whereBetween('expiry_date', [now(), now()->addDays(30)]);
                    break;
                case '60_days':
                    $query->whereBetween('expiry_date', [now(), now()->addDays(60)]);
                    break;
                case '90_days':
                    $query->whereBetween('expiry_date', [now(), now()->addDays(90)]);
                    break;
                case '180_days':
                    $query->whereBetween('expiry_date', [now(), now()->addDays(180)]);
                    break;
            }
        }

        // Sort
        $query->orderBy($this->sortBy, $this->sortOrder);

        return $query;
    }

    public function render()
    {
        $permits = $this->getFilteredPermits()->get();

        return view('livewire.permit-list', [
            'permits' => $permits
        ]);
    }

}
