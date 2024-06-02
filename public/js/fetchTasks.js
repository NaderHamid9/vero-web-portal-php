let allTasks = [];

$(document).ready(function () {
  function fetchTasks() {
    $("#tasks-container").addClass("hidden"); //Hide the table
    $("#loading-spinner").show(); // Show the spinner

    $.ajax({
      url: "/tasks/update",
      method: "GET",
      dataType: "json",
      success: function (data) {
        console.log("AJAX response data:", data);
        if (data.status === 200 && Array.isArray(data.data)) {
          allTasks = data.data;
          updateTable(allTasks);
        } else {
          console.error("Failed to fetch tasks:", data);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error(
          "Failed to fetch tasks. Status:",
          textStatus,
          "Error:",
          errorThrown
        );
      },
      complete: function () {
        $("#loading-spinner").hide(); 
        $("#tasks-container").removeClass("hidden"); 
      },
    });
  }
  fetchTasks(); // Initial fetch of tasks

 
  setInterval(fetchTasks, 3600000); // Repeat fetch every 60 minutes
});
