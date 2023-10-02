@php
use App\Models\StageTrack;
@endphp


@if(!empty($filtered_task))

  @foreach ($filtered_task as $row)
    <tr>
        <td>{{ $row->id }}</td>
        <td>{{ $row->task_title }}</td>
        <td>{{ $row->sbu->name }}</td>
        <td>{{ $row->user->name }}</td>
        <td>
        @foreach(json_decode($row->a_office) as $step)
            {{ $step }},
        @endforeach
        </td>
        <td>
            @php
                $taskApprovedSteps = json_decode($row->task_approved_steps, true);

                $approvedStages = StageTrack::where('task_id', $row->task_id)
                    ->whereIn('stage_status', $taskApprovedSteps)
                    ->where('task_status', 3)
                    ->get();
                    
                
                    foreach ($approvedStages as $stage) {
                        
                        }

                $allStagesApproved = $approvedStages->count() === count($taskApprovedSteps);
                $anyStages = $row->stageTracks->isNotEmpty();
            @endphp

            @if ($allStagesApproved)
                <span class="badge badge-pill badge-success">Approved</span>
            @elseif ($anyStages)
                <span class="badge badge-pill badge-info">On-Progress</span>
            @else
                <span class="badge badge-pill badge-warning">Not Started</span>
            @endif
    </td>
        <td>{{ $row->p_type }}</td>
    </tr>
    @endforeach

@else
            <tr>
                <td colspan="10">No data Found</td>
            </tr>
@endif