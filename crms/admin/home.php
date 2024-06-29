<?php include 'db_connect.php' ?>
<style>
   .col-md-3  .info-box-icon {
    border-radius: 0.25rem;
    align-items: center;
    display: flex;
    font-size: 2.875rem;
    justify-content: center;
    text-align: center;
    width: 70px;
    }
    .col-md-6 {
        background-color: whitesmoke;

    }

    span.float-right.summary_icon {
        font-size: 3rem;
        position: absolute;
        right: 1rem;
        top: 0;
    }

    .imgs {
        margin: .5em;
        max-width: calc(100%);
        max-height: calc(100%);
    }

    .imgs img {
        max-width: calc(100%);
        max-height: calc(100%);
        cursor: pointer;
    }

    #imagesCarousel,
    #imagesCarousel .carousel-inner,
    #imagesCarousel .carousel-item {
        height: 60vh !important;
        background: black;
    }

    #imagesCarousel .carousel-item.active {
        display: flex !important;
    }

    #imagesCarousel .carousel-item-next {
        display: flex !important;
    }

    #imagesCarousel .carousel-item img {
        margin: auto;
    }

    #imagesCarousel img {
        width: auto !important;
        height: auto !important;
        max-height: calc(100%) !important;
        max-width: calc(100%) !important;
    }
</style>

<div class="container-fluid">
    <div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo "Welcome back " . $_SESSION['login_name'] . "!" ?><br>

                    <hr>
                </div>


                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3 ">
                            <div class="info-box bg-light shadow">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">COMPLAINTS</span>
                                    <span class="info-box-number text-right">
                                        <?php
                                        echo $conn->query("SELECT * FROM `complaints` where status = 1")->num_rows;
                                        ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-3 ">
                            <div class="info-box bg-light shadow">
                                <span class="info-box-icon bg-gradient-dark elevation-1"><i
                                        class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">COMPLAINANTS</span>
                                    <span class="info-box-number text-right">
                                        <?php
                                        echo $conn->query("SELECT * FROM `complainants` where `status` = 1")->num_rows;
                                        ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-3 ">
                            <div class="info-box bg-light shadow">
                                <span class="info-box-icon bg-gradient-dark elevation-1"><i
                                        class="fas fa-th-station"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">STATION</span>
                                    <span class="info-box-number text-right">
                                        <?php
                                        echo $conn->query("SELECT * FROM `stations`")->num_rows;
                                        ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-light shadow">
                                <span class="info-box-icon bg-gradient-primary elevation-1"><i
                                        class="fas fa-user-alt"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">USERS</span>
                                    <span class="info-box-number text-right">
                                        <?php
                                        echo $conn->query("SELECT * FROM `users`")->num_rows;
                                        ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                </div>
               
            </div>
            
        </div>
        <div>
                    <img src="../images\1707457860_IMG_20240205_201554.jpg" alt="los" width="100%" height="90%">
                </div>
    </div>
</div>

<script>
    $('#manage-records').submit(function (e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function (resp) {
                resp = JSON.parse(resp)
                if (resp.status == 1) {
                    alert_toast("Data successfully saved", 'success')
                    setTimeout(function () {
                        location.reload()
                    }, 800)

                }

            }
        })
    })
    $('#tracking_id').on('keypress', function (e) {
        if (e.which == 13) {
            get_person()
        }
    })
    $('#check').on('click', function (e) {
        get_person()
    })
    function get_person() {
        start_load()
        $.ajax({
            url: 'ajax.php?action=get_pdetails',
            method: "POST",
            data: { tracking_id: $('#tracking_id').val() },
            success: function (resp) {
                if (resp) {
                    resp = JSON.parse(resp)
                    if (resp.status == 1) {
                        $('#name').html(resp.name)
                        $('#address').html(resp.address)
                        $('[name="person_id"]').val(resp.id)
                        $('#details').show()
                        end_load()

                    } else if (resp.status == 2) {
                        alert_toast("Unknow tracking id.", 'danger');
                        end_load();
                    }
                }
            }
        })
    }
</script>