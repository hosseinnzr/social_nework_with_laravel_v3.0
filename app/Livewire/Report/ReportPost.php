<?php

namespace App\Livewire\Report;

use Livewire\Component;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportPost extends Component
{
    public string $selectedReason = '';
    public int $relatedContentId;

    public $state = 0;

    protected $rules = [
        'selectedReason' => 'required|string',
    ];

    public function sendReport()
    {
        $this->validate();

        Report::create([
            'UID' => Auth::id(),
            'type' => 'post',
            'related_content_id' => $this->relatedContentId,
            'status' => 'pending',
            'message' => $this->selectedReason,
            'answer' => null,
            'isdeleted' => false,
        ]);

        $this->state = 1;
        session()->flash('message', 'Report submitted successfully!');
        $this->reset('selectedReason');
    }

    public function backToReport(){
        $this->state = 0;
    }

    public function render()
    {
        return view('livewire.report.report-post');
    }
}
