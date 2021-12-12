<?php
require '../includes/conn.php';

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
}

?>
<?php include '../common/header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
<style>
    .user-image-update {
        position: absolute;
        top: auto;
        bottom: auto;
        color: white;
        z-index: 100;
        margin-top: 130px;
        text-align: center;
        margin-left: 100px;
        background-color: #1a2226;
        padding: 9px;
        border-radius: 50%;
    }

    .user-edit-form-wapper {
        display: flex;
        justify-content: center;
    }

    .cropper-view-box,
    .cropper-face {
        border-radius: 50%;
    }

    img {
        max-width: 100%;
        /* This rule is very important, please do not ignore this! */
    }
</style>

<div class="wrapper">

    <?php include '../includes/navbar.php'; ?>
    <?php include '../includes/menubar.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="col-xs-12">
                <h2> My Profile </h2>

                <ol class="breadcrumb">
                    <li>
                        <a href="#"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">
                        Dashboard
                    </li>
                </ol>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <div class="user-edit-form-wapper">
                                    <div class="" style="width: 500px;">
                                        <br>
                                        <br>
                                        <div>
                                            <div class="text-center user-image-wapper">
                                                <input type='file' data-uid="<?php echo $uid; ?>" onchange="readURL(this);" accept="image/*" style="display: none;" />
                                                <div class="user-image" style="background-image: url('<?php echo $User['image_path'] ?  '../' . $User['image_path'] . '?t=' . rand(1000, 9999) :  '../images/profile.jpg'; ?>');"></div>
                                                <div class="user-image-update" onclick="$(this).parent().find('input').trigger('click');">
                                                    <i class="ti-pencil"></i> 
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <form class="form-horizontal" action="profile_save.php" method="POST" id="userCreateFrm" enctype="multipart/form-data">
                                            <input type="hidden" name="user_edit" value="1">
                                            <input type="hidden" name="user_id" value="<?php echo $uid; ?>">
                                            <input type="hidden" name="color" id="color" value="<?php echo $User['color']; ?>">
                                            <div class="">
                                                <div class="form-group">
                                                    <label for="title" class="col-sm-4 control-label">Title</label>
                                                    <div class="col-sm-8">
                                                        <select name="title" class="form-control" id="title" required>
                                                            <option value="Mr." <?php echo $User['title'] == 'Mr.' ? 'selected' : ''; ?>> Mr. </option>
                                                            <option value="Mrs." <?php echo $User['title'] == 'Mrs.' ? 'selected' : ''; ?>> Mrs. </option>
                                                            <option value="Miss." <?php echo $User['title'] == 'Miss.' ? 'selected' : ''; ?>> Miss. </option>
                                                            <option value="Dr." <?php echo $User['title'] == 'Dr.' ? 'selected' : ''; ?>> Dr. </option>
                                                            <option value="Rev." <?php echo $User['title'] == 'Rev.' ? 'selected' : ''; ?>> Rev. </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="firstname" class="col-sm-4 control-label">First Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" maxlength="30" onkeypress="return /[a-z]/i.test(event.key)" id="firstname" name="firstname" placeholder="First Name" value="<?php echo $User['firstname']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="secondname" class="col-sm-4 control-label">Second Name</label>

                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" maxlength="30" onkeypress="return /[a-z]/i.test(event.key)" id="secondname" name="secondname" placeholder="Second Name" value="<?php echo $User['secondname']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mobile" class="col-sm-4 control-label">Mobile Number</label>

                                                    <div class="col-sm-8">
                                                        <input type="tel" class="form-control" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="mobile" name="mobile" placeholder="User Mobile Number (Optional)" value="<?php echo $User['mobile']; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mobile" class="col-sm-4 control-label">My Color</label>

                                                    <div class="col-sm-8 d-flex">
                                                        <div class="colorPickSelector"></div> <small style=" margin-top: 10px; margin-left: 10px;">This Color will use on your reservations </small>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label for="mobile" class="col-sm-4 control-label">Login Email</label>

                                                    <div class="col-sm-8">
                                                        <input type="tel" readonly class="form-control" id="email" name="email" placeholder="User Mobile Number" required value="<?php echo $User['email']; ?>">
                                                        <small>Login Email can not be changed.</small>
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group">
                                                    <label for="department" class="col-sm-4 control-label">Password</label>
                                                    <div class="col-sm-8">
                                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#changePassword">
                                                            Change Password
                                                        </button><br>
                                                        <small>You can change your password here.</small>
                                                    </div>
                                                </div> -->
                                                <br>
                                                <div class="form-group">
                                                    <label for="department" class="col-sm-4 control-label"></label>
                                                    <div class="col-sm-8">
                                                        <button type="submit" class="btn btn-success btn-block">
                                                            Save Details
                                                        </button>
                                                    </div>
                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="imageCropperModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crop Profile Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div style="position: relative; width: 100%; max-height: 500px;">
                            <img id="image" src="" alt="Picture" height="auto" width="100%">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="setImage" class="btn btn-success">Set as Profile Image</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changePassword" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="reservationModalTitle"><b>Change Password</b></h4>
                </div>
                <div>
                    <form action="reset_actions.php" method="POST">
                        <div class="form-group has-feedback">
                            <input type="hidden" name="profile-password-reset" value="1">
                            <input type="password" class="form-control" name="password1" placeholder="New Password" autofocus required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" name="password2" placeholder="Repeat New Password" autofocus required>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-primary btn-block btn-flat" id="resetPassword" name="login"><i class="fa fa-sign-in"></i>
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/scripts.php'; ?>
    <?php include '../includes/footer.php'; ?>
