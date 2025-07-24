class ValidateInput {
    constructor(itemModal, arrayValidateInput) {
        this.itemModal = itemModal;
        this.arrayValidateInput = arrayValidateInput;
        this.init();
    }
    validate() {
        let isValid = true;
        let invalids = [];
        this.arrayValidateInput.forEach((item) => {
            if (item.type !== "list") {
                if (!$("#" + item.id).val()) {
                    $("#" + item.id).addClass("is-invalid");
                    invalids.push(item.name);
                    isValid = false;
                } else {
                    $("#" + item.id).removeClass("is-invalid");
                }
            } else if (item.type == "list") {
                if (item.require) {
                    if (!$("#" + item.id).val()) {
                        $("#" + item.id).addClass("is-invalid");
                        invalids.push(item.name);
                        isValid = false;
                    } else {
                        if (
                            !this.checkValueInDataSource(
                                $("#" + item.id).val(),
                                item.key,
                                item.dataSource
                            )
                        ) {
                            $("#" + item.id).addClass("is-invalid");
                            invalids.push(item.name + " ไม่ถูกต้อง");
                            isValid = false;
                        } else {
                            $("#" + item.id).removeClass("is-invalid");
                        }
                    }
                } else {
                    if ($("#" + item.id).val()) {
                        if (
                            !this.checkValueInDataSource(
                                $("#" + item.id).val(),
                                item.key,
                                item.dataSource
                            )
                        ) {
                            $("#" + item.id).addClass("is-invalid");
                            invalids.push(item.name + " ไม่ถูกต้อง");
                            isValid = false;
                        } else {
                            $("#" + item.id).removeClass("is-invalid");
                        }
                    }
                    else {
                        $("#" + item.id).removeClass("is-invalid");
                    }
                }
            }
        });
        let invalidStr = "";
        invalids.forEach((item) => {
            invalidStr += "<BR>" + item;
        });
        return { status: isValid, invalidString: invalidStr };
    }

    checkValueInDataSource(value, key, dataSource) {
        let status = dataSource.find((x) => x[key] == value);
        return status ?? false;
    }

    validateList(id, key, dataSource) {
        let isValid = true;
        let invalids = [];
        if (!$("#" + id).val()) {
            $("#" + id).addClass("is-invalid");
            // invalids.push(item.name);
            invalids.push("name");
            isValid = false;
        } else {
            let value = $("#" + id).val();
            let status = dataSource.find((x) => x[key] == value);
            if (!status) {
                $("#" + id).addClass("is-invalid");
            } else {
                $("#" + id).removeClass("is-invalid");
            }
        }
        let invalidStr = "";
        invalids.forEach((item) => {
            invalidStr += "<BR>" + item;
        });
        return { status: isValid, invalidString: invalidStr };
    }

    init() {
        $("#" + this.itemModal).on("click", "input", function () {
            if (this.id || this.id !== "") {
                $("#" + this.id).removeClass("is-invalid");
            }
        });
    }
}
