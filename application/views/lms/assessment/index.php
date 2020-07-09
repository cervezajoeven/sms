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
            <?php
            if ($this->rbac->hasPrivilege('upload_content', 'can_add')) {
                ?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create Assessment</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <form id="form1" action="<?php echo site_url('lms/assessment/save') ?>"  id="assessment" name="assessmentform" method="post"  enctype='multipart/form-data' accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Assessment Name</label><small class="req"> *</small>
                                    <input autofocus="" id="assessment_name" name="assessment_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('content_title'); ?>" />
                                    <span class="text-danger"><?php echo form_error('content_title'); ?></span>
                                </div>

                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>

                </div><!--/.col (right) -->
                <!-- left column -->
            <?php } ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('upload_content', 'can_add')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Assessment List</h3>
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
                            <div class="download_label"><?php echo $this->lang->line('content_list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example nowrap">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Availability</th>
                                        <th>Attempts</th>
                                        <th>Assigned By</th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $list_key => $list_data): ?>

                                        <tr>
                                            <td class="mailbox-name">
                                                <?php echo $list_data['assessment_name']?>
                                            </td>

                                            <td class="mailbox-name">
                                               <?php echo date("F d H:i A", strtotime($list_data['start_date'])); ?> - <?php echo date("F d H:i A", strtotime($list_data['end_date'])); ?>
                                            </td>
                                            <td class="mailbox-name">

                                                <?php if($role=="student"): ?><?php print_r($list_data['student_attempt']) ?>/<?php endif; ?> <?php print_r($list_data['attempts']) ?>
                                            </td>
                                            <td>
                                                <?php print_r($list_data['name']) ?> <?php print_r($list_data['surname']) ?>
                                            </td>
                                            <td class="mailbox-date pull-right">
                                                <?php if($role=="admin"): ?>

                                                    <a data-placement="left" href="<?php echo site_url('lms/assessment/reports/'.$list_data['id']);?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Reports" >
                                                            <i class="fa fa-file"></i>
                                                    </a>

                                                    <a data-placement="left" href="<?php echo site_url('lms/assessment/edit/'.$list_data['id']);?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>" >
                                                            <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a data-placement="left" href=""class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>

                                                <?php elseif($role=="student"): ?>
                                                    <?php if($list_data['student_attempt']>=1): ?>
                                                        <a data-placement="left" href="<?php echo site_url('lms/assessment/review/'.$list_data['id']);?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="View Answer">
                                                                <i class="fa fa-eye"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if($list_data['student_attempt']<$list_data['attempts']): ?>
                                                        <span data-placement="left" href="" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Answer" onclick="take_quiz('<?php echo site_url('lms/assessment/answer/'.$list_data['id']);?>')">
                                                                <i class="fa fa-edit"></i>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                
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
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

                <!-- Horizontal Form -->

                <!-- general form elements disabled -->

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
      
        
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

    function take_quiz(url){

        if(confirm("Are you sure you want to take this quiz?")){
            window.location.replace(url);

        }
        
    }
</script>