</div>

<script script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {

        var userSelected = '<?php echo $User['color']; ?>';
        var userColor = '#27ae60';

        if (userSelected) {
            var userColor = userSelected;
        }

        $('.colorPickSelector').click(function() {
            if ($("#colorPick").length) {
                console.log(1);
                $("#colorPick").remove();
            } else {
                console.log(0);
            }
        });

        $(".colorPickSelector").colorPick({
            'initialColor': userColor,
            'onColorSelected': function() {
                $("#color").val(this.color);
                //console.log("The user has selected the color: " + this.color)
                this.element.css({
                    'backgroundColor': this.color,
                    'color': this.color
                });
            }
        });
    });

    // Show any message
    function showMessage(type, description) {
        Swal.fire({
            icon: type,
            title: description,
            showConfirmButton: false,
            timer: 1200
        })
    }

    // Handle Image
    function readURL(input) {

        var ext = input.value.match(/\.(.+)$/)[1];
        switch (ext) {
            case 'jpg':
            case 'jpeg':
            case 'png':
                notImage = 0;
                break;
            default:
                this.value = '';
                notImage = 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Please select a image file <br><br> <small> .jpg .jpeg .png </small>',
                    showConfirmButton: false,
                    timer: 2500
                })
        }

        if (input.files && input.files[0] && !notImage) {
            var lid = input.getAttribute('data-uid');
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result).width('100%').height('50%');
            };

            reader.readAsDataURL(input.files[0]);
            var image = document.getElementById('image');
            var cropBoxData;
            var canvasData;
            var cropper;

            $("#imageCropperModal").modal('show');
            $('#imageCropperModal').on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    viewMode: 2,
                    autoCropArea: 0.5,
                    aspectRatio: 100 / 100,
                    ready: function() {
                        cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                    }
                });

            }).on('hidden.bs.modal', function() {
                cropBoxData = cropper.getCropBoxData();
                canvasData = cropper.getCanvasData();
                cropper.destroy();
            });
        }

        $("#setImage").on('click', function() {
            var initialAvatarURL;
            var canvas;

            if (cropper) {
                canvas = getRoundedCanvas(cropper.getCroppedCanvas());
                initialAvatarURL = image.src;
                image.src = canvas.toDataURL();

                canvas.toBlob(function(blob) {
                    var formData = new FormData();
                    formData.append('avatar', blob, 'avatar_' + lid + '.png');
                    formData.append('lid', lid);

                    //$("#setImage").attr('disabled', 'disabled');
                    var uploadUrl = 'profile_save.php';

                    $.ajax(uploadUrl, {
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        xhr: function() {
                            var xhr = new XMLHttpRequest();
                            xhr.upload.onprogress = function(e) {
                                var percent = '0';
                                var percentage = '0%';
                                if (e.lengthComputable) {
                                    percent = Math.round((e.loaded / e.total) * 100);
                                    percentage = percent + '%';
                                    $("#setImage").html('Uploading (' + percentage + ')');
                                }
                            };
                            return xhr;
                        },
                        success: function() {
                            $("#setImage").html('Success !');
                            showMessage('success', 'Profile Picture Updated');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);

                        },
                        error: function() {
                            //avatar.src = initialAvatarURL;
                            $("#setImage").html('Upload Faild');
                        },
                        complete: function() {
                            $("#setImage").html('Success !');
                        }
                    });
                });
            }
        });
    }

    function getRoundedCanvas(sourceCanvas) {
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        var width = sourceCanvas.width;
        var height = sourceCanvas.height;

        canvas.width = width;
        canvas.height = height;
        context.imageSmoothingEnabled = true;
        context.drawImage(sourceCanvas, 0, 0, width, height);
        context.globalCompositeOperation = 'destination-in';
        context.beginPath();
        context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
        context.fill();
        return canvas;
    }
</script>

</html>