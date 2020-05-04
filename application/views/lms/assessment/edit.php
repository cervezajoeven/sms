<!DOCTYPE html>
<html>
	<head>
		<title>Control</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="<?php echo $resources.'boostrap.min.css'?>">
		<link rel="stylesheet" href="<?php echo $resources.'bootstrap-theme.min.css'?>">
		<link rel="stylesheet" href="<?php echo $resources.'fileinput.css'?>">
		<link rel="stylesheet" href="<?php echo $resources.'fileinput.min.css'?>">
		<link rel="stylesheet" href="<?php echo $resources.'jquery-ui.css'?>">
		<link rel="stylesheet" href="<?php echo $resources.'font-awesome.min.css'?>">
		<link rel="stylesheet" href="<?php echo $resources.'assessment.css'?>">
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>

		<div class = "container-fluid">
	      	<div class = "row row-height">
		        <div class = "col-sm-7 left">
		        	<form enctype="multipart/form-data" id="upload_form" method="POST" action="<?php echo site_url('lms/assessment/upload/'.$assessment['id']); ?>" style="top: 0;position: absolute; width: 100%;">
		        		<input type="file" required="" class="form-control file" accept="application/pdf" name="assessment_form">
		        		<input type="button" value="Upload" class="form-control btn btn-success upload">
		        	</form>
		        	<?php if($assessment['assessment_file']): ?>
	            		<iframe style="height: 100%;width: 100%;" id="optical_pdf" class="embed-responsive-item" src="<?php echo $resources.'pdfjs/web/viewer.html?file='.urlencode(site_url('uploads/lms_assessment/'.$assessment['id'].'/'.$assessment['assessment_file'])); ?>"></iframe>
	            	<?php else: ?>
	            		<h1 style="text-align: center;">Upload a PDF File Here</h1>
		            <?php endif; ?>
		        </div>

		        <div class="col-sm-5 right">
		        	<div class="info col-sm-5">
		        		<div class="info-row">
			        		<div class="info-tab info-title col-sm-2">Name :</div>
			        		<div class="info-tab col-sm-8">Joeven Abraham Cerveza</div>
		        		</div>
		        		<div class="info-row">
		        			<a href="<?php echo site_url('lms/assessment/index/'); ?>">
			        			<div class="info-tab info-title col-sm-2 the_close">Close</div>
			        		</a>
		        		</div>

		        		<div class="info-row">
			        		<div class="info-tab info-title col-sm-3">Date :</div>
			        		<div class="info-tab col-sm-9"><?php echo date('F d, Y'); ?></div>
		        		</div>

		        		<div class="info-row">
			        		<div class="info-tab info-title col-sm-3">Title :</div>
			        		<div class="info-tab col-sm-9"><?php echo $assessment['assessment_name']?></div>
		        		</div>
		        		<div class="info-row">
			        		<div class="info-tab info-key col-sm-3" option_type="multiple_choice" title="True or False, Yes or No, Chronological Order, Matching Type">Multiple Choice</div>
			        		<div class="tooltip">Hover over me
							  	<span class="tooltiptext">Tooltip text</span>
							</div>
			        		<div class="info-tab info-key col-sm-3" title="Identification, Matching Type, Chronological Order, Fill in the Blanks" option_type="short_answer">Short Answer</div>

			        		<div class="info-tab info-key col-sm-3" title="Essay" option_type="long_answer"><center>Long Answer</center></div>
			        		<div class="info-tab info-key col-sm-3" title="Multiple Answer" option_type="multiple_answer">Multiple Answer</div>
		        		</div>
		        		<div class="info-row">
			        		<div class="info-tab col-sm-12 save">
			        			<center>Save</center>
			        		</div>
		        		</div>
		        	</div>
		        	<div class="clearfix"></div>
		        	<ul class="sortable ui-sortable">
		        		<li class="option-container option-container-clonable">
		        			<div class="numbering_option"></div>
		        				<div class="copy_last" style="display: inline;">
		        					<button class="btn btn-success">Duplicate</button>
		        				</div>
		        				<!-- <div class="copy_bottom" style="display: inline;">
		        					<button class="btn btn-warning">Duplicate To No. 2</button>
		        				</div> -->
		        			
		        			<div class="remove_option float-right">X</div>
		        			<div class="option">
		        				<div class="option_type">
		        					<input type="radio" name="" class="form-control">
		        				</div>
		        				<div class="option_label_container">
		        					<div class="option_label"></div>
		        					<div class="option_label_input">
		        						<input type="text" name="" value="A" class="form-control">
		        					</div>
		        					<div class="remove_choice"><button>X</button></div>
		        				</div>		        				

		        			</div>
		        			
		        			<div class="add_option">
		        				<div class="option_type">
		        					
		        				</div>
		        				<div class="option_label_container">
		        					
		        					<div class="">
		        						<center>
		        							<input type="button" name="" class="form-control btn btn-success" style="margin-top: 10px;" value="Add Option">
		        						</center>
		        						
		        					</div>
		        				</div>		        				

		        			</div>
		        		</li>
		        		
		        	</ul>
		            
		        </div>
	      	</div>
	    </div>
	    <input type="hidden" id="url" value="<?php echo site_url('lms/assessment/update'); ?>" name="" />
	    <input type="hidden" id="stored_json" value="<?php echo $assessment['sheet']; ?>" name="" />
	    <input type="hidden" id="assessment_id" value="<?php echo $assessment['id'] ?>" name="" />
	</body>
</html>
<script type="text/javascript" src="<?php echo $resources.'jquery-1.12.4.js'?>"></script>
<script type="text/javascript" src="<?php echo $resources.'jquery-ui.js'?>"></script>
<script type="text/javascript" src="https://nosir.github.io/cleave.js/dist/cleave.min.js"></script>
<script type="text/javascript" src="https://nosir.github.io/cleave.js/dist/cleave-phone.i18n.js"></script>
<script type="text/javascript" src="<?php echo $resources.'assessment.js'?>"></script>