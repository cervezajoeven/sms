<!DOCTYPE html>
<html>
<head>
	<title>Checking Zoom Accounts</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
	
	<div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="#">Zoom</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Zoom Checker</h3>
      </div>

      <div class="jumbotron">

			
			<h1>Pick Zoom Meeting</h1>
			<p class="lead">Please select a zoom to start the class. If you encounter any disconnection. You can reconnect here.</p>
			

      <table class="table">
        <tr>
          <th>Zoom Email</th>
          <th>Status</th>
          <th>Lesson</th>
          <th>Start Class / Reconnect</th>
          <th>Observe Class / Join Meeting</th>
        </tr>
        <?php foreach ($zoom_lister as $zoom_lister_key => $zoom_lister_value): ?>
          <tr>
            <td><?php echo $zoom_lister_value['email'] ?></td>
            <td><?php echo $zoom_lister_value['availability'] ?></td>
            <td><?php echo $zoom_lister_value['lesson_title'] ?></td>
            <?php if($zoom_lister_value['start_url'] != ""): ?>
              <td><a href="<?php echo $zoom_lister_value['start_url'] ?>" target="_blank"><button class="btn btn-success">Reconnect</button></a></td>
            <?php else: ?>
              <td><a href="<?php echo base_url('lms/lesson/start_zoom/'.$lesson_id.'/'.$zoom_lister_value['email']); ?>" target="_blank"><button class="btn btn-success">Start Class</button></a></td>
            <?php endif; ?>
            <td><a href="<?php echo $zoom_lister_value['join_url'] ?>"><button class="btn btn-warning">Join / Observe Meeting</button></a></td>
          </tr>
        <?php endforeach; ?>
      </table>
			
        
        
        <p class="lead">This is the new update for LMS Zoom Implementation. We upgraded the algorithm and User Friendliness of the interface for the teachers. There are no changes as of the method of using Zoom in the LMS please feel free to use it as the same as before.</p>
      </div>

      <div class="row marketing">
        <div class="col-lg-12">
        	<h1>FAQ's</h1>
        </div>
        <div class="col-lg-6">
          <h4>Q: Encountered <b>Sign In to Start</b> instead going inside the zoom meeting.</h4>
          <p>A: If you encounter this issue please click this button <p><a class="btn btn-lg btn-warning" href="" role="button">Refresh this page.</a></p></p>
          <p>The system will reassign you to a new zoom account which is available right now.</p>
          <hr>
          <h4>Q: When starting zoom there is a warning that looks like this. Saying that there is a current meeting in progress</h4>
          <img class="img-responsive" src="<?php echo base_url('backend/lms/images/zoom_conflict.png'); ?>">
          <p>A: This means that there is a person or teacher started class before you. This mostly happens if you both clicked the start meeting at the same time. To fix this issue please click this button. <a class="btn btn-lg btn-warning" href="" role="button">Refresh this page.</a></p>
        </div>

        <div class="col-lg-6">
          <h4>A: I can't share screen there is an error everytime I try to start</h4>
          <p>Q: This issue may be caused by either the hardware or the software. Zoom recommends to update to the latest zoom application and having Windows 10 or Windows 8 (OS)Operating System. If running on Windows 7 OS please make sure it is running on the latest software version. If you are running on Macintosh Machine aka. (Apple Laptop/Desktop) Please update the firmware to the lastest version, same case with other operating systems.</p>

        </div>
      </div>

      <footer class="footer">
        <p>© 2020 Cloud PH</p>
      </footer>

    </div>
	
</body>
</html>