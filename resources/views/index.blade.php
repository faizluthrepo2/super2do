<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/mdb.min.css">
    <style>
        .gradient-custom {
            background: radial-gradient(50% 123.47% at 50% 50%, #00ff94 0%, #720059 100%),
                linear-gradient(121.28deg, #669600 0%, #ff0000 100%),
                linear-gradient(360deg, #0029ff 0%, #8fff00 100%),
                radial-gradient(100% 164.72% at 100% 100%, #6100ff 0%, #00ff57 100%),
                radial-gradient(100% 148.07% at 0% 0%, #fff500 0%, #51d500 100%);
            background-blend-mode: screen, color-dodge, overlay, difference, normal;
        }
    </style>
</head>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">

                    <div class="card">
                        <div class="card-body p-5">

                            <form class="d-flex justify-content-center align-items-center mb-4" id="postForm">
                                <div class="form-outline flex-fill">
                                    <input type="text" id="form2" name="description" class="form-control" />
                                    <label class="form-label" for="form2">New task...</label>
                                </div>
                                <button type="submit" id="savedata" class="btn btn-info ms-2">Add</button>
                            </form>

                            <!-- Tabs navs -->
                            <ul class="nav nav-tabs mb-4 pb-2" id="ex1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="switch_status" data-value="all" data-mdb-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">All</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="switch_status" data-value="active" data-mdb-toggle="tab" href="#ex1-tabs-2" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">Active</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="switch_status" data-value="completed" data-mdb-toggle="tab" href="#ex1-tabs-3" role="tab" aria-controls="ex1-tabs-3" aria-selected="false">Completed</a>
                                </li>
                                <li> <button id="updateall" class="btn btn-warning ms-2">Completed All Task</button></li>
                                <li> <button id="deleteall" class="btn btn-danger ms-2">Clear All Compeleted Task</button></li>
                            </ul>

                            <input type="hidden" id="url" value="all">
                            <!-- Tabs navs -->

                            <!-- Tabs content -->
                            <div class="tab-content" id="ex1-content">
                                <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">

                                    <ul class="list-group mb-0" id="alltask">


                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                                    <ul class="list-group mb-0" id="activetask">

                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="ex1-tabs-3" role="tabpanel" aria-labelledby="ex1-tab-3">
                                    <ul class="list-group mb-0" id="completedtask">

                                    </ul>
                                </div>
                            </div>
                            <!-- Tabs content -->

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</body>
<script type="text/javascript" src="js/mdb.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getData() {
            var datas2 = $('#url').val();
            var url = '';
            if (datas2 == 'completed') {
                url += '/api/show_completed';
            } else if (datas2 == 'active') {
                url += '/api/show_active';
            } else {
                url += '/api/show_task';
            }
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    var result = data.data
                    var isi = ``;
                    for (var i = 0; i < result.length; i++) {
                        var desc = '';
                        var datas = ``;
                        if (result[i].status == 'completed') {
                            desc += 'checked';
                            datas += `<s>` + result[i].description + `</s>`;
                        } else {
                            datas += result[i].description;
                        }
                        isi += `<li class="list-group-item d-flex align-items-center border-0 mb-2 rounded" style="background-color: #f4f6f7;">
                                    <input class="form-check-input me-2" id="checked" name="check[]" type="checkbox" value="` + result[i].id + `" aria-label="..." ` + desc + `/>
                                    ` + datas + `
                                </li>`;
                    }
                    if (datas2 == 'completed') {
                        $('#completedtask').html(isi);
                    } else if (datas2 == 'active') {
                        $('#activetask').html(isi);
                    } else {
                        $('#alltask').html(isi);
                    }

                },
            });

        }

        getData()
        $(document).on('click', '#checked', function() {
            var id = $(this).val();
            $.ajax({
                url: "/api/update_status/" + id,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    getData()
                }

            })
        })

        $(document).on('click', '#switch_status', function() {
            var datas = $(this).attr('data-value');
            $('#url').val(datas);
            getData();



        })

        $('#updateall').click(function() {
            $.ajax({
                url: "/api/completed_all",
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    getData();
                }
            });
        })

        $('#deleteall').click(function() {
            var result = confirm("Want to delete?");
            if (result) {
                $.ajax({
                    url: "/api/delete_all",
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.success == 'Success') {
                            getData();

                        } else {
                            alert('Data task completed not found.');
                        }
                    }
                });
            }

        })

        $('#savedata').click(function(e) {
            e.preventDefault();
            $.ajax({
                data: $('#postForm').serialize(),
                url: "/api/insert_task",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    getData();
                }
            });
        });
    });
</script>

</html>