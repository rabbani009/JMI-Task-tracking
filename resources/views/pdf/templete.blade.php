@php
use App\Models\StageTrack;
@endphp

<!DOCTYPE html>
<html>
<head>
<style>
        /* Basic Styles */
        
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {

            border: 1px solid #ddd;
            padding: 7px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }   

        /* Table Header Styles */
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Table Hover Effect */
        tbody tr:hover {
            background-color: #f5f5f5;
        }

            .content-wrapper {
            text-align: center;
            margin-top: 50px; /* Adjust the top margin as needed for vertical alignment */
            }

            h1 {
                margin: 5px 0;
                font-size: 24px; 
                color:#024F62;
            }

            p {
                margin: 10px 0;
                font-size: 18px;
                text-transform: capitalize;

            }

    </style>
</head>
<body>
     <div class="content-wrapper">
        <h1>JMI Group</h1>
        <p>Task Overall Report Overview</p>
     </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Task Title</th>
                <th>SBU</th>
                <th>User</th>
                <th>Belong Office</th>
                <th>Task Status</th>
                <th>Product Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($taskall as $row)
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
                            
                            $allStagesApproved = $approvedStages->count() === count($taskApprovedSteps);
                            $anyStages = $row->stageTracks->isNotEmpty();
                        @endphp

                        @if ($allStagesApproved)
                            Approved
                        @elseif ($anyStages)
                              In progress
                        @else
                            Not Started
                        @endif
                    </td>
                    <td>{{ $row->p_type }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
