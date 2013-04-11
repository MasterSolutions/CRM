// JavaScript Document
  $(document).ready(function() {
    $("#end_time").blur(function(){
      $("#message").text("Calculating. Wait...");
      var start_time = $("#start_time").val();
      var end_time = $("#end_time").val();
      $.getJSON("test.php?s="+start_time+"&e="+end_time, function(data){
        var success = data.success;
        if (success == 1) {
          $("#message").text("Calculation done! See result below.");
          $("#difference").val(data.hours + ":" + data.minutes );
		  $("#difference2").val(data.hours_rot + ":" + data.minutes_rot );
        }
        else {
          $("#message").text("Error! " + data.reason);
        }
      })
    });
  });

