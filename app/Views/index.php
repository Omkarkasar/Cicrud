<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title>Document</title>
</head>

<body>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
        data-bs-whatever="@mdo" onclick="$('#SubmitForm')[0].reset(); $('#id').val()">ADD NEW STUDENT</button>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">ADD STUDENT</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="SubmitForm">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" name="id" id="id">

                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $stu): ?>
                <tr>
                    <th scope="row"><?= $stu['id'] ?></th>
                    <td><?= $stu['name'] ?></td>
                    <td>
                        <button class="btn btn-success editBtn" data-id="<?= $stu['id'] ?>">Edit</button>
                        <button class="btn btn-danger deleteBtn" data-id="<?= $stu['id'] ?>">Delete</button>

                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
  <div class="pagination">
    <?= $pager->links() ?>
</div>

    <script>

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#SubmitForm').on('submit', function (e) {
                e.preventDefault();
                var id = $('#id').val();
                var url = id ? `updatestudent/${id}` : `storestudent`
                var formdata = new FormData(this);

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#SubmitForm')[0].reset();
                        $('#exampleModal').modal('hide');
                        location.reload();
                        alert(response.success);
                    },
                    error: function (response) {
                        alert(response.responseText);
                        console.log(response);
                    }
                })
            })
            $(document).on('click', '.editBtn', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: `editstudent/${id}`,
                    type: "GET",
                    success: function (response) {
                        $('#id').val(response.id);
                        $('#name').val(response.name);
                        $('#exampleModal').modal('show');


                    },
                    error: function (xhr) {
                        alert(xhr.responseText)
                    }
                })
            })

            $(document).on('click', '.deleteBtn', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: `deletestudent/${id}`,
                    type: "POST",
                    success: function (response) {
                        alert(response.success);
                        location.reload()
                    },
                    error: function (xhr) {
                        alert(xhr.responseText)
                    }
                })
            })

        })
    </script>
</body>

</html>