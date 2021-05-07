
<div class="row">
            <div class="col-md-12">
                <div class="box box-primary border0 mb0 margesection">
                    <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-search"></i>  <?php echo $this->lang->line('student_information')." ".$this->lang->line('report')?></h3>

            </div>
                    <div class="">
                        <ul class="reportlists">
                        
                        	<?php
                        	 if ($this->rbac->hasPrivilege('student_report', 'can_view')) {
                                ?>
                                <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/student_information/student_report'); ?>"><a href="<?php echo base_url(); ?>student/studentreport"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('student_report'); ?></a></li>
                                <?php
                            }
                             if ($this->rbac->hasPrivilege('guardian_report', 'can_view')) {
                                ?>

                                <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/student_information/guardian_report'); ?>"><a href="<?php echo base_url(); ?>student/guardianreport"><i class="fa fa-file-text-o"></i>
                                        <?php echo $this->lang->line('guardian_report'); ?></a></li>
                                <?php
                            } 
                             if ($this->rbac->hasPrivilege('student_history', 'can_view')) {
                               
                            ?>

                            <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/student_information/student_history'); ?>"><a href="<?php echo base_url() ?>admin/users/admissionreport"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('student_history'); ?></a></li>
                        <?php } ?>
                        
                         <?php if($this->rbac->hasPrivilege('student_login_credential_report','can_view')){   ?>
                        <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/student_information/student_login_credential'); ?>"><a href="<?php echo base_url(); ?>admin/users/logindetailreport"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('student')." ".$this->lang->line('login_credential'); ?></a></li>
                      <?php } ?>

                        <?php if($this->rbac->hasPrivilege('class_subject_report','can_view')){
                          ?>
                          <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/student_information/class_subject_report'); ?>"><a href="<?php echo base_url(); ?>report/class_subject"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('class')." ".$this->lang->line('subject')." ".$this->lang->line('report'); ?></a></li>
                          <?php   } if($this->rbac->hasPrivilege('admission_report','can_view')){ ?>
                         

                         <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/student_information/admission_report'); ?>"><a href="<?php echo base_url(); ?>report/admission_report"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('admission')." ".$this->lang->line('report'); ?></a></li>
                     <?php } if($this->rbac->hasPrivilege('sibling_report','can_view')){ ?>

                         <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/student_information/sibling_report'); ?>"><a href="<?php echo base_url(); ?>report/sibling_report"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('sibling')." ".$this->lang->line('report'); ?></a></li>
                       <?php } 
                       if($this->rbac->hasPrivilege('student_profile','can_view')){ ?>
                          <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/student_information/student_profile'); ?>"><a href="<?php echo base_url(); ?>report/student_profile"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('student')." ".$this->lang->line('profile'); ?></a></li><?php 
                        }if($this->rbac->hasPrivilege('homehork_evaluation_report','can_view')){ ?>
                         <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/student_information/evaluation_report'); ?>"><a href="<?php echo base_url(); ?>homework/evaluation_report"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('homework')." ".$this->lang->line('evaluation_report'); ?></a></li>
                       <?php }  ?>
                        <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/student_information/enrollment_report'); ?>"><a href="<?php echo base_url(); ?>report/enrollment_report"><i class="fa fa-file-text-o"></i> Enrollment Report</a></li>
                        <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/student_information/enrollment_summary_report'); ?>"><a href="<?php echo base_url(); ?>report/enrollment_summary_report"><i class="fa fa-file-text-o"></i> Enrollment Summary Report</a></li>
                        <?php if ($this->rbac->hasPrivilege('student_report', 'can_view')) { ?>
                            <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/class_record/class_record_summary'); ?>"><a href="<?php echo base_url(); ?>report/class_record_summary"><i class="fa fa-file-text-o"></i> Summary of Consolidated Grades</a></li>
                            <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/class_record/class_record_quarterly'); ?>"><a href="<?php echo base_url(); ?>report/class_record_quarterly"><i class="fa fa-file-text-o"></i> Summary of Quarterly Grades</a></li>
                            <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/class_record/class_record_per_student'); ?>"><a href="<?php echo base_url(); ?>report/class_record_per_student"><i class="fa fa-file-text-o"></i> Quarterly Grades Per Student</a></li>
                            <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/class_record/class_record_banig'); ?>"><a href="<?php echo base_url(); ?>report/class_record_banig"><i class="fa fa-file-text-o"></i> Generate DepEd Banig</a></li>
                            <li class="col-lg-4 col-md-3 col-sm-6 <?php echo set_SubSubmenu('Reports/class_record/class_record_per_student'); ?>"><a href="<?php echo base_url(); ?>report/print_cards_per_section"><i class="fa fa-file-text-o"></i> Print Card Per Section</a></li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>