function project_dt() {
    $.ajax({
        type: "get",
        url: "/api/project_dt",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            if (data) {
                $(".project").html("");
                $(".project").append('<option value="">--Select--</option>');
                $.each(data, function (index, value) {
                    var jsonString = JSON.stringify(value);
                    $(".project").append(
                        '<option value="' +
                            value.id +
                            "\"  data-value='" +
                            encodeURIComponent(jsonString) +
                            "'>" +
                            value.name +
                            "</option>"
                    );
                });
            }
        },
    });
}

$(".project_value_click").click(function () {
    project_dt();
    $(".project_user_name").text("");
    $(".project_start_date").text("");
    $(".project_end_date").text("");
    $("select[name='project_id']").val("");
    $("textarea[name='message']").val("");
    $("input[name=status]").prop("checked", false);
});

function project_change(id) {
    var json_encode = $(id).find("option:selected").attr("data-value");
    if (json_encode) {
        var data = JSON.parse(decodeURIComponent(json_encode));
        $(".project_user_name").text(data.user_name);
        $(".project_start_date").text(
            moment(data.start_date, "YYYY-MM-DD HH:mm:ss").format(
                "DD-MM-YYYY hh:mm A"
            )
        );
        $(".project_end_date").text(
            moment(data.end_date, "YYYY-MM-DD HH:mm:ss").format(
                "DD-MM-YYYY hh:mm A"
            )
        );
    }
}

function get_task() {
    $.ajax({
        type: "get",
        url: "/api/get_task",
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
                        "<td>" +
                        value.user_name +
                        "</td>" +
                        "<td class='" +
                        value.status +
                        "'>" +
                        status +
                        "</td>" +
                        "<td>" +
                        value.message +
                        "</td>" +
                        "<td>" +
                        moment(value.date, "YYYY-MM-DD").format("DD-MM-YYYY") +
                        "</td>" +
                        "<td>" +
                        '<button class="btn btn-success mr-2" onclick="edit_option(\'' +
                        encodeURIComponent(jsonString) +
                        "','" +
                        value.id +
                        "')\">Edit</button>" +
                        '<button class="btn btn-danger" onclick="delete_option(' +
                        value.task_id +
                        ')">Delete</button>' +
                        "</td>" +
                        "</tr>"
                );
            });
        },
    });
}
get_task();
$(document).ready(function () {
    $("#addcrud").on("submit", function (event) {
        event.preventDefault();

        $.ajax({
            type: "post",
            url: "/api/add_task",
            data: {
                project_id: $("select[name='project_id']").val(),
                message: $("textarea[name='message']").val(),
                status: $("input[name='status']:checked").val(),
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                if (data.success) {
                    toastr.success(data.message);
                    $("#exampleModal").modal("hide");
                    get_task();
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
            url: "/api/edit_task",
            data: {
                project_id: $("select[name='edit_project_id']").val(),
                message: $("textarea[name='edit_message']").val(),
                status: $("input[name='edit_status']:checked").val(),
                edit_id: $("#edit_id").val(),
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                if (data.success) {
                    toastr.success(data.message);
                    $("#editModal").modal("hide");
                    get_task();
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
            url: "/api/delete_task",
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
                    get_task();
                } else {
                    toastr.error(data.message);
                }
            },
        });
    });
});

function edit_option(json_val, name) {
    var decodedValue = JSON.parse(decodeURIComponent(json_val));
    $("#edit_id").val(decodedValue.task_id);
    project_dt();
    $("input[name=edit_status][value='" + decodedValue.status + "']").prop(
        "checked",
        true
    );
    $("textarea[name='edit_message']").val(decodedValue.message);

    $(".project_user_name").text(decodedValue.user_name);
    $(".project_start_date").text(
        moment(decodedValue.start_date, "YYYY-MM-DD HH:mm:ss").format(
            "DD-MM-YYYY hh:mm A"
        )
    );
    $(".project_end_date").text(
        moment(decodedValue.end_date, "YYYY-MM-DD HH:mm:ss").format(
            "DD-MM-YYYY hh:mm A"
        )
    );
    setTimeout(function () {
        $("select[name='edit_project_id']").val(decodedValue.id);
    }, 1000);
    $("select[name='edit_project_id']").val(decodedValue.id);
    $("#editModal").modal("show");
}
function delete_option(id) {
    $("#delete_id").val(id);
    $("#deleteModal").modal("show");
}
