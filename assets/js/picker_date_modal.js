function picker_date(element, option) {
    // $(element).prop("readonly", true);
    // $(element).css("background-color", "white");
    // background_color = $(element).css("background-color");
    $(element).prop("readonly", true);
    // $(element).css("background-color", background_color);
    // alert(background_color);
    
    //alert($(element).val());
    
    //alert(curDate);
    
    let myArray = $(element).val().split("/");
    
    let curDate = parseInt(myArray[2])-543+"-"+myArray[1]+"-"+myArray[0];
    

    let ran_cal_id = null;

    ran_cal_id = Math.random() * 100000;
    ran_cal_id = ran_cal_id.toString().split(".")[0];
    ran_cal_id = "cal" + ran_cal_id;

    while ($("." + ran_cal_id).length != 0) {
        ran_cal_id = Math.random() * 100000;
        ran_cal_id = ran_cal_id.toString().split(".")[0];
        ran_cal_id = "cal" + ran_cal_id;
    }

    $(element).attr("data-picker", ran_cal_id);
    $(element).addClass(ran_cal_id);

    let modalCal = document.createElement("div");
    $(modalCal).addClass("modal fade");
    $(modalCal).attr("id", "picker_date_modal" + ran_cal_id);
    let modalDialogCal = document.createElement("div");
    $(modalDialogCal).addClass("modal-dialog modal-dialog-centered");
    $(modalDialogCal).css("width", "90vw");
    $(modalDialogCal).css("max-width", "500px");
    $(modalDialogCal).css("margin", "auto");
    $(modalDialogCal).css("padding-top", "50px");
    $(modalCal).append(modalDialogCal);
    $("body").append(modalCal);

    $("#picker_date_modal" + ran_cal_id).on('hidden.bs.modal', function () {
        // do something…
        $("#picker_date_modal" + ran_cal_id).find(".modal-content").remove();
        //   $(element).prop("readonly", false);
    })

    var sel_pic_cal = function (ran_cal_id, td) {

        let date = $(td).html();
        // let date = $(td)[0].attributes[1].value
        if (date == "") {
            return;
        }
        date = $(td)[0].attributes[1].value;
        let m = $("#picker_date_modal" + ran_cal_id).find(".month_select").val();
        let y = parseInt($("#picker_date_modal" + ran_cal_id).find(".year_select").val()) + 543;

        y = y.toString();

        date = date + "/" + m + "/" + y;

        $("[data-picker=" + ran_cal_id + "]").html(date);
        $("[data-picker=" + ran_cal_id + "]").val(date);
        // $("[data-picker=" + ran_cal_id + "]").attr("sel_val", date);

        $("#picker_date_modal" + ran_cal_id).modal("hide");
        //$("#picker_date_modal"+ ran_cal_id).find(".modal-content").remove();

        if (option.onchange != null) {
            // option.onchange.call(date);
            eval(option.onchange).call(date)
            // setDate(date);
        }
    }

    var render_cal_pic = function (element, month, year) {
        let html;
        html = "";
        html += "<table class='table table-sm' >";
        html += "<thead>";
        html += "<tr class='table-active'>";
        html += "<th class='text-center' style='width:14.3%'>อา</th>";
        html += "<th class='text-center' style='width:14.3%'>จ</th>";
        html += "<th class='text-center' style='width:14.3%'>อ</th>";
        html += "<th class='text-center' style='width:14.3%'>พ</th>";
        html += "<th class='text-center' style='width:14.3%'>พฤ</th>";
        html += "<th class='text-center' style='width:14.3%'>ศ</th>";
        html += "<th class='text-center' style='width:14.3%'>ส</th>";
        html += "</tr>";
        html += "</thead>";

        let d1 = new Date(year, month - 1, 1);
        html += "<tbody>";
        if (d1.getDay() == 0) { html += "<tr>"; }
        if (d1.getDay() == 1) { html += "<tr><td></td>"; }
        if (d1.getDay() == 2) { html += "<tr><td></td><td></td>"; }
        if (d1.getDay() == 3) { html += "<tr><td></td><td></td><td></td>"; }
        if (d1.getDay() == 4) { html += "<tr><td></td><td></td><td></td><td></td>"; }
        if (d1.getDay() == 5) { html += "<tr><td></td><td></td><td></td><td></td><td></td>"; }
        if (d1.getDay() == 6) { html += "<tr><td></td><td></td><td></td><td></td><td></td><td></td>"; }
        while ((d1.getMonth() + 1) == month) {
            if (d1.getDay() == 0 && d1.getDate() != 1) {
                html += "<tr>";
            }
            let to_day = new Date();
            let date_str = d1.getDate().toString();
            if (date_str.length == 1) { date_str = "0" + date_str; }
            let date_month = (d1.getMonth() + 1).toString();
            if (date_month.length == 1) { date_month = "0" + date_month; }
            let date_year = d1.getFullYear().toString();
            if (date_year.length == 1) { date_year = "0" + date_year; }
            date_str = date_year + "-" + date_month + "-" + date_str;
            let str_d = d1.getDate().toString();
            if (str_d.length == 1) {
                str_d = "0" + str_d;
            }
            //let today_class = "class='text-center'";
            let today_class = "<div class='text-center style='width:80%'>" + str_d + "</div>";
            // today_class = "<div class='text-center bg-primary text-primary' style='width:80%;border-radius:30%'>" + str_d + "</div>";
            if (
                to_day.getDate() == d1.getDate() &&
                to_day.getMonth() == d1.getMonth() &&
                to_day.getFullYear() == d1.getFullYear()
            ) {
                today_class = "class='text-center bg-primary text-primary' style='width:80%;border-radius:30%'";
                today_class = "<div class='text-center bg-primary text-primary' style='width:80%;border-radius:30%'>" + str_d + "</div>";
            }
            let cur_day = new Date(curDate);
            if (
                cur_day.getDate() == d1.getDate() &&
                cur_day.getMonth() == d1.getMonth() &&
                cur_day.getFullYear() == d1.getFullYear()
            ) {
                today_class = "class='text-center bg-success text-primary' style='width:80%;border-radius:30%'";
                today_class = "<div class='text-center bg-success text-primary' style='width:80%;border-radius:30%'>" + str_d + "</div>";
            }
            let onclick = "";
            //html += "<td " + onclick + " onmouseover=\"this.style.cursor='pointer'\" onmouseout=\"this.style.cursor=''\" " + today_class + " >" + str_d + "</td>";
            html += "<td " + onclick + " onmouseover=\"this.style.cursor='pointer'\" value='" + str_d + "' align='center'>" + today_class + "</td>";
            if (d1.getDay() == 6) {
                html += "</tr>";
            }
            d1.setDate(d1.getDate() + 1);
        }
        while (d1.getDay() != 0) {
            html += "<td></td>";
            d1.setDate(d1.getDate() + 1);
        }
        if (html.substr(html.length - 5) != "</tr>") {
            html += "</tr>";
        }

        html += "</tbody>";
        html += "</table>";
        // html += "<button class='btn btn-sm btn-danger clear_cal_btn'>";
        // html += "<i class='fa fa-times' ></i> ล้างข้อมูลปฎิทิน";
        // html += "</button>";
        return html;
    }

    var change_mon_year_cal_pic = function (ran_cal_id) {
        let html = render_cal_pic(
            element,
            parseInt($("." + ran_cal_id + "_panel").find(".month_select").val()),
            parseInt($("." + ran_cal_id + "_panel").find(".year_select").val())
        );
        $("." + ran_cal_id + "_panel").find(".clear_cal_btn").remove();
        $("." + ran_cal_id + "_panel").find("table").remove();
        $("." + ran_cal_id + "_panel").append(html);

        $("." + ran_cal_id + "_panel").find("td").on("click", function () {
            sel_pic_cal(ran_cal_id, this);
        });

        $(element).next().find(".clear_cal_btn").on('click', function () {
            if (option.onchange != null) {
                option.onchange("");
            }

            $("[data-picker=" + ran_cal_id + "]").val("");
            $("#picker_date_modal" + ran_cal_id).modal('hide');
            //$("#picker_date_modal"+ran_cal_id).find(".modal-content").remove();
        });
    }

    $("[data-picker=" + ran_cal_id + "]").on("click", function () {
        if (document.querySelector("." + ran_cal_id + "_panel")) {
            $("." + ran_cal_id + "_panel").remove();
            return;
        }
        
         myArray = $(element).val().split("/");
    
     curDate = parseInt(myArray[2])-543+"-"+myArray[1]+"-"+myArray[0];
    
        // $(element).prop("readonly", true);

        let html = "";
        if (this.value != "" && this.value != null) {
            let date_arr = this.value.split("/");
            html = render_cal_pic(element, date_arr[1], parseInt(date_arr[2]) - 543);
        }
        else {
            html = render_cal_pic(element, (new Date()).getMonth() + 1, (new Date()).getFullYear());
        }
        let cal = document.createElement("div");
        $(cal).addClass(ran_cal_id + "_panel");
        let filter_panel = document.createElement("div");
        $(filter_panel).css("padding", "10px");
        $(filter_panel).css("display", "flex");
        $(filter_panel).css("justify-content", "space-between");
        $(filter_panel).css("align-items", "center");


        let select_panel1 = document.createElement("div");
        let select_panel2 = document.createElement("div");
        let month_select = document.createElement("select");
        $(month_select).addClass("month_select");
        $(month_select).addClass("form-control");
        $(select_panel1).append(month_select);

        $(month_select).append("<option value='01' >มกราคม</option>");
        $(month_select).append("<option value='02' >กุมภาพันธ์</option>");
        $(month_select).append("<option value='03' >มีนาคม</option>");
        $(month_select).append("<option value='04' >เมษายน</option>");
        $(month_select).append("<option value='05' >พฤษภาคม</option>");
        $(month_select).append("<option value='06' >มิถุนายน</option>");
        $(month_select).append("<option value='07' >กรกฎาคม</option>");
        $(month_select).append("<option value='08' >สิงหาคม</option>");
        $(month_select).append("<option value='09' >กันยายน</option>");
        $(month_select).append("<option value='10' >ตุลาคม</option>");
        $(month_select).append("<option value='11' >พฤศจิกายน</option>");
        $(month_select).append("<option value='12' >ธันวาคม</option>");

        let year_select = document.createElement("select");
        $(year_select).addClass("year_select");
        $(year_select).addClass("form-control");
        $(select_panel2).append(year_select);


        $(select_panel1).append(month_select);
        $(select_panel2).append(year_select);

        let year_now = (new Date()).getFullYear();
        let month_now = (new Date()).getMonth() + 1;
        let year_range;

        if (option.year_range != null) {
            year_range = option.year_range;
        }
        else {
            year_range = "-10:+10";
        }

        let year1 = year_now + parseInt(year_range.split(":")[0]);
        let year2 = year_now + parseInt(year_range.split(":")[1]);

        while (year1 <= year2) {
            $(year_select).append("<option value='" + year1 + "' >" + (year1 + 543).toString() + "</option>");
            year1++;
        }

        if (this.value != "" && this.value != null) {
            let date_arr = this.value.split("/");

            $(month_select).val(date_arr[1]);
            $(year_select).val(parseInt(date_arr[2]) - 543);
        }
        else {
            month_now = month_now.toString();
            if (month_now.length == 1) {
                month_now = "0" + month_now;
            }
            $(month_select).val(month_now);
            $(year_select).val(year_now);
        }

        $(month_select).on("change", function () { change_mon_year_cal_pic(ran_cal_id) });
        $(year_select).on("change", function () { change_mon_year_cal_pic(ran_cal_id) });

        let left_btn = document.createElement("button");
        $(left_btn).prop("type", "button");
        //$(left_btn).addClass("btn");
        $(left_btn).addClass("btn-sm");
        $(left_btn).addClass("btn-primary");
        $(left_btn).css("width","40px");
        $(left_btn).css("height","40px");
        $(left_btn).css("border-radius","50%");
        $(left_btn).css("padding-right","12px");
        $(left_btn).css("padding-top","5px");
        $(left_btn).html("<i class='fa fa-2x fa-chevron-left' aria-hidden='true'></i>");
        
        $(left_btn).on("click", function () {

            let m = parseInt($("." + ran_cal_id + "_panel").find(".month_select").val());
            m--;
            if (m == 0) {

                m = 12;
                let y = parseInt($("." + ran_cal_id + "_panel").find(".year_select").val());
                y--;
                $("." + ran_cal_id + "_panel").find(".year_select").val(y);
            }

            m = m.toString();
            if (m.length == 1) {
                m = "0" + m;
            }


            $("." + ran_cal_id + "_panel").find(".month_select").val(m);

            change_mon_year_cal_pic(ran_cal_id);
        });

        let right_btn = document.createElement("button");
        $(right_btn).prop("type", "button");
        //$(right_btn).addClass("btn");
        $(right_btn).addClass("btn-sm");
        $(right_btn).addClass("btn-primary");
        $(right_btn).css("width","40px");
        $(right_btn).css("height","40px");
        $(right_btn).css("border-radius","50%");
        $(right_btn).css("padding-left","12px");
        $(right_btn).css("padding-top","5px");
        $(right_btn).html("<i class='fa fa-2x fa-chevron-right' aria-hidden='true'></i>");

        $(right_btn).on("click", function () {

            let m = parseInt($("." + ran_cal_id + "_panel").find(".month_select").val());
            m++;
            if (m == 13) {

                m = 1;
                let y = parseInt($("." + ran_cal_id + "_panel").find(".year_select").val());
                y++;
                $("." + ran_cal_id + "_panel").find(".year_select").val(y);
            }

            m = m.toString();
            if (m.length == 1) {
                m = "0" + m;
            }


            $("." + ran_cal_id + "_panel").find(".month_select").val(m);

            change_mon_year_cal_pic(ran_cal_id);
        });


        let left_panel = document.createElement("div");
        $(left_panel).append(left_btn);

        let right_panel = document.createElement("div");
        $(right_panel).append(right_btn);

        $(filter_panel).append(left_panel);
        $(filter_panel).append(select_panel1);
        $(filter_panel).append(select_panel2);
        $(filter_panel).append(right_panel);

        $(cal).append(filter_panel);
        $(cal).append(html);

        let modalDialog = $("#picker_date_modal" + ran_cal_id).find(".modal-dialog");

        let modalContent = document.createElement("div");
        $(modalContent).addClass("modal-content");
        $(modalDialog).append(modalContent);
        $(modalContent).append(cal);

        $("#picker_date_modal" + ran_cal_id).modal();

        $("#picker_date_modal" + ran_cal_id).find("td").on("click", function () {
            sel_pic_cal(ran_cal_id, this);
        });

        $("#picker_date_modal" + ran_cal_id).find(".clear_cal_btn").on('click', function () {
            if (option.onchange != null) {
                option.onchange("");
            }
            $("[data-picker=" + ran_cal_id + "]").val("");
            $("#picker_date_modal" + ran_cal_id).modal('hide');
            //$("#picker_date_modal"+ran_cal_id).find(".modal-content").remove();
        });
    });
}