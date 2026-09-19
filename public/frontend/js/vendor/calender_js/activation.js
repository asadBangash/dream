if ($("#calendar").length > 0) {
  document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ["dayGrid", "timeGrid", "list", "interaction"],
      initialView: "timeGridWeek",
      header: {
        left: "prev, title , next",
        center: "dayGridMonth,timeGridWeek",
        right: "title",
      },
      height: "",
      defaultDate: "2021-11-20",
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      eventLimit: true, // allow "more" link when too many events

      events: [
        {
          title: "Dorm Open Houses issponsore monitors!",
          start: "2021-11-20",
          end: "2021-11-22",
          color: "transparent",
          textColor: "#1466D9",
          display: "background",
          className: "blue_bg",
          display: "background",
        },
        {
          title: "08:00 - 09:00 AM",
          start: "2021-11-20",
          end: "2021-11-20",
          textColor: "#FB1159",
          color: "transparent",
        },
        {
          title: "Dorm Open Houses issponsore monitors!",
          start: "2021-11-24",
          end: "2021-11-24",
          color: "transparent",
          textColor: "#1466D9",
          display: "background",
          className: "paste_bg",
          display: "background",
        },
        {
          title: "08:00 - 09:00 AM",
          start: "2021-11-24",
          end: "2021-11-24",
          textColor: "#FB1159",
          color: "transparent",
        },
      ],
      eventClick: function (event) {
        var modal = $("#lms_view_modal");
        modal.modal();
      },
      dateClick: function (date, jsEvent, view) {
        $("#lms_view_modal").modal("show");
      },
    });

    calendar.render();
  });
}
