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
            if (!$("#" + item.id).val()) {
                $("#" + item.id).addClass("is-invalid");
                invalids.push(item.name);
                isValid = false;
            } else {
                $("#" + item.id).removeClass("is-invalid");
            }
        });
        let invalidStr = "";
        invalids.forEach((item) => {
            invalidStr += "<BR>" + item;
        });
        return { status: isValid, invalidString: invalidStr };
    }

    init() {
        $("#" + this.itemModal).on("click", "input", function () {
            if(this.id || this.id!==""){
                $("#" + this.id).removeClass("is-invalid");
            }
        });
    }
}
