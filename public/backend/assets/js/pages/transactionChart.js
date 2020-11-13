function generateDayWiseTimeSeries(e, t, a) {
    for (var r = 0, o = []; r < t;) {
        var i = e,
            n = Math.floor(Math.random() * (a.max - a.min + 1)) + a.min;
        o.push([i, n]), e += 864e5, r++
    }
    return o
}

function generateData(e, t, a) {
    for (var r = 0, o = []; r < t;) {
        var i = Math.floor(750 * Math.random()) + 1,
            n = Math.floor(Math.random() * (a.max - a.min + 1)) + a.min,
            s = Math.floor(61 * Math.random()) + 15;
        o.push([i, n, s]), 864e5, r++
    }
    return o
}

function generateData1(e, t, a) {
    for (var r = 0, o = []; r < t;) {
        var i = Math.floor(Math.random() * (a.max - a.min + 1)) + a.min,
            n = Math.floor(61 * Math.random()) + 15;
        o.push([e, i, n]), e += 864e5, r++
    }
    return o
}
Apex = {
        chart: {
            parentHeightOffset: 0,
            toolbar: {
                show: !1
            }
        },
        grid: {
            padding: {
                left: 0,
                right: 0
            }
        },
        colors: ["#5369f8", "#43d39e", "#f77e53", "#1ce1ac", "#25c2e3", "#ffbe0b"],
        tooltip: {
            theme: "dark",
            x: {
                show: !1
            }
        },
        dataLabels: {
            enabled: !1
        },
        xaxis: {
            axisBorder: {
                color: "#d6ddea"
            },
            axisTicks: {
                color: "#d6ddea"
            }
        },
        yaxis: {
            labels: {
                offsetX: -10
            }
        }
    },
    function (e) {
        "use strict";

        function t() {}
        t.prototype.initCharts = function () {
            var e = {
                chart: {
                    height: 380,
                    type: "line",
                    zoom: {
                        enabled: !1
                    },
                    toolbar: {
                        show: !1
                    }
                },
                dataLabels: {
                    enabled: !0
                },
                stroke: {
                    width: [3, 3],
                    curve: "smooth"
                },
                series: [{
                    name: "High - 2018",
                    data: [28, 29, 33, 36, 32, 32, 33]
                }, {
                    name: "Low - 2018",
                    data: [12, 11, 14, 18, 17, 13, 13]
                }],
                grid: {
                    row: {
                        colors: ["transparent", "transparent"],
                        opacity: .2
                    },
                    borderColor: "#e9ecef"
                },
                markers: {
                    style: "inverted",
                    size: 6
                },
                xaxis: {
                    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                    title: {
                        text: "Month"
                    },
                    axisBorder: {
                        color: "#d6ddea"
                    },
                    axisTicks: {
                        color: "#d6ddea"
                    }
                },
                yaxis: {
                    title: {
                        text: "Temperature"
                    },
                    min: 5,
                    max: 40
                },
                legend: {
                    position: "top",
                    horizontalAlign: "right",
                    floating: !0,
                    offsetY: -25,
                    offsetX: -5
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        chart: {
                            toolbar: {
                                show: !1
                            }
                        },
                        legend: {
                            show: !1
                        }
                    }
                }]
            };
         
            new ApexCharts(document.querySelector("#apex-line-2"), e).render();
            e = {
                chart: {
                    height: 380,
                    type: "area",
                    stacked: !0
                },
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    width: [3, 3, 3],
                    curve: "smooth"
                },
                series: [{
                    name: "South",
                    data: generateDayWiseTimeSeries(new Date("11 Feb 2019 GMT").getTime(), 20, {
                        min: 10,
                        max: 60
                    })
                }, {
                    name: "North",
                    data: generateDayWiseTimeSeries(new Date("11 Feb 2019 GMT").getTime(), 20, {
                        min: 10,
                        max: 20
                    })
                }, {
                    name: "Central",
                    data: generateDayWiseTimeSeries(new Date("11 Feb 2019 GMT").getTime(), 20, {
                        min: 10,
                        max: 15
                    })
                }],
                legend: {
                    position: "top",
                    horizontalAlign: "left"
                },
                xaxis: {
                    type: "datetime"
                }
            };
        }, t.prototype.init = function () {
            this.initCharts()
        }, e.ApexChartPage = new t, e.ApexChartPage.Constructor = t
    }(window.jQuery),
    function () {
        "use strict";
        window.jQuery.ApexChartPage.init()
    }();
