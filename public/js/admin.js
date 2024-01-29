function get_project() {
    var originalDateTime = "2024-01-17 23:39:00";

    // Use moment.js to parse the original date and time
    var parsedDateTime = moment(originalDateTime, "YYYY-MM-DD HH:mm:ss");

    // Format the date in the desired format (DD-MM-YYYY hh:mm A)
    var formattedDateTime = moment(
        originalDateTime,
        "YYYY-MM-DD HH:mm:ss"
    ).format("DD-MM-YYYY hh:mm A");

    // Output the formatted date and time
    console.log(formattedDateTime);

    $.ajax({
        type: "get",
        url: "/api/get_project",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $("#user_dt").html("");
            $.each(data, function (index, value) {
                console.log(value);
                var jsonString = JSON.stringify(value);

                if (value.status == "not_completed") {
                    status = "not completed";
                } else {
                    status = value.status;
                }

                $("#user_dt").append(
                    "<tr>" +
                        "<td>" +
                        (index + 1) +
                        "</td>" +
                        "<td>" +
                        value.name +
                        "</td>" +
                        "<td class='" +
                        value.status +
                        "'>" +
                        status +
                        "</td>" +
                        "<td>" +
                        value.user_name +
                        "</td>" +
                        "<td>" +
                        moment(value.start_date, "YYYY-MM-DD HH:mm:ss").format(
                            "DD-MM-YYYY hh:mm A"
                        ) +
                        "</td>" +
                        "<td>" +
                        moment(value.end_date, "YYYY-MM-DD HH:mm:ss").format(
                            "DD-MM-YYYY hh:mm A"
                        ) +
                        "</td>" +
                        "<td>" +
                        '<button class="btn btn-success mr-2" onclick="edit_option(\'' +
                        encodeURIComponent(jsonString) +
                        "','" +
                        value.id +
                        "')\">Edit</button>" +
                        '<button class="btn btn-danger" onclick="delete_option(' +
                        value.id +
                        ')">Delete</button>' +
                        '<button class="btn btn-warning ml-2" onclick="view_option(\'' +
                        encodeURIComponent(jsonString) +
                        "')\">View</button>" +
                        "</td>" +
                        "</tr>"
                );
            });
        },
    });
}
get_project();
$(document).ready(function () {
    $("#addcrud").on("submit", function (event) {
        event.preventDefault();

        $.ajax({
            type: "post",
            url: "/api/add_project",
            data: {
                name: $("input[name='name']").val(),
                user_id: $("select[name='user_id']").val(),
                start_date: $("input[name='start_date']").val(),
                end_date: $("input[name='end_date']").val(),
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                if (data.success) {
                    toastr.success(data.message);
                    $("#exampleModal").modal("hide");
                    get_project();
                } else {
                    toastr.error(data.message);
                }
            },
        });
    });

    $("#editcrud").on("submit", function (event) {
        event.preventDefault();

        $.ajax({
            type: "post",
            url: "/api/edit_project",
            data: {
                name: $("input[name='edit_name']").val(),
                user_id: $("select[name='edit_user_id']").val(),
                start_date: $("input[name='edit_start_date']").val(),
                end_date: $("input[name='edit_end_date']").val(),
                edit_id: $("#edit_id").val(),
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                if (data.success) {
                    toastr.success(data.message);
                    $("#editModal").modal("hide");
                    get_project();
                } else {
                    toastr.error(data.message);
                }
            },
        });
    });

    $("#deletecrud").on("submit", function (event) {
        event.preventDefault();

        $.ajax({
            type: "post",
            url: "/api/delete_project",
            data: {
                id: $("#delete_id").val(),
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                if (data.success) {
                    toastr.success(data.message);
                    $("#deleteModal").modal("hide");
                    get_project();
                } else {
                    toastr.error(data.message);
                }
            },
        });
    });
});

function edit_option(json_val, name) {
    var decodedValue = JSON.parse(decodeURIComponent(json_val));
    $("#edit_id").val(decodedValue.id);
    $("input[name='edit_name']").val(decodedValue.name);
    $("select[name='edit_user_id']").val(decodedValue.user_id);
    $("input[name='edit_start_date']").val(decodedValue.start_date);
    $("input[name='edit_end_date']").val(decodedValue.end_date);
    $("#editModal").modal("show");
}
function delete_option(id) {
    $("#delete_id").val(id);
    $("#deleteModal").modal("show");
}
function view_option(json_val) {
    var decodedValue = JSON.parse(decodeURIComponent(json_val));
    console.log(decodedValue);

    $(".view_project_name").text(decodedValue.name);
    $(".view_user_name").text(decodedValue.user_name);

    if (decodedValue.status == "not_completed") {
        var status = "not completed";
    } else {
        var status = decodedValue.status;
    }
    $(".view_status").text(status);
    $(".view_start_date").text(
        moment(decodedValue.start_date, "YYYY-MM-DD HH:mm:ss").format(
            "DD-MM-YYYY hh:mm A"
        )
    );
    $(".view_end_date").text(
        moment(decodedValue.end_date, "YYYY-MM-DD HH:mm:ss").format(
            "DD-MM-YYYY hh:mm A"
        )
    );

    $("#viewModal").modal("show");

    $.ajax({
        type: "post",
        url: "/api/view_project",
        data: {
            project_id: decodedValue.id,
            user_id: decodedValue.user_id,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            if (data) {
                $(".view_task").html("");
                $.each(data, function (index, value) {
                    $(".view_task").append(
                        "<tr>" +
                            "<td>" +
                            (index + 1) +
                            "</td>" +
                            "<td>" +
                            moment(
                                value.created_at,
                                "YYYY-MM-DD HH:mm:ss"
                            ).format("DD-MM-YYYY hh:mm A") +
                            "</td>" +
                            "<td>" +
                            value.message +
                            "</td>" +
                            "</tr>"
                    );
                });
            } else {
                toastr.error(data.message);
            }
        },
    });
}
