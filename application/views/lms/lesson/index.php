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
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create <?php echo $this->lang->line('lesson'); ?></h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <form id="form1" action="<?php echo site_url('lms/lesson/save') ?>"  id="lesson" name="employeeform" method="post"  enctype='multipart/form-data' accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lesson Title</label><small class="req"> *</small>
                                    <input autofocus="" id="content_title" name="content_title" placeholder="" type="text" class="form-control"  value="<?php echo set_value('content_title'); ?>" />
                                    <span class="text-danger"><?php echo form_error('content_title'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Subject</label><small class="req"> *</small>
                                    <select autofocus="" id="subject_id" name="subject" placeholder="" type="text" class="form-control">
                                        <?php foreach ($subjects as $key => $value) : ?>
                                            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('content_title'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Grade/Level</label><small class="req"> *</small>
                                    <select autofocus="" id="grade_id" name="grade" placeholder="" type="text" class="form-control">
                                        <?php foreach ($classes as $key => $value) : ?>
                                            <option value="<?php echo $value['id'] ?>"><?php echo $value['class'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('content_title'); ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Education Level</label><small class="req"> *</small>
                                    <select autofocus="" id="" name="education_level" placeholder="" type="text" class="form-control">
                                        <option value="pre_school">Pre-School</option>
                                        <option value="grade_school">Grade School</option>
                                        <option value="junior">Junior Highschool</option>
                                        <option value="senior">Senior Highschool</option>
                                        <option value="tertiary">Tertiary</option>
                                        <option value="all_levels">All Levels</option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('content_title'); ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Term</label><small class="req"> *</small>
                                    <select autofocus="" id="" name="term" placeholder="" type="text" class="form-control">
                                        <option value="1">1st Term</option>
                                        <option value="2">2nd Term</option>
                                        <option value="3">3rd Term</option>
                                        <option value="4">4th Term</option>
                                    </select>
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
            <!-- <?php } ?> -->
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('upload_content', 'can_add')) {
                echo "12";
            } else {
                echo "12";
            }
            ?>">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <?php if($role=="student"): ?>
                            <?php if($lesson_query=="upcoming"): ?>
                                <h3 class="box-title titlefix">Upcoming Lessons</h3>
                            <?php else: ?>
                                <h3 class="box-title titlefix">Recent Lessons</h3>
                            <?php endif; ?>
                        <?php else: ?>
                            <h3 class="box-title titlefix">View/Edit My Lesson</h3>

                        <?php endif; ?>
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
                                        <?php if($real_role==7||$real_role==1): ?>
                                            <th>Teacher</th>
                                        <?php endif;?>
                                        <th><?php echo $this->lang->line('type'); ?></th>
                                        <th>Date</th>
                                        <th>Term</th>
                                        <th>Subject</th>
                                        <th>Grade</th>
                                        <th>Education Level</th>
                                        <th>Shared</th>
                                        <th>Status</th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $list_key => $list_data): ?>

                                        <tr>
                                            <td class="mailbox-name">
                                                <?php echo $list_data['lesson_name']?>
                                            </td>
                                            <?php if($real_role==7||$real_role==1): ?>
                                                <td class="mailbox-name">
                                                    <?php echo $list_data['name'] ?> <?php echo $list_data['surname'] ?>
                                                </td>
                                            <?php endif;?>
                                            <td class="mailbox-name">
                                                <?php echo ($list_data['lesson_type']=="virtual")?"Google Meet":$list_data['lesson_type']; ?>
                                            </td>
                                            <td class="mailbox-name">
                                               <?php echo date("M d, h:i A", strtotime($list_data['start_date'])); ?> - <?php echo date("M d, h:i A", strtotime($list_data['end_date'])); ?>
                                            </td>
                                            <td class="mailbox-name">
                                                <center><?php echo $list_data['term']; ?></center>
                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $list_data['name']; ?>
                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $list_data['class']; ?>
                                            </td>
                                            
                                            <td class="mailbox-name">
                                                <?php echo str_replace("_", " ", strtoupper($list_data['education_level'])); ?>
                                            </td>
                                            <td>
                                                <?php echo ($list_data['shared'] == 1)?"Yes":"No" ; ?>
                                            </td>
                                            <td>
                                                <select class="lesson_status" lesson_id="<?php echo $list_data['id'] ?>" <?php if($role=="student"): ?> readonly="" <?php endif; ?> >
                                                    <option value="awaiting">Awaiting</option>
                                                    <option value="cancelled">Cancelled</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </td>
                                            <td class="mailbox-date pull-right">
                                                <?php if($role=="admin"): ?>

                                                    <?php if($list_data['lesson_type'] == "virtual"||$list_data['lesson_type'] == "zoom"): ?>
                                                        <a data-placement="left" href="<?php echo site_url('lms/lesson/create/'.$list_data['id']);?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Start Class" >
                                                                <i class="fa fa-sign-in"></i> Start Class
                                                        </a>
                                                    <?php endif; ?>
                                                    <a data-placement="left" href="<?php echo site_url('lms/lesson/create/'.$list_data['id']);?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>" >
                                                            <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a data-placement="left" href="<?php echo site_url('lms/lesson/delete/'.$list_data['id']);?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>

                                                <?php elseif($role=="student"): ?>
                                               

                                                    <?php if($list_data["allow_view"]=="1"): ?>
                                                        <a data-placement="left" id="student_view" href="<?php echo site_url('lms/lesson/create/'.$list_data['id']);?>" <?php echo ($list_data['lesson_type']=="virtual")?'onclick="google_meet_open(\''.$list_data["google_meet"].'\')"':'' ?> <?php echo ($list_data['lesson_type']=="zoom")?'onclick="google_meet_open(\''.$list_data["student_zoom_link"].'\')"':'' ?> class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('view'); ?>" >
                                                                <i class="fa fa-eye"  ></i> Enter Class
                                                        </a>
                                                    <?php else: ?>
                                                        <a data-placement="left" id="student_view" <?php echo ($list_data['lesson_type']=="virtual")?'onclick="google_meet_open(\''.$list_data["google_meet"].'\')"':'' ?> <?php echo ($list_data['lesson_type']=="zoom")?'onclick="google_meet_open(\''.$list_data["student_zoom_link"].'\')"':'' ?> class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('view'); ?>" >
                                                                <i class="fa fa-eye"  ></i> Enter Class
                                                        </a>
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


<script>
    function google_meet_open(url){
        window.open(url);
    }
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

        $(".lesson_status").change(function(){
            var lesson_status_val = $(this).val();
            
            alert($(this).val());
        });
        
        
    });
</script>