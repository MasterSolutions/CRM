<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Test</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#end_time").blur(function(){
      $("#message").text("Calculating. Wait...");
      var start_time = $("#start_time").val();
      var end_time = $("#end_time").val();
      $.getJSON("test.php?s="+start_time+"&e="+end_time, function(data){
        var success = data.success;
        if (success == 1) {
          $("#message").text("Calculation done! See result below.");
          $("#difference").val(data.days + " day(s) " + data.hours + " hour(s) " + data.minutes + " minute(s) " + data.seconds + " second(s) ");
        }
        else {
          $("#message").text("Error! " + data.reason);
        }
      })
    });
  });

</script>
</head>
<body>
  <div id="message">&nbsp;</div>
  <form>
    <input id="start_time" type="text" value="" name="start_time"/>
    <input id="end_time" type="text" value="" name="end_time"/>
    <input id="difference" type="text" value="" name="difference"/>
  </form>
</body>
</html>