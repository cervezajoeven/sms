<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-download"></i> <?php echo $this->lang->line('download_center'); ?></h1>

    </section>
 
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Assessment Details</h3>
                        <div class="box-tools pull-right">

                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <div class="pull-right">

                            </div><!-- /.pull-right -->
                        </div>
                        <div class="mailbox-messages table-responsive">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>Title</th>
                                    <td><?php echo $assessment['assessment_name']?></td>
                                </tr>
                                <tr>
                                    <th>Total Score</th>
                                    <td><?php echo $assessment['total_score']?></td>
                                </tr>
                                <tr>
                                    <th>Start Date</th>
                                    <td><?php echo date("F d, Y",strtotime($assessment['start_date'])) ?></td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td><?php echo date("F d, Y",strtotime($assessment['end_date'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Duration</th>
                                    <td><?php echo $assessment['duration']?></td>
                                </tr>
                                <tr>
                                    <th>Passing Percentage</th>
                                    <td><?php echo $assessment['percentage']?>%</td>
                                </tr>
                                <tr>
                                    <th>Analysis Report</th>
                                    <td>
                                        <a href="<?php echo site_url('lms/assessment/analysis/').$assessment['id'] ?>">
                                            <button class="form-control btn btn-primary">Item Analysis</button>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Check Essays</th>
                                    <td>
                                        <a href="<?php echo site_url('lms/assessment/check_essays/').$assessment['id'] ?>">
                                            <button class="form-control btn btn-primary">Check Essays</button>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Recheck Answers</th>
                                    <td>
                                        <a href="<?php echo site_url('lms/assessment/recheck_answers/').$assessment['id'] ?>">
                                            <button class="form-control btn btn-primary">Recheck Answers</button>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div><!-- /.mail-box-messages -->

                    </div><!-- /.box-body -->

                </div>
            </div><!--/.col (left) -->


            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Students List</h3>
                        <style type="text/css">
                            .filter{
                                width: 150px;
                                display: inline;
                            }
                        </style>
                        <div class="box-tools pull-right">

                            Filters:
                            <select class="form-control filter section">
                                <option value="all">All Section</option>
                                <?php foreach ($sections as $section_key => $section_value) : ?>
                                    <option value="<?php echo $section_value['id'] ?>"><?php echo $section_value['section'] ?></option>
                                <?php endforeach; ?>
                            </select>

                            <select class="form-control filter gender">
                                <option <?php echo ($gender=="all")?"selected":""; ?> value="all">All Gender</option>
                                <option <?php echo ($gender=="male")?"selected":""; ?> value="male">Male</option>
                                <option <?php echo ($gender=="female")?"selected":""; ?> value="female">Female</option>
                            </select>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <div class="pull-right">
                                
                            </div><!-- /.pull-right -->
                        </div>
                        <div class="mailbox-messages table-responsive">
                            <div class="download_label"><?php echo $this->lang->line('content_list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Grade</th>
                                        <th>Section</th>
                                        <th>Score</th>
                                        <th>Percentage</th>
                                        <th>Status</th>
                                        <th>Browser</th>
                                        <th>Device</th>
                                        <th>Version</th>
                                        <th>OS</th>
                                        <!-- <th>Essays</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $list_key => $list_data): ?>

                                        <tr>
                                            <td class="mailbox-date pull-right">
                                                <center>
                                                    <a data-placement="right" href="<?php echo site_url('lms/assessment/review/'.$list_data['assessment_id'].'/'.$list_data['student_id']);?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="View Answer Sheet" >
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a data-placement="right" href="<?php echo site_url('lms_v2/index.php/lms/assessment/initialize/'.$list_data['student_id'].'/student/'.$list_data['assessment_id']);?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Check Answer Sheet" >
                                                        <i class="fa fa-play"></i>
                                                    </a>
                                                </center>
                                                

                                               
                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $list_data['lastname']?>, <?php echo $list_data['firstname']?>
                                            </td>
                                            <td class="mailbox-name">
                                               <?php echo $list_data['gender']?>
                                            </td>
                                            <td class="mailbox-name">
                                               <?php echo $list_data['class']?>
                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $list_data['section']?>
                                            </td>
                                            <td>
                                                <?php echo $list_data['score']?>
                                            </td>
                                            <td>
                                                <?php echo round(($list_data['score']/$list_data['total_score'])*100) ?>%
                                                <?php $current_percentage = round(($list_data['score']/$list_data['total_score'])*100) ?>
                                            </td>
                                            <td>
                                                <?php echo ($current_percentage>=$assessment['percentage'])?"Pass":"Fail"; ?>
                                            </td>
                                            <td>
                                                <?php echo $list_data['browser']?>
                                            </td>
                                            <td>
                                                <?php echo $list_data['device']?>
                                            </td>
                                            <td>
                                                <?php echo $list_data['browser_version']?>
                                            </td>
                                            <td>
                                                <?php echo $list_data['os_platform']?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>

                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->

                    </div><!-- /.box-body -->

                </div>
            </div><!--/.col (left) -->
            
            


            <!-- right column -->

        </div>
        <input type="hidden" id="url" value="<?php echo site_url() ?>" name="">
        <input type="hidden" id="assessment_id" value="<?php echo $assessment['id'] ?>" name="">
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        var url = $("#url").val();
        var assessment_id = $("#assessment_id").val();
        $('.filter').select2();
        $(".filter").change(function() {
            
            var filter_redirect = url+'lms/assessment/reports/'+assessment_id;
            var section = $(".section").val();
            var gender = $(".gender").val();
            var filter_url = filter_redirect+'/'+section+'/'+gender;
            window.location.href = filter_url;

        });
        $("#btnreset").click(function () {

            $("#form1")[0].reset();
        });
        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id') ?>';
        getSectionByClass(class_id, section_id);
        $(document).on('change', '#class_id', function (e) {
            $('#section_id').html("");
            var class_id = $(this).val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        div_data += "<option value=" + obj.id + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        });
        function getSectionByClass(class_id, section_id) {
            if (class_id != "" && section_id != "") {
                $('#section_id').html("");
                var base_url = '<?php echo base_url() ?>';
                var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                $.ajax({
                    type: "GET",
                    url: base_url + "sections/getByClass",
                    data: {'class_id': class_id},
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (i, obj)
                        {
                            var sel = "";
                            if (section_id == obj.id) {
                                sel = "selected";
                            }
                            div_data += "<option value=" + obj.id + " " + sel + ">" + obj.section + "</option>";
                        });
                        $('#section_id').append(div_data);
                    }
                });
            }
        }



    });
    $(document).ready(function () {

        $(document).on("click", '.content_available', function (e) {
            var avai_value = $(this).val();
            if (avai_value === "student") {
                console.log(avai_value);
                if ($(this).is(":checked")) {

                    $(this).closest("div").parents().find('.upload_content').removeClass("content_disable");

                } else {
                    $(this).closest("div").parents().find('.upload_content').addClass("content_disable");

                }
            }
        });
        $("#chk").click(function () {
            if ($(this).is(":checked")) {
                $("#class_id").prop("disabled", true);
            } else {
                $("#class_id").prop("disabled", false);
            }
        });
        if ($("#chk").is(":checked")) {
            $("#class_id").prop("disabled", true);
        } else {
            $("#class_id").prop("disabled", false);
        }

    });</script>

<script>
    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });
</script>