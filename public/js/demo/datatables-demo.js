// Call the dataTables jQuery plugin
$(document).ready(function() {
  $("table[id^='dataTable']").DataTable(
    {
      language: {
          url: ".\French.json"
      }
  }
  );
});
