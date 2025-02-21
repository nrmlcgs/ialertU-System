function getchartdata(d, m, t) {
  $.ajax({
    type: "POST",
    url: `/ialertu/Controllers/Reports.php?f=gcd`,
    data: { y: d, m: m, t: t },
    dataType: `JSON`,
    success: function (data) {
      if (t == "all") {
        vrpc(data.type_acc);
        cc(data.brgy);
      } else if (t == "first") {
        vrpc(data.type_acc);
      } else if (t == "second") {
        cc(data.brgy);
      }

    }
  });
}
let root1;
let root2;
function vrpc(data) {
  try {
    root1.dispose();
  } catch (error) {

  }
  am5.ready(function () {

    // Create root1 element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    root1 = am5.Root.new("chartdiv");
    root1._logo.dispose();
    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root1.setThemes([
      am5themes_Animated.new(root1)
    ]);

    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root1.container.children.push(am5xy.XYChart.new(root1, {
      panX: true,
      panY: true,
      wheelX: "panX",
      wheelY: "zoomX",
      pinchZoomX: true,
      paddingLeft: 0,
      paddingRight: 1
    }));

    // Add cursor
    // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
    var cursor = chart.set("cursor", am5xy.XYCursor.new(root1, {}));
    cursor.lineY.set("visible", false);


    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xRenderer = am5xy.AxisRendererX.new(root1, {
      minGridDistance: 30,
      minorGridEnabled: true
    });

    xRenderer.labels.template.setAll({
      rotation: -90,
      centerY: am5.p50,
      centerX: am5.p100,
      paddingRight: 15
    });

    xRenderer.grid.template.setAll({
      location: 1
    })

    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root1, {
      maxDeviation: 0.3,
      categoryField: "type",
      renderer: xRenderer,
      tooltip: am5.Tooltip.new(root1, {})
    }));

    var yRenderer = am5xy.AxisRendererY.new(root1, {
      strokeOpacity: 0.1
    })

    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root1, {
      maxDeviation: 0.3,
      renderer: yRenderer
    }));

    // Create series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var series = chart.series.push(am5xy.ColumnSeries.new(root1, {
      name: "Series 1",
      xAxis: xAxis,
      yAxis: yAxis,
      valueYField: "count",
      sequencedInterpolation: true,
      categoryXField: "type",
      tooltip: am5.Tooltip.new(root1, {
        labelText: "{valueY}"
      })
    }));

    series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });
    series.columns.template.adapters.add("fill", function (fill, target) {
      return chart.get("colors").getIndex(series.columns.indexOf(target));
    });

    series.columns.template.adapters.add("stroke", function (stroke, target) {
      return chart.get("colors").getIndex(series.columns.indexOf(target));
    });



    xAxis.data.setAll(data);
    series.data.setAll(data);


    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear(1000);
    chart.appear(1000, 100);

  });
}
function cc(data) {
  console.log(data)
  am5.ready(function () {
    try {
      root2.dispose();
    } catch (error) {

    }
    root2 = am5.Root.new("chartdiv2");
    root2._logo.dispose();
    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root2.setThemes([
      am5themes_Animated.new(root2)
    ]);

    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root2.container.children.push(
      am5xy.XYChart.new(root2, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX",
        paddingLeft: 5,
        paddingRight: 5
      })
    );

    // Add cursor
    // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
    var cursor = chart.set("cursor", am5xy.XYCursor.new(root2, {}));
    cursor.lineY.set("visible", false);

    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xRenderer = am5xy.AxisRendererX.new(root2, {
      minGridDistance: 60,
      minorGridEnabled: true
    });

    var xAxis = chart.xAxes.push(
      am5xy.CategoryAxis.new(root2, {
        maxDeviation: 0.3,
        categoryField: "barangay",
        renderer: xRenderer,
        tooltip: am5.Tooltip.new(root2, {})
      })
    );

    xRenderer.grid.template.setAll({
      location: 1
    })

    var yAxis = chart.yAxes.push(
      am5xy.ValueAxis.new(root2, {
        maxDeviation: 0.3,
        renderer: am5xy.AxisRendererY.new(root2, {
          strokeOpacity: 0.1
        })
      })
    );

    // Create series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var series = chart.series.push(
      am5xy.ColumnSeries.new(root2, {
        name: "Series 1",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "count",
        sequencedInterpolation: true,
        categoryXField: "barangay"
      })
    );

    series.columns.template.setAll({
      width: am5.percent(120),
      fillOpacity: 0.9,
      strokeOpacity: 0
    });
    series.columns.template.adapters.add("fill", (fill, target) => {
      return chart.get("colors").getIndex(series.columns.indexOf(target));
    });

    series.columns.template.adapters.add("stroke", (stroke, target) => {
      return chart.get("colors").getIndex(series.columns.indexOf(target));
    });

    series.columns.template.set("draw", function (display, target) {
      var w = target.getPrivate("width", 0);
      var h = target.getPrivate("height", 0);
      display.moveTo(0, h);
      display.bezierCurveTo(w / 4, h, w / 4, 0, w / 2, 0);
      display.bezierCurveTo(w - w / 4, 0, w - w / 4, h, w, h);
    });
    xAxis.data.setAll(data);
    series.data.setAll(data);

    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear(1000);
    chart.appear(1000, 100);

  }); // end am5.ready()
}