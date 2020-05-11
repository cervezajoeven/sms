var url = $("#url").val();
var site_url = $("#site_url").val();
var stored_json = $("#stored_json").val();
var account_id = $("#account_id").val();
var assessment_sheet_id = $("#assessment_sheet_id").val();
var final_json = {};
var letters_array = ["A","B","C","D"];
// $(".sortable").sortable({
// 	stop:function(event,ui){
// 		renumbering();
// 	}
// });
$(".option-container-clonable").hide();

function isEmpty(obj) {
  for(var prop in obj) {
    if(obj.hasOwnProperty(prop)) {
      return false;
    }
  }

  return JSON.stringify(obj) === JSON.stringify({});
}

function populate_key(option_type,data={}){
	var option_clone = $(".option-container-clonable").clone();
	
	switch (option_type){
		case "multiple_choice":
			option_clone.removeClass("option-container-clonable");
			option_clone.addClass("option-container-actual");
			option_clone.addClass("multiple_choice");
			option_clone.attr("option_type","multiple_choice");
			option_clone.show();
			
			if(!isEmpty(data)){
				
			}

			$(".sortable").append(option_clone);
		break;
		case "multiple_answer":
			option_clone.removeClass("option-container-clonable");
			option_clone.addClass("option-container-actual");
			option_clone.addClass("multiple_choice");
			option_clone.attr("option_type","multiple_answer");
			option_clone.show();
			option_clone.find(".option_type").find("input").attr("type","checkbox");
			$(".sortable").append(option_clone);
		break;
		case "short_answer":

			option_clone.removeClass("option-container-clonable");
			option_clone.addClass("option-container-actual");
			option_clone.addClass("short_answer");
			option_clone.show();
			option_clone.attr("option_type","short_answer");

			option_clone.find(".option_type").find("input").attr("type","text");
			// option_clone.find(".option_type").find("input").val(data.correct.split(",").join(" or "));
			option_clone.find(".option_type").find("input").css("width","100%");
			option_clone.find(".option_label_input").find("input").remove();
			option_clone.find(".remove_choice").remove();
			option_clone.find(".add_option").remove();
			$(".sortable").append(option_clone);
		break;
		case "long_answer":
			option_clone.removeClass("option-container-clonable");
			option_clone.addClass("option-container-actual");
			option_clone.addClass("short_answer");
			option_clone.show();
			option_clone.attr("option_type","long_answer");
			option_clone.find(".option_type").empty();
			option_clone.find(".option_type").html('<textarea class="form-control"></textarea>');
			option_clone.find(".option_type").find("textarea").css("width","100%");
			option_clone.find(".option_label_input").find("input").remove();
			option_clone.find(".add_option").remove();
			$(".sortable").append(option_clone);
		break;
	}
}

function renumbering(){
	var total_number = $(".option-container-actual");
	$.each(total_number,function(key,value){
		$(value).find(".numbering_option").text(key+1);
		$(value).find(".option_type").find("input").attr("name","option_"+key+1);
	});
}
$(document).ready(function(){
	
	if(stored_json){

		$.each(JSON.parse(stored_json),function(key,value){
			populate_key(value.type,value);
			// console.log(value.correct);
			$.each(value.option_labels.split(","),function(split_key,split_value){
				
				var last_option = $(".option-container-actual").eq(key).find(".option").length;
				var option_clone = $(".option-container-actual").eq(key).find(".option").eq(last_option-1).clone();
				$(".option-container-actual").eq(key).find(".option").eq(last_option-1).after(option_clone);

			});


			var the_last = $(".option-container-actual").eq(key).find(".option").length;
			$.each(value.option_labels.split(","),function(value_key,value_value){
				$(".option-container-actual").eq(key).find(".option").eq(value_key).find(".option_label_input").find("input").val(value_value);
				
			});
			$(".option-container-actual").eq(key).find(".option").eq(the_last-1).remove();


			
		});
		renumbering();
		$(document).find(".option_label_input").find("input").attr("readonly","readonly");
	}
	

});
$(document).on("click",".remove_option",function(){
	$(this).parent().remove();
	renumbering();

});
$(".info-key").click(function(){
	var option_type = $(this).attr("option_type");
	populate_key(option_type);
	
	renumbering();
});
$(document).on("click",".add_option",function(){
	var last_option = $(this).parent().find(".option").length;
	var option_clone = $(this).siblings(".option").eq(last_option-1).clone();
	$(this).parent().find(".option").eq(last_option-1).after(option_clone);

});
$(".submit").click(function(){
	var json = [];
	var options = $(".option-container-actual");
	$.each(options,function(key,value){
		var the_option_type = $(value).attr("option_type");
		
		if(the_option_type=="multiple_choice"||the_option_type=="multiple_answer"){
			var answer_val = [];
			$.each($(value).find(".option"),function(option_key,option_value){

				 if($(option_value).find(".option_type").find("input").eq(0).is(':checked')){
				 	answer_val.push("1");
				 }else{
				 	answer_val.push("0");
				 }
			});

			option_json = {
				"type":the_option_type,
				"answer":answer_val.join(","),
			};

		}else if(the_option_type=="short_answer"){
			
			var short_answer_val = $(value).find(".option").find("input").eq(0).val();

			option_json = {
				"type":the_option_type,
				"answer": short_answer_val,
			};
		}else{
			var answer_val = $(value).find(".option").find("textarea").eq(0).val();
			option_json = {
				"type":the_option_type,
				"answer":answer_val,
			};
		}
		json.push(option_json);
		
		
		
	});
	final_json = {id:assessment_sheet_id,answer:JSON.stringify(json)};
	console.log(final_json);

	$.ajax({
	    url: site_url+'/answer_submit',
	    type: "POST",
	    data: final_json,
	    complete: function(response){
	    	console.log(response.responseText);
	    }
	});
});
$('.file').hide();
$(".upload").click(function(){
	$('.file').click();
});
$(".file").change(function(){
	$("#upload_form").submit();
});
$(document).on("click",".remove_choice",function(){
	$(this).parent().parent().remove();

});


