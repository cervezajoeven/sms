<?php
if (!$form_admission) {
    ?>
    <div class="alert alert-danger">
         <?php echo $this->lang->line('admission_form_disable_please_contact_to_administrator');?>    </div>
    <?php
    return;
}
?>

<?php if ($this->session->flashdata('msg')) {
    echo $this->session->flashdata('msg'); 
} ?>

<style>
    .req{
        color:red;
    }
    .modal-dialog{
        overflow-y: initial !important
    }
    .modal-body{
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
</style>

<div class="modal fade" tabindex="-1" role="dialog" id="privacyPolicy">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4><b>Data Privacy Policy</b></h4>
      </div>

        <div class="modal-body">
            <p>In bound for this Admission system, the <?php echo $schoolname; ?> is committed to respect and protect the collected the confidentiality and privacy of these data and information, including personal information, from various subject using the system as required under the Data Privacy Act of 2012 (Republic Act No. 10173). 
            </p>
            <p>This privacy determines on how the system will manage the personal information/s collected by it, who uses and how the information used, shared and how long is the information will be retained.</p>
            <p>By visiting our system you are doing so on the basis of the general practices described in this Data Protection and Privacy Policy. Where we require your consent to process your personal data in accordance with these practices, we will seek this consent at the point at which you provide us with this data. Where we wish to process your personal data for a purpose other than that for which the personal data were collected, we will notify you of that intention and obtain any further necessary consents.
            </p>
            <p><b>Information you provide to us</b></p>
            <p>As part of the admission process, you will be asked to provide your specific consent for us to process your personal data, including sensitive information, disability status and/or religion (if provided), during and after admission.
            </p>
            <ol>
            <li>Personal information refers to any information whether recorded in a material form or not, from which the identity of an individual is apparent or can be reasonably and directly ascertained by the entity holding the information, or when put together with other information would directly and certainly identify an individual.</li>
            <li>Sensitive personal information refers to personal information:</li>
                <ul>
                    <li>About a marital status, age, and religious, philosophical or political affiliations;</li>
                    <li>About an individual’s health, education, genetic or sexual life of a person, or to any proceeding for any offense committed or alleged to have been committed by such person, the disposal of such proceedings, or the sentence of any court in such proceedings;</li>
                </ul>
            </ol>
            <p><b>How we use information about you</b></p>
            <p>The purposes for which the School uses personal information of students and parents include (but are not limited to):</p>
            <ul>
                    <li>evaluating applications for admission to the School and processing confirmation of incoming students and transfer students;</li>
                    <li>recording, storing and evaluating student work, e. g. homework, seatwork, tests, research papers, essays and presentations;</li>
                    <li>recording, generating and maintaining records, whether manually, electronically or other means, of class attendance and participation in curricular, co-curricular and extra-curricular activities;</li>
                    <li>sharing of grades between and among faculty members, and others with legitimate official need, for academic deliberations;</li>
                    <li>processing scholarship applications, grants and other forms of assistance;</li>
                    <li>investigating incidents relating to student behavior and implementing disciplinary measures;</li>
                    <li>maintaining directories and alumni records;</li>
                    <li>compiling and generating reports for statistical and research purposes;</li>
                    <li>providing health, counseling, information technology, library, sports/recreation, transportation, parking, campus mobility, safety and security services;</li>
                    <li>communicating official school announcements;</li>
                    <li>sharing marketing and promotional materials regarding school-related functions, events, projects and activities;</li>
                    <li>keeping parents informed about matters related to the student’s schooling, through correspondence, newsletters and magazines;</li>
                    <li>satisfying the School’s legal obligations and allowing the School to discharge its duty of care. In cases where the School requests personal information about a Student or parent, if the information requested is not provided, the School may not be able to enroll or continue the enrollment of the student or permit the student to take part in a particular activity.</li>
            </ul>
            
            <p><b>Retention of your personal information</b></p>
            <p>Your personal data will be destroyed or erased from our systems when it is no longer required for the relevant specified purpose that it was collected for, provided that we may retain personal data in order to comply with applicable laws, regulations and rules. </p>
        </div>
        <div class="modal-footer">
            <!-- <div class="checkbox pull-left">
                <label><input type="checkbox" value="">Option 1</label>
            </div> -->
            <div class="pull-right">
                <button type="button" class="onlineformbtn" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="admissionguidelines">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3><b>Admission Guidelines</b></h3>
      </div>

        <div class="modal-body">
            <!-- <h2>Admission Guidelines</h2> -->
            <ol>
                <li>
                    <h3>
                        <strong>Guidelines and Requirements</strong>
                    </h3>
                    <strong>For new Students</strong><br>
                    <ol>
                        <li>Any incoming freshman, whether he/she is a graduate of <?php echo $schoolname; ?> or not, has to undergo an entrance examination and panel interview on top of submitting the necessary credentials.</li>
                        <li>Only an applicant who is able to pass the above said requirements can be admitted to the High School Department.</li>
                        <li>A student whose overall screening is a little bit below the acceptable standard is placed on probation for one school year. He/She will be regarded as a regular student in the following school year if he does not fail any of his subject and has a general average of 80%. In addition, he/she should not have any disciplinary problems throughout his first year in our school.</li>
                        <li>His/ Her parent(s) or guardian has/have to be interviewed also.</li>
                        <li>The following requirements must be submitted upon application:</li>
                            <ul>
                                <li>Photocopy of NSO birth certificate (original copy must be brought for verification purposes)</li>
                                <li>Medical certificate and immunization record from the child’s pediatrician</li>
                                <li>Three (3) copies of recent ID picture (1” x 1”)</li>
                                <li>Assessment and Interview of the Child/ Interview of his/her parent(s) or guardian</li>
                                <li>Application Fee</li>
                                <li>For transferees - letters (a – e) plus Report Card and Certificate of good moral character from the school last attended.</li>
                                <li>ACR and ICR for foreigners</li>
                                <li>NCAE Results for SHS applicants</li>
                            </ul>
                    </ol>
                    <strong>For incumbent students</strong>
                    <ol>
                        <li>The child must present his/her Report Card—Form 138 and re-admission slip.</li>
                        <li>The child who fails for two (2) consecutive years in the same year level will not be re-admitted. This likewise holds true to any student who gets suspended for three (3) times within a school year.</li>
                        <li>The child who is under academic and/or disciplinary probation has one school year to meet the condition(s) given to him in order to be re-admitted for the next school year.</li>
                    </ol>
                </li>
                <li>
                <h3>
                    <strong>Scholarship</strong>
                    </h3>
                    <ol>
                        <li><strong>School Academic Scholarship</strong> is given to a student who garners the school holistic excellence awards of With Distinctions, With Honors, With High Honors, and With Highest Honors. The percentage of the tuition fee discounts will be based on the award he/she has received.</li>
                        <li><strong>Educational Service Contracting (ESC) Program</strong> is a DepEd fund assistance to private education. A fund assistance is given to a qualified student for four (4) years, (Grade 7 to 12) provided that he/she will not have any failing grades.</li>
                        <li><strong>Other scholarship grants</strong> are given to selected underprivileged students.</li>
                    </ol>
                </li>
                <li>
                    <h3>
                    <strong>Enrollment Calendar</strong>
                    </h3>
                    <ul>
                        <p>May XX, 2020 – Detail here </p>
                        <p>May XX, 2020 – Detail here</p>
                        <p>Month XX, 2020 – Detail here</p>
                    </ul>
                </li>
            </ol>
        </div>
        <div class="modal-footer">
            <!-- <div class="checkbox pull-left">
                <label><input type="checkbox" value="">Option 1</label>
            </div> -->
            <div class="pull-right">
                <button type="button" class="onlineformbtn" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<form id="form1" class="spaceb60 onlineform" action="<?php echo current_url() ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <?php
        if (isset($error_message)) {
            //echo "<div class='alert alert-danger'>" . $error_message . "</div>";
        }

        $enrollTypes = array(""=>"Select","new"=>"New","old"=>"Old","returnee"=>"Returnee","transferee"=>"Transferee");
        // $enrollTypes = array(""=>"Select","new"=>"New","old"=>"Old");
        $modeofPayment = array(""=>"Select","Reservation"=>"Reservation", "Monthly"=>"Monthly","Quarterly"=>"Quarterly","Semestral"=>"Semestral","Whole Year"=>"Whole Year");
    ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group pull-right">
                <button type="button" class="onlineformbtn pull-right pb-3" onclick="ShowGuidelines()">Admission Guidelines</button>
            </div> 
        </div>    
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="" class="control-label">Student Enrollment Type</label>
                <small class='req'> *</small>
                <select id="enrollment_type" name="enrollment_type" class="form-control" onchange="DoOnChange(this)">
                    <?php foreach ($enrollTypes as $enrollType_key => $enrollType_value) { ?>
                        <option value="<?php echo $enrollType_key; ?>" <?php echo(set_value('enrollment_type') == $enrollType_key ? 'selected' : ''); ?>><?php echo $enrollType_value; ?></option>
                    <?php }?>
                </select>
                <span class="text-danger"><?php echo form_error('enrollment_type'); ?></span>
            </div>
        </div>
        <div class="col-md-3" id="id_number_input">
            <div class="form-group">
                <label for="studentidnumber"><?php echo $this->lang->line('student_id').' (old students only)'; ?></label><small class="req"> *</small> 
                <input id="studentidnumber" disabled="disabled" name="studentidnumber" placeholder="Type ID number then press enter" type="text" class="form-control"  value="<?php echo set_value('studentidnumber'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('studentidnumber'); ?></span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="" class="control-label">Mode of Payment</label>
                <small class='req'> *</small>
                <select id="mode_of_payment" name="mode_of_payment" class="form-control">
                    <?php foreach ($modeofPayment as $modeofPayment_key => $modeofPayment_value) { ?>
                        <option value="<?php echo $modeofPayment_key; ?>" <?php echo(set_value('mode_of_payment') == $modeofPayment_key ? 'selected' : ''); ?>><?php echo $modeofPayment_value; ?></option>
                    <?php }?>
                </select>
                <span class="text-danger"><?php echo form_error('mode_of_payment'); ?></span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('email'); ?></label><small class="req"> *</small>
                <input id="email" name="email" placeholder="" type="text" class="form-control"  value="<?php echo set_value('email'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('email'); ?></span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="firstname"><?php echo $this->lang->line('first_name'); ?></label><small class="req"> *</small> 
                <input id="firstname" name="firstname" placeholder="" type="text" class="form-control"  value="<?php echo set_value('firstname'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('firstname'); ?></span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="middlename"><?php echo $this->lang->line('middle_name'); ?></label>
                <input id="middlename" name="middlename" placeholder="" type="text" class="form-control"  value="<?php echo set_value('middlename'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('middlename'); ?></span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="lastname"><?php echo $this->lang->line('last_name'); ?></label><small class="req"> *</small> 
                <input id="lastname" name="lastname" placeholder="" type="text" class="form-control"  value="<?php echo set_value('lastname'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('lastname'); ?></span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="class_id"><?php echo $this->lang->line('enrolling_for'); ?></label><small class="req"> *</small>
                <select  id="class_id" name="class_id" class="form-control"  >
                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                    <?php
                    foreach ($classlist as $class) {
                        ?>
                        <option value="<?php echo $class['id'] ?>"<?php if (set_value('class_id') == $class['id']) echo "selected=selected" ?>><?php echo $class['class'] ?></option>
                        <?php
                        $count++;
                    }
                    ?>
                </select>
                <span class="text-danger"><?php echo form_error('class_id'); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputFile"> <?php echo $this->lang->line('gender'); ?></label><small class="req"> *</small> 
                <select class="form-control" name="gender" id="gender">
                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                    <?php foreach ($genderList as $key => $value) { ?>
                        <option value="<?php echo strtolower($key); ?>" <?php if (strtolower(set_value('gender')) == strtolower($key)) echo "selected"; ?>><?php echo $value; ?></option>
                    <?php } ?>
                </select>
                <span class="text-danger"><?php echo form_error('gender'); ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('date_of_birth'); ?></label><small class="req"> *</small> 
                <input  type="text" class="form-control date2"  value="<?php echo set_value('dob'); ?>" id="dob" name="dob" readonly="readonly" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('dob'); ?></span>
            </div>            
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"> <?php echo $this->lang->line('upload')." ".$this->lang->line('documents');?></label>
                <input id="document" name="document"  type="file" class="form-control"  value="<?php echo set_value('document'); ?>" />
                <span class="text-danger"><?php echo form_error('document'); ?></span>
            </div>
        </div>
    </div><!--./row-->     

    <div class="row" id="parentdetail">  
        <div class="col-md-12"><h4 class="pagetitleh2"><?php echo $this->lang->line('parent_guardian_detail'); ?></h4></div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('father_name'); ?></label>
                <input id="father_name" name="father_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_name'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('father_name'); ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('father_phone'); ?></label>
                <input id="father_phone" name="father_phone" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_phone'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('father_phone'); ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('father_occupation'); ?></label>
                <input id="father_occupation" name="father_occupation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_occupation'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('father_occupation'); ?></span>
            </div>
        </div>    
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_name'); ?></label>
                <input id="mother_name" name="mother_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_name'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('mother_name'); ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_phone'); ?></label>
                <input id="mother_phone" name="mother_phone" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_phone'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('mother_phone'); ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_occupation'); ?></label>
                <input id="mother_occupation" name="mother_occupation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_occupation'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('mother_occupation'); ?></span>
            </div>
        </div>
    </div><!--./row-->        
           
    <div class="row" id="guardiandetail1">
        <div class="form-group col-md-12">
            <label><?php echo $this->lang->line('if_guardian_is'); ?><small class="req"> *</small>&nbsp;&nbsp;&nbsp;</label>
            <label class="radio-inline">
                <input type="radio" name="guardian_is" <?php
                echo set_value('guardian_is') == "father" ? "checked" : "";
                ?>   value="father"> <?php echo $this->lang->line('father'); ?>
            </label>
            <label class="radio-inline">
                <input type="radio" name="guardian_is" <?php
                echo set_value('guardian_is') == "mother" ? "checked" : "";
                ?>   value="mother"> <?php echo $this->lang->line('mother'); ?>
            </label>
            <label class="radio-inline">
                <input type="radio" name="guardian_is" <?php
                echo set_value('guardian_is') == "other" ? "checked" : "";
                ?>   value="other"> <?php echo $this->lang->line('other'); ?>
            </label>
            <span class="text-danger"><?php echo form_error('guardian_is'); ?></span>
        </div>        

        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_name'); ?></label><small class="req"> *</small>
                <input id="guardian_name" name="guardian_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_name'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('guardian_name'); ?></span>
            </div>
        
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_relation'); ?></label>
                <input id="guardian_relation" name="guardian_relation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_relation'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('guardian_relation'); ?></span>
            </div>
        </div>
    </div><!--./row-->    

    <div class="row" id="guardiandetail2">
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_phone'); ?></label><small class="req"> *</small>
                <input id="guardian_phone" name="guardian_phone" placeholder="e.g. +639999999999" type="text" class="form-control"  value="<?php echo set_value('guardian_phone'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('guardian_phone'); ?></span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_occupation'); ?></label>
                <input id="guardian_occupation" name="guardian_occupation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_occupation'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('guardian_occupation'); ?></span>
            </div>
        </div>
    
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_email'); ?></label>
                <input id="guardian_email" name="guardian_email" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_email'); ?>" autocomplete="off"/>
                <span class="text-danger"><?php echo form_error('guardian_email'); ?></span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">   
                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_address'); ?></label>
                <textarea id="guardian_address" name="guardian_address" placeholder="" class="form-control" rows="2"><?php echo set_value('guardian_address'); ?></textarea>
                <span class="text-danger"><?php echo form_error('guardian_address'); ?></span>
            </div>  
        </div>
    </div>
    
    <div class="row" id="otherparentdetail">
        <div class="col-md-12"><h4 class="pagetitleh2"><?php echo $this->lang->line('other_parent_detail'); ?></h4></div>
        <div class="nav-tabs-custom theme-shadow">
            <ul class="nav nav-tabs" style="margin:15px">
                <li class="active"><a href="#father" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('father'); ?></a></li>
                <li class=""><a href="#mother" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('mother'); ?></a></li>
            </ul>
        </div>

        <div class="tab-content" style="margin:15px;">
            <div class="tab-pane active" id="father">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="father_company_name"><?php echo $this->lang->line('company'); ?></label>
                            <input id="father_company_name" name="father_company_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_company_name'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_company_name'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="father_company_position"><?php echo $this->lang->line('position'); ?></label>
                            <input id="father_company_position" name="father_company_position" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_company_position'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_company_position'); ?></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="father_nature_of_business"><?php echo $this->lang->line('nature_of_business'); ?></label>
                            <input id="father_nature_of_business" name="father_nature_of_business" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_nature_of_business'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_nature_of_business'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="father_mobile"><?php echo $this->lang->line('mobile'); ?></label>
                            <input id="father_mobile" name="father_mobile" pattern="[+][0-9]{2}[0-9]{3}[0-9]{7}" placeholder="e.g. +639999999999" type="text" class="form-control"  value="<?php echo set_value('father_mobile'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_mobile'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="father_dob"><?php echo $this->lang->line('date_of_birth'); ?></label>
                            <input  type="text" class="form-control date2"  value="<?php echo set_value('father_dob'); ?>" id="father_dob" name="father_dob" readonly="readonly" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_dob'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="father_citizenship"><?php echo $this->lang->line('citizenship'); ?></label>
                            <input id="father_citizenship" name="father_citizenship" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_citizenship'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_citizenship'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="father_religion"><?php echo $this->lang->line('religion'); ?></label>
                            <input id="father_religion" name="father_religion" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_religion'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_religion'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="father_highschool"><?php echo $this->lang->line('highschool'); ?></label>
                            <input id="father_highschool" name="father_highschool" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_highschool'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_highschool'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="father_college"><?php echo $this->lang->line('college'); ?></label>
                            <input id="father_college" name="father_college" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_college'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_college'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="father_college_course"><?php echo $this->lang->line('college_course'); ?></label>
                            <input id="father_college_course" name="father_college_course" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_college_course'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_college_course'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="father_post_graduate"><?php echo $this->lang->line('post_graduate'); ?></label>
                            <input id="father_post_graduate" name="father_post_graduate" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_post_graduate'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_post_graduate'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="father_post_course"><?php echo $this->lang->line('degree_attained'); ?></label>
                            <input id="father_post_course" name="father_post_course" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_post_course'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_post_course'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="father_prof_affiliation"><?php echo $this->lang->line('prof_affil'); ?></label>
                            <input id="father_prof_affiliation" name="father_prof_affiliation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_prof_affiliation'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_prof_affiliation'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="father_prof_affiliation_position"><?php echo $this->lang->line('position_held'); ?></label>
                            <input id="father_prof_affiliation_position" name="father_prof_affiliation_position" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_prof_affiliation_position'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('father_prof_affiliation_position'); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-6">
                        <label><?php echo $this->lang->line('tech_prof');?>
                        <label class="radio-inline">
                            <input type="radio" name="father_tech_prof" <?php echo set_value('father_tech_prof') == "yes" ? "checked" : ""; ?> value="yes"> <?php echo $this->lang->line('yes'); ?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="father_tech_prof" <?php echo set_value('father_tech_prof') == "no" ? "checked" : ""; ?> value="no"> <?php echo $this->lang->line('no'); ?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="father_tech_prof" <?php echo set_value('father_tech_prof') == "others" ? "checked" : ""; ?> value="others"> <?php echo $this->lang->line('other'); ?>
                        </label>
                        <span class="text-danger"><?php echo form_error('father_tech_prof'); ?></span>
                    </div>
                    <div class="form-group col-md-6">
                        <input id="father_tech_prof_other" name="father_tech_prof_other" placeholder="If others, please specify" type="text" class="form-control"  value="<?php echo set_value('father_tech_prof_other'); ?>" autocomplete="off"/>
                    </div>
                </div>

            </div>

            <div class="tab-pane" id="mother">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mother_company_name"><?php echo $this->lang->line('company'); ?></label>
                            <input id="mother_company_name" name="mother_company_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_company_name'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_company_name'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mother_company_position"><?php echo $this->lang->line('position'); ?></label>
                            <input id="mother_company_position" name="mother_company_position" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_company_position'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_company_position'); ?></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mother_nature_of_business"><?php echo $this->lang->line('nature_of_business'); ?></label>
                            <input id="mother_nature_of_business" name="mother_nature_of_business" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_nature_of_business'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_nature_of_business'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mother_mobile"><?php echo $this->lang->line('mobile'); ?></label>
                            <input id="mother_mobile" name="mother_mobile" pattern="^\+(?:[0-9] ?){6,25}[0-9]$" placeholder="e.g. +639999999999" type="text" class="form-control"  value="<?php echo set_value('mother_mobile'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_mobile'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mother_dob"><?php echo $this->lang->line('date_of_birth'); ?></label>
                            <input  type="text" class="form-control date2"  value="<?php echo set_value('mother_dob'); ?>" id="mother_dob" name="mother_dob" readonly="readonly" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_dob'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mother_citizenship"><?php echo $this->lang->line('citizenship'); ?></label>
                            <input id="mother_citizenship" name="mother_citizenship" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_citizenship'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_citizenship'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mother_religion"><?php echo $this->lang->line('religion'); ?></label>
                            <input id="mother_religion" name="mother_religion" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_religion'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_religion'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mother_highschool"><?php echo $this->lang->line('highschool'); ?></label>
                            <input id="mother_highschool" name="mother_highschool" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_highschool'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_highschool'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mother_college"><?php echo $this->lang->line('college'); ?></label>
                            <input id="mother_college" name="mother_college" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_college'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_college'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mother_college_course"><?php echo $this->lang->line('college_course'); ?></label>
                            <input id="mother_college_course" name="mother_college_course" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_college_course'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_college_course'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mother_post_graduate"><?php echo $this->lang->line('post_graduate'); ?></label>
                            <input id="mother_post_graduate" name="mother_post_graduate" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_post_graduate'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_post_graduate'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mother_post_course"><?php echo $this->lang->line('degree_attained'); ?></label>
                            <input id="mother_post_course" name="mother_post_course" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_post_course'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_post_course'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mother_prof_affiliation"><?php echo $this->lang->line('prof_affil'); ?></label>
                            <input id="mother_prof_affiliation" name="mother_prof_affiliation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_prof_affiliation'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_prof_affiliation'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mother_prof_affiliation_position"><?php echo $this->lang->line('position_held'); ?></label>
                            <input id="mother_prof_affiliation_position" name="mother_prof_affiliation_position" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_prof_affiliation_position'); ?>" autocomplete="off"/>
                            <span class="text-danger"><?php echo form_error('mother_prof_affiliation_position'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label><?php echo $this->lang->line('tech_prof');?>
                        <label class="radio-inline">
                            <input type="radio" name="mother_tech_prof" <?php echo set_value('mother_tech_prof') == "yes" ? "checked" : ""; ?> value="yes"> <?php echo $this->lang->line('yes'); ?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="mother_tech_prof" <?php echo set_value('mother_tech_prof') == "no" ? "checked" : ""; ?> value="no"> <?php echo $this->lang->line('no'); ?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="mother_tech_prof" <?php echo set_value('mother_tech_prof') == "other" ? "checked" : "";?> value="other"> <?php echo $this->lang->line('other'); ?>
                        </label>
                        <span class="text-danger"><?php echo form_error('mother_tech_prof'); ?></span>
                    </div>
                    <div class="form-group col-md-6">
                    <input id="mother_tech_prof_other" name="mother_tech_prof_other" placeholder="If others, please specify" type="text" class="form-control"  value="<?php echo set_value('mother_tech_prof_other'); ?>" autocomplete="off"/>
                    </div>
                </div>
            </div>
        </div>
    </div><!--./row-->

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
            </div>  
        </div>
        <div class="col-md-4">
            <div class="form-group">
            </div>  
        </div>        
        <div class="col-md-4">
            <div class="form-group">
                <div class="form-group pull-right">
                    <label><input type="checkbox" value="" id="iagree"> I understand that by checking this box, I authorize the <?php echo $schoolname; ?> to use the information I provided but within the bounds of data privacy act. See our <a href="#" onclick="ShowPrivacyPolicy()">Data Privacy Policy</a> for more details.</label>
                </div>
            </div>  
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group pull-right">
                <!-- <label><input type="checkbox" value="" id="iagree"> I agree with the <a href="#" onclick="ShowPrivacyPolicy()">Data Privacy Policy</a></label> -->
                <button disabled='disabled' id="save_admission" type="submit" class="onlineformbtn"><?php echo $this->lang->line('save'); ?></button>
            </div> 
        </div>    
    </div><!--./row-->    
</form>

<script type="text/javascript">
    $(document).ready(function () {
        // var class_id = $('#class_id').val();
        // var section_id = '<?php //echo set_value('section_id', 0) ?>';

        // getSectionByClass(class_id, section_id);

        // $(document).on('change', '#class_id', function (e) {
        //     $('#section_id').html("");
        //     var class_id = $(this).val();
        //     getSectionByClass(class_id, 0);
        // });

        // function getSectionByClass(class_id, section_id) {
        //     if (class_id !== "") {
        //         $('#section_id').html("");

        //         var div_data = '<option value=""><?php //echo $this->lang->line('select'); ?></option>';
        //         var url = "";

        //         $.ajax({
        //             type: "POST",
        //             url: base_url + "welcome/getSections",
        //             data: {'class_id': class_id},
        //             dataType: "json",
        //             beforeSend: function () {
        //                 $('#section_id').addClass('dropdownloading');
        //             },
        //             success: function (data) {
        //                 $.each(data, function (i, obj)
        //                 {
        //                     var sel = "";
        //                     if (section_id === obj.section_id) {
        //                         sel = "selected";
        //                     }
        //                     div_data += "<option value=" + obj.id + " " + sel + ">" + obj.section + "</option>";
        //                 });
        //                 $('#section_id').append(div_data);
        //             },
        //             complete: function () {
        //                 $('#section_id').removeClass('dropdownloading');
        //             }
        //         });
        //     }
        // }

        $('#father_tech_prof_other').fadeOut();
        $('#mother_tech_prof_other').fadeOut();

        $('.date2').datepicker({
            autoclose: true,
            todayHighlight: true
        });

        if ($('#enrollment_type').val() == 'old') {
            $('#studentidnumber').prop('disabled', false);
            $('#firstname').prop('readonly', true);
            $('#middlename').prop('readonly', true);
            $('#lastname').prop('readonly', true);
            $('#gender').prop('readonly', true);
            $('#dob').prop('readonly', true);
            $('#id_number_input').fadeIn();
            $('#parentdetail').slideUp();
            $('#guardiandetail1').slideUp();
            $('#guardiandetail2').slideUp();
            $('#otherparentdetail').slideUp();
        }
    });

    $('input:radio[name="guardian_is"]').change(
        function () {
            if ($(this).is(':checked')) {
                var value = $(this).val();
                if (value === "father") {
                    $('#guardian_name').val($('#father_name').val());
                    $('#guardian_phone').val($('#father_phone').val());
                    $('#guardian_occupation').val($('#father_occupation').val());
                    $('#guardian_relation').val("Father");
                } else if (value === "mother") {
                    $('#guardian_name').val($('#mother_name').val());
                    $('#guardian_phone').val($('#mother_phone').val());
                    $('#guardian_occupation').val($('#mother_occupation').val());
                    $('#guardian_relation').val("Mother");
                } else {
                    $('#guardian_name').val("");
                    $('#guardian_phone').val("");
                    $('#guardian_occupation').val("");
                    $('#guardian_relation').val("");
                }
            }
        }
    );

    $('input:radio[name="father_tech_prof"]').change(
        function () {
            if ($(this).is(':checked')) {
                var value = $(this).val();
                if (value === "others") {
                    $('#father_tech_prof_other').fadeIn();
                }
                else {
                    $('#father_tech_prof_other').fadeOut();
                }
            }
        }
    );

    $('input:radio[name="mother_tech_prof"]').change(
        function () {
            if ($(this).is(':checked')) {
                var value = $(this).val();
                if (value === "others") {
                    $('#mother_tech_prof_other').fadeIn();
                }
                else {
                    $('#mother_tech_prof_other').fadeOut();
                }
            }
        }
    );

    $("#iagree").change(function() {
        if (this.checked) {
            $('#save_admission').prop('disabled', false);
        } else {
            $('#save_admission').prop('disabled', true);
        }
    });

    $('#studentidnumber').keypress(function (e) {
        var key = e.which;

        if(key == 13) {  // the enter key code
            if ($("#studentidnumber").val() != '') {
                var url = '<?php echo base_url(); ?>' + 'welcome/GetStudentDetails/'+$("#studentidnumber").val();
                $.get(url)
                .done(function(data) {
                    //alert( "Data Loaded: " + data );
                    AutoFillDetails(JSON.parse(data));
                });
            }
        }
    });

    function DoOnChange(sel) {
        $('.text-danger').html('');
        $('.alert').alert('close');

        if (sel.value == "old") {
            $('#studentidnumber').prop('disabled', false);
            $('#firstname').prop('readonly', true);
            $('#middlename').prop('readonly', true);
            $('#lastname').prop('readonly', true);
            $('#gender').prop('readonly', true);
            $('#dob').prop('readonly', true);
            $('#id_number_input').fadeIn();
            $('#parentdetail').slideUp();
            $('#guardiandetail1').slideUp();
            $('#guardiandetail2').slideUp();
            $('#otherparentdetail').slideUp();
        }            
        else {
            $('#studentidnumber').val('');
            $('#firstname').val('');
            $('#middlename').val('');
            $('#lastname').val('');
            $('#gender').val('');
            $('#dob').val('');

            $('#studentidnumber').prop('disabled', true);
            $('#firstname').prop('readonly', false);
            $('#middlename').prop('readonly', false);
            $('#lastname').prop('readonly', false);
            $('#gender').prop('readonly', false);
            $('#dob').prop('readonly', false);
            $('#id_number_input').fadeOut();
            $('#parentdetail').slideDown();
            $('#guardiandetail1').slideDown();
            $('#guardiandetail2').slideDown();
            $('#otherparentdetail').slideDown();
        }        
    }

    function AutoFillDetails(data) {
        //$('#studentidnumber').val('');
        $('#firstname').val('');
        $('#middlename').val('');
        $('#lastname').val('');
        $('#gender').val('');
        $('#dob').val('');
        $('#firstname').val(data.firstname);
        $('#middlename').val(data.middlename);
        $('#lastname').val(data.lastname);
        $('#gender').val(data.gender);
        $('#dob').val(data.dob);
    }

    function ShowGuidelines() {
        $('#admissionguidelines').modal("show");
    }

    function ShowPrivacyPolicy() {
        $('#privacyPolicy').modal("show");
    }

</script>


