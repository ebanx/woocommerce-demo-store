! function($) {
    function dhPie(element, options) {
        this.el = element, this.$el = $(this.el), this.options = $.extend({
            color: "#f7f7f7",
            units: "",
            label_selector: ".dh-pie-value",
            back_selector: ".dh-pie-back",
            border: 10,
            responsive: !0
        }, options), this.init()
    }
    dhPie.prototype = {
        constructor: dhPie,
        _progress_v: 0,
        animated: !1,
        init: function() {
            this.color = this.options.color, this.value = this.$el.data("pie-value") / 100, this.label_value = this.$el.data("pie-label-value") || this.$el.data("pie-value"), this.$wrapper = $(".dh-pie-wrap", this.$el), this.$label = $(this.options.label_selector, this.$el), this.$back = $(this.options.back_selector, this.$el), this.$canvas = this.$el.find("canvas"), this.draw(), this.setWayPoint(), !0 === this.options.responsive && this.setResponsive()
        },
        setResponsive: function() {
            var that = this;
            $(window).resize(function() {
                !0 === that.animated && that.circle.stop(), that.draw(!0)
            })
        },
        draw: function(redraw) {
            var radius, w = this.$el.addClass("dh-ready").width(),
                border_w = this.options.border;
            w || (w = this.$el.parents(":visible").first().width() - 2), w = w / 100 * 80, radius = w / 2 - border_w - 1, this.$wrapper.css({
                width: w + "px"
            }), this.$label.css({
                width: w,
                height: w,
                "line-height": w + "px"
            }), this.$back.css({
                width: w,
                height: w
            }), this.$canvas.attr({
                width: w + "px",
                height: w + "px"
            }), this.$el.addClass("dh-ready"), this.circle = new ProgressCircle({
                canvas: this.$canvas.get(0),
                minRadius: radius,
                arcWidth: border_w
            }), !0 === redraw && !0 === this.animated && (this._progress_v = this.value, this.circle.addEntry({
                fillColor: this.color,
                progressListener: $.proxy(this.setProgress, this)
            }).start())
        },
        setProgress: function() {
            if (this._progress_v >= this.value) return this.circle.stop(), this.$label.find('span').text(this.label_value), this._progress_v;
            this._progress_v += .005;
            var label_value = this._progress_v / this.value * this.label_value,
                val = Math.round(label_value);
            return this.$label.find('span').text(val), this._progress_v
        },
        animate: function() {
            !0 !== this.animated && (this.animated = !0, this.circle.addEntry({
                fillColor: this.color,
                progressListener: $.proxy(this.setProgress, this)
            }).start(5))
        },
        setWayPoint: function() {
            "undefined" != typeof $.fn.waypoint ? this.$el.waypoint($.proxy(this.animate, this), {
                offset: "85%"
            }) : this.animate()
        }
    }, $.fn.dhPie = function(option, value) {
        return this.each(function() {
            var $this = $(this),
                data = $this.data("vc_chart"),
                options = "object" == typeof option ? option : {
                    color: $this.data("pie-color"),
                    units: $this.data("pie-units"),
                    border:$this.data('border-width')
                };
            "undefined" == typeof option && $this.data("vc_chart", data = new dhPie(this, options)), "string" == typeof option && data[option](value)
        })
    },window.dhPieChart = function() {
        $(".dh-pie:visible").dhPie()
    }, $(document).ready(function() {
    	dhPieChart()
    })
}(window.jQuery);