var DatePickers = function() {
    var _componentDaterange = function() {
        if (!$().daterangepicker) {
            console.warn('Warning - daterangepicker.js is not loaded.');
            return;
        }

        moment.locale("ko");
        $(".date").daterangepicker({
            timePicker: false,
            timePicker24Hour: true,
            timePickerSeconds: true,
            singleDatePicker: true,
            locale: {format: "YYYY-MM-DD"},
            autoUpdateInput: false,
            autoApply: true
        });

        $('.date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });

        $(".daterange").daterangepicker({
            timePicker: false,
            timePicker24Hour: true,
            timePickerSeconds: true,
            singleDatePicker: false,
            locale :{format: "YYYY-MM-DD"},
            autoUpdateInput: false,
            autoApply:true
        });

        $('.daterange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });

        function converDateString(dt) {
            return (
                dt.getFullYear() +
                "-" +
                addZero(eval(dt.getMonth() + 1)) +
                "-" +
                addZero(dt.getDate())
            );
        }
        function getDtDay(s, i) {
            var newDt = new Date(s);
            newDt.setDate(newDt.getDate() - i);
            return converDateString(newDt);
        }
        function addZero(i) {
            var rtn = i + 100;
            return rtn.toString().substring(1, 3);
        }
        let dt = new Date();
        if ($("#date_range_btns").length) {
            $("#date_range_btns > .btn").click(function() {
                let range = $(this).attr("data-range");
                let year = "";
                let month = "";
                let l_s = "";
                let l_e = "";
                let s = "";
                let e = "";
                if (range == "last_month") {
                    year = dt.getFullYear();
                    month = dt.getMonth();
                    //console.log(month);
                    if (month - 1 < 0) {
                        year = year - 1;
                        month = 12;
                    }
                    l_s = new Date(year, month - 1, 1);
                    l_e = new Date(year, month, 0);
                    e = converDateString(l_s);
                    s = converDateString(l_e);
                } else if (range == "this_month") {
                    year = dt.getFullYear();
                    month = dt.getMonth();
                    l_s = new Date(year, month, 1);
                    l_e = new Date(year, month + 1, 0);
                    e = converDateString(l_s);
                    s = converDateString(l_e);
                } else if (range == "reset") {
                    e = "";
                    s = "";
                } else {
                    s = converDateString(dt);
                    e = getDtDay(s, parseInt(range));
                    if (range == 1) {
                        s = e;
                    }
                }
                $("#date_start").val(e);
                $("#date_end").val(s);
            });
        }
    }

    return {
        init: function() {
            _componentDaterange();
        }
    }
}();

document.addEventListener('DOMContentLoaded', function() {
    DatePickers.init();
});
