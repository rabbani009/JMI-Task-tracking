$(document).ready(function () {
    // Select2 initialization
    $(".select2").select2();
    $("#council").select2({ passive: true });
    $("#area_of_expertise").select2({
        tags: true,
        tokenSeparators: [","],
        passive: true, // Mark the event listener for this element as passive
    });

    // DateTimePicker initialization
    $("#start_date").datetimepicker({
        default: true,
        format: "L",
        locale: "BST",
        format: "YYYY-MM-DD",
    });
    $("#end_date").datetimepicker({
        default: true,
        format: "L",
        locale: "BST",
        format: "YYYY-MM-DD",
        placeholder: "Select End Date",
    });

    // Click event for "Notify" button
    $(".notify-btn").on("click", function () {
        var taskId = $(this).data("task-id");

        $.ajax({
            url: "getTaskData/" + taskId,
            method: "GET",
            success: function (response) {
                // Update the modal fields with the retrieved data
                $("#taskTitle").val(response.task_title);
                $("#taskID").val(response.task_id);

                // Check if SBU data exists in the response
                if (response.sbu) {
                    $("#taskSBU").val(response.sbu.name); // Populate the SBU name
                } else {
                    $("#taskSBU").val(""); // Clear the SBU name field if no SBU data found
                }

                // Convert the start_date and end_date strings to Date objects
                var startDate = new Date(response.start_date);
                var endDate = new Date(response.end_date);

                // Format the dates as "YYYY-MM-DD"
                var formattedStartDate = formatDate(startDate);
                var formattedEndDate = formatDate(endDate);

                $("#startDate").val(formattedStartDate);
                $("#endDate").val(formattedEndDate);

                // Parse the JSON string for task_approved_steps
                var approvedSteps = JSON.parse(response.task_approved_steps);

                // Add the approvedSteps as options to the taskStatus dropdown
                var taskStatusDropdown = $("#stageStatus");
                taskStatusDropdown.empty(); // Clear existing options
                approvedSteps.forEach(function (step) {
                    taskStatusDropdown.append(
                        '<option value="' + step + '">' + step + "</option>"
                    );
                });

                // Show the modal
                $("#modal-lg").modal("show");
            },
            error: function (error) {
                console.log("Error fetching task data:", error);
            },
        });

        function formatDate(date) {
            var year = date.getFullYear();
            var month = String(date.getMonth() + 1).padStart(2, "0");
            var day = String(date.getDate()).padStart(2, "0");
            return year + "-" + month + "-" + day;
        }
    });

    // Handling stage_track form submission
    $("#saveChangesBtn").on("click", function () {
        var $button = $(this); // Store a reference to the button

        // Disable the button to prevent multiple clicks
        $button.prop("disabled", true);

        var formData = new FormData();
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
        formData.append("task_id", $("#taskID").val());
        formData.append("task_status", $("#taskStatus").val());
        formData.append("stage_status", $("#stageStatus").val());

        var selectedAttachmentTitle = $("#attachTitle option:selected").text();
        formData.append("attachment_title", selectedAttachmentTitle);

        var selectedStatus = $("#taskStatus").val();

        // Append start_date and end_date based on selectedStatus
        if (selectedStatus === "1") {
            formData.append("start_date", $("#start_date input").val());
            formData.append("end_date", $("#end_date input").val()); // Include end_date for "Started"
        } else if (selectedStatus === "3") {
            formData.append("start_date", $("#start_date input").val());
        } else if (selectedStatus === "4") {
            formData.append("start_date", $("#start_date input").val());
            formData.append("reason_description", $("textarea[name='reason_description']").val());
        }

        // Append multiple attachments (if any)
        var attachmentFiles = $("#fileUpload")[0].files;
        for (var i = 0; i < attachmentFiles.length; i++) {
            formData.append("attachments[]", attachmentFiles[i]); // Use 'attachments[]' key here
        }

        // AJAX post request to save the data
        $.ajax({
            url: "saveTaskTrackData",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Handle the success response here, e.g., show a success message
                console.log("Data saved successfully:", response);

                // Clear error messages
                $("#taskStatusError").text("");
                $("#stageStatusError").text("");

                // Display a success message at the top of the modal
                $("#successMessage")
                    .text("Data saved successfully")
                    .removeClass("d-none");
            },
            error: function (error) {
                console.log("Error saving task track data:", error);

                // Handle the error response here
                if (error.responseJSON && error.responseJSON.message) {
                    // Display error messages below the input fields
                    if (
                        error.responseJSON.message.includes(
                            "same data already exists"
                        )
                    ) {
                        $("#taskStatusError").text(
                            "A record with the same data already exists."
                        );
                    } else if (
                        error.responseJSON.message.includes(
                            "already exists with a different task_status"
                        )
                    ) {
                        $("#stageStatusError").text(
                            "You have already given the entry."
                        );
                    }
                }
            },
            complete: function () {
                // Re-enable the button after the AJAX request is complete
                console.log("Request complete");
                $button.prop("disabled", false);
            },
        });
    });

    // Dynamic content based on selected task status
    $("#taskStatus").change(function () {
        var selectedStatus = $(this).val();
        var dynamicContent = "";

        if (selectedStatus === "1") {
            // Started
            dynamicContent = `     
            <div class="row">
            <div class="col-md-6">
                <div class="form-group @if ($errors->has('start_date')) has-error @endif">
                    <label for="">Date of Start *</label>
                    <div class="input-group date" id="start_date" data-target-input="nearest">
                        <input value="{{ old('start_date') }}" type="text" name="start_date" class="form-control datetimepicker-input" data-target="#start_date" autocomplete="off" placeholder="YYYY-MM-DD">
                        <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group @if ($errors->has('end_date')) has-error @endif">
                    <label for="">Expected date of Approval *</label>
                    <div class="input-group date" id="end_date" data-target-input="nearest">
                        <input type="text" name="end_date" value="{{ old('end_date') }}" class="form-control datetimepicker-input" data-target="#end_date" autocomplete="off" placeholder="YYYY-MM-DD">
                        <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
        } else if (selectedStatus === "3") {
            // Completed
            dynamicContent = `
            <div class="col-md-6">
            <div class="form-group @if ($errors->has('start_date')) has-error @endif">
                <label for="">Date of Approval *</label>
                <div class="input-group date" id="start_date" data-target-input="nearest">
                    <input value="{{ old('start_date') }}" type="text" name="start_date" class="form-control datetimepicker-input" data-target="#start_date" autocomplete="off" placeholder="YYYY-MM-DD">
                    <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>`;
        } else if (selectedStatus === "4") {
            // Rejected
            dynamicContent = `
            <div class="row">
            <div class="col-md-6">
                <div class="form-group @if ($errors->has('start_date')) has-error @endif">
                    <label for="">Date of Rejection *</label>
                    <div class="input-group date" id="start_date" data-target-input="nearest">
                        <input value="{{ old('start_date') }}" type="text" name="start_date" class="form-control datetimepicker-input" data-target="#start_date" autocomplete="off" placeholder="YYYY-MM-DD">
                        <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group @if ($errors->has('end_date')) has-error @endif">
                    <label for="">Reason of Rejection *</label>
                   
                        <textarea class="form-control" name= "reason_description" rows="4" placeholder="Enter Reason ..."  class="form-control @if($errors->has('reason_description')) is-invalid @endif" value="{{ old('reason_description') }}"></textarea>

                </div>
            </div>
        </div>`;
        }

        // Update the dynamic content container
        $("#dynamicContent").html(dynamicContent);

        // Reinitialize the datetimepicker after changing the content
        $("#start_date").datetimepicker({
            default: true,
            format: "L",
            locale: "BST",
            format: "YYYY-MM-DD",
        });
        $("#end_date").datetimepicker({
            default: true,
            format: "L",
            locale: "BST",
            format: "YYYY-MM-DD",
            placeholder: "Select End Date",
        });
    });
});
