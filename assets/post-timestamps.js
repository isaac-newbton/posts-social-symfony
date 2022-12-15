(function () {
  let timestamps = document.querySelectorAll(".dt-local-adjust");
  if (0 < timestamps.length) {
    let months = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ];
    for (var t of timestamps) {
      let dt = t.dataset.dt;
      let f = t.dataset.format;
      let adj = new Date(dt * 1000);
      let replace = f
        .replace("d", adj.getDate())
        .replace("Y", adj.getFullYear())
        .replace("M", months[adj.getMonth()]);
      console.log(dt, f, replace);
      t.innerHTML = replace;
    }
  }
})();
