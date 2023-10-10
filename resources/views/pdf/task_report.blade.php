<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Report</title>
    <style>
        /* Define your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            font-size:13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .truncate-text {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
<div class="card-body box-profile text-center"> <!-- Added 'text-center' class here -->
    <h3 class="profile-username float-right">{{$task->task_title}}</h3>

    <ul class="list-group list-group-unbordered mb-3">
        <li class="list-group-item">
            <b>SBU : </b> <a class="float-right">{{ $task->sbu->name}}</a>
        </li>
        <li class="list-group-item">
            <b>Task Opening Date : </b> <a class="float-right">{{ \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') }}</a>
        </li>
        <li class="list-group-item">
            <b>Expected Closing Date : </b> <a class="float-right">{{ \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') }}</a>
        </li>
        
        <li class="list-group-item">
            <b>Target Office :</b>
            @php
                $a_office = json_decode($task->a_office);
                $combinedOffice = implode(', ', $a_office);
            @endphp
            <a class="float-right">{{ $combinedOffice }}</a>
        </li>

        <li class="list-group-item">
            <b>Time Left :</b>
            
            <a class="float-right">
                @php
                    $expectedClosingDate = \Carbon\Carbon::parse($task->end_date);
                    $currentDate = \Carbon\Carbon::now();

                    if ($currentDate->gt($expectedClosingDate)) {
                        // The current date is greater than the expected closing date, so it's finished.
                        echo "Time finished";
                    } else {
                        // Calculate the days remaining, considering years, months, and days.
                        $diff = $expectedClosingDate->diff($currentDate);
                        $daysRemaining = $diff->format('%m months,%d days');
                        echo $daysRemaining . " left";
                    }
                @endphp
            </a>
        </li>

        @if(!empty($task->remarks))
            <li class="list-group-item">
                <b style="color:red">Issuees Reason:</b><a class="float-right">{{ $task->remarks }}</a>
            </li>
        @endif
    </ul>
</div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Stage</th>
                <th>Start/Approval/Reject Date</th>
                <th>Expected Approval Date</th>
                <th>Updated Start/Approval/Reject Date</th>
              
                <th>Reason</th>
                <th>Stage Status</th>
                <!-- <th>Update Progress</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach ($taskData as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $data->stage_status }}
                        <br>
                        <small>Created Date: {{ $data->created_at->format('Y-m-d') }}</small><br>
                        <small><span class="badge badge-warning">Updated Date: {{ $data->updated_at->format('Y-m-d') }}</span></small>
                    </td>
                    <td>{{ $data->start_date }}</td>
                    <td>{{ $data->end_date }}</td>
                    <td>{{ $data->Updated_start_date }}</td>
                  
                    <td>
                        <div class="truncate-text">
                            @if (strlen($data->reason_description) > 0)
                                {{ substr($data->reason_description, 0, 50) }}...
                            @endif
                        </div>
                    </td>
                    <td class="project-state">
                        @if($data->task_status == 1)
                            <span class="badge badge-pill badge-info">Started</span>
                        @elseif($data->task_status == 2)
                            <span class="badge badge-pill badge-info">Working</span>
                        @elseif($data->task_status == 3)
                            <span class="badge badge-pill badge-success">Completed</span>
                        @elseif($data->task_status == 4)
                            <span class="badge badge-pill badge-danger">Rejected</span>
                        @endif
                    </td>
                    <!-- <td class="project-actions text-center">
                        <a class="btn btn-info btn-sm" href="{{ route('stage.edit', ['stage' => $data->id]) }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </td> -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
