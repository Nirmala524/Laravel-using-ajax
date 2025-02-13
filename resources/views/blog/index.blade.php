<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5">

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    ADD
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="container">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id='content'>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- add data Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Blog</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id='addblog'>
                        <!-- Name input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" id="name" class="form-control" />
                        </div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="details">Details</label>
                            <textarea name="details" id="details" cols="40" rows="4" class="form-control"></textarea>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ..............edit form................... --}}


    <div class="modal fade" id="exampleModaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Blog</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id='editblog'>
                        <input type="hidden" id="editid" class="form-control" />
                        <!-- Name input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="editname">Name</label>
                            <input type="text" id="editname" class="form-control">
                        </div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="details">Details</label>
                            <textarea name="details" id="editdetails" cols="40" rows="4" class="form-control"></textarea>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>
    <script>
        function fatchalldata() {

            $.ajax({
                type: "GET",
                url: "/getdata",
                success: function(response) {
                    if (response.status == 200) {
                        $("#content").html("");
                        let data = '';
                        $.map(response.data, function(value, key) {

                            data += `<tr>
                        <td>${value.id}</td>
                        <td>${value.name}</td>
                        <td>${value.details}</td>
                         <td>
                                 <button type="button" class="btn btn-success" onclick="edit(${value.id})">Edit</button> 
                                <button type="button" class="btn btn-danger" onclick="deletedata(${value.id})">delete</button>

                            </td>
                      </tr>`;

                        });
                        $('#content').append(data);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",

                        });

                    }

                }
            });

        }
        fatchalldata();

        // ..............store data..............


        $('#addblog').submit(function(e) {
            e.preventDefault();
            let alldata = {
                "_token": "{{ csrf_token() }}",
                "name": $('#name').val(),
                "details": $('#details').val(),

            };
            $.ajax({
                type: "POST",
                url: "storedata",
                data: alldata,  

                success: function(response) {

                    if (response.status == 200) {


                        fatchalldata();
                        $('#name').val("");
                        $('#details').val("");
                        $('#exampleModal').modal('toggle');

                        const duration = 15 * 1000,
                            animationEnd = Date.now() + duration,
                            defaults = {
                                startVelocity: 30,
                                spread: 360,
                                ticks: 60,
                                zIndex: 0
                            };

                        function randomInRange(min, max) {
                            return Math.random() * (max - min) + min;
                        }

                        const interval = setInterval(function() {
                            const timeLeft = animationEnd - Date.now();

                            if (timeLeft <= 0) {
                                return clearInterval(interval);
                            }

                            const particleCount = 50 * (timeLeft / duration);

                            // since particles fall down, start a bit higher than random
                            confetti(
                                Object.assign({}, defaults, {
                                    particleCount,
                                    origin: {
                                        x: randomInRange(0.1, 0.3),
                                        y: Math.random() - 0.2
                                    },
                                })
                            );
                            confetti(
                                Object.assign({}, defaults, {
                                    particleCount,
                                    origin: {
                                        x: randomInRange(0.7, 0.9),
                                        y: Math.random() - 0.2
                                    },
                                })
                            );
                        }, 250);

                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",

                        });
                    }
                }
            });
        });

        // .....edit blog............

        function edit(id) {
            $.ajax({
                type: "GET",
                url: "/editdata/" + id,
                success: function(response) {
                    $('#exampleModaledit').modal('toggle');
                    $('#editid').val(response.data.id);
                    $('#editname').val(response.data.name);
                    $('#editdetails').val(response.data.details);

                }
            });
        }
        //update data

        $('#editblog').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "update",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": $('#editid').val(),
                    "name": $('#editname').val(),
                    "details": $('#editdetails').val(),
                },
                success: function(response) {
                    if (response.status == 200) {
                        $('#editid').val("");
                        $('#editname').val("");
                        $('#editdetails').val("");
                        $('#exampleModaledit').modal('toggle');
                        fatchalldata();
                        confetti({
                            particleCount: 100,
                            spread: 70,
                            origin: {
                                y: 0.6
                            },
                        });

                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",

                        });

                    }

                }
            });
        })
        //delete   

        function deletedata(id) {
            $.ajax({
                type: "GET",
                url: "deletedata/" + id,

                success: function(response) {
                    console.log(response);
                    
                    if (response.status == 200) {
                        fatchalldata();
                        confetti({
                            particleCount: 100,
                            spread: 70,
                            origin: {
                                y: 0.6
                            },
                        });

                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",

                        });
                    }

                }
            });
        }
    </script>
</body>

</html>